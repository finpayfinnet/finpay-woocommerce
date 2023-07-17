=== -WooCommerce ===
Contributors: oentoro
Tags: Finpay, snap, payment, payment-gateway, credit-card, commerce, e-commerce, woocommerce, finnet
Requires at least: 3.9.1
Tested up to: 6.1
Stable tag: 2.32.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Finpay-WooCommerce is plugin for Finpay, Indonesian Payment Gateway. Brings safety and highly dedicated to customer experience (UX) to WooCommerce

== Description ==

This plugin will allow secure online payment on your WooCommerce store, without your customer ever need to leave your WooCommerce store! 

Finpay-WooCommerce is official plugin from [Finpay](https://finpay.id). Finpay is an online payment gateway. We strive to make payments simple & secure for both the merchant and customers. Support various online payment channel. Support WooCommerce v3 & v2.

Please follow [this step by step guide](https://docs.finpay.id/en/snap/with-plugins?id=wordpress-woocommerce) for complete configuration. If you have any feedback or request, please [do let us know here](https://docs.finpay.id/en/snap/with-plugins?id=feedback-and-request).

Payment Method Feature:

* Credit card fullpayment and other payment methods.
* E-wallet, Bank transfer, internet banking for various banks
* Credit card Online & offline installment payment.
* Credit card BIN, bank transfer, and other channel promo payment.
* Credit card MIGS acquiring channel.
* Custom expiry.
* Two-click & One-click feature.
* Finpay Snap all supported payment method.
* Optional: Separated specific payment buttons with its own icons.

== Installation ==

1. Upload the plugin files to the `wp-content/plugins/Finpay-woocommerce` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the `Plugins` screen in WordPress
3. Go to **WooCommerce - Settings - Payments - Finpay** menu, fill the configuration fields.

### Finpay Configuration

1. Login to Finpay Dashboard.
2. Select the environment (sandbox or production).
3. Go to **settings - configuration**

    - Insert `[YourWebHomepageUrl]/?wc-api=WC_Gateway_Finpay` as your Payment Notification URL
    - Insert `[YourWebHomepageUrl]/?wc-api=WC_Gateway_Finpay` as your Finish, Pending and Error Redirect URL


== Frequently Asked Questions ==

= Where can find my access key (client & server key)? How to get Started? =

Register first to [Finpay](https://account.finpay.id/register), you will get the access key on Finpay Dashboard.
Also please refere to this official [documentation](https://docs.finpay.id/en/snap/with-plugins?id=wordpress-woocommerce).

= How to configure installment and other additional feature ? =

Please refer to [Wiki](https://github.com/finnet/SNAP-Woocommerce/wiki) for full documentation and tutorial.

= Where can I report bugs and request feature? =

The best way please email to support@finpay.id, but bugs can be reported in our [repo](https://github.com/finnet/SNAP-Woocommerce/issues), or you can also use WordPress plugins support for reporting bugs and error. 

== Screenshots ==

1. Payment displayed as popup, your customer no need to leave your store!

2. Various payment channel

3. Support for additional feature like installment & promo.

4. Configuration page