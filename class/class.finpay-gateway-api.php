<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Finpay_API class.
 * @TODO: refactor this messy class
 * 
 * Communicates with Finpay API.
 */
class WC_Finpay_API {

	/**
	 * Server Key.
	 * @var string
	 */
	private static $server_key = '';

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
	 * Set Server Key.
	 * @param string $key
	 */
	public static function set_server_key( $server_key ) {
		self::$server_key = $server_key;
    }

	/**
	 * Set Finpay Environment.
	 * @param string $key
	 */
	public static function set_environment( $environment ) {
		self::$environment = $environment;
    }

    // @TODO: maybe handle when $plugin_id is invalid (e.g: `all`), it result in invalid $plugin_options, then empty serverKey, then it will cause failure on getStatusFromFinpayNotif. Make $plugin_options default value to `Finpay` plugin when serverKey not found?.
	/**
	 * Fetch Plugin Options and Set as self/private vars
	 * @param string $plugin_id
	 */
	public static function fetchAndSetCurrentPluginOptions ( $plugin_id="Finpay" ) {
		self::$plugin_options = get_option( 'woocommerce_' . $plugin_id . '_settings' );
	}

	/**
	 * Get Server Key.
	 * @return string
	 */
	public static function get_server_key() {
		if ( ! self::$server_key ) {
			$plugin_options = self::$plugin_options;
			if ( isset( $plugin_options['server_key_v2_production'], $plugin_options['server_key_v2_sandbox'] ) ) {
				self::set_server_key( self::get_environment() == 'production' ? $plugin_options['server_key_v2_production'] : $plugin_options['server_key_v2_sandbox'] );
			}
		}
		return self::$server_key;
	}

    /**
	 * Get Finpay Environment.
	 * @return string
	 */
	public static function get_environment() {
		if ( ! self::$environment ) {
			$plugin_options = self::$plugin_options;
			if ( isset( $plugin_options['select_Finpay_environment'] ) ) {
				self::set_environment( $plugin_options['select_Finpay_environment'] );
			}
		}
		return self::$environment;
	}

    /**
     * Fetch Finpay API Configuration from plugin id and set as self/private vars.
     * @return void
     */
    public static function fetchAndSetFinpayApiConfig( $plugin_id="Finpay" ) {
        if(strpos($plugin_id, 'Finpay_sub') !== false){
          // for sub separated gateway buttons, use main gateway plugin id instead
          $plugin_id = 'Finpay';
        }
		self::fetchAndSetCurrentPluginOptions( $plugin_id );
        Finpay\Config::$isProduction = (self::get_environment() == 'production') ? true : false;
        Finpay\Config::$serverKey = self::get_server_key();     
        Finpay\Config::$isSanitized = true;

        // setup custom HTTP client header as identifier ref:
        // https://github.com/omarxp/Finpay-Drupal8/blob/3d4e4b4af46e96c742667c7a2925cf70dfaa9e2a/src/PluginForm/FinpayOfflineInstallmentForm.php#L39-L42
        try {
            Finpay\Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'x-Finpay-wc-plu-version: '.FINPAY_PLUGIN_VERSION;
            Finpay\Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'x-Finpay-wc-plu-wc-version: '.WC_VERSION;
            Finpay\Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'x-Finpay-wc-plu-php-version: '.phpversion();
        } catch (Exception $e) { }
    }

