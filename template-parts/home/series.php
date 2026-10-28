<?php
/**
 * Home — 08 The Series (timeline).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_total = max( 2, absint( lbff_mod( 'book_series_total' ) ) );
?>
<section class="ff-section ff-bg-teal ff-series">
	<div class="ff-series__warmth" aria-hidden="true"></div>
	<div class="ff-container ff-stack-xl">
		<div class="ff-headrow" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( '07', __( 'The series', 'littlebunny' ), true ); ?>
				<h2 class="ff-display">
					<?php
					/* translators: %s: number of books, spelled out. */
					printf( wp_kses( __( '%s books.<br><em>One horizon.</em>', 'littlebunny' ), lbff_inline_kses() ), esc_html( 10 === $lbff_total ? __( 'Ten', 'littlebunny' ) : number_format_i18n( $lbff_total ) ) );
					?>
				</h2>
			</div>
			<div class="ff-headrow__aside">
				<p>
					<?php
					/* translators: %s: number of books. */
					echo esc_html( sprintf( __( 'Foo Foo’s journey is planned across %s books — each a new landscape, a new question, a new way of seeing.', 'littlebunny' ), 10 === $lbff_total ? __( 'ten', 'littlebunny' ) : number_format_i18n( $lbff_total ) ) );
					?>
				</p>
				<?php lbff_text_link( __( 'Follow the journey', 'littlebunny' ), lbff_page_url( 'books', 'series' ), true ); ?>
			</div>
		</div>

		<div class="ff-timeline" data-reveal>
			<div class="ff-timeline__line" aria-hidden="true"></div>
			<div class="ff-timeline__track" style="--count:<?php echo (int) ( $lbff_total - 1 ); ?>">
				<a class="ff-timeline__current" href="<?php echo esc_url( lbff_page_url( 'books' ) ); ?>" aria-label="<?php esc_attr_e( 'Book 01 — available now', 'littlebunny' ); ?>"><?php lbff_book_cover(); ?></a>
				<?php for ( $lbff_n = 2; $lbff_n <= $lbff_total; $lbff_n++ ) : ?>
					<div class="ff-timeline__stop" style="opacity:<?php echo esc_attr( number_format( max( 0.2, 0.85 - ( $lbff_n - 2 ) * 0.075 ), 2, '.', '' ) ); ?>">
						<span class="ff-timeline__num"><?php echo esc_html( sprintf( '%02d', $lbff_n ) ); ?></span>
						<span class="ff-timeline__diamond" aria-hidden="true"></span>
						<span class="ff-timeline__soon"><?php esc_html_e( 'Soon', 'littlebunny' ); ?></span>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</section>
