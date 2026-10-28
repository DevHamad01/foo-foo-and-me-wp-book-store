<?php
/**
 * Meet — 06 Parents & educators.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_edu = array(
	array( __( 'Learning objectives', 'littlebunny' ), __( 'Clear outcomes mapped to each book and age group.', 'littlebunny' ) ),
	array( __( 'Teacher resources', 'littlebunny' ), __( 'Lesson plans, discussion guides and read-aloud notes.', 'littlebunny' ) ),
	array( __( 'Classroom materials', 'littlebunny' ), __( 'Printable worksheets, posters and activity packs.', 'littlebunny' ) ),
	array( __( 'Workshops', 'littlebunny' ), __( 'Story-led sessions for schools and learning centres.', 'littlebunny' ) ),
);
?>
<section class="ff-section ff-bg-deep ff-meetedu">
	<div class="ff-container ff-split ff-split--top">
		<div class="ff-copy ff-copy--light" data-reveal>
			<?php lbff_eyebrow( '06', __( 'Parents & educators', 'littlebunny' ), true ); ?>
			<h2 class="ff-display ff-display--md"><?php echo wp_kses( __( 'Stories that travel<br><em>into the classroom</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			<p><?php esc_html_e( 'Every book is built around clear learning objectives, with materials that help adults carry the story beyond the final page.', 'littlebunny' ); ?></p>
		</div>
		<div class="ff-linklist ff-linklist--light" data-reveal>
			<?php foreach ( $lbff_edu as $lbff_i => $lbff_e ) : ?>
				<a class="ff-linklist__row" href="<?php echo esc_url( lbff_page_url( 'explore', 'educators' ) ); ?>">
					<span class="ff-linklist__num"><?php echo esc_html( sprintf( '%02d', $lbff_i + 1 ) ); ?></span>
					<span class="ff-linklist__main"><span class="ff-linklist__title"><?php echo esc_html( $lbff_e[0] ); ?></span><span class="ff-linklist__line"><?php echo esc_html( $lbff_e[1] ); ?></span></span>
					<span class="ff-linklist__icon" aria-hidden="true">→</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
