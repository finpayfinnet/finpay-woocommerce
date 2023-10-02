<?php
  /**
   * Output HTML to display Snap Payment page
   */

  // ## Output the basic static HTML part
  ?>
  <div style="text-align: center;">

    <a id="pay-button" title="Proceed To Payment!" class="button alt">Loading Payment...</a>

    <div id="payment-instruction" style="display:none;">
      <br>
      <!-- <h3 class="alert alert-info"> Awaiting Your Payment </h3> -->
      <p> Please complete your payment as instructed. If you have already completed your payment, please check your email or "My Order" menu to get update of your order status. </p>
      <a target="_blank" href="#" id="payment-instruction-btn" title="Payment Instruction" class="button alt" >
        Payment Instruction
      </a>
    </div>
  </div>
<?php
  // ## End of output HTML
  
  // ## Dynamic part, javascript and backend stuff below

  // Ensure backward compatibility with WP version <5.7 which don't have these functions
  if( !function_exists('wp_get_script_tag')){
    WC_Finpay_Utils::polyfill_wp_get_script_tag();
  }
  if( !function_exists('wp_get_inline_script_tag')){
    WC_Finpay_Utils::polyfill_wp_get_inline_script_tag();
  }
  
  $order_items = array();
  $cart = $woocommerce->cart;
  $is_production = $this->environment == 'production';
  $username = esc_attr($this -> username);
  $password = esc_attr($this -> password);

  $wp_base_url = home_url( '/' );
  $plugin_backend_url = esc_url($wp_base_url."?wc-api=WC_Gateway_Finpay");
  $finish_url = $wp_base_url."?wc-api=WC_Gateway_Finpay";
  $pending_url = $finish_url;
  $error_url = $wp_base_url."?wc-api=WC_Gateway_Finpay";

