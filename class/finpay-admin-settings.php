<?php
if (!defined('ABSPATH')) {
    exit;
}

$sandbox_key_url = 'https://devo.finnet.co.id/pg/payment/card/initiate';
$production_key_url = 'https://live.finnet.co.id/pg/payment/card/initiate';
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
        'username_sandbox'  => array(
            'title'         => __("Merchant ID - Sandbox", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your finpay\'s Merchant ID. Get the Merchant ID <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $sandbox_key_url),
            'default'       => '',
            'class'         => 'sandbox_settings toggle-finpay',
        ),

        'password_sandbox'  => array(
            'title'         => __("Merchant Key - Sandbox", 'finpay-woocommerce'),
            'type'          => 'password',
            'description'   => sprintf(__('Input your finpay\'s Merchant Key. Get the password <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $sandbox_key_url),
            'default'       => '',
            'class'         => 'sandbox_settings toggle-finpay'
        ),
        
        'username_production'    => array(
            'title'         => __("Merchant ID - Production", 'finpay-woocommerce'),
            'type'          => 'text',
            'description'   => sprintf(__('Input your <b>Production</b> Merchant ID. Get the key <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $production_key_url),
            'default'       => '',
            'class'         => 'production_settings toggle-finpay',
        ),
        'password_production'     => array(
            'title'         => __("Merchant Key - Production", 'finpay-woocommerce'),
            'type'          => 'password',
            'description'   => sprintf(__('Input your <b>Production</b> Merchant Key. Get the key <a href="%s" target="_blank">here</a>', 'finpay-woocommerce'), $production_key_url),
            'default'       => '',
            'class'         => 'production_settings toggle-finpay'
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
