Finpay&nbsp; WooCommerce - Wordpress Payment Gateway Module
=====================================

Finpay&nbsp; :heart: WooCommerce!
Receive online payment on your WooCommerce store with Finpay payment gateway integration plugin.

<!-- Also [Available on Wordpress plugin store](https://wordpress.org/plugins/Finpay-woocommerce/) -->

### Description

This plugin will allow secure online payment on your WooCommerce store.

Finpay-WooCommerce is official plugin from [Finpay](https://hub.finpay.id). Finpay is an online payment gateway. We strive to make payments simple & secure for both the merchant and customers. Support various online payment channel.

Please follow [this step by step guide](https://docs.Finpay.com/en/snap/with-plugins?id=wordpress-woocommerce) for complete configuration. If you have any feedback or request, please [do let us know here](https://docs.Finpay.com/en/snap/with-plugins?id=feedback-and-request).

Want to see Finpay-WooCommerce payment plugins in action? We have some demo web-stores for WooCommerce that you can use to try the payment journey directly, visit the [CMS Demo Store](https://docs.Finpay.com/en/snap/with-plugins?id=Finpay-payment-plugin-live-demonstration)

Payment Method Feature:

* Credit card fullpayment and other payment methods.
* E-wallet, Bank transfer, internet banking for various banks
* Credit card Online & offline installment payment.
* Credit card BIN, bank transfer, and other channel promo payment.
* Credit card MIGS acquiring channel.
* Custom expiry.
* Two-click & One-click feature.
* Optional: Separated specific payment buttons with its own icons.


### Installation

#### Minimum Requirements

* WordPress v3.9 or greater (tested up to v5.x)
* WooCommerce v2 or greater (tested up to v3.5.2)
* PHP version v5.4 or greater
* MySQL version v5.0 or greater
* PHP CURL enabled server/host

#### Manual Installation

1. [Download](../../archive/master.zip) the plugin from this repository.
2. Extract the plugin, then rename the folder modules as **Finpay-woocommerce**
3. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installation's `wp-content/plugins/` directory.
4. Install & Activate the plugin from the Plugins menu within the WordPress admin panel.
5. Go to menu **WooCommerce > Settings > Payment > Finpay > Manage**, fill the configuration fields.
	* Fill **Title** with text button that you want to display to customer
	* Select **Environment**, Sandbox is for testing transaction, Production is for real transaction
	* Fill in the **username** & **password** with your corresonding [Finpay account](https://dashboard.finpay.id/) credentials
	* Note: **username** and **password** for Sandbox & Production is different, make sure you use the correct one.
	* Other configuration are optional, you may leave it as is.

<!-- ### Finpay Configuration

1. Login to your [Finpay&nbsp; Account](https://dashboard.finpay.id), select your environment (sandbox/production), go to menu **settings > configuration**
  * Insert `http://[your web]/?wc-api=WC_Gateway_Finpay` as your Payment Notification URL.
  * Insert `http://[your web]/?wc-api=WC_Gateway_Finpay` link as Finish/Unfinish/Error Redirect URL -->

#### Manual Clean Up WP Options Config Value of This Plugin

<details><summary>Click to expand info</summary>
<br>

In general use-case, you don't need to do what explained in this section. This section is relevent only in case **you want to know/clean-up/remove** `wp_options` config values created by this plugin. Those config values are located under your WP's database SQL table `wp_options` with record's name prefix `woocommerce_finpay_`. 
	
You can also find it by executing this SQL on your WP's database to find those values:
```sql
SELECT * FROM `wp_options` WHERE `option_name` LIKE '%woocommerce_finpay%'
```
Then if you want, you can remove the values from the SQL database (alternatively, you can also modify the SQL `SELECT` command with `DELETE`). 
	
Background: 
	
This plugin was mainly developed by following the official guideline from WooCommerce(WC), where WooCommerce provided their internal API function to create/edit WP options, we don’t use WP options API function directly. It seems the default WC Payment Gateway behavior (when uninstalled) does not include the uninstall clean up procedure to remove wp_options config values. Though that may be by design from WC, they may have decided that Gateway Settings/options should preserved during uninstall, so that upon re-install the Settings is auto-restored. For further explanation you can also [check this link](https://wordpress.org/support/topic/no-clean-uninstall-2/#post-15287583).

</details>