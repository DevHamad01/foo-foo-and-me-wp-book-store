<?php
/**
 * Theme setup: supports, menus, image sizes, body classes.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme features.
 */
function lbff_setup() {
	load_theme_textdomain( 'littlebunny', LBFF_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'littlebunny' ),
			'footer'  => __( 'Footer navigation', 'littlebunny' ),
			'legal'   => __( 'Footer legal links', 'littlebunny' ),
		)
	);

	// Image sizes tuned to the layouts in the design.
	add_image_size( 'lbff-hero', 1920, 1280, true );
	add_image_size( 'lbff-wide', 1400, 900, false );
	add_image_size( 'lbff-portrait', 900, 1200, false );
	add_image_size( 'lbff-card', 640, 820, false );

	add_editor_style( 'assets/css/editor.css' );

	// Brand palette for the block editor.
	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => __( 'Cream', 'littlebunny' ), 'slug' => 'cream', 'color' => '#F7F2E8' ),
			array( 'name' => __( 'Sand', 'littlebunny' ), 'slug' => 'sand', 'color' => '#EDE3D0' ),
			array( 'name' => __( 'Gold', 'littlebunny' ), 'slug' => 'gold', 'color' => '#E8C08D' ),
			array( 'name' => __( 'Copper', 'littlebunny' ), 'slug' => 'copper', 'color' => '#A86A36' ),
			array( 'name' => __( 'Teal', 'littlebunny' ), 'slug' => 'teal', 'color' => '#073B46' ),
			array( 'name' => __( 'Deep teal', 'littlebunny' ), 'slug' => 'deep', 'color' => '#04262E' ),
			array( 'name' => __( 'Ink', 'littlebunny' ), 'slug' => 'ink', 'color' => '#182321' ),
		)
	);
}
add_action( 'after_setup_theme', 'lbff_setup' );

/**
 * Content width for embeds.
 */
function lbff_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lbff_content_width', 860 );
}
add_action( 'after_setup_theme', 'lbff_content_width', 0 );

/**
 * Footer widget area (optional, shown above the footer bottom bar when used).
 */
function lbff_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog sidebar', 'littlebunny' ),
			'id'            => 'sidebar-blog',
			'description'   => __( 'Shown beside blog posts and archives.', 'littlebunny' ),
			'before_widget' => '<section id="%1$s" class="ff-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="ff-widget__title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'lbff_widgets_init' );

/**
 * Helpful body classes.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function lbff_body_classes( $classes ) {
	$classes[] = 'ff-body';
	if ( lbff_has_cinematic_hero() ) {
		$classes[] = 'ff-has-hero';
	}
	return $classes;
}
add_filter( 'body_class', 'lbff_body_classes' );

/**
 * Whether the current view starts with a full-screen desert hero.
 * Generic pages get a shorter "page hero" — also dark — so the glass nav
 * always sits on a dark background.
 *
 * @return bool
 */
function lbff_has_cinematic_hero() {
	return is_front_page() || is_page_template(
		array(
			'page-templates/template-meet.php',
			'page-templates/template-books.php',
			'page-templates/template-explore.php',
		)
	);
}

/**
 * Remove the "Archive:" / "Category:" prefixes from archive titles.
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Shorter, cleaner excerpts.
 */
add_filter(
	'excerpt_length',
	static function () {
		return 28;
	}
);
add_filter(
	'excerpt_more',
	static function () {
		return '…';
	}
);
