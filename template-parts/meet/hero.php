<?php
/**
 * Meet — 01 Hero.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-hero ff-hero--meet" aria-label="<?php esc_attr_e( 'Meet Foo Foo', 'littlebunny' ); ?>">
	<?php lbff_desert_scene( 'dusk' ); ?>
	<div class="ff-hero__content ff-hero__content--wide">
		<?php lbff_kicker( __( 'The character', 'littlebunny' ) ); ?>
		<h1 class="ff-hero__title ff-hero__title--meet"><span class="ff-hero__pre"><?php esc_html_e( 'Meet', 'littlebunny' ); ?></span><?php esc_html_e( 'Foo Foo', 'littlebunny' ); ?></h1>
		<p class="ff-hero__quote"><?php esc_html_e( '“Every adventure begins with curiosity.”', 'littlebunny' ); ?></p>
	</div>
	<div class="ff-glass ff-hero__note ff-hero__note--bottom">
		<span class="ff-label ff-label--gold"><?php esc_html_e( 'Field notes', 'littlebunny' ); ?></span>
		<span class="ff-hero__note-text"><?php echo wp_kses( __( 'Desert rabbit · Lives near Medina<br>Favourite hour: just before sunset', 'littlebunny' ), lbff_inline_kses() ); ?></span>
	</div>
</section>
