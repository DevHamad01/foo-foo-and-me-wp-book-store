<?php
/**
 * Template helpers. Keep markup in templates; keep logic here.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values for every Customizer setting. One place to change copy.
 *
 * @return array<string, mixed>
 */
function lbff_defaults() {
	return array(
		// Brand & contact.
		'brand_kicker'       => 'Little Bunny',
		'brand_name'         => 'Foo Foo',
		'contact_email'      => 'hello@littlebunnyfoofoo.com',
		'contact_recipient'  => '',
		'footer_heading'     => 'Discover <em>your</em> world',
		'footer_copyright'   => '© {year} Little Bunny Foo Foo · A United Education Project',
		'footer_contact_txt' => "Schools, educators,\npublishers & partners",
		'newsletter_title'   => 'Letters from the dunes',
		'newsletter_text'    => 'New books, activities and read-alouds — a few times a year.',

		// Links.
		'link_amazon'        => '#',
		'link_kindle'        => '#',
		'link_instagram'     => '#',
		'link_youtube'       => '#',
		'link_facebook'      => '#',
		'link_privacy'       => '',
		'link_terms'         => '',

		// Desert hero scene.
		'hero_video'         => 'https://videos.pexels.com/video-files/26745835/11999451_2560_1440_30fps.mp4',
		'hero_video_id'      => 0,
		'hero_poster'        => 0,
		'hero_particles'     => true,

		// Book 01.
		'book_num'           => '01',
		'book_title_1'       => 'Energy',
		'book_title_2'       => '& Rest',
		'book_author'        => 'Brent Corley',
		'book_illustrator'   => 'Muhammad Riaz',
		'book_cover'         => 0,
		'book_ages'          => '5 – 9',
		'book_theme'         => 'Balance & wellbeing',
		'book_learning'      => 'Energy, rest & balance',
		'book_formats'       => 'Print · Kindle · Audio',
		'book_series_total'  => 10,
		'book_blurb'         => 'Foo Foo wants to run every dune before sunset. But as the desert grows quiet, he begins to notice how everything around him — the falcon, the palm, the sun itself — knows when to move and when to rest.',

		// Media.
		'audio_readaloud'    => '',
		'audio_duration'     => '14:20',
		'video_story'        => '',
		'video_author'       => '',
		'youtube_channel'    => '',
	);
}

/**
 * Get a theme mod with the central default.
 *
 * @param string $key Setting key (without prefix).
 * @return mixed
 */
function lbff_mod( $key ) {
	$defaults = lbff_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	$value    = get_theme_mod( 'lbff_' . $key, $default );

	if ( is_string( $value ) && function_exists( 'lbff_is_ar' ) && lbff_is_ar() ) {
		$arabic = (string) get_theme_mod( 'lbff_' . $key . '_ar', '' );
		return '' !== trim( $arabic ) ? $arabic : lbff_t( $value );
	}
	return $value;
}

/**
 * Allowed inline HTML for short, editable headings (em / br / span only).
 *
 * @return array
 */
function lbff_inline_kses() {
	return array(
		'em'     => array(),
		'br'     => array(),
		'strong' => array(),
		'span'   => array( 'class' => true ),
	);
}

/**
 * Echo a URL from the Customizer, falling back to "#".
 *
 * @param string $key Link key.
 */
function lbff_link( $key ) {
	$url = lbff_mod( $key );
	echo esc_url( $url ? $url : '#' );
}

/**
 * Whether a link leaves the site (adds target=_blank attributes).
 *
 * @param string $key Link key.
 */
