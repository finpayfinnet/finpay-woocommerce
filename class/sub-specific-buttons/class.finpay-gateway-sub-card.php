<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_Card extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'finpay_sub_card';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['credit_card'];
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'cc_amex.png,cc_jcb.png,cc_master.png,cc_visa.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: Card Payment";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('Credit/Debit Card', 'Finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('', 'Finpay-woocommerce');
  }
}