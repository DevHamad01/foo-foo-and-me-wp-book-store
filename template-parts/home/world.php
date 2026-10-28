<?php
/**
 * Home — 05 The World of Foo Foo (horizontal gallery).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_places = array(
	array( 'home-world-1', 'i.', __( 'The Dunes', 'littlebunny' ), __( 'Energy & Rest', 'littlebunny' ), 'xl' ),
	array( 'home-world-2', 'ii.', __( 'The Oasis', 'littlebunny' ), __( 'Water & Growth', 'littlebunny' ), 's' ),
	array( 'home-world-3', 'iii.', __( 'Medina', 'littlebunny' ), __( 'Community & Kindness', 'littlebunny' ), 'l' ),
	array( 'home-world-4', 'iv.', __( 'The Wild', 'littlebunny' ), __( 'Animals & Habitats', 'littlebunny' ), 'xs' ),
	array( 'home-world-5', 'v.', __( 'The Night Sky', 'littlebunny' ), __( 'Stillness & Wonder', 'littlebunny' ), 'm' ),
);
?>
<section class="ff-section ff-section--bleed ff-bg-sand ff-world" data-scroller>
	<div class="ff-container ff-headrow">
		<div class="ff-stack-sm" data-reveal>
			<?php lbff_eyebrow( '04', __( 'The World of Foo Foo', 'littlebunny' ) ); ?>
			<h2 class="ff-display"><?php echo wp_kses( __( 'A world drawn from<br><em>the Kingdom</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
		</div>
		<div class="ff-headrow__aside" data-reveal>
			<p><?php esc_html_e( 'Every story is rooted in a real place. The landscapes are the classroom — the lesson is whatever Foo Foo notices first.', 'littlebunny' ); ?></p>
			<div class="ff-arrows">
				<button type="button" class="ff-round ff-round--line" data-scroll-prev aria-label="<?php esc_attr_e( 'Previous', 'littlebunny' ); ?>">←</button>
				<button type="button" class="ff-round ff-round--solid" data-scroll-next aria-label="<?php esc_attr_e( 'Next', 'littlebunny' ); ?>">→</button>
			</div>
		</div>
	</div>
	<div class="ff-rail ff-world__rail" data-scroll-track tabindex="0" aria-label="<?php esc_attr_e( 'Places in the series', 'littlebunny' ); ?>">
		<?php foreach ( $lbff_places as $lbff_p ) : ?>
			<article class="ff-world__card ff-world__card--<?php echo esc_attr( $lbff_p[4] ); ?>">
				<div class="ff-world__img"><?php lbff_slot( $lbff_p[0], array( 'alt' => $lbff_p[2] ) ); ?></div>
				<div class="ff-world__meta">
					<span class="ff-world__num"><?php echo esc_html( $lbff_p[1] ); ?></span>
					<div>
						<h3 class="ff-world__place"><?php echo esc_html( $lbff_p[2] ); ?></h3>
						<span class="ff-label ff-label--earth"><?php echo esc_html( $lbff_p[3] ); ?></span>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
		<span class="ff-rail__end" aria-hidden="true"></span>
	</div>
</section>
