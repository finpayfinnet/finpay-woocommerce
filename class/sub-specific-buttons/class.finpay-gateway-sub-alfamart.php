<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_Alfamart extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'Finpay_sub_alfamart';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['alfamart'];
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'alfamart_1.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: Alfamart Group";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('Alfamart Group (Alfamart, Alfamidi, Dan+Dan)', 'finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('Pay from Alfamart Group, Alfamidi, Dan+Dan outlet', 'finpay-woocommerce');
  }
}