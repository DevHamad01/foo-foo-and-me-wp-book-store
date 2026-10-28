<?php
/**
 * WooCommerce wrapper (used only if WooCommerce is installed later).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( is_singular( 'product' ) ) {
	$lbff_title = get_the_title();
} elseif ( function_exists( 'woocommerce_page_title' ) ) {
	$lbff_title = woocommerce_page_title( false );
} else {
	$lbff_title = __( 'Shop', 'littlebunny' );
}

get_template_part(
	'template-parts/global/page-hero',
	null,
	array(
		'kicker' => __( 'The shop', 'littlebunny' ),
		'title'  => $lbff_title,
	)
);
?>
<section class="ff-section ff-bg-cream ff-shop">
	<div class="ff-container">
		<?php
		if ( function_exists( 'woocommerce_content' ) ) {
			woocommerce_content();
		}
		?>
	</div>
</section>
<?php
get_footer();
