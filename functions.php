<?php
/**
 * Little Bunny Foo Foo — theme bootstrap.
 *
 * Every feature lives in its own file inside /inc so the theme stays easy to
 * read and maintain. This file only defines constants and loads them.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

define( 'LBFF_VERSION', '1.2.4' );
define( 'LBFF_DIR', get_template_directory() );
define( 'LBFF_URI', get_template_directory_uri() );

$lbff_includes = array(
	'inc/i18n.php',           // English / Arabic switch (runs first: it reads the URL).
	'inc/setup.php',          // Theme supports, menus, image sizes.
	'inc/enqueue.php',        // Styles, scripts, fonts.
	'inc/image-slots.php',    // Registry of every editable image on the site.
	'inc/illustrations.php',  // Drawn SVG scenes shown until real images are added.
	'inc/template-tags.php',  // Small rendering helpers used by templates.
	'inc/customizer.php',     // Appearance → Customize settings.
	'inc/post-types.php',     // "Activities" downloadable resources.
	'inc/forms.php',          // Contact form + newsletter handlers.
	'inc/activation.php',     // Creates pages + menu on theme activation.
	'inc/woocommerce.php',    // Light WooCommerce compatibility for later.
);

foreach ( $lbff_includes as $lbff_file ) {
	require_once LBFF_DIR . '/' . $lbff_file;
}
unset( $lbff_includes, $lbff_file );
