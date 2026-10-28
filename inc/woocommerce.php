<?php
/**
 * Light WooCommerce compatibility.
 *
 * The site currently sells through Amazon / Kindle links. If WooCommerce is
 * installed later, shop pages render inside the theme's header, page hero
 * and footer automatically (see woocommerce.php in the theme root).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare support.
 */
function lbff_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 900,
			'product_grid'          => array(
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'lbff_woocommerce_setup' );

if ( class_exists( 'WooCommerce' ) ) {
	// The theme prints its own wrapper and breadcrumbs are not part of the design.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}
