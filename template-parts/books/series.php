<?php
/**
 * Books — 03 The series (books on the horizon).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

// left %, bottom %, base width px, opacity, blur px, z-index — books shrink into the distance.
$lbff_horizon = array(
	array( 42, 12, 104, .82, 0, 9 ),
	array( 53, 18.5, 84, .7, .4, 8 ),
	array( 62, 23, 70, .6, .7, 7 ),
	array( 70, 26.2, 58, .5, 1, 6 ),
	array( 77, 28.6, 49, .42, 1.3, 5 ),
	array( 83, 30.4, 42, .35, 1.6, 4 ),
	array( 88, 31.8, 36, .29, 1.9, 3 ),
	array( 92.5, 32.8, 31, .24, 2.2, 2 ),
	array( 96.5, 33.6, 27, .19, 2.5, 1 ),
);
$lbff_total   = absint( lbff_mod( 'book_series_total' ) );
$lbff_horizon = array_slice( $lbff_horizon, 0, max( 0, $lbff_total - 1 ) );
?>
<section class="ff-horizon" id="series">
	<?php lbff_desert_scene( 'dusk', false ); ?>
	<div class="ff-horizon__copy" data-reveal>
		<?php lbff_eyebrow( '02', __( 'The series', 'littlebunny' ), true ); ?>
		<h2 class="ff-display ff-display--horizon"><?php echo wp_kses( __( 'Ten books.<br><em>Nine still on the horizon.</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
		<p><?php esc_html_e( 'Book 01 begins the journey. Each new book is a destination further across the Kingdom — waiting to be discovered.', 'littlebunny' ); ?></p>
		<a class="ff-horizon__mobile-cta" href="#newsletter"><?php esc_html_e( 'Join the list →', 'littlebunny' ); ?></a>
	</div>

	<?php foreach ( $lbff_horizon as $lbff_i => $lbff_h ) : ?>
		<div class="ff-horizon__book<?php echo $lbff_i >= 6 ? ' is-hidden-md' : ''; ?><?php echo $lbff_i >= 3 ? ' is-hidden-sm' : ''; ?>" style="--l:<?php echo esc_attr( $lbff_h[0] ); ?>;--b:<?php echo esc_attr( $lbff_h[1] ); ?>;--w:<?php echo esc_attr( $lbff_h[2] ); ?>;--o:<?php echo esc_attr( $lbff_h[3] ); ?>;--blur:<?php echo esc_attr( $lbff_h[4] ); ?>px;z-index:<?php echo (int) $lbff_h[5]; ?>">
			<?php lbff_book_cover( array( 'variant' => 'future', 'num' => sprintf( '%02d', $lbff_i + 2 ) ) ); ?>
			<span class="ff-horizon__label">
				<?php
				/* translators: %s: book number. */
				echo esc_html( sprintf( __( 'Book %s', 'littlebunny' ), sprintf( '%02d', $lbff_i + 2 ) ) );
				?>
			</span>
		</div>
	<?php endforeach; ?>

	<div class="ff-horizon__current">
		<?php lbff_book_cover(); ?>
		<span class="ff-horizon__current-label">
			<?php
			/* translators: %s: book number. */
			echo esc_html( sprintf( __( 'Book %s · Available now', 'littlebunny' ), lbff_mod( 'book_num' ) ) );
			?>
		</span>
	</div>

	<div class="ff-glass ff-horizon__card">
		<span class="ff-label ff-label--gold"><?php esc_html_e( 'Be first to know', 'littlebunny' ); ?></span>
		<span class="ff-horizon__card-text"><?php esc_html_e( 'Hear when Book 02 arrives over the dunes.', 'littlebunny' ); ?></span>
		<a class="ff-horizon__card-link" href="#newsletter"><?php esc_html_e( 'Join the list →', 'littlebunny' ); ?></a>
	</div>
</section>
