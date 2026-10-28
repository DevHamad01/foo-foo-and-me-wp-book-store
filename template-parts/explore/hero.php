<?php
/**
 * Explore — 01 Hero with "On this page" index.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_index = array(
	array( __( 'Read & Listen', 'littlebunny' ), '#listen' ),
	array( __( 'Activities', 'littlebunny' ), '#activities' ),
	array( __( 'Little Explorers', 'littlebunny' ), '#little' ),
	array( __( 'Big Adventure', 'littlebunny' ), '#big' ),
	array( __( 'Parents & Educators', 'littlebunny' ), '#educators' ),
	array( __( 'Contact', 'littlebunny' ), '#contact' ),
);
?>
<section class="ff-hero ff-hero--explore" aria-label="<?php esc_attr_e( 'Explore', 'littlebunny' ); ?>">
	<?php lbff_desert_scene( 'teal' ); ?>
	<div class="ff-hero__content ff-hero__content--explore">
		<?php lbff_kicker( __( 'Resources · Activities · Experiences', 'littlebunny' ) ); ?>
		<h1 class="ff-hero__title ff-hero__title--explore"><?php echo wp_kses( __( 'Explore<br><em>beyond</em> the story', 'littlebunny' ), lbff_inline_kses() ); ?></h1>
		<p class="ff-hero__lede"><?php esc_html_e( 'Read-alouds, activities and real-world experiences that carry Foo Foo’s curiosity off the page and into the day.', 'littlebunny' ); ?></p>
	</div>
	<nav class="ff-glass ff-onpage" aria-label="<?php esc_attr_e( 'On this page', 'littlebunny' ); ?>">
		<span class="ff-label ff-label--gold"><?php esc_html_e( 'On this page', 'littlebunny' ); ?></span>
		<?php foreach ( $lbff_index as $lbff_i => $lbff_x ) : ?>
			<a class="ff-onpage__link" href="<?php echo esc_attr( $lbff_x[1] ); ?>"><span><?php echo esc_html( $lbff_x[0] ); ?></span><span class="ff-onpage__num"><?php echo esc_html( sprintf( '%02d', $lbff_i + 1 ) ); ?></span></a>
		<?php endforeach; ?>
	</nav>
</section>
