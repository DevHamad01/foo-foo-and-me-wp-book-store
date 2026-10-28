<?php
/**
 * Hand-drawn style SVG illustrations.
 *
 * Used wherever an image slot is still empty, so every section looks finished
 * and on-brand before the client's artwork arrives. Each scene is drawn on a
 * 600×500 canvas with its subject inside the centre "safe zone", so it crops
 * well into portrait cards, wide video frames and arches alike.
 *
 * Colours come from CSS custom properties (see .ff-art--{tone} in main.css),
 * so one scene can be dawn, dusk, teal, night or paper.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Echo an illustration.
 *
 * @param string $scene Scene name.
 * @param string $tone  Colour tone (only used for the wrapper class).
 */
function lbff_illustration( $scene = 'dunes', $tone = 'dawn' ) {
	$fn = 'lbff_scene_' . preg_replace( '/[^a-z]/', '', $scene );
	if ( ! function_exists( $fn ) ) {
		$fn = 'lbff_scene_dunes';
	}
	echo '<svg class="ff-art ff-art--scene" viewBox="0 0 600 500" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">';
	echo $fn(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG built in this file.
	echo '</svg>';
}

/* ---------------------------------------------------------------------------
 * Building blocks
 * ------------------------------------------------------------------------- */

/**
 * Sun (or moon) with a soft halo.
 *
 * @param float $x  Centre x.
 * @param float $y  Centre y.
 * @param float $r  Radius.
 * @return string
 */
function lbff_svg_sun( $x, $y, $r ) {
	return sprintf(
		'<circle class="i-glow" cx="%1$s" cy="%2$s" r="%4$s"/><circle class="i-glow" cx="%1$s" cy="%2$s" r="%5$s"/><circle class="i-sun" cx="%1$s" cy="%2$s" r="%3$s"/>',
		$x,
		$y,
		$r,
		round( $r * 2.1 ),
		round( $r * 1.45 )
	);
}

/**
 * Foo Foo — a small sitting desert rabbit (original character silhouette).
 *
 * @param float  $x     Bottom-left x.
 * @param float  $y     Ground y.
 * @param float  $s     Scale.
 * @param string $class Fill class.
 * @param bool   $flip  Face left instead of right.
 * @return string
 */
function lbff_svg_rabbit( $x, $y, $s = 1, $class = 'i-sil', $flip = false ) {
	$t     = $flip ? sprintf( 'translate(%s %s) scale(%s %s)', $x + 120 * $s, $y, -$s, $s ) : sprintf( 'translate(%s %s) scale(%s)', $x, $y, $s );
	$shape = '<ellipse cx="2" cy="-30" rx="12" ry="11"/>'                                   // Tail.
		. '<ellipse cx="50" cy="-38" rx="52" ry="40"/>'                                     // Body.
		. '<ellipse cx="86" cy="-22" rx="24" ry="22"/>'                                     // Chest.
		. '<ellipse cx="86" cy="-64" rx="17" ry="16"/>'                                     // Neck.
		. '<ellipse cx="86" cy="-140" rx="9.5" ry="38" transform="rotate(-14 86 -140)"/>'   // Back ear.
		. '<ellipse cx="104" cy="-138" rx="9.5" ry="38" transform="rotate(9 104 -138)"/>'   // Front ear.
		. '<circle cx="98" cy="-84" r="25"/>'                                              // Head.
		. '<ellipse cx="98" cy="-5" rx="17" ry="7"/>';                                      // Paw.

	if ( 'i-outline' === $class ) {
		// Draw the shapes twice — thick strokes, then white fills on top — so only the outer contour shows.
		return '<g transform="' . $t . '"><g class="i-ol-stroke">' . $shape . '</g><g class="i-ol-fill">' . $shape . '</g>'
			. '<ellipse class="i-ol-line" cx="104.5" cy="-140" rx="4" ry="24" transform="rotate(9 104 -138)"/>'
			. '<circle class="i-ol-dot" cx="108" cy="-88" r="2.8"/><path class="i-ol-line" d="M82 -6 C76 -18 76 -30 84 -40"/></g>';
	}

	return '<g class="' . $class . '" transform="' . $t . '">' . $shape
		. '<ellipse class="i-hi" cx="104.5" cy="-140" rx="4" ry="26" transform="rotate(9 104 -138)" opacity=".55"/>'
		. '<circle class="i-eye" cx="108" cy="-88" r="3.2"/>'
		. '</g>';
}

/**
 * Date palm.
 *
 * @param float $x    Base x.
 * @param float $y    Base y.
 * @param float $h    Height.
 * @param float $lean Horizontal lean.
 * @param float $s    Scale for fronds.
 * @return string
 */
function lbff_svg_palm( $x, $y, $h, $lean = 14, $s = 1 ) {
	$tx  = $x + $lean;
	$ty  = $y - $h;
	$out = sprintf( '<path class="i-trunk" d="M%1$s %2$s Q%3$s %4$s %5$s %6$s" stroke-width="%7$s"/>', $x, $y, $x + $lean * 0.15, $y - $h * 0.55, $tx, $ty, round( 8 * $s, 1 ) );
	foreach ( array( -168, -138, -108, -72, -40, -10, 18, 160 ) as $a ) {
		$out .= sprintf( '<path class="i-sil" d="M0 0 C18 -14 46 -16 74 6 C46 -3 20 -1 0 0Z" transform="translate(%s %s) rotate(%s) scale(%s)"/>', $tx, $ty, $a, $s );
	}
	$out .= sprintf( '<circle class="i-sil" cx="%s" cy="%s" r="%s"/>', $tx, $ty + 3, round( 7 * $s, 1 ) );
	return $out;
}

/**
 * Arabian oryx facing left.
 *
 * @param float $x Ground x (centre).
 * @param float $y Ground y.
 * @param float $s Scale.
 * @return string
 */
function lbff_svg_oryx( $x, $y, $s = 1 ) {
	return sprintf( '<g class="i-sil i-animal" transform="translate(%s %s) scale(%s)">', $x, $y, $s )
		. '<ellipse cx="0" cy="-50" rx="46" ry="20"/>'
		. '<polygon points="-30,-60 -50,-94 -37,-99 -14,-62"/>'
		. '<ellipse cx="-52" cy="-97" rx="15" ry="8" transform="rotate(28 -52 -97)"/>'
		. '<path class="i-stroke" d="M-47 -103 L-22 -163 M-41 -101 L-14 -159" stroke-width="3.4"/>'
		. '<path class="i-stroke" d="M-30 -36 L-32 0 M-19 -34 L-20 0 M26 -36 L28 0 M36 -38 L39 0" stroke-width="5.5"/>'
		. '<path class="i-stroke" d="M45 -54 Q54 -40 50 -22" stroke-width="3"/>'
		. '</g>';
}

/**
 * Falcon gliding.
 *
 * @param float $x Centre x.
 * @param float $y Centre y.
 * @param float $s Scale.
 * @param float $o Opacity.
 * @return string
 */
function lbff_svg_falcon( $x, $y, $s = 1, $o = 1 ) {
	return sprintf( '<g class="i-sil" transform="translate(%s %s) scale(%s)" opacity="%s">', $x, $y, $s, $o )
		. '<path d="M0 0 C-26 -8 -58 -30 -96 -22 C-66 -14 -38 -2 -12 8 L-8 22 L0 30 L8 22 L12 8 C38 -2 66 -14 96 -22 C58 -30 26 -8 0 0Z"/>'
		. '<circle cx="0" cy="-4" r="7"/>'
		. '</g>';
}

/**
 * Arched window / doorway.
 *
 * @param float  $cx    Centre x.
 * @param float  $base  Bottom y.
 * @param float  $w     Width.
 * @param float  $h     Height.
 * @param string $class Fill class.
 * @return string
 */
function lbff_svg_arch( $cx, $base, $w, $h, $class = 'i-hi' ) {
	$r = $w / 2;
	return sprintf( '<path class="%6$s" d="M%1$s %2$s V%3$s A%4$s %4$s 0 0 1 %5$s %3$s V%2$s Z"/>', $cx - $r, $base, $base - $h + $r, $r, $cx + $r, $class );
}

/**
 * Small grass tufts.
 *
 * @param array $points List of [x, y, scale].
 * @return string
 */
function lbff_svg_tufts( $points ) {
	$out = '';
	foreach ( $points as $p ) {
		$out .= sprintf( '<path class="i-tuft" transform="translate(%s %s) scale(%s)" d="M0 0 C-2 -10 -8 -16 -12 -20 M0 0 C0 -12 2 -20 4 -26 M0 0 C4 -8 10 -14 16 -16 M0 0 C-4 -6 -12 -8 -18 -8"/>', $p[0], $p[1], $p[2] );
	}
	return $out;
}

/**
 * Twinkling stars (deterministic positions).
 *
 * @param float $max_y Lowest y for stars.
 * @return string
 */
function lbff_svg_stars( $max_y = 300 ) {
	$pts = array( array( 40, 60, 1.6 ), array( 92, 128, 1.1 ), array( 150, 40, 1.3 ), array( 205, 98, 2 ), array( 262, 30, 1 ), array( 318, 140, 1.2 ), array( 352, 66, 1.5 ), array( 470, 40, 1.1 ), array( 520, 110, 1.8 ), array( 560, 62, 1 ), array( 585, 160, 1.3 ), array( 120, 210, 1 ), array( 236, 186, 1.3 ), array( 60, 260, 1.1 ), array( 548, 230, 1 ), array( 300, 232, .9 ), array( 440, 190, 1.2 ), array( 18, 170, 1 ) );
	$out = '<g class="i-stars">';
	foreach ( $pts as $p ) {
		if ( $p[1] < $max_y ) {
			$out .= sprintf( '<circle cx="%s" cy="%s" r="%s"/>', $p[0], $p[1], $p[2] );
		}
	}
	return $out . '<path d="M205 82 V114 M189 98 H221" class="i-sparkle"/></g>';
}

/* ---------------------------------------------------------------------------
 * Scenes
 * ------------------------------------------------------------------------- */

/** Dunes with footprints — the signature landscape. */
function lbff_scene_dunes() {
	$prints = '';
	$steps  = array( array( 150, 398 ), array( 182, 389 ), array( 214, 384 ), array( 246, 377 ), array( 278, 372 ), array( 310, 366 ), array( 342, 362 ), array( 374, 356 ), array( 406, 352 ), array( 438, 346 ) );
	foreach ( $steps as $i => $p ) {
		$prints .= sprintf( '<ellipse cx="%s" cy="%s" rx="5" ry="2.4"/>', $p[0], $p[1] + ( $i % 2 ? -5 : 0 ) );
	}
	return lbff_svg_sun( 395, 212, 56 )
		. '<path class="i-d1" d="M0 286 C110 244 214 250 304 276 S484 302 600 262 V500 H0Z"/>'
		. '<path class="i-d2" d="M0 338 C122 300 250 310 352 336 S522 362 600 338 V500 H0Z"/>'
		. '<path class="i-ridge" d="M0 338 C122 300 250 310 352 336 S522 362 600 338"/>'
		. '<g class="i-prints">' . $prints . '</g>'
		. '<path class="i-d3" d="M0 412 C132 380 262 388 382 410 S542 434 600 420 V500 H0Z"/>'
		. lbff_svg_tufts( array( array( 90, 430, 1.2 ), array( 120, 436, .8 ), array( 470, 440, 1.1 ), array( 505, 446, .7 ) ) );
}

/** Sand ripple macro. */
function lbff_scene_ripples() {
	$out = '<circle class="i-glow" cx="520" cy="40" r="220"/>';
	for ( $i = 0; $i < 13; $i++ ) {
		$y    = 30 + $i * 38;
		$out .= sprintf( '<path class="i-ripple-shade" d="M-20 %1$s C100 %2$s 200 %3$s 320 %4$s S520 %5$s 620 %1$s"/>', $y + 7, $y - 11, $y + 21, $y + 1, $y - 13 );
		$out .= sprintf( '<path class="i-ripple" d="M-20 %1$s C100 %2$s 200 %3$s 320 %4$s S520 %5$s 620 %1$s"/>', $y, $y - 18, $y + 14, $y - 6, $y - 20 );
	}
	return $out;
}

/** Oasis with date palms and still water. */
function lbff_scene_oasis() {
	return lbff_svg_sun( 300, 250, 44 )
		. '<path class="i-d1" d="M0 300 C120 270 230 276 320 292 S500 300 600 280 V500 H0Z"/>'
		. '<path class="i-d2" d="M0 360 C140 336 260 344 360 352 S520 362 600 350 V500 H0Z"/>'
		. '<ellipse class="i-water" cx="300" cy="392" rx="196" ry="30"/>'
		. '<path class="i-reflect" d="M150 386 H236 M268 396 H392 M190 404 H262 M330 380 H430"/>'
		. lbff_svg_palm( 200, 382, 150, -18, 1.1 )
		. lbff_svg_palm( 238, 384, 116, 16, .9 )
		. lbff_svg_palm( 400, 380, 170, 22, 1.2 )
		. lbff_svg_palm( 440, 386, 96, -10, .75 )
		. '<path class="i-d3" d="M0 430 C140 408 270 414 380 430 S540 450 600 440 V500 H0Z"/>'
		. lbff_svg_tufts( array( array( 120, 446, 1 ), array( 470, 452, .9 ) ) );
}

/** Medina skyline — domes, minarets and glowing arches. */
function lbff_scene_medina() {
	$b  = 388;
	$out = lbff_svg_sun( 300, 236, 62 )
		. '<path class="i-d1" d="M0 330 C140 312 300 318 420 326 S560 330 600 322 V500 H0Z"/>'
		. '<g class="i-sil">'
		. '<rect x="34" y="236" width="12" height="160"/><polygon points="34,236 40,212 46,236"/><rect x="30" y="268" width="20" height="6"/>'
		. '<rect x="62" y="300" width="112" height="96"/>'
		. '<rect x="210" y="290" width="150" height="106"/><path d="M215 292 A70 70 0 0 1 355 292Z"/><rect x="283" y="196" width="4" height="30"/><circle cx="285" cy="194" r="6"/>'
		. '<rect x="396" y="176" width="20" height="220"/><rect x="390" y="232" width="32" height="8"/><polygon points="396,176 406,144 416,176"/><circle cx="406" cy="140" r="4"/>'
		. '<rect x="432" y="316" width="128" height="80"/><path d="M462 318 A20 20 0 0 1 502 318Z"/>'
		. '</g>';
	foreach ( array( 86, 118, 150 ) as $cx ) {
		$out .= lbff_svg_arch( $cx, $b - 22, 18, 44 );
	}
	foreach ( array( 238, 268, 302, 332 ) as $cx ) {
		$out .= lbff_svg_arch( $cx, $b - 20, 18, 50 );
	}
	$out .= lbff_svg_arch( 285, $b + 8, 30, 64 );
	foreach ( array( 458, 494, 530 ) as $cx ) {
		$out .= lbff_svg_arch( $cx, $b - 16, 16, 36 );
	}
	return $out
		. lbff_svg_palm( 190, 396, 92, -10, .7 )
		. lbff_svg_palm( 580, 398, 110, -12, .8 )
		. '<path class="i-d3" d="M0 396 H600 V500 H0Z"/>'
		. '<path class="i-path" d="M285 396 C280 430 250 460 210 500"/>';
}

/** Arabian oryx on a ridge. */
function lbff_scene_wild() {
	return lbff_svg_sun( 430, 214, 50 )
		. '<path class="i-d1" d="M0 300 C120 270 230 272 330 296 S520 312 600 286 V500 H0Z"/>'
		. '<path class="i-d2" d="M0 382 C120 358 220 334 300 334 C380 334 480 360 600 368 V500 H0Z"/>'
		. lbff_svg_oryx( 300, 336, 1.25 )
		. '<g opacity=".7">' . lbff_svg_oryx( 486, 362, .62 ) . '</g>'
		. '<path class="i-d3" d="M0 440 C140 420 280 424 400 438 S560 452 600 446 V500 H0Z"/>'
		. lbff_svg_tufts( array( array( 140, 380, 1 ), array( 420, 350, .8 ), array( 520, 458, 1 ) ) );
}

/** Night sky over a desert camp. */
function lbff_scene_night() {
	return lbff_svg_stars( 300 )
		. lbff_svg_sun( 430, 150, 36 )
		. '<path class="i-d1" d="M0 320 C120 292 240 298 330 312 S500 324 600 300 V500 H0Z"/>'
		. '<path class="i-d2" d="M0 392 C140 366 270 370 380 388 S540 404 600 396 V500 H0Z"/>'
		. '<ellipse class="i-glow" cx="250" cy="392" rx="120" ry="34"/>'
		. '<g transform="translate(250 394)"><polygon class="i-sil" points="-82,0 0,-92 82,0"/><polygon class="i-hi" points="-16,0 0,-42 16,0"/><path class="i-stroke" d="M0 -92 L0 -104 M-82 0 L-104 8 M82 0 L104 8" stroke-width="2"/></g>'
		. lbff_svg_rabbit( 352, 396, .46 )
		. '<path class="i-d3" d="M0 448 C140 430 280 436 400 446 S560 460 600 456 V500 H0Z"/>';
}

/** AlUla-style sandstone rocks with a natural arch. */
function lbff_scene_canyon() {
	return lbff_svg_sun( 462, 196, 42 )
		. '<path class="i-d1" d="M0 322 C22 322 26 270 62 262 C102 254 122 272 130 322 L212 322 C218 292 242 286 262 288 C286 286 300 302 304 322 L436 322 C442 262 478 242 518 246 C558 250 580 282 586 322 L600 322 V500 H0Z"/>'
		. '<path class="i-rock" d="M206 404 C212 364 192 330 198 292 C204 246 250 220 302 220 C362 220 406 248 412 298 C416 336 398 362 404 404 Z"/>'
		. '<path class="i-rock-shade" d="M330 222 C384 230 410 262 412 300 C414 336 398 362 404 404 L360 404 C378 352 392 290 330 222Z"/>'
		. '<path class="i-strata" d="M204 300 C260 292 330 296 410 288 M200 330 C262 324 330 328 404 320 M206 262 C262 254 330 256 400 252"/>'
		. '<path class="i-skyhole" d="M298 404 C298 352 316 330 338 330 C360 330 372 352 372 404Z"/>'
		. '<path class="i-d2" d="M0 400 C150 388 300 396 440 404 S560 410 600 404 V500 H0Z"/>'
		. lbff_svg_rabbit( 452, 404, .32 )
		. '<path class="i-d3" d="M0 452 C150 438 300 444 420 452 S560 462 600 458 V500 H0Z"/>'
		. lbff_svg_tufts( array( array( 120, 410, .9 ), array( 160, 416, .6 ), array( 540, 462, 1 ) ) );
}

/** Foo Foo on a dune crest, watching the sun. */
function lbff_scene_rabbit() {
	return lbff_svg_sun( 380, 238, 70 )
		. '<path class="i-d1" d="M0 300 C120 276 236 280 330 300 S500 316 600 292 V500 H0Z"/>'
		. '<path class="i-d2" d="M0 382 C150 362 228 344 300 344 C380 344 470 370 600 362 V500 H0Z"/>'
		. lbff_svg_rabbit( 232, 346, 1.18 )
		. '<path class="i-d3" d="M0 444 C140 424 280 430 400 442 S560 456 600 450 V500 H0Z"/>'
		. lbff_svg_tufts( array( array( 120, 380, .9 ), array( 470, 372, .8 ), array( 520, 458, 1 ) ) );
}

/** Foo Foo reading by the glow of an open book. */
function lbff_scene_reading() {
	return lbff_svg_stars( 220 )
		. lbff_svg_sun( 450, 170, 34 )
		. '<path class="i-d1" d="M0 320 C120 296 240 300 340 316 S510 330 600 306 V500 H0Z"/>'
		. '<ellipse class="i-glow i-glow--strong" cx="356" cy="372" rx="110" ry="70"/>'
		. '<path class="i-d2" d="M0 400 C150 380 280 384 400 396 S560 410 600 404 V500 H0Z"/>'
		. lbff_svg_rabbit( 196, 398, 1.05 )
		. '<g transform="translate(356 396)"><path class="i-paper" d="M0 0 L-62 -10 L-62 -46 L0 -36Z"/><path class="i-paper i-paper--2" d="M0 0 L62 -10 L62 -46 L0 -36Z"/><path class="i-pagelines" d="M-52 -34 L-12 -28 M-52 -26 L-12 -20 M-52 -18 L-20 -13 M12 -28 L52 -34 M12 -20 L52 -26 M12 -12 L40 -16"/></g>'
		. '<path class="i-d3" d="M0 452 C150 436 300 442 420 450 S560 462 600 458 V500 H0Z"/>';
}

/** Falcon over the dunes. */
function lbff_scene_falcon() {
	return lbff_svg_sun( 420, 250, 50 )
		. lbff_svg_falcon( 270, 196, 1.35 )
		. lbff_svg_falcon( 452, 140, .55, .6 )
		. '<path class="i-d1" d="M0 320 C120 292 236 296 330 316 S500 330 600 304 V500 H0Z"/>'
		. '<path class="i-d2" d="M0 390 C140 360 260 366 360 384 S530 404 600 392 V500 H0Z"/>'
		. '<path class="i-d3" d="M0 448 C150 430 300 436 420 446 S560 458 600 454 V500 H0Z"/>'
		. lbff_svg_tufts( array( array( 100, 400, .9 ), array( 480, 458, 1 ) ) );
}

/** Hand-drawn treasure map. */
function lbff_scene_map() {
	return '<path class="i-d1" d="M0 380 C150 360 300 366 420 378 S560 390 600 384 V500 H0Z"/>'
		. '<g transform="rotate(-4 300 250)">'
		. '<rect class="i-shadow" x="122" y="104" width="372" height="312" rx="6"/>'
		. '<rect class="i-paper" x="112" y="92" width="372" height="312" rx="6"/>'
		. '<path class="i-mapline" d="M160 370 C200 310 252 336 292 286 S380 226 426 160" stroke-dasharray="7 9"/>'
		. '<path class="i-mark" d="M414 148 L438 172 M438 148 L414 172"/>'
		. '<path class="i-mapicon" d="M160 382 C180 362 200 362 220 382 M320 360 C340 340 362 340 382 360 M240 230 L262 196 L284 230Z M268 230 L286 204 L306 230Z"/>'
		. lbff_svg_palm( 372, 304, 34, 4, .32 )
		. '<g transform="translate(184 158)"><circle class="i-compass" r="28"/><polygon class="i-compass-star" points="0,-26 6,-6 26,0 6,6 0,26 -6,6 -26,0 -6,-6"/></g>'
		. '<path class="i-pagelines" d="M330 122 H452 M350 136 H452"/>'
		. '</g>'
		. lbff_svg_rabbit( 460, 444, .42 );
}

/** Line-art colouring page. */
function lbff_scene_colouring() {
	return '<g class="i-outline">'
		. '<circle cx="410" cy="190" r="52"/>'
		. '<path d="M410 112 V96 M466 134 L478 122 M488 190 H504 M354 134 L342 122"/>'
		. '<path d="M0 300 C120 270 240 276 340 296 S520 314 600 290"/>'
		. '<path d="M0 392 C150 366 228 350 300 350 C380 350 470 374 600 366"/>'
		. '<path d="M0 450 C140 430 280 436 400 448 S560 460 600 454"/>'
		. '<path d="M70 150 C80 138 96 138 104 150 C112 138 128 138 136 150"/>'
		. '</g>'
		. lbff_svg_rabbit( 236, 352, 1.1, 'i-outline' )
		. lbff_svg_tufts( array( array( 110, 392, 1.1 ), array( 500, 458, 1.1 ) ) );
}

/** Story-book page: text lines and a small vignette. */
function lbff_scene_paper() {
	return '<g class="i-pagelines i-pagelines--page">'
		. '<path d="M180 96 H440 M150 122 H420 M150 148 H440 M150 174 H380"/>'
		. '<path d="M150 214 H430 M150 240 H400"/>'
		. '</g>'
		. '<text class="i-dropcap" x="140" y="128">F</text>'
		. lbff_svg_sun( 430, 300, 44 )
		. '<path class="i-d1" d="M0 360 C120 330 240 336 340 352 S520 368 600 344 V500 H0Z"/>'
		. lbff_svg_rabbit( 330, 372, .5 )
		. '<path class="i-d2" d="M0 420 C150 396 290 402 400 414 S560 428 600 420 V500 H0Z"/>'
		. '<text class="i-folio" x="300" y="480">— 4 —</text>';
}
