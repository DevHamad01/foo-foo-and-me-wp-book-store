<?php
/**
 * Explore — 06 Experiences (coming soon rail).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_exps = array(
	array( 'i.', __( 'Workshops', 'littlebunny' ), __( 'Story-led creative sessions with the Foo Foo team.', 'littlebunny' ) ),
	array( 'ii.', __( 'School activities', 'littlebunny' ), __( 'Visits and programmes designed for whole classes.', 'littlebunny' ) ),
	array( 'iii.', __( 'Animal encounters', 'littlebunny' ), __( 'Meeting the desert animals from the books, responsibly.', 'littlebunny' ) ),
	array( 'iv.', __( 'Experiential programmes', 'littlebunny' ), __( 'Guided outdoor learning in real Saudi landscapes.', 'littlebunny' ) ),
);
?>
<section class="ff-section ff-section--bleed ff-bg-ink ff-exps">
	<div class="ff-container ff-headrow" data-reveal>
		<div class="ff-stack-sm">
			<?php lbff_eyebrow( '06', __( 'Experiences · In development', 'littlebunny' ), true ); ?>
			<h2 class="ff-display"><?php echo wp_kses( __( 'Where the story<br><em>becomes real</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
		</div>
		<p class="ff-headrow__note"><?php esc_html_e( 'Future programmes that bring children into the landscapes Foo Foo explores — guided, hands-on and outdoors.', 'littlebunny' ); ?></p>
	</div>
	<div class="ff-rail ff-exps__rail" tabindex="0" aria-label="<?php esc_attr_e( 'Experiences', 'littlebunny' ); ?>">
		<?php foreach ( $lbff_exps as $lbff_i => $lbff_x ) : ?>
			<article class="ff-exp">
				<div class="ff-exp__img">
					<div class="ff-zoom"><?php lbff_slot( 'explore-exp-' . ( $lbff_i + 1 ), array( 'alt' => $lbff_x[1] ) ); ?></div>
					<span class="ff-chip ff-chip--ink"><?php esc_html_e( 'Coming soon', 'littlebunny' ); ?></span>
				</div>
				<div class="ff-world__meta ff-world__meta--light">
					<span class="ff-world__num"><?php echo esc_html( $lbff_x[0] ); ?></span>
					<div class="ff-stack-xs"><h3 class="ff-exp__title"><?php echo esc_html( $lbff_x[1] ); ?></h3><p><?php echo esc_html( $lbff_x[2] ); ?></p></div>
				</div>
			</article>
		<?php endforeach; ?>
		<span class="ff-rail__end" aria-hidden="true"></span>
	</div>
</section>
