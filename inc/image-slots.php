<?php
/**
 * Image slot registry.
 *
 * Every photo / illustration position in the design is an "image slot".
 * Each slot becomes an image picker under Appearance → Customize → Page Images.
 * Until an image is chosen, a hand-drawn desert illustration is shown instead,
 * so the site never looks broken or empty.
 *
 * Each slot: [ label, tone, image size, illustration scene ].
 * Tones: dawn | teal | dusk | night | sand | paper
 * Scenes: see inc/illustrations.php
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * All slots, grouped by page.
 *
 * @return array<string, array{title:string, slots:array<string, array{0:string,1:string,2?:string}>}>
 */
function lbff_image_slot_groups() {
	$groups = array(
		'home'    => array(
			'title' => __( 'Home page', 'littlebunny' ),
			'slots' => array(
				'home-hero-p1'       => array( __( 'Hero slider 1 — Dune crest, Rub’ al Khali', 'littlebunny' ), 'dawn', 'lbff-card', 'dunes' ),
				'home-hero-p2'       => array( __( 'Hero slider 2 — Medina rooftops, evening', 'littlebunny' ), 'dusk', 'lbff-card', 'medina' ),
				'home-hero-p3'       => array( __( 'Hero slider 3 — AlUla sandstone, warm light', 'littlebunny' ), 'sand', 'lbff-card', 'canyon' ),
				'home-intro-medina'  => array( __( 'Introduction — Medina courtyard & arches', 'littlebunny' ), 'dusk', 'lbff-wide', 'medina' ),
				'home-intro-ripple'  => array( __( 'Introduction — Sand ripple macro', 'littlebunny' ), 'sand', 'lbff-card', 'ripples' ),
				'home-spread-left'   => array( __( 'Featured book — sample page (left)', 'littlebunny' ), 'paper', 'lbff-card', 'paper' ),
				'home-spread-right'  => array( __( 'Featured book — sample page (right)', 'littlebunny' ), 'dawn', 'lbff-card', 'rabbit' ),
				'home-sample-1'      => array( __( 'Featured book — thumbnail p.4', 'littlebunny' ), 'paper', 'medium', 'paper' ),
				'home-sample-2'      => array( __( 'Featured book — thumbnail p.12', 'littlebunny' ), 'dawn', 'medium', 'rabbit' ),
				'home-sample-3'      => array( __( 'Featured book — thumbnail p.22', 'littlebunny' ), 'sand', 'medium', 'falcon' ),
				'home-meet-portrait' => array( __( 'Meet Foo Foo — portrait on a dune crest', 'littlebunny' ), 'dawn', 'lbff-portrait', 'rabbit' ),
				'home-world-1'       => array( __( 'World — The Dunes', 'littlebunny' ), 'dawn', 'lbff-portrait', 'dunes' ),
				'home-world-2'       => array( __( 'World — The Oasis', 'littlebunny' ), 'teal', 'lbff-portrait', 'oasis' ),
				'home-world-3'       => array( __( 'World — Medina', 'littlebunny' ), 'dusk', 'lbff-portrait', 'medina' ),
				'home-world-4'       => array( __( 'World — The Wild', 'littlebunny' ), 'sand', 'lbff-portrait', 'wild' ),
				'home-world-5'       => array( __( 'World — The Night Sky', 'littlebunny' ), 'night', 'lbff-portrait', 'night' ),
				'home-age-little'    => array( __( 'Age group — Little Explorers', 'littlebunny' ), 'dusk', 'lbff-portrait', 'reading' ),
				'home-age-big'       => array( __( 'Age group — Big Adventure', 'littlebunny' ), 'dusk', 'lbff-portrait', 'canyon' ),
				'home-video-still'   => array( __( 'Read & Listen — video still', 'littlebunny' ), 'night', 'lbff-wide', 'night' ),
			),
		),
		'meet'    => array(
			'title' => __( 'Meet Foo Foo page', 'littlebunny' ),
			'slots' => array(
				'meet-who-portrait'    => array( __( 'Who is Foo Foo — portrait', 'littlebunny' ), 'dawn', 'lbff-portrait', 'rabbit' ),
				'meet-journey-1'       => array( __( 'Journey I — Desert', 'littlebunny' ), 'dawn', 'lbff-wide', 'dunes' ),
				'meet-journey-2'       => array( __( 'Journey II — Nature', 'littlebunny' ), 'teal', 'lbff-wide', 'oasis' ),
				'meet-journey-3'       => array( __( 'Journey III — Animals', 'littlebunny' ), 'sand', 'lbff-wide', 'wild' ),
				'meet-journey-4'       => array( __( 'Journey IV — Medina', 'littlebunny' ), 'dusk', 'lbff-wide', 'medina' ),
				'meet-journey-5'       => array( __( 'Journey V — Discovery', 'littlebunny' ), 'sand', 'lbff-wide', 'map' ),
				'meet-journey-6'       => array( __( 'Journey VI — Learning', 'littlebunny' ), 'night', 'lbff-wide', 'reading' ),
				'meet-little-main'     => array( __( 'Little Explorers — main image', 'littlebunny' ), 'dusk', 'lbff-wide', 'reading' ),
				'meet-little-detail'   => array( __( 'Little Explorers — spread detail', 'littlebunny' ), 'paper', 'lbff-card', 'paper' ),
				'meet-big-main'        => array( __( 'Big Adventure — main image', 'littlebunny' ), 'dusk', 'lbff-wide', 'canyon' ),
				'meet-big-detail'      => array( __( 'Big Adventure — field journal page', 'littlebunny' ), 'sand', 'lbff-card', 'map' ),
				'meet-author-portrait' => array( __( 'Author portrait', 'littlebunny' ), 'dawn', 'lbff-portrait', 'dunes' ),
				'meet-author-medina'   => array( __( 'Author — Medina photograph', 'littlebunny' ), 'dusk', 'lbff-card', 'medina' ),
				'meet-credit-riaz'     => array( __( 'Credits — story illustration sample', 'littlebunny' ), 'paper', 'lbff-card', 'colouring' ),
				'meet-credit-alaa'     => array( __( 'Credits — Medina artwork sample', 'littlebunny' ), 'dusk', 'lbff-card', 'medina' ),
			),
		),
		'books'   => array(
			'title' => __( 'The Books page', 'littlebunny' ),
			'slots' => array(
				'books-spread-1-l' => array( __( 'Book preview — spread 1, left page', 'littlebunny' ), 'paper', 'lbff-wide', 'paper' ),
				'books-spread-1-r' => array( __( 'Book preview — spread 1, right page', 'littlebunny' ), 'dawn', 'lbff-wide', 'rabbit' ),
				'books-spread-2-l' => array( __( 'Book preview — spread 2, left page', 'littlebunny' ), 'paper', 'lbff-wide', 'paper' ),
				'books-spread-2-r' => array( __( 'Book preview — spread 2, right page', 'littlebunny' ), 'sand', 'lbff-wide', 'dunes' ),
				'books-spread-3-l' => array( __( 'Book preview — spread 3, left page', 'littlebunny' ), 'paper', 'lbff-wide', 'paper' ),
				'books-spread-3-r' => array( __( 'Book preview — spread 3, right page', 'littlebunny' ), 'dawn', 'lbff-wide', 'falcon' ),
				'books-spread-4-l' => array( __( 'Book preview — spread 4, left page', 'littlebunny' ), 'paper', 'lbff-wide', 'paper' ),
				'books-spread-4-r' => array( __( 'Book preview — spread 4, right page', 'littlebunny' ), 'dusk', 'lbff-wide', 'reading' ),
				'books-video-1'    => array( __( 'Video — the animated story (thumbnail)', 'littlebunny' ), 'night', 'lbff-wide', 'night' ),
				'books-video-2'    => array( __( 'Video — reading with the author (thumbnail)', 'littlebunny' ), 'dusk', 'lbff-wide', 'reading' ),
			),
		),
		'explore' => array(
			'title' => __( 'Explore page', 'littlebunny' ),
			'slots' => array(
				'explore-media-1'          => array( __( 'Read & Listen — Read-aloud', 'littlebunny' ), 'night', 'lbff-card', 'reading' ),
				'explore-media-2'          => array( __( 'Read & Listen — Voice-over', 'littlebunny' ), 'teal', 'lbff-card', 'oasis' ),
				'explore-media-3'          => array( __( 'Read & Listen — Story video', 'littlebunny' ), 'dusk', 'lbff-card', 'falcon' ),
				'explore-media-4'          => array( __( 'Read & Listen — YouTube', 'littlebunny' ), 'night', 'lbff-card', 'night' ),
				'explore-activity-preview' => array( __( 'Activities — colouring page preview', 'littlebunny' ), 'paper', 'lbff-card', 'colouring' ),
				'explore-exp-1'            => array( __( 'Experiences — Workshops', 'littlebunny' ), 'sand', 'lbff-card', 'reading' ),
				'explore-exp-2'            => array( __( 'Experiences — School activities', 'littlebunny' ), 'teal', 'lbff-card', 'medina' ),
				'explore-exp-3'            => array( __( 'Experiences — Animal encounters', 'littlebunny' ), 'dawn', 'lbff-card', 'wild' ),
				'explore-exp-4'            => array( __( 'Experiences — Experiential programmes', 'littlebunny' ), 'dusk', 'lbff-card', 'canyon' ),
			),
		),
	);

	return apply_filters( 'lbff_image_slot_groups', $groups );
}

/**
 * Flat lookup: slot id => [label, tone, size].
 *
 * @return array<string, array>
 */
function lbff_image_slots() {
	static $flat = null;
	if ( null === $flat ) {
		$flat = array();
		foreach ( lbff_image_slot_groups() as $group ) {
			$flat = array_merge( $flat, $group['slots'] );
		}
	}
	return $flat;
}

/**
 * Customizer setting key for a slot.
 *
 * @param string $id Slot id.
 * @return string
 */
function lbff_slot_setting( $id ) {
	return 'lbff_img_' . str_replace( '-', '_', $id );
}
