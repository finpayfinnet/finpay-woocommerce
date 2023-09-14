<?php
/*
Plugin Name: finpay - WooCommerce Payment Gateway
Plugin URI: https://github.com/finpayfinnet/finpay-woocommerce
Description: Accept all payment directly on your WooCommerce site in a seamless and secure checkout environment with <a  target="_blank" href="https://finpay.com/">finpay</a>
Version: 2.32.2
Author: Finpay
Author URI: https://finpay.id
License: GPLv2 or later
WC requires at least: 2.0.0
WC tested up to: 7.2.2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

  /**
   * ### finpay Payment Plugin for Wordrpress-WooCommerce ###
   *
   * This plugin allow your Wordrpress-WooCommerce to accept payment from customer using finpay Payment Gateway solution.
   *
   * @category   Wordrpress-WooCommerce Payment Plugin
   * @author     Caisar Oentoro <caisar@finnet.co.id>
   * @link       https://hub.finpay.id/
   * (This plugin is made based on Payment Plugin Template by WooCommerce)
   */
  
  /**
   * This file is the WP/WC plugin main entry point, all other files are imported and registered from within this file.
   */

// Make sure we don't expose any info if called directly
add_action( 'plugins_loaded', 'finpay_gateway_init', 0 );

function finpay_gateway_init() {

  if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
    return;
  }

  DEFINE ('FINPAY_PLUGIN_DIR_URL', plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) . '/' );
  DEFINE ('FINPAY_PLUGIN_VERSION', get_file_data(__FILE__, array('Version' => 'Version'), false)['Version'] );
  
  if(!class_exists("finpay\Config")){
    include_once dirname( __FILE__ ) . '/lib/finpay/Finpay.php';
  }
  // shared imports
  require_once dirname( __FILE__ ) . '/abstract/abstract.finpay-gateway.php';
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-notif-handler.php';
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-api.php';
  // utils imports
  require_once dirname( __FILE__ ) . '/class/class.finpay-utils.php';
  require_once dirname( __FILE__ ) . '/class/class.finpay-logger.php';
  // main gateway imports
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway.php';

  add_filter( 'woocommerce_payment_gateways', 'finpay_add_payment_gateway' );
  add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'finpay_plugin_action_links' );
}

function finpay_add_payment_gateway( $methods ) {
  /**
   * Payment methods are separated as different method/class so it will be separated
   * as different payment button. This is needed because each of 'feature' like Promo,
   * require special backend treatment (i.e. applying discount and locking payment channel). 
   * Especially Offline Installment, it requires `whitelist_bins` so it should not be combined 
   * with other payment feature.
   * Order of these will determine the order of gateway/button shown on WC payment config page
   */
  // main gateways
  $methods[] = 'WC_Gateway_Finpay';
  // Add this payment method if WooCommerce Subscriptions plugin activated
  if( class_exists( 'WC_Subscriptions' ) ) {
    $methods[] = 'WC_Gateway_Finpay_Subscription';
  }
  return $methods;
}
/**
 * BCA Klikpay, CIMB Clicks, and other direct banking payment channel will need finish url
 * to handle redirect after payment complete, especially BCA, may require custom finish url
 * required by BCA team as UAT process.
 */
function finpay_handle_finish_url_page()
{
  if(is_page('finpay-payment-finish')){ 
    include(dirname(__FILE__) . '/class/finish-url-page.php');
    die();
  }
}
add_action( 'wp', 'finpay_handle_finish_url_page' );

/**
 * Adds plugin action links
 *
 * @param array $links
 */
function finpay_plugin_action_links($links){
  $plugin_links = array(
      '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=finpay') . '">' . __('Settings', 'finpay-woocommerce') . '</a>',
      '<a target="_blank" href="https://hub.finpay.id/docs/overview">' . __('Documentation', 'finpay-woocommerce') . '</a>',
      '<a target="_blank" href="https://hub.finpay.id/docs/overview">' . __('Wiki', 'finpay-woocommerce') . '</a>',
  );
  return array_merge($plugin_links, $links);
}
