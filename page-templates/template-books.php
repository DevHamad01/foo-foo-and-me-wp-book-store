<?php
/**
 * Template Name: The Books
 * Template Post Type: page
 *
 * Sections live in template-parts/books/ — reorder or remove them with the
 * 'lbff_books_sections' filter.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

get_header();

$lbff_sections = apply_filters( 'lbff_books_sections', array( 'hero', 'book', 'series', 'listen', 'buy' ) );

foreach ( $lbff_sections as $lbff_section ) {
	get_template_part( 'template-parts/books/' . $lbff_section );
}

// Anything typed into the page editor appears after the designed sections.
while ( have_posts() ) {
	the_post();
	if ( '' !== trim( get_the_content() ) ) {
		echo '<section class="ff-section ff-bg-cream"><div class="ff-container ff-prose entry-content">';
		the_content();
		echo '</div></section>';
	}
}

get_footer();
