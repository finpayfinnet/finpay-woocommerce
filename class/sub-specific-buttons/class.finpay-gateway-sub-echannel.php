<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_Echannel extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'Finpay_sub_echannel';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['echannel'];
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'echannel.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: Bank Transfer Mandiri Bill Payment";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('Bank Transfer - Mandiri Bill Payment', 'Finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('Only accept Bill Payment from Mandiri account.', 'Finpay-woocommerce');
  }
}