<?php
/**
 * Books — 02 Book 01 with the page-turning preview.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_spreads = array(
	__( 'The race', 'littlebunny' ),
	__( 'Midday', 'littlebunny' ),
	__( 'The falcon', 'littlebunny' ),
	__( 'Sunset', 'littlebunny' ),
);
$lbff_details = array(
	__( 'Author', 'littlebunny' )         => lbff_mod( 'book_author' ),
	__( 'Illustrations', 'littlebunny' )  => lbff_mod( 'book_illustrator' ),
	__( 'Ages', 'littlebunny' )           => lbff_mod( 'book_ages' ),
	__( 'Learning theme', 'littlebunny' ) => lbff_mod( 'book_learning' ),
	/* translators: 1: book number without leading zero, 2: total. */
	__( 'Series', 'littlebunny' )         => sprintf( __( 'Book %1$d of %2$d', 'littlebunny' ), absint( lbff_mod( 'book_num' ) ), absint( lbff_mod( 'book_series_total' ) ) ),
	__( 'Formats', 'littlebunny' )        => lbff_mod( 'book_formats' ),
);
?>
<section class="ff-section ff-bg-cream ff-bookdetail" id="book">
	<div class="ff-container ff-stack-xl">
		<div class="ff-split ff-split--bottom" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( lbff_mod( 'book_num' ), sprintf( /* translators: %s: book number. */ __( 'Book %s · Now available', 'littlebunny' ), lbff_mod( 'book_num' ) ) ); ?>
				<h2 class="ff-display ff-display--xxl"><?php echo esc_html( lbff_mod( 'book_title_1' ) ); ?><br><em class="ff-indent"><?php echo esc_html( lbff_mod( 'book_title_2' ) ); ?></em></h2>
			</div>
			<div class="ff-copy ff-copy--narrow">
				<p class="ff-lede ff-lede--dark"><?php echo esc_html( lbff_mod( 'book_blurb' ) ); ?></p>
				<p class="ff-small"><?php esc_html_e( 'A gentle first lesson in balance: that rest is not the opposite of adventure, but part of it.', 'littlebunny' ); ?></p>
			</div>
		</div>

		<div class="ff-flipbook" data-flipbook>
			<div class="ff-flipbook__stage">
				<div class="ff-flipbook__shadow" aria-hidden="true"></div>
				<div class="ff-flipbook__book">
					<div class="ff-flipbook__board" aria-hidden="true"></div>
					<?php foreach ( $lbff_spreads as $lbff_i => $lbff_label ) : ?>
						<div class="ff-flipbook__spread<?php echo 0 === $lbff_i ? ' is-active' : ''; ?>" data-spread="<?php echo (int) $lbff_i; ?>" aria-hidden="<?php echo 0 === $lbff_i ? 'false' : 'true'; ?>">
							<div class="ff-flipbook__page ff-flipbook__page--left"><?php lbff_slot( 'books-spread-' . ( $lbff_i + 1 ) . '-l' ); ?></div>
							<div class="ff-flipbook__page ff-flipbook__page--right"><?php lbff_slot( 'books-spread-' . ( $lbff_i + 1 ) . '-r' ); ?></div>
						</div>
					<?php endforeach; ?>
					<div class="ff-flipbook__leaf" data-leaf aria-hidden="true"></div>
				</div>
				<button type="button" class="ff-flipbook__arrow ff-flipbook__arrow--prev" data-flip-prev aria-label="<?php esc_attr_e( 'Previous spread', 'littlebunny' ); ?>">←</button>
				<button type="button" class="ff-flipbook__arrow ff-flipbook__arrow--next" data-flip-next aria-label="<?php esc_attr_e( 'Next spread', 'littlebunny' ); ?>">→</button>
			</div>
			<div class="ff-flipbook__controls">
				<div class="ff-flipbook__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Book spreads', 'littlebunny' ); ?>">
					<?php foreach ( $lbff_spreads as $lbff_i => $lbff_label ) : ?>
						<button type="button" role="tab" class="ff-flipbook__tab<?php echo 0 === $lbff_i ? ' is-active' : ''; ?>" data-flip-go="<?php echo (int) $lbff_i; ?>" aria-selected="<?php echo 0 === $lbff_i ? 'true' : 'false'; ?>"><span class="ff-flipbook__tabbar" aria-hidden="true"></span><?php echo esc_html( $lbff_label ); ?></button>
					<?php endforeach; ?>
				</div>
				<span class="ff-flipbook__count"><?php esc_html_e( 'Spread', 'littlebunny' ); ?> <span data-flip-num>01</span> <em>/ <?php echo esc_html( sprintf( '%02d', count( $lbff_spreads ) ) ); ?></em></span>
			</div>
		</div>

		<dl class="ff-details" data-reveal>
			<?php foreach ( $lbff_details as $lbff_k => $lbff_v ) : ?>
				<div class="ff-details__item"><dt><?php echo esc_html( $lbff_k ); ?></dt><dd><?php echo esc_html( $lbff_v ); ?></dd></div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
