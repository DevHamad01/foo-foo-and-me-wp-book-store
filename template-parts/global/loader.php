<?php
/**
 * First-visit loading screen + the curtain used for page transitions in
 * browsers without native View Transitions.
 *
 * Shown once per browser session (see lbff_head_boot() in inc/enqueue.php).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="ff-loader" data-loader aria-hidden="true">
	<div class="ff-loader__inner">
		<span class="ff-loader__kicker"><?php echo esc_html( lbff_mod( 'brand_kicker' ) ); ?></span>
		<span class="ff-loader__name"><?php echo esc_html( lbff_mod( 'brand_name' ) ); ?></span>
		<svg class="ff-loader__scene" viewBox="0 0 260 70" focusable="false">
			<path class="ff-loader__dune" d="M4 58 C50 38 92 40 130 50 S210 64 256 44"/>
			<g class="ff-loader__hop">
				<g transform="translate(0 0) scale(.18)">
					<ellipse cx="2" cy="-30" rx="12" ry="11"/><ellipse cx="50" cy="-38" rx="52" ry="40"/><ellipse cx="86" cy="-22" rx="24" ry="22"/><ellipse cx="86" cy="-64" rx="17" ry="16"/>
					<ellipse cx="86" cy="-140" rx="9.5" ry="38" transform="rotate(-14 86 -140)"/><ellipse cx="104" cy="-138" rx="9.5" ry="38" transform="rotate(9 104 -138)"/><circle cx="98" cy="-84" r="25"/>
				</g>
			</g>
		</svg>
		<div class="ff-loader__bar"><span></span></div>
	</div>
	<div class="ff-loader__edge"></div>
</div>
<div class="ff-curtain" data-curtain aria-hidden="true"><div class="ff-curtain__mark"><?php echo esc_html( lbff_mod( 'brand_name' ) ); ?></div></div>
