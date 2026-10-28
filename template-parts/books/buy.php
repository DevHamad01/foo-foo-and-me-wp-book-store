<?php
/**
 * Books — 05 Buy the book.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-section ff-bg-sand ff-buy" id="buy">
	<div class="ff-buy__glow" aria-hidden="true"></div>
	<div class="ff-container ff-split ff-split--center">
		<div class="ff-buy__cover" data-reveal><div class="ff-float"><?php lbff_book_cover(); ?></div></div>
		<div class="ff-copy" data-reveal>
			<?php lbff_eyebrow( '04', __( 'Buy the book', 'littlebunny' ) ); ?>
			<h2 class="ff-display"><?php echo wp_kses( __( 'Bring the desert<br><em>home</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			<div class="ff-buylist">
				<a class="ff-buylist__row" href="<?php lbff_link( 'link_amazon' ); ?>"<?php lbff_link_target( 'link_amazon' ); ?>>
					<span class="ff-buylist__text"><span class="ff-label ff-label--earth"><?php esc_html_e( 'Print edition', 'littlebunny' ); ?></span><span class="ff-buylist__title"><?php esc_html_e( 'Buy on Amazon', 'littlebunny' ); ?></span></span>
					<span class="ff-buylist__icon ff-buylist__icon--solid" aria-hidden="true">→</span>
				</a>
				<a class="ff-buylist__row" href="<?php lbff_link( 'link_kindle' ); ?>"<?php lbff_link_target( 'link_kindle' ); ?>>
					<span class="ff-buylist__text"><span class="ff-label ff-label--earth"><?php esc_html_e( 'Ebook', 'littlebunny' ); ?></span><span class="ff-buylist__title"><?php esc_html_e( 'Read on Kindle', 'littlebunny' ); ?></span></span>
					<span class="ff-buylist__icon" aria-hidden="true">→</span>
				</a>
			</div>
			<p class="ff-small">
				<?php esc_html_e( 'Ordering for a school or library?', 'littlebunny' ); ?>
				<a class="ff-underline" href="<?php echo esc_url( lbff_page_url( 'explore', 'contact' ) ); ?>"><?php esc_html_e( 'Contact us about class sets', 'littlebunny' ); ?></a>.
			</p>
		</div>
	</div>
</section>
