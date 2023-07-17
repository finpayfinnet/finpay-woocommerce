<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_BRI_VA extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'Finpay_sub_bri_va';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['bri_va'];
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'bri_va.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: Bank Transfer BRI VA";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('Bank Transfer - BRI VA', 'Finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('Accept transfer from any bank, and BRI account.', 'Finpay-woocommerce');
  }
}