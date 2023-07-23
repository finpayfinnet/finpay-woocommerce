<?php
if (! defined('ABSPATH')) {
  exit;
}

/**
 * WC_Gateway_Finpay_Abstract_Sub Class
 * Abstract class prototype to be extended by sub gateway separated buttons.
 * Because Finpay WC plugins have separate buttons for each payment methods.
 */
abstract class WC_Gateway_Finpay_Abstract_Sub extends WC_Gateway_Finpay_Abstract {

  /**
   * Constructor
   */
  function __construct() {
    // $this->id = ''; // override me. sample: 'Finpay_sub_other_va';
    // $this->sub_payment_method_params =  []; // override me. sample: ['other_va'];
    // $this->sub_payment_method_image_file_names_str_final =  []; // override me. sample: 'other_va.png,other_va_2.png';
    // override above values when extending this class

    $this->method_title = __( $this->pluginTitle(), 'finpay-woocommerce' );
    $this->method_description = __( $this->getSettingsDescription(), 'finpay-woocommerce');
    $this->main_gateway = false;

    parent::__construct();
    add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) ); 
    // maybe replace $this->id with main gateway id?
    add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'receipt_page' ) );// Payment page hook
  }

  /**
   * Hook function that will be auto-called by WC, this determine what will be shown on Gateway config page on WP panel
   * Admin Panel Options
   * - Options for bits like 'title' and availability on a country-by-country basis
   * @access public
   * @return void
   */
  public function admin_options() { 
    ?>
    <h3><?php _e( $this->pluginTitle(), 'finpay-woocommerce' ); ?></h3>
    <p><?php _e( $this->getSettingsDescription(), 'finpay-woocommerce' ); ?></p>
    <table class="form-table">
      <?php
        // Generate the HTML For the settings form. Built in WC function
      $this->generate_settings_html();
      ?>
    </table><!--/.form-table-->
    <?php
  }

  /**
   * Initialise Gateway Settings Form Fields
   * Hook function that will be auto-called by WC, this determine what will be shown on Gateway config page on WP panel, likely called from generate_settings_html() above.
   */
  function init_form_fields() {
    $this->form_fields = 
    apply_filters(
      'wc_finpay_settings',
      array(
        'enabled'       => array(
          'title'     => __( 'Enable/Disable', 'finpay-woocommerce' ),
          'type'      => 'checkbox',
          'label'     => __( 'Enable this specific payment methods', 'finpay-woocommerce' ),
          'default'   => 'no'
        ),
        'title'                     => array(
          'title'         => __( 'Payment Title', 'finpay-woocommerce' ),
          'type'          => 'text',
          'description'   => __( 'This controls the payment label title which the user sees during checkout. <a href="https://github.com/veritrans/SNAP-Woocommerce#configurables"  target="_blank">This support HTML tags</a> like &lt;img&gt; tag, if you want to include images.', 'finpay-woocommerce' ),
          'placeholder'       => $this->getDefaultTitle(),
          'default'       => $this->getDefaultTitle(),
        // 'desc_tip'      => true,
        ),
        'description'               => array(
          'title' => __( 'Payment Description', 'finpay-woocommerce' ),
          'type' => 'textarea',
          'description' => __( 'You can customize here the expanded description which the user sees during checkout when they choose this payment. <a href="https://github.com/veritrans/SNAP-Woocommerce#configurables"  target="_blank">This support HTML tags</a> like &lt;img&gt; tag, if you want to include images.', 'finpay-woocommerce' ),
          'placeholder'       => $this->getDefaultDescription(),
          'default'       => $this->getDefaultDescription(),
        ),
        'advanced_config_separator'             => array(
          'title'         => __( 'Note:', 'finpay-woocommerce' ),
          'type'          => 'title',
          'description'   => __( 'Other configurations by default will follow main Finpay Payment plugin config'),
        ),
      )
    );
  }
  /**
   * Override Hook function that will be auto-called by WC on customer initiate payment
   * act as entry point when payment process is initated
   * @param  string $order_id generated from WC
   * @return array contains redirect_url of payment for customer
   */
  function process_payment( $order_id ) {
    $main_gateway = $this->getMainGatewayObject();
    // pass through the real function from main gateway implementation, with options params
    return $main_gateway->process_payment_helper(
      $order_id, 
      array('sub_payment_method_params' => $this->sub_payment_method_params)
    );
  }

  /**
   * Hook function that will be auto-called by WC on receipt page
   * Output HTML for Snap payment page. Including `snap.pay()` part
   * @param  string $order_id generated by WC
   * @return string HTML
   */
  function receipt_page( $order_id ) {
    // pass through the real function from main gateway implementation
    $main_gateway = $this->getMainGatewayObject();
    $main_gateway->set_sub_payment_method_id($this->id);
    return $main_gateway->receipt_page($order_id);
  }

  /**
   * @return string Title for plugin config page
   */
  abstract public function pluginTitle ();
  
  /**
   * @return string Description for plugin config page
   */
  abstract public function getSettingsDescription ();

  /**
   * Commented out to prevent this issue: https://www.php.net/manual/en/language.oop5.abstract.php#78388 on likely specific PHP version bug only https://stackoverflow.com/a/22521203
   * @return string Config field: Title for pay button label for customer
   */
  // abstract protected function getDefaultTitle ();

  /**
   * Commented out to prevent this issue: https://www.php.net/manual/en/language.oop5.abstract.php#78388 on likely specific PHP version bug only https://stackoverflow.com/a/22521203
   * @return string Config field: Description for pay button label for customer
   */
  // abstract protected function getDefaultDescription ();

  /**
   * @return WC_Gateway_Finpay
   */
  protected function getMainGatewayObject(){
    if ($this->main_gateway && $this->main_gateway->id) {
      // main gateway exist, do nothing
    } else {
      $this->main_gateway = new WC_Gateway_Finpay();
    }
    return $this->main_gateway;
  }

}