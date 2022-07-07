<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class PayFast_MoreTyme_product_page {

	public function __construct() {
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'woocommerce_before_add_to_cart_button_func' ), 10 );
	}
	public function woocommerce_before_add_to_cart_button_func()
	{
        global $product;

        $productPrice = $product->get_price();

        $settings = [
            'amount' => $productPrice,
            'theme' => get_option('pf-mt-theme', null),
            'font' => get_option('pf-mt-font', 'Lato'),
            'font-color' => get_option('pf-mt-font-color', null),
            'link-color' => get_option('pf-mt-link-color', null),
            'logo-align' => get_option('pf-mt-logo-align', null),
            'logo-type' => get_option('pf-mt-logo-type', null),
            'size' => get_option('pf-mt-size', null),
        ];
        if($productPrice >= 50) {
            echo "<script async src='https://content.payfast.co.za/widgets/moretyme/widget.min.js?" . str_replace('%23', '#', http_build_query($settings)) . "' type='text/javascript'></script>";
        }
        ?>
        <br>
        <?php
	}

}
new PayFast_MoreTyme_product_page;
