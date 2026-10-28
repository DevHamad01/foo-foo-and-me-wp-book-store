<?php
/**
 * Home — 09 Closing call to action.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-cta">
	<?php lbff_desert_scene( 'dusk', false ); ?>
	<div class="ff-cta__content" data-reveal>
		<span class="ff-label ff-label--gold ff-label--lg">
			<?php
			/* translators: 1: book number, 2: book title. */
			echo esc_html( sprintf( __( 'Book %1$s · %2$s', 'littlebunny' ), lbff_mod( 'book_num' ), trim( lbff_mod( 'book_title_1' ) . ' ' . lbff_mod( 'book_title_2' ) ) ) );
			?>
		</span>
		<h2 class="ff-display ff-display--cta"><?php echo wp_kses( __( 'Every adventure begins<br><em>with a single page</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
		<div class="ff-btn-row ff-btn-row--center">
			<?php lbff_button( __( 'Buy on Amazon', 'littlebunny' ), lbff_mod( 'link_amazon' ) ? lbff_mod( 'link_amazon' ) : '#', lbff_link_target_attr( 'link_amazon' ) ); ?>
			<a class="ff-btn ff-btn--glass ff-btn--glass-teal" href="<?php lbff_link( 'link_kindle' ); ?>"<?php lbff_link_target( 'link_kindle' ); ?>><?php esc_html_e( 'Read on Kindle', 'littlebunny' ); ?></a>
		</div>
	</div>
</section>
