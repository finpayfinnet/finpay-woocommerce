<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Finpay_API class.
 * @TODO: refactor this messy class
 * 
 * Communicates with Finpay API.
 */
class WC_Finpay_API
{

    /**
     * Username.
     * @var string
     */
    private static $username = '';


    /**
     * Passowrd.
     * @var string
     */
    private static $password = '';

    /**
     * Finpay Environment.
     * @var string
     */
    private static $environment = '';

    /**
     * Plugin Options.
     * @var string
     */
    private static $plugin_options;

    /**
     * Set Username.
     * @param string $username
     */
    public static function set_username($username)
    {
        self::$username = $username;
    }

    /**
     * Set Password.
     * @param string $password
     */
    public static function set_password($password)
    {
        self::$password = $password;
    }

    /**
     * Set Finpay Environment.
     * @param string $key
     */
    public static function set_environment($environment)
    {
        self::$environment = $environment;
    }

    // @TODO: maybe handle when $plugin_id is invalid (e.g: `all`), it result in invalid $plugin_options, then empty serverKey, then it will cause failure on getStatusFromFinpayNotif. Make $plugin_options default value to `Finpay` plugin when serverKey not found?.
    /**
     * Fetch Plugin Options and Set as self/private vars
     * @param string $plugin_id
     */
    public static function fetchAndSetCurrentPluginOptions($plugin_id = "finpay")
    {
        self::$plugin_options = get_option('woocommerce_' . $plugin_id . '_settings');
        // var_dump(self::$plugin_options);
    }

    /**
     * Get Username.
     * @return string
     */
    public static function get_username()
    {
        if (!self::$username) {
            $plugin_options = self::$plugin_options;
            // var_dump($plugin_options);exit();
            if (isset($plugin_options['username_production'], $plugin_options['password_sandbox'])) {
                self::set_username(self::get_environment() == 'production' ? $plugin_options['username_production'] : $plugin_options['username_sandbox']);
            }
        }
        // var_dump(self::$username);exit();
        return self::$username;
    }


    /**
     * Get Passowrd.
     * @return string
     */
    public static function get_password()
    {
        if (!self::$password) {
            $plugin_options = self::$plugin_options;
            if (isset($plugin_options['password_production'], $plugin_options['password_sandbox'])) {
                self::set_password(self::get_environment() == 'production' ? $plugin_options['password_production'] : $plugin_options['password_sandbox']);
            }
        }
        return self::$password;
    }

    /**
     * Get Finpay Environment.
     * @return string
     */
    public static function get_environment()
    {
        if (!self::$environment) {
            $plugin_options = self::$plugin_options;
            if (isset($plugin_options['select_finpay_environment'])) {
                self::set_environment($plugin_options['select_finpay_environment']);
            }
        }
        return self::$environment;
    }

    /**
     * Fetch Finpay API Configuration from plugin id and set as self/private vars.
     * @return void
     */
    public static function fetchAndSetFinpayApiConfig($plugin_id = "finpay")
    {
        self::fetchAndSetCurrentPluginOptions($plugin_id);
        Finpay\Config::$isProduction = (self::get_environment() == 'production') ? true : false;
        Finpay\Config::$username = self::get_username();
        Finpay\Config::$password = self::get_password();
        Finpay\Config::$isSanitized = true;
    }

    public static function doPayment($order, $params, $plugin_id = 'finpay')
    {
        wc_get_logger()->debug('DATA REQUEST: '.json_encode($params));
        self::fetchAndSetFinpayApiConfig($plugin_id);
        self::setLogRequest(print_r($params, true), $plugin_id);
        // return Finpay\
        return Finpay\Link::createTransaction($params);
    }

    /**
     * Create Recurring Transaction for Subscription Payment.
     * @param  array $params Payment options.
     * @return object Core API response (token and redirect_url).
     * @throws Exception curl error or Finpay error.
     */
    public static function createRecurringTransaction($params, $plugin_id = 'finpay_subscription')
    {
        self::fetchAndSetFinpayApiConfig($plugin_id);
        self::setLogRequest(print_r($params, true), $plugin_id);
        return Finpay\CoreApi::charge($params);
    }

    /**
     * Create Refund.
     * 
     * @param int $order_id.
     * @param  array $params Payment options.
     * @return object Refund response.
     * @throws Exception curl error or Finpay error.
     */
    public static function createRefund($order_id, $params, $plugin_id = "finpay")
    {
        self::fetchAndSetFinpayApiConfig($plugin_id);
        self::setLogRequest(print_r($params, true), $plugin_id);
        return Finpay\Transaction::refund($order_id, $params);
    }

    /**
     * Get Finpay Notification.
     * @return object Finpay Notification response.
     */
    public static function getStatusFromFinpayNotif($plugin_id = "finpay")
    {
        self::fetchAndSetFinpayApiConfig($plugin_id);
        return new Finpay\Notification();
    }

    /**
     * Retrieve transaction status. Default ID is main plugin, which is "Finpay"
     * @param string $id Order ID or transaction ID.
     * @return object Finpay response.
     */
    public static function getFinpayStatus($order_id, $plugin_id = "finpay")
    {
        self::fetchAndSetFinpayApiConfig($plugin_id);
        return Finpay\Transaction::status($order_id);
    }

    /**
     * Cancel transaction.
     * 
     * @param string $id Order ID or transaction ID.
     * @param string $plugin_id Plugin id.
     * @return object Finpay response.
     */
    public static function CancelTransaction($id, $plugin_id = "finpay")
    {
        self::fetchAndSetFinpayApiConfig($plugin_id);
        self::setLogRequest('Request Cancel Transaction ' . $id, $plugin_id);
        return Finpay\Transaction::cancel($id);
    }

    /**
     * Set log request on Finpay logger.
     * 
     * @param string $message payload request.
     * @return void
     */
    public static function setLogRequest($message, $plugin_id = "finpay")
    {
        WC_Finpay_Logger::log($message, 'finpay-request', $plugin_id, current_time('timestamp'));
    }
}
