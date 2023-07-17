<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_Danamon_Online extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'finpay_sub_danamon_online';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['danamon_online'];
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'danamon_online.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: Danamon Online Banking";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('Danamon Online Banking', 'Finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('', 'Finpay-woocommerce');
  }
}