    /**
     * Same as createSnapTransaction, but it will auto handle exception
     * 406 duplicated order_id exception from Snap API, by calling WC_Finpay_Utils::generate_non_duplicate_order_id
     * @param  object $order the WC Order instance.
     * @param  array $params Payment options.
     * @param  string $plugin_id ID of the plugin class calling this function
     * @return object Snap response (token and redirect_url).
     * @throws Exception curl error or Finpay error.
     */
    public static function createSnapTransactionHandleDuplicate( $order, $params, $plugin_id="Finpay") {
        try {
            $response = self::createSnapTransaction($params, $plugin_id);
        } catch (Exception $e) {
            // Handle: Snap order_id duplicated, retry with suffixed order_id
            if( strpos($e->getMessage(), 'transaction_details.order_id sudah digunakan') !== false) {
                self::setLogRequest( $e->getMessage().' - Attempt to auto retry with suffixed order_id', $plugin_id );
                // @TAG: order-id-suffix-handling
                $params['transaction_details']['order_id'] = 
                    WC_Finpay_Utils::generate_non_duplicate_order_id($params['transaction_details']['order_id']);
                $response =  self::createSnapTransaction($params, $plugin_id);
                
                // store the suffixed order id to order metadata
                // @TAG: order-id-suffix-handling-meta
                $order->update_meta_data('_mt_suffixed_Finpay_order_id', $params['transaction_details']['order_id']);
            } else {
                throw $e;
            }
        }
        return $response;
    }

    /**
     * Create Snap Token.
     * @param  array $params Payment options.
     * @return object Snap response (token and redirect_url).
     * @throws Exception curl error or Finpay error.
     */
    public static function createSnapTransaction( $params, $plugin_id="Finpay" ) {
        self::fetchAndSetFinpayApiConfig( $plugin_id );
		self::setLogRequest( print_r( $params, true ), $plugin_id );
        return Finpay\Snap::createTransaction( $params );
	}
	
    /**
     * Create Recurring Transaction for Subscription Payment.
     * @param  array $params Payment options.
     * @return object Core API response (token and redirect_url).
     * @throws Exception curl error or Finpay error.
     */
    public static function createRecurringTransaction( $params, $plugin_id = 'Finpay_subscription' ) {
		self::fetchAndSetFinpayApiConfig( $plugin_id );
		self::setLogRequest( print_r( $params, true ), $plugin_id );
		return Finpay\CoreApi::charge( $params );
    }

	/**
     * Create Refund.
	 * 
	 * @param int $order_id.
     * @param  array $params Payment options.
     * @return object Refund response.
     * @throws Exception curl error or Finpay error.
     */
    public static function createRefund( $order_id, $params, $plugin_id="Finpay" ) {
		self::fetchAndSetFinpayApiConfig( $plugin_id );
		self::setLogRequest( print_r( $params, true ), $plugin_id );
		return Finpay\Transaction::refund($order_id, $params);
    }

    /**
     * Get Finpay Notification.
     * @return object Finpay Notification response.
     */
    public static function getStatusFromFinpayNotif( $plugin_id="Finpay") {
        self::fetchAndSetFinpayApiConfig( $plugin_id );
        return new Finpay\Notification();
    }

    /**
     * Retrieve transaction status. Default ID is main plugin, which is "Finpay"
     * @param string $id Order ID or transaction ID.
     * @return object Finpay response.
     */
    public static function getFinpayStatus( $order_id, $plugin_id="Finpay" ) {
        self::fetchAndSetFinpayApiConfig( $plugin_id );
        return Finpay\Transaction::status( $order_id );
    }

	/**
	 * Cancel transaction.
	 * 
	 * @param string $id Order ID or transaction ID.
	 * @param string $plugin_id Plugin id.
	 * @return object Finpay response.
	 */
    public static function CancelTransaction( $id, $plugin_id="Finpay" ) {
		self::fetchAndSetFinpayApiConfig( $plugin_id );
		self::setLogRequest('Request Cancel Transaction ' . $id, $plugin_id );
        return Finpay\Transaction::cancel( $id );
    }

    /**
     * Set log request on Finpay logger.
	 * 
     * @param string $message payload request.
     * @return void
     */
	public static function setLogRequest( $message, $plugin_id="Finpay" ) {
		WC_Finpay_Logger::log( $message, 'Finpay-request', $plugin_id, current_time( 'timestamp') );
	  }
}