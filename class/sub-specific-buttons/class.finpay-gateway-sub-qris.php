<?php
if (! defined('ABSPATH')) { exit; }
/**
 * Class for each sub separated gateway buttons extending Abstract "Sub" class
 */
class WC_Gateway_Finpay_Sub_QRIS extends WC_Gateway_Finpay_Abstract_Sub {
  function __construct() {
    // used as plugin id
    $this->id = 'Finpay_sub_qris';
    // used as Snap enabled_payments params.
    $this->sub_payment_method_params = ['gopay']; // via gopay, since Snap don't have 'qris' standalone method
    // used to display icons on customer side's payment buttons.
    $this->sub_payment_method_image_file_names_str_final = 'qris.png';

    parent::__construct();
  }

  public function pluginTitle() {
    return "Finpay Specific: QRIS";
  }
  public function getSettingsDescription() {
    return "Separated payment buttons for this specific the payment methods with its own icons";
  }
  protected function getDefaultTitle () {
    return __('QRIS', 'Finpay-woocommerce');
  }
  protected function getDefaultDescription () {
    return __('Pay with any QRIS compatible e-wallets or banking app (GoPay, ShopeePay, OVO, DANA, LinkAja, and other e-wallets).', 'Finpay-woocommerce');
  }
}