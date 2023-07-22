<?php
if (!defined('ABSPATH')) {
    exit;
}

$sandbox_key_url = 'https://devo.finnet.co.id/pg/payment/card/initiate';
$production_key_url = 'https://devo.finnet.co.id/pg/payment/card/initiate';
/**
 * Build array of configurations that will be displayed on Admin Panel
 */
return apply_filters(
    'wc_finpay_settings',
    array(
        'enabled'       => array(
            'title'     => __('Enable/Disable', 'finpay-woocommerce'),
            'type'      => 'checkbox',
            'label'     => __('Enable finpay Payment', 'finpay-woocommerce'),
            'default'   => 'no'
        ),
        'select_finpay_environment' => array(
            'title'           => __('Environment', 'finpay-woocommerce'),
            'type'            => 'select',
            'default'         => 'sandbox',
            'description'     => __('Select the finpay Environment', 'finpay-woocommerce'),
            'options'         => array(
                'sandbox'           => __('Sandbox', 'finpay-woocommerce'),
                'production'        => __('Production', 'finpay-woocommerce'),
            ),
        ),
        'username'                => array(
            'title'         => __("Username", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your finpay\'s merchant username. Get the username <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $sandbox_key_url),
            'default'       => '',
        ),

        'client_key_v2_sandbox'       => array(
            'title'         => __("Client Key - Sandbox", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your <b>Sandbox</b> finpay Client Key. Get the key <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $sandbox_key_url),
            'default'       => '',
            'class'         => 'sandbox_settings toggle-finpay',
        ),
        'server_key_v2_sandbox'       => array(
            'title'         => __("Server Key - Sandbox", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your <b>Sandbox</b> finpay Server Key. Get the key <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $sandbox_key_url),
            'default'       => '',
            'class'         => 'sandbox_settings toggle-finpay'
        ),
        'client_key_v2_production'    => array(
            'title'         => __("Client Key - Production", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your <b>Production</b> finpay Client Key. Get the key <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $production_key_url),
            'default'       => '',
            'class'         => 'production_settings toggle-finpay',
        ),
        'server_key_v2_production'     => array(
            'title'         => __("Server Key - Production", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your <b>Production</b> finpay Server Key. Get the key <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $production_key_url),
            'default'       => '',
            'class'         => 'production_settings toggle-finpay'
        ),
        'notification_url_display'             => array(
            'title'         => __('Notification URL value', 'finpay-woocommerce'),
            'type'          => 'title',
            'description'   => __('After you have filled required config above, don\'t forget to scroll to bottom and click  <strong>Save Changes</strong> button.</br></br>Copy and use this recommended Notification URL <code>' . $this->get_main_notification_url() . '</code> into "<strong><a href="https://account.finpay.com/" target="_blank">finpay Dashboard</a> > Settings > Configuration > Notification Url</strong>". This will allow your WooCommerce to receive finpay payment status, which auto sync the payment status.', 'finpay-woocommerce'),
        ),
        'label_config_separator'             => array(
            'title'         => __('II. Payment Buttons Appereance Section - Optional', 'finpay-woocommerce'),
            'type'          => 'title',
            'description'   => __('-- Configure how the payment button will appear to customer, you can leave them default.', 'finpay-woocommerce'),
        ),
        'title'                     => array(
            'title'         => __('Button Title', 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => __('This controls the payment label title which the user sees during checkout. <a href="https://github.com/veritrans/SNAP-Woocommerce#configurables"  target="_blank">This support HTML tags</a> like &lt;img&gt; tag, if you want to include images.', 'finpay-woocommerce'),
            'default'       => $this->getDefaultTitle(),
            // 'desc_tip'      => true,
        ),
        'description'               => array(
            'title' => __('Button Description', 'finpay-woocommerce'),
            'type' => 'textarea',
            'description' => __('You can customize here the expanded description which the user sees during checkout when they choose this payment. <a href="https://github.com/veritrans/SNAP-Woocommerce#configurables"  target="_blank">This support HTML tags</a> like &lt;img&gt; tag, if you want to include images.', 'finpay-woocommerce'),
            'default'       => $this->getDefaultDescription(),
        ),
        'sub_payment_method_image_file_names_str' => array(
            'title' => __('Button Icons', 'finpay-woocommerce'),
            'type' => 'text',
            'description' => __('You can input multiple payment method names separated by coma (,). </br>See <a href="https://github.com/veritrans/SNAP-Woocommerce#customize-payment-icons" target="_blank">all available values here</a>, you can copy paste the value, and adjust as needed. Also support https:// url to external image.', 'finpay-woocommerce'),
            'placeholder'       => 'finpay.png,credit_card.png',
        ),
        'advanced_config_separator'             => array(
            'title'         => __('III. Advanced Config Section - Optional', 'finpay-woocommerce'),
            'type'          => 'title',
            'description'   => __('-- Configurations below is optional and don\'t need to be changed, you can leave them default. Unless you know you want advanced configuration --', 'finpay-woocommerce'),
        ),
        'enable_3d_secure'             => array(
            'title'         => __('Enable 3D Secure', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'         => __('Enable 3D Secure?', 'finpay-woocommerce'),
            'description'   => __('You should enable 3D Secure.
                Please contact us if you wish to disable this feature in the Production environment.', 'finpay-woocommerce'),
            'default'       => 'yes'
        ),
        'enable_savecard'               => array(
            'title'         => __('Enable Save Card', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'         => __('Enable Save Card?', 'finpay-woocommerce'),
            'description'   => __('This will allow your customer to save their card on the payment popup, for faster payment flow on the following purchase', 'finpay-woocommerce'),
            'class'         => 'toggle-advanced',
            'default'       => 'no'
        ),
        'custom_payment_complete_status' => array(
            'title'         => __('WC Order Status on Payment Paid', 'finpay-woocommerce'),
            'type'          => 'select',
            'label'         => __('Map WC Order status to value', 'finpay-woocommerce'),
            'description'   => __('The status that WooCommerce Order should become when an order is successfully paid. This can be useful if you want, for example, order status to become "completed" once paid.', 'finpay-woocommerce'),
            'class'         => 'toggle-advanced',
            'options' => array(
                'default' => __('default', 'finpay-woocommerce'),
                'processing' => __('processing', 'finpay-woocommerce'),
                'completed' => __('completed', 'finpay-woocommerce'),
                'on-hold' => __('on-hold', 'finpay-woocommerce'),
                'pending' => __('pending', 'finpay-woocommerce'),
            ),
            'default'       => 'default'
        ),
        'enable_redirect'               => array(
            'title'         => __('Redirect payment mode', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'         => __('Enable redirection for payment page?', 'finpay-woocommerce'),
            'description'   => __('This will redirect customer to finpay hosted payment page instead of popup payment page on your website. <br>Useful if you encounter issue with payment page on your website.', 'finpay-woocommerce'),
            'class'         => 'toggle-advanced',
            'default'       => 'no'
        ),
        'custom_expiry'                 => array(
            'title'         => __('Custom Expiry', 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => __('This will allow you to set custom duration on how long the transaction available to be paid.<br> example: 45 minutes', 'finpay-woocommerce'),
            'default'       => 'disabled'
        ),
        'custom_fields'                 => array(
            'title'         => __('Custom Fields', 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => __('This will allow you to set custom fields that will be displayed on finpay dashboard. <br>Up to 3 fields are available, separate by coma (,) <br> Example:  Order from web, Woocommerce, Processed', 'finpay-woocommerce'),
            'default'       => ''
        ),
        'enable_map_finish_url'         => array(
            'title'         => __('Use Dashboard Finish url', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'         => 'Use dashboard configured payment finish url?',
            'description'   => __('This will alternatively redirect customer to Dashboard configured payment finish url instead of auto configured url, after payment is completed', 'finpay-woocommerce'),
            'default'       => 'no'
        ),
        'ganalytics_id'                 => array(
            'title'         => __('Google Analytics ID', 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => __('This will allow you to use Google Analytics tracking on woocommerce payment page. <br>Input your tracking ID ("UA-XXXXX-Y") <br> Leave it blank if you are not sure', 'finpay-woocommerce'),
            'default'       => ''
        ),
        'enable_immediate_reduce_stock' => array(
            'title'         => __('Immediate Reduce Stock', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'         => 'Immediately reduce item stock on finpay payment pop-up?',
            'description'   => __('By default, item stock only reduced if payment status on finpay reach pending/success (customer choose payment channel and click pay on payment pop-up). Enable this if you want to immediately reduce item stock when payment pop-up generated/displayed.', 'finpay-woocommerce'),
            'default'       => 'no'
        ),
        // @Note: only main plugin class config will be applied on notif handler, sub plugin class config will not affect it, check gateway-notif-handler.php class to fix
        'ignore_pending_status'         => array(
            'title'         => __('Ignore finpay Transaction Pending Status', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'         => __('Ignore finpay Transaction Pending Status?', 'finpay-woocommerce'),
            'description'   => __('This will prevent customer for being redirected to "order received" page, on unpaid async payment type. <br>Backend pending notification will also ignored, and will not change to "on-hold" status. <br>Leave it disabled if you are not sure', 'finpay-woocommerce'),
            'class'         => 'toggle-advanced',
            'default'       => 'no'
        ),
        'logging' => array(
            'title'         => __('Enable finpay Logging', 'finpay-woocommerce'),
            'type'          => 'checkbox',
            'label'       => __('Log debug messages', 'finpay-woocommerce'),
            'description' => __('Save debug messages to the WooCommerce System Status log.', 'finpay-woocommerce'),
            'default'       => 'no'
        ),
    )
);
