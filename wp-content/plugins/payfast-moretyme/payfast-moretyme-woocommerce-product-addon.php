<?php
/**
 * Plugin Name: PayFast MoreTyme
 * Description:	This plugin adds the PayFast MoreTyme payment details to your product page.
 * Version: 1.0.0
 * Author: PayFast
 * Author URI: https://www.payfast.co.za
 * Text Domain: payfast-moretyme-product-addon-for-woocommerce
*/

define( 'PAYFAST_MORETYME_PRODUCT_ADDON_VERSION', '1.0.0' );
/**
 * Plugin activation check
 */
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  )
{

	class payfast_moretyme {

		public function __construct() {
			include_once('includes/payfast-moretyme-product-page.php');
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}

		public function init() {
			load_plugin_textdomain( 'payfast-moretyme-product-addon-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/i18n/' );
		}
	}

	new payfast_moretyme;
}

//submenu in woocommerce
add_action( 'admin_menu', 'payfast_moretyme_admin_page' );
function payfast_moretyme_admin_page() {
	add_submenu_page( 'woocommerce', 'Product Price Custom Text & Discount', 'Product Price Custom Text & Discount', 'manage_options', 'admin.php?page=wc-settings&tab=payfast-moretyme' );
}
require 'includes/payfast-moretyme-settings.php';
