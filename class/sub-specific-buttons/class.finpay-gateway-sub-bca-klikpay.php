<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_BCA_Klikpay extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'finpay_sub_bca_klikpay';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['bca_klikpay'];
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'bca_klikpay.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: BCA KlikPay";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('BCA KlikPay', 'finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('', 'finpay-woocommerce');
  }
}