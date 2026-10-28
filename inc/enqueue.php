<?php
/**
 * Front-end assets.
 *
 * Fonts are self-hosted (no Google request, faster and GDPR friendly).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Asset version — file modification time during development, theme version otherwise.
 *
 * @param string $rel Path relative to the theme root.
 * @return string
 */
function lbff_asset_ver( $rel ) {
	$path = LBFF_DIR . '/' . $rel;
	return ( defined( 'WP_DEBUG' ) && WP_DEBUG && file_exists( $path ) ) ? (string) filemtime( $path ) : LBFF_VERSION;
}

/**
 * Enqueue styles and scripts.
 */
function lbff_enqueue_assets() {
	wp_enqueue_style( 'lbff-main', LBFF_URI . '/assets/css/main.css', array(), lbff_asset_ver( 'assets/css/main.css' ) );

	wp_enqueue_script( 'lbff-main', LBFF_URI . '/assets/js/main.js', array(), lbff_asset_ver( 'assets/js/main.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );

	wp_localize_script(
		'lbff-main',
		'LBFF',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'i18n'    => array(
				'play'    => __( 'Play the story', 'littlebunny' ),
				'pause'   => __( 'Pause', 'littlebunny' ),
				'sending' => __( 'Sending…', 'littlebunny' ),
				'error'   => __( 'Something went wrong. Please try again or email us directly.', 'littlebunny' ),
			),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lbff_enqueue_assets' );

/**
 * Preload the two most-used font files so headings render without a flash.
 */
function lbff_preload_fonts() {
	$fonts = ( function_exists( 'lbff_is_ar' ) && lbff_is_ar() ) ? array( 'amiri-arabic-400.woff2', 'ibm-plex-sans-arabic-400.woff2' ) : array( 'cormorant-garamond-latin.woff2', 'manrope-latin.woff2' );
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( LBFF_URI . '/assets/fonts/' . $font )
		);
	}
}
add_action( 'wp_head', 'lbff_preload_fonts', 1 );

/**
 * Runs before first paint:
 *  • marks the document as JS-enabled (reveal animations, skeletons),
 *  • shows the loading screen on the first page of a visit,
 *  • plays the arrival half of the page transition in browsers without
 *    native cross-page View Transitions.
 */
function lbff_head_boot() {
	?>
<script>(function(d){var h=d.documentElement;h.classList.add('ff-js');try{var s=sessionStorage,r=window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches;if(!s.getItem('lbff_seen')&&!r){h.classList.add('ff-loading');}if(s.getItem('lbff_nav')){s.removeItem('lbff_nav');if(!('onpagereveal' in window)){h.classList.add('ff-arriving');}}}catch(e){}})(document);</script>
	<?php
}
add_action( 'wp_head', 'lbff_head_boot', 0 );

/**
 * Brand colour for mobile browser chrome.
 */
function lbff_theme_color() {
	echo '<meta name="theme-color" content="#073B46">' . "\n";
}
add_action( 'wp_head', 'lbff_theme_color', 2 );
