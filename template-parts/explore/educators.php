<?php
/**
 * Explore — 05 Parents & educators.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_edu = array(
	array( '01', __( 'Learning objectives', 'littlebunny' ), __( 'Outcomes for each book, mapped to age and stage.', 'littlebunny' ) ),
	array( '02', __( 'Teacher resources', 'littlebunny' ), __( 'Lesson plans, discussion guides and read-aloud notes.', 'littlebunny' ) ),
	array( '03', __( 'Classroom materials', 'littlebunny' ), __( 'Posters, worksheets and printable activity packs.', 'littlebunny' ) ),
	array( '04', __( 'Workshop resources', 'littlebunny' ), __( 'Facilitator guides for story-led sessions.', 'littlebunny' ) ),
);
?>
<section class="ff-section ff-bg-cream ff-edu" id="educators">
	<div class="ff-container ff-stack-lg">
		<div class="ff-headrow" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( '05', __( 'Parents & educators', 'littlebunny' ) ); ?>
				<h2 class="ff-display"><?php echo wp_kses( __( 'For the adults<br><em>guiding the journey</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			</div>
			<?php lbff_text_link( __( 'Request the educator pack', 'littlebunny' ), '#contact' ); ?>
		</div>
		<div class="ff-edu__grid">
			<?php foreach ( $lbff_edu as $lbff_e ) : ?>
				<div class="ff-edu__item" data-reveal>
					<span class="ff-edu__num"><?php echo esc_html( $lbff_e[0] ); ?></span>
					<h3 class="ff-edu__title"><?php echo esc_html( $lbff_e[1] ); ?></h3>
					<p><?php echo esc_html( $lbff_e[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
