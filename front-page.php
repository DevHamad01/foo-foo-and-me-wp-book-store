<?php
/**
 * Front page — the Home design.
 *
 * Each section lives in template-parts/home/ so it can be reordered,
 * removed or reused without touching the others.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

get_header();

$lbff_sections = apply_filters(
	'lbff_home_sections',
	array( 'hero', 'intro', 'featured', 'meet', 'world', 'ages', 'listen', 'series', 'cta' )
);

foreach ( $lbff_sections as $lbff_section ) {
	get_template_part( 'template-parts/home/' . $lbff_section );
}

get_footer();
