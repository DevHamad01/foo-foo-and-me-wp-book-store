<?php
/**
 * Meet — 03 Learning through discovery.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_steps = array(
	array( 'i.', __( 'Observe', 'littlebunny' ), __( 'Each story opens with something to look at closely — a track in the sand, a change in the light.', 'littlebunny' ) ),
	array( 'ii.', __( 'Wonder', 'littlebunny' ), __( 'Foo Foo asks the question a child would ask — and leaves room for the reader to ask it too.', 'littlebunny' ) ),
	array( 'iii.', __( 'Understand', 'littlebunny' ), __( 'The answer arrives through experience, not instruction — and connects back to the child’s own day.', 'littlebunny' ) ),
);
?>
<section class="ff-section ff-section--tall ff-bg-teal ff-discovery">
	<div class="ff-discovery__glow" aria-hidden="true"></div>
	<div class="ff-container ff-stack-xl">
		<?php lbff_eyebrow( '02', __( 'Learning through discovery', 'littlebunny' ), true ); ?>
		<p class="ff-statement" data-reveal><?php echo wp_kses( __( 'Foo Foo doesn’t learn by being told. He learns by <em>noticing</em> — the way shadows move, the way the oryx waits for evening, the way the city slows at midday.', 'littlebunny' ), lbff_inline_kses() ); ?></p>
		<div class="ff-steps">
			<?php foreach ( $lbff_steps as $lbff_s ) : ?>
				<div class="ff-steps__item" data-reveal>
					<span class="ff-steps__num"><?php echo esc_html( $lbff_s[0] ); ?></span>
					<h3 class="ff-steps__title"><?php echo esc_html( $lbff_s[1] ); ?></h3>
					<p><?php echo esc_html( $lbff_s[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