function lbff_link_target( $key ) {
	echo lbff_link_target_attr( $key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static string.
}

/**
 * Same as lbff_link_target() but returns the attribute string.
 *
 * @param string $key Link key.
 * @return string
 */
function lbff_link_target_attr( $key ) {
	$url = (string) lbff_mod( $key );
	if ( $url && '#' !== $url && 0 !== strpos( $url, home_url() ) && preg_match( '#^https?://#', $url ) ) {
		return ' target="_blank" rel="noopener"';
	}
	return '';
}

/**
 * Main navigation (desktop bar + mobile menu). One place to change labels
 * or targets — 'page' is a key for lbff_page_url(), 'hash' an optional anchor.
 * The pages keep their own URLs; only the labels differ from the page titles.
 *
 * @return array<int, array{title:string, page:string, hash:string}>
 */
function lbff_primary_nav() {
	return array(
		array(
			'title' => __( 'Home', 'littlebunny' ),
			'page'  => 'home',
			'hash'  => '',
		),
		array(
			'title' => __( 'The Books', 'littlebunny' ),
			'page'  => 'books',
			'hash'  => '',
		),
		array(
			'title' => __( 'Workshops & Field Trips', 'littlebunny' ),
			'page'  => 'explore',
			'hash'  => '',
		),
		array(
			'title' => __( 'Our Story', 'littlebunny' ),
			'page'  => 'meet',
			'hash'  => '',
		),
		array(
			'title' => __( 'Shop', 'littlebunny' ),
			'page'  => 'books',
			'hash'  => 'buy',
		),
	);
}

/**
 * The three "pillar" buttons in the home hero. One place to change labels
 * or targets — 'page' is a key for lbff_page_url().
 *
 * @return array<int, array{label:string, page:string}>
 */
function lbff_hero_pillars() {
	return array(
		array(
			'label' => __( 'Joy for Children', 'littlebunny' ),
			'page'  => 'books',
		),
		array(
			'label' => __( 'Memories for Families', 'littlebunny' ),
			'page'  => 'explore',
		),
		array(
			'label' => __( 'A Lifelong Love of Discovery', 'littlebunny' ),
			'page'  => 'meet',
		),
	);
}

/**
 * URL of the page that uses one of the theme's templates.
 *
 * @param string $key home|meet|books|explore.
 * @param string $hash Optional fragment without "#".
 * @return string
 */
function lbff_page_url( $key, $hash = '' ) {
	static $cache = array();

	if ( ! isset( $cache[ $key ] ) ) {
		$url = '';
		if ( 'home' === $key ) {
			$url = home_url( '/' );
		} else {
			$pages = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => 'publish',
					'posts_per_page' => 1,
					'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
					'meta_value'     => 'page-templates/template-' . $key . '.php', // phpcs:ignore WordPress.DB.SlowDBQuery
					'fields'         => 'ids',
				)
			);
			$url   = $pages ? get_permalink( $pages[0] ) : home_url( '/' );
		}
		$cache[ $key ] = $url;
	}

	return $cache[ $key ] . ( $hash ? '#' . $hash : '' );
}

/**
 * Section eyebrow: "01 —— INTRODUCTION".
 *
 * @param string $num   Number, e.g. "01".
 * @param string $label Label.
 * @param bool   $light On a dark background.
 */
function lbff_eyebrow( $num, $label, $light = false ) {
	printf(
		'<div class="ff-eyebrow%1$s"><span class="ff-eyebrow__num">%2$s</span><span class="ff-eyebrow__line" aria-hidden="true"></span><span class="ff-eyebrow__label">%3$s</span></div>',
		$light ? ' ff-eyebrow--light' : '',
		esc_html( $num ),
		esc_html( $label )
	);
}

/**
 * Hero kicker with the small diamond: "◇ THE CATALOGUE".
 *
 * @param string $label Label.
 */
function lbff_kicker( $label ) {
	printf( '<div class="ff-kicker"><span class="ff-kicker__diamond" aria-hidden="true"></span>%s</div>', esc_html( $label ) );
}

/**
 * Primary pill button with the square arrow tile.
 *
 * @param string $label Text.
 * @param string $url   URL.
 * @param string $extra Extra attributes (already escaped).
 */
