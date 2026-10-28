<?php
/**
 * Books — 01 Hero.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-hero ff-hero--books" aria-label="<?php esc_attr_e( 'The books', 'littlebunny' ); ?>">
	<?php lbff_desert_scene( 'teal' ); ?>
	<div class="ff-hero__content">
		<?php lbff_kicker( __( 'The catalogue', 'littlebunny' ) ); ?>
		<h1 class="ff-hero__title ff-hero__title--books"><?php echo wp_kses( __( 'The<br><em>Books</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h1>
		<p class="ff-hero__quote"><?php esc_html_e( 'Stories created for curious minds.', 'littlebunny' ); ?></p>
	</div>
	<div class="ff-hero__bigbook ff-float"><?php lbff_book_cover(); ?></div>
	<div class="ff-glass ff-hero__note ff-hero__note--mid">
		<span class="ff-label ff-label--gold">
			<?php
			/* translators: 1: book number, 2: total books. */
			echo esc_html( sprintf( __( 'Book %1$s of %2$s', 'littlebunny' ), lbff_mod( 'book_num' ), absint( lbff_mod( 'book_series_total' ) ) ) );
			?>
		</span>
		<span class="ff-hero__note-text"><?php esc_html_e( 'Available now', 'littlebunny' ); ?></span>
	</div>
</section>
