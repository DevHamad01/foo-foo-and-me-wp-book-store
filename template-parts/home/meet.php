<?php
/**
 * Home — 04 Meet Foo Foo.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-section ff-bg-cream ff-meetband">
	<div class="ff-container ff-stack-md">
		<?php lbff_eyebrow( '03', __( 'Meet Foo Foo', 'littlebunny' ) ); ?>
		<div class="ff-meetband__stage">
			<div class="ff-meetband__word" aria-hidden="true"><span><?php echo esc_html_x( 'Foo', 'decorative word', 'littlebunny' ); ?></span><span><?php echo esc_html_x( 'Foo', 'decorative word', 'littlebunny' ); ?></span></div>
			<div class="ff-meetband__arch" data-reveal>
				<?php lbff_slot( 'home-meet-portrait', array( 'alt' => __( 'Foo Foo standing on a dune crest', 'littlebunny' ) ) ); ?>
			</div>
			<div class="ff-meetband__text" data-reveal>
				<p><?php esc_html_e( 'A small desert rabbit who would rather ask one more question than go home early. Foo Foo learns by looking — closely, patiently, and always a little further.', 'littlebunny' ); ?></p>
				<?php lbff_text_link( __( 'Meet Foo Foo', 'littlebunny' ), lbff_page_url( 'meet' ) ); ?>
			</div>
			<ul class="ff-meetband__traits" data-reveal>
				<li><?php esc_html_e( 'Curious', 'littlebunny' ); ?></li>
				<li><?php esc_html_e( 'Observant', 'littlebunny' ); ?></li>
				<li><?php esc_html_e( 'Playful', 'littlebunny' ); ?></li>
				<li><?php esc_html_e( 'Adventurous', 'littlebunny' ); ?></li>
				<li class="is-accent"><?php esc_html_e( 'Thoughtful', 'littlebunny' ); ?></li>
			</ul>
		</div>
	</div>
</section>