function lbff_button( $label, $url, $extra = '' ) {
	printf(
		'<a class="ff-btn ff-btn--primary" href="%1$s"%3$s><span>%2$s</span><span class="ff-btn__icon" aria-hidden="true">→</span></a>',
		esc_url( $url ),
		esc_html( $label ),
		$extra // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Text link with underline and copper arrow.
 *
 * @param string $label Text.
 * @param string $url   URL.
 * @param bool   $light On dark background.
 */
function lbff_text_link( $label, $url, $light = false ) {
	printf(
		'<a class="ff-link%1$s" href="%2$s">%3$s <span class="ff-link__arrow" aria-hidden="true">→</span></a>',
		$light ? ' ff-link--light' : '',
		esc_url( $url ),
		esc_html( $label )
	);
}

/**
 * Render an image slot: the chosen image, or the illustrated fallback.
 *
 * @param string $id   Slot id from inc/image-slots.php.
 * @param array  $args { class, alt, eager }.
 */
function lbff_slot( $id, $args = array() ) {
	$slots = lbff_image_slots();
	$meta  = isset( $slots[ $id ] ) ? $slots[ $id ] : array( '', 'dawn', 'large' );
	$args  = wp_parse_args(
		$args,
		array(
			'class' => '',
			'alt'   => '',
			'eager' => false,
		)
	);

	$attachment = absint( get_theme_mod( lbff_slot_setting( $id ), 0 ) );
	$classes    = trim( 'ff-slot ' . $args['class'] );

	if ( $attachment && wp_attachment_is_image( $attachment ) ) {
		$size = isset( $meta[2] ) ? $meta[2] : 'large';
		echo '<div class="' . esc_attr( $classes ) . ' ff-slot--filled">';
		echo wp_get_attachment_image(
			$attachment,
			$size,
			false,
			array(
				'class'    => 'ff-slot__img',
				'alt'      => $args['alt'] ? $args['alt'] : get_post_meta( $attachment, '_wp_attachment_image_alt', true ),
				'loading'  => $args['eager'] ? 'eager' : 'lazy',
				'decoding' => 'async',
				'sizes'    => '(max-width: 760px) 100vw, 50vw',
			)
		);
		echo '</div>';
		return;
	}

	$tone  = isset( $meta[1] ) ? $meta[1] : 'dawn';
	$scene = isset( $meta[3] ) ? $meta[3] : 'dunes';
	echo '<div class="' . esc_attr( $classes . ' ff-slot--art ff-art--' . $tone ) . '" role="img" aria-label="' . esc_attr( $args['alt'] ? $args['alt'] : wp_strip_all_tags( (string) $meta[0] ) ) . '">';
	lbff_illustration( $scene, $tone );
	if ( is_customize_preview() || current_user_can( 'edit_theme_options' ) ) {
		printf(
			'<span class="ff-slot__hint">%s</span>',
			/* translators: %s: image slot description. */
			esc_html( sprintf( __( 'Add image: %s', 'littlebunny' ), $meta[0] ) )
		);
	}
	echo '</div>';
}

/**
 * Illustrated fallback (kept for backwards compatibility).
 *
 * @param string $tone  Tone name.
 * @param string $scene Scene name.
 */
function lbff_art_svg( $tone = 'dawn', $scene = 'dunes' ) {
	lbff_illustration( $scene, $tone );
}

/**
 * Book cover URL (Customizer image or the bundled cover photo).
 *
 * @return string
 */
function lbff_book_cover_url() {
	$id = absint( lbff_mod( 'book_cover' ) );
	if ( $id ) {
		$src = wp_get_attachment_image_url( $id, 'lbff-card' );
		if ( $src ) {
			return $src;
		}
	}
	return LBFF_URI . '/assets/images/book-01-cover.jpg';
}

/**
 * 3D book cover (the signature element of the design).
 *
 * @param array $args { variant: revealed|future, num, class, title1, title2, author }.
 */
function lbff_book_cover( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'variant' => 'revealed',
			'num'     => lbff_mod( 'book_num' ),
			'class'   => '',
			'title1'  => lbff_mod( 'book_title_1' ),
			'title2'  => lbff_mod( 'book_title_2' ),
			'author'  => lbff_mod( 'book_author' ),
		)
	);
	get_template_part( 'template-parts/global/book-cover', null, $args );
}

/**
 * Desert hero scene (video + overlays + particles).
 *
 * @param string $mood teal|dusk.
 * @param bool   $cream_edge Draw the curved cream edge at the bottom.
 */
function lbff_desert_scene( $mood = 'teal', $cream_edge = true ) {
	get_template_part(
		'template-parts/global/desert-scene',
		null,
		array(
			'mood' => $mood,
			'edge' => $cream_edge,
		)
	);
}

/**
 * Turn "Discover <em>your</em> world" style strings into safe HTML.
 *
 * @param string $text Text with limited inline HTML.
 */
function lbff_inline( $text ) {
	echo wp_kses( $text, lbff_inline_kses() );
}

/**
 * Menu items as a simple array (keeps the custom nav markup clean).
 * The primary navigation always comes from lbff_primary_nav(); other
 * locations use their assigned menu and fall back to the same list.
 *
 * @param string $location Menu location.
 * @return array<int, array{title:string, url:string, current:bool}>
 */
function lbff_menu_items( $location = 'primary' ) {
	$items     = array();
	$locations = get_nav_menu_locations();

	if ( 'primary' !== $location && ! empty( $locations[ $location ] ) ) {
		$menu_items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( $menu_items ) {
			_wp_menu_item_classes_by_context( $menu_items );
			foreach ( $menu_items as $item ) {
				if ( (int) $item->menu_item_parent ) {
					continue; // Single-level navigation, like the design.
				}
				$classes = (array) $item->classes;
				$items[] = array(
					'title'   => lbff_t( $item->title ),
					'url'     => $item->url,
					'current' => in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ),
				);
			}
			return $items;
		}
	}

	foreach ( lbff_primary_nav() as $nav ) {
		if ( $nav['hash'] ) {
			$current = false; // Anchors (Shop → Buy section) never mark a page as current.
		} else {
			$current = ( 'home' === $nav['page'] ) ? is_front_page() : is_page_template( 'page-templates/template-' . $nav['page'] . '.php' );
		}
		$items[] = array(
			'title'   => $nav['title'],
			'url'     => lbff_page_url( $nav['page'], $nav['hash'] ),
			'current' => $current,
		);
	}
	return $items;
}

/**
 * Parse a "mm:ss" duration into seconds.
 *
 * @param string $str Duration.
 * @return int
 */
function lbff_duration_seconds( $str ) {
	$parts = array_map( 'intval', explode( ':', (string) $str ) );
	if ( 3 === count( $parts ) ) {
		return $parts[0] * 3600 + $parts[1] * 60 + $parts[2];
	}
	if ( 2 === count( $parts ) ) {
		return $parts[0] * 60 + $parts[1];
	}
	return (int) $str;
}
