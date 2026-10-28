<?php
/**
 * Meet — 05 Age groups (two editorial rows).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-section ff-bg-cream ff-meetages">
	<div class="ff-container ff-meetages__stack">
		<div class="ff-split ff-split--center" id="little">
			<div class="ff-collage ff-collage--right" data-reveal>
				<?php lbff_slot( 'meet-little-main', array( 'class' => 'ff-collage__main' ) ); ?>
				<?php lbff_slot( 'meet-little-detail', array( 'class' => 'ff-collage__inset' ) ); ?>
			</div>
			<div class="ff-copy" data-reveal>
				<span class="ff-label ff-label--earth ff-label--lg"><?php esc_html_e( '04 — Destination I', 'littlebunny' ); ?></span>
				<div class="ff-agehead"><h2 class="ff-display ff-display--md"><?php echo wp_kses( __( 'Little<br><em>Explorers</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2><span class="ff-agehead__ages">5–6</span></div>
				<p><?php esc_html_e( 'For first explorers: large illustrations, short read-aloud passages and one big idea per story. Questions are gentle and open — what do you see, what do you think happens next?', 'littlebunny' ); ?></p>
				<div class="ff-tags"><span><?php esc_html_e( 'Read-aloud', 'littlebunny' ); ?></span><span><?php esc_html_e( 'Picture-led', 'littlebunny' ); ?></span><span><?php esc_html_e( 'Colouring', 'littlebunny' ); ?></span></div>
			</div>
		</div>

		<div class="ff-split ff-split--center ff-split--reverse" id="big">
			<div class="ff-copy" data-reveal>
				<span class="ff-label ff-label--earth ff-label--lg"><?php esc_html_e( '05 — Destination II', 'littlebunny' ); ?></span>
				<div class="ff-agehead"><h2 class="ff-display ff-display--md"><?php echo wp_kses( __( 'Foo Foo’s<br><em>Big Adventure</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2><span class="ff-agehead__ages">7–9</span></div>
				<p><?php esc_html_e( 'For independent readers: richer text, real facts about Saudi landscapes and wildlife, and challenges that send children outside to observe for themselves.', 'littlebunny' ); ?></p>
				<div class="ff-tags"><span><?php esc_html_e( 'Writing prompts', 'littlebunny' ); ?></span><span><?php esc_html_e( 'Challenges', 'littlebunny' ); ?></span><span><?php esc_html_e( 'Field journals', 'littlebunny' ); ?></span></div>
			</div>
			<div class="ff-collage ff-collage--left" data-reveal>
				<?php lbff_slot( 'meet-big-main', array( 'class' => 'ff-collage__main' ) ); ?>
				<?php lbff_slot( 'meet-big-detail', array( 'class' => 'ff-collage__inset' ) ); ?>
			</div>
		</div>
	</div>
</section>
