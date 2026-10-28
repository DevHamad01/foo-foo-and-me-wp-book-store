<?php
/**
 * Home — 03 Featured book.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-section ff-bg-teal ff-featured" id="featured">
	<div class="ff-featured__glow" aria-hidden="true"></div>
	<div class="ff-featured__horizon" aria-hidden="true"></div>
	<div class="ff-container ff-split ff-split--center ff-featured__grid">
		<div class="ff-featured__stage" data-reveal>
			<div class="ff-spread ff-spread--tilted">
				<div class="ff-spread__page ff-spread__page--left"><?php lbff_slot( 'home-spread-left' ); ?></div>
				<div class="ff-spread__page ff-spread__page--right"><?php lbff_slot( 'home-spread-right' ); ?></div>
			</div>
			<div class="ff-featured__cover ff-float"><?php lbff_book_cover(); ?></div>
			<div class="ff-glass ff-featured__credit">
				<span class="ff-label ff-label--gold"><?php esc_html_e( 'Illustrated by', 'littlebunny' ); ?></span>
				<span class="ff-featured__credit-name"><?php echo esc_html( lbff_mod( 'book_illustrator' ) ); ?></span>
			</div>
		</div>

		<div class="ff-copy ff-copy--light ff-featured__copy" data-reveal>
			<?php lbff_eyebrow( '02', sprintf( /* translators: %s: book number. */ __( 'Featured book · Book %s', 'littlebunny' ), lbff_mod( 'book_num' ) ), true ); ?>
			<h2 class="ff-display ff-display--xl"><?php echo esc_html( lbff_mod( 'book_title_1' ) ); ?><br><em class="ff-indent"><?php echo esc_html( lbff_mod( 'book_title_2' ) ); ?></em></h2>
			<p class="ff-lede"><?php echo esc_html( lbff_mod( 'book_blurb' ) ); ?></p>

			<dl class="ff-facts">
				<div><dt><?php esc_html_e( 'Ages', 'littlebunny' ); ?></dt><dd><?php echo esc_html( lbff_mod( 'book_ages' ) ); ?></dd></div>
				<div><dt><?php esc_html_e( 'Theme', 'littlebunny' ); ?></dt><dd><?php echo esc_html( lbff_mod( 'book_theme' ) ); ?></dd></div>
				<div><dt><?php esc_html_e( 'Formats', 'littlebunny' ); ?></dt><dd><?php echo esc_html( lbff_mod( 'book_formats' ) ); ?></dd></div>
			</dl>

			<div class="ff-samples">
				<span class="ff-label ff-label--muted"><?php esc_html_e( 'Sample pages', 'littlebunny' ); ?></span>
				<div class="ff-samples__row">
					<?php foreach ( array( 1, 2, 3 ) as $lbff_n ) : ?>
						<a class="ff-samples__thumb" href="<?php echo esc_url( lbff_page_url( 'books' ) ); ?>" aria-label="<?php esc_attr_e( 'Preview the book', 'littlebunny' ); ?>"><?php lbff_slot( 'home-sample-' . $lbff_n ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="ff-btn-row">
				<?php lbff_button( __( 'Buy the book', 'littlebunny' ), lbff_page_url( 'books', 'buy' ) ); ?>
				<a class="ff-btn ff-btn--outline-light" href="#listen"><span class="ff-play-tri" aria-hidden="true"></span><?php esc_html_e( 'Read & listen', 'littlebunny' ); ?></a>
			</div>
		</div>
	</div>
</section>
