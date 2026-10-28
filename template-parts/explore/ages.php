<?php
/**
 * Explore — 04 Age groups (two coloured panels).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_little = array(
	__( 'Colour Foo Foo’s desert', 'littlebunny' ),
	__( 'Spot the animal: picture cards', 'littlebunny' ),
	__( 'Sun & moon matching', 'littlebunny' ),
	__( 'Draw your quiet place', 'littlebunny' ),
);
$lbff_big = array(
	__( 'Write a day in Foo Foo’s life', 'littlebunny' ),
	__( 'The 10-minute observation challenge', 'littlebunny' ),
	__( 'Map your neighbourhood like Medina', 'littlebunny' ),
	__( 'Energy & rest diary for one week', 'littlebunny' ),
);
?>
<section class="ff-panels">
	<div class="ff-panel ff-panel--teal" id="little">
		<div class="ff-panel__glow" aria-hidden="true"></div>
		<span class="ff-label ff-label--gold ff-label--lg"><?php esc_html_e( '03 — Destination I', 'littlebunny' ); ?></span>
		<div class="ff-agehead"><h2 class="ff-display ff-display--panel"><?php echo wp_kses( __( 'Little<br><em>Explorers</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2><span class="ff-agehead__ages ff-agehead__ages--xl">5–6</span></div>
		<p><?php esc_html_e( 'Simple, joyful activities for first explorers — built around looking, naming and making.', 'littlebunny' ); ?></p>
		<ol class="ff-numlist" role="list">
			<?php foreach ( $lbff_little as $lbff_i => $lbff_t ) : ?>
				<li><span class="ff-numlist__n"><?php echo (int) ( $lbff_i + 1 ); ?></span><span><?php echo esc_html( $lbff_t ); ?></span></li>
			<?php endforeach; ?>
		</ol>
	</div>
	<div class="ff-panel ff-panel--amber" id="big">
		<div class="ff-panel__dune" aria-hidden="true"></div>
		<span class="ff-label ff-label--dark ff-label--lg"><?php esc_html_e( '04 — Destination II', 'littlebunny' ); ?></span>
		<div class="ff-agehead"><h2 class="ff-display ff-display--panel"><?php echo wp_kses( __( 'Foo Foo’s<br><em>Big Adventure</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2><span class="ff-agehead__ages ff-agehead__ages--xl">7–9</span></div>
		<p><?php esc_html_e( 'Writing prompts, challenges and longer activities for independent explorers ready to dig deeper.', 'littlebunny' ); ?></p>
		<ol class="ff-numlist" role="list">
			<?php foreach ( $lbff_big as $lbff_i => $lbff_t ) : ?>
				<li><span class="ff-numlist__n"><?php echo (int) ( $lbff_i + 1 ); ?></span><span><?php echo esc_html( $lbff_t ); ?></span></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
