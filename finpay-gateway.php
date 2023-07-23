<?php
/*
Plugin Name: finpay - WooCommerce Payment Gateway
Plugin URI: https://github.com/veritrans/SNAP-Woocommerce
Description: Accept all payment directly on your WooCommerce site in a seamless and secure checkout environment with <a  target="_blank" href="https://finpay.com/">finpay</a>
Version: 2.32.2
Author: finpay
Author URI: http://finpay.co.id
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
   * @author     Rizda Dwi Prasetya <rizda.prasetya@finpay.com>
   * @link       http://docs.finpay.com
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
  // sub gateway imports
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-installment.php';
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-installmentoff.php';
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-promo.php';
  require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-paymentrequest.php';
  // shared abstract import for sub separated gateway buttons
  // require_once dirname( __FILE__ ) . '/abstract/abstract.finpay-gateway-sub.php';
  // sub separated gateway buttons imports, add new methods under here
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-card.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-gopay.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-shopeepay.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-qris.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-bca-va.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-bni-va.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-bri-va.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-permata-va.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-echannel.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-other-va.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-akulaku.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-bca-klikpay.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-bri-epay.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-cimb-clicks.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-danamon-online.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-alfamart.php';
  // require_once dirname( __FILE__ ) . '/class/sub-specific-buttons/class.finpay-gateway-sub-indomaret.php';

  // Add this payment method if WooCommerce Subscriptions plugin activated
  // if( class_exists( 'WC_Subscriptions' ) ) {
  //   require_once dirname( __FILE__ ) . '/class/class.finpay-gateway-subscription.php';
  // }

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
  // sub separated gateway buttons, add new methods under here
  // $methods[] = 'WC_Gateway_finpay_Sub_Card';
  // $methods[] = 'WC_Gateway_finpay_Sub_Gopay';
  // $methods[] = 'WC_Gateway_finpay_Sub_Shopeepay';
  // $methods[] = 'WC_Gateway_finpay_Sub_QRIS';
  // $methods[] = 'WC_Gateway_finpay_Sub_BCA_VA';
  // $methods[] = 'WC_Gateway_finpay_Sub_BNI_VA';
  // $methods[] = 'WC_Gateway_finpay_Sub_BRI_VA';
  // $methods[] = 'WC_Gateway_finpay_Sub_Permata_VA';
  // $methods[] = 'WC_Gateway_finpay_Sub_Echannel';
  // $methods[] = 'WC_Gateway_finpay_Sub_Other_VA';
  // $methods[] = 'WC_Gateway_finpay_Sub_Akulaku';
  // $methods[] = 'WC_Gateway_finpay_Sub_BCA_Klikpay';
  // $methods[] = 'WC_Gateway_finpay_Sub_BRI_Epay';
  // $methods[] = 'WC_Gateway_finpay_Sub_CIMB_Clicks';
  // $methods[] = 'WC_Gateway_finpay_Sub_Danamon_Online';
  // $methods[] = 'WC_Gateway_finpay_Sub_Alfamart';
  // $methods[] = 'WC_Gateway_finpay_Sub_Indomaret';
  // additional gateways
  // $methods[] = 'WC_Gateway_finpay_Installment';
  // $methods[] = 'WC_Gateway_finpay_InstallmentOff';
  // $methods[] = 'WC_Gateway_finpay_Promo';
  // $methods[] = 'WC_Gateway_Finpay_Paymentrequest';
  
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
