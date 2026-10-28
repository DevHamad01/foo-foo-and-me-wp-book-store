<?php
/**
 * Compact desert hero for regular pages, posts and archives.
 *
 * Args: kicker, title, text.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_kicker = isset( $args['kicker'] ) ? $args['kicker'] : '';
$lbff_title  = isset( $args['title'] ) ? $args['title'] : get_the_title();
$lbff_text   = isset( $args['text'] ) ? $args['text'] : '';
?>
<section class="ff-pagehero">
	<?php lbff_desert_scene( 'teal' ); ?>
	<div class="ff-pagehero__content">
		<?php if ( $lbff_kicker ) : ?>
			<?php lbff_kicker( $lbff_kicker ); ?>
		<?php endif; ?>
		<h1 class="ff-pagehero__title"><?php echo wp_kses( $lbff_title, lbff_inline_kses() ); ?></h1>
		<?php if ( $lbff_text ) : ?>
			<p class="ff-pagehero__text"><?php echo wp_kses_post( $lbff_text ); ?></p>
		<?php endif; ?>
	</div>
</section>
