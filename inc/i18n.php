<?php
/**
 * English / Arabic (Saudi) language switch — no plugin required.
 *
 *  • English lives at  /the-books/      Arabic at  /ar/the-books/
 *    (with plain permalinks Arabic uses ?lang=ar instead)
 *  • Arabic pages switch to right-to-left layout and Arabic fonts.
 *  • All theme text is translated from languages/ar.php.
 *  • Customizer texts can be given their own Arabic version
 *    (Customize → Foo Foo — Settings → Arabic texts).
 *  • hreflang tags tell search engines about both versions.
 *
 * For translating blog posts / page editor content later, a plugin such as
 * Polylang can be added; this switch only covers the theme's own content.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Languages offered by the theme.
 *
 * @return array<string, array{label:string, name:string, dir:string, locale:string}>
 */
function lbff_languages() {
	return array(
		'en' => array( 'label' => 'EN', 'name' => 'English', 'dir' => 'ltr', 'locale' => 'en' ),
		'ar' => array( 'label' => 'عربي', 'name' => 'العربية', 'dir' => 'rtl', 'locale' => 'ar-SA' ),
	);
}

/**
 * Whether the Arabic switch is enabled in the Customizer.
 *
 * @return bool
 */
function lbff_multilingual_enabled() {
	return (bool) get_theme_mod( 'lbff_enable_arabic', true );
}

/**
 * Current language: 'en' or 'ar'.
 *
 * @return string
 */
function lbff_lang() {
	if ( isset( $GLOBALS['lbff_lang'] ) ) {
		return $GLOBALS['lbff_lang'];
	}
	return 'en';
}

/**
 * Is the current request Arabic?
 *
 * @return bool
 */
function lbff_is_ar() {
	return 'ar' === lbff_lang();
}

/**
 * Path of the home URL, e.g. "/" or "/site/".
 *
 * @return string
 */
function lbff_home_path() {
	$path = wp_parse_url( get_option( 'home' ), PHP_URL_PATH );
	return trailingslashit( $path ? $path : '/' );
}

/**
 * Detect the language from the URL as early as possible and strip the /ar
 * prefix so WordPress routes the request to the normal page.
 */
function lbff_detect_language() {
	$GLOBALS['lbff_lang']      = 'en';
	$GLOBALS['lbff_clean_uri'] = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/'; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

	if ( ! lbff_multilingual_enabled() ) {
		return;
	}

	// Form submissions carry the visitor's language.
	if ( ( defined( 'DOING_AJAX' ) || ( isset( $_SERVER['SCRIPT_NAME'] ) && false !== strpos( sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ), 'admin-post.php' ) ) ) && isset( $_POST['lang'] ) && 'ar' === $_POST['lang'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$GLOBALS['lbff_lang'] = 'ar';
		return;
	}

	if ( is_admin() ) {
		return;
	}

	$uri    = $GLOBALS['lbff_clean_uri'];
	$prefix = lbff_home_path() . 'ar';

	if ( 0 === strpos( $uri, $prefix ) && preg_match( '#^' . preg_quote( $prefix, '#' ) . '(/|\?|$)#', $uri ) ) {
		$rest                      = substr( $uri, strlen( $prefix ) );
		$clean                     = lbff_home_path() . ltrim( $rest, '/' );
		$_SERVER['REQUEST_URI']    = $clean;
		$GLOBALS['lbff_clean_uri'] = $clean;
		$GLOBALS['lbff_lang']      = 'ar';
		return;
	}

	if ( isset( $_GET['lang'] ) && 'ar' === $_GET['lang'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$GLOBALS['lbff_lang']      = 'ar';
		$GLOBALS['lbff_clean_uri'] = remove_query_arg( 'lang', $uri );
	}
}
lbff_detect_language();

/**
 * Turn a site URL into its version in another language.
 *
 * @param string $url  Absolute URL on this site (English form).
 * @param string $lang Target language.
 * @return string
 */
function lbff_localize_url( $url, $lang ) {
	$home = untrailingslashit( get_option( 'home' ) );
	if ( 'ar' !== $lang || 0 !== strpos( $url, $home ) ) {
		return $url;
	}
	if ( ! get_option( 'permalink_structure' ) ) {
		return add_query_arg( 'lang', 'ar', $url );
	}
	$rest = substr( $url, strlen( $home ) );
	if ( preg_match( '#^/ar(/|\?|$)#', $rest ) ) {
		return $url;
	}
	return $home . '/ar' . ( '' === $rest ? '/' : ( '/' === $rest[0] ? $rest : '/' . $rest ) );
}

/**
 * URL of the current page in a given language.
 *
 * @param string $lang Language code.
 * @return string
 */
function lbff_switch_url( $lang ) {
	$home_host = untrailingslashit( preg_replace( '#(https?://[^/]+).*#', '$1', get_option( 'home' ) ) );
	$clean     = remove_query_arg( array( 'lang', 'lbff_form', 'lbff_status' ), $GLOBALS['lbff_clean_uri'] );
	$url       = $home_host . $clean;
	return 'ar' === $lang ? lbff_localize_url( $url, 'ar' ) : $url;
}

if ( lbff_is_ar() && ! is_admin() ) {
	// Every link WordPress builds (pages, menus, home) stays in Arabic.
	add_filter(
		'home_url',
		static function ( $url ) {
			return lbff_localize_url( $url, 'ar' );
		},
		20
	);

	// The stripped request no longer matches its own permalink — don't "fix" it.
	add_filter( 'redirect_canonical', '__return_false' );

	// Translate theme strings.
	add_filter(
		'gettext_littlebunny',
		static function ( $translation, $text ) {
			$t = lbff_ar_lookup( $text );
			return null === $t ? $translation : $t;
		},
		10,
		2
	);
	add_filter(
		'gettext_with_context_littlebunny',
		static function ( $translation, $text ) {
			$t = lbff_ar_lookup( $text );
			return null === $t ? $translation : $t;
		},
		10,
		2
	);
	add_filter(
		'ngettext_littlebunny',
		static function ( $translation, $single, $plural, $number ) {
			$t = lbff_ar_lookup( 1 === (int) $number ? $single : $plural );
			return null === $t ? $translation : $t;
		},
		10,
		4
	);

	// Page titles from the database (menu items, page heroes, browser tab).
	add_filter(
		'the_title',
		static function ( $title ) {
			return lbff_t( $title );
		}
	);
	add_filter(
		'document_title_parts',
		static function ( $parts ) {
			foreach ( array( 'title', 'site', 'tagline' ) as $k ) {
				if ( isset( $parts[ $k ] ) ) {
					$parts[ $k ] = lbff_t( $parts[ $k ] );
				}
			}
			return $parts;
		}
	);
	add_filter(
		'bloginfo',
		static function ( $output, $show ) {
			return in_array( $show, array( 'name', 'description' ), true ) ? lbff_t( $output ) : $output;
		},
		10,
		2
	);
}

/**
 * Arabic dictionary lookup.
 *
 * @param string $text English text.
 * @return string|null
 */
function lbff_ar_lookup( $text ) {
	static $dict = null;
	if ( null === $dict ) {
		$file = LBFF_DIR . '/languages/ar.php';
		$dict = file_exists( $file ) ? (array) include $file : array();
		$dict = apply_filters( 'lbff_arabic_strings', $dict );
	}
	return isset( $dict[ $text ] ) ? $dict[ $text ] : null;
}

/**
 * Translate any string (not only gettext calls) when the page is Arabic.
 *
 * @param string $text Text.
 * @return string
 */
function lbff_t( $text ) {
	if ( ! lbff_is_ar() || ! is_string( $text ) || '' === $text ) {
		return $text;
	}
	$t = lbff_ar_lookup( $text );
	if ( null === $t && false !== strpos( $text, '&' ) ) {
		// Titles arrive texturized ("&" → "&#038;") — match the plain dictionary key.
		$t = lbff_ar_lookup( html_entity_decode( $text, ENT_QUOTES, 'UTF-8' ) );
	}
	return null === $t ? $text : $t;
}

/**
 * <html lang="ar" dir="rtl"> on Arabic pages.
 */
add_filter(
	'language_attributes',
	static function ( $output ) {
		if ( lbff_is_ar() && ! is_admin() ) {
			return 'lang="ar" dir="rtl"';
		}
		return $output;
	}
);

/**
 * Body classes for styling.
 */
add_filter(
	'body_class',
	static function ( $classes ) {
		$classes[] = 'ff-lang-' . lbff_lang();
		if ( lbff_is_ar() ) {
			$classes[] = 'rtl';
			$classes[] = 'ff-rtl';
		}
		return $classes;
	}
);

/**
 * hreflang alternates for search engines.
 */
function lbff_hreflang() {
	if ( ! lbff_multilingual_enabled() || is_404() || is_search() ) {
		return;
	}
	printf( '<link rel="alternate" hreflang="en" href="%s">' . "\n", esc_url( lbff_switch_url( 'en' ) ) );
	printf( '<link rel="alternate" hreflang="ar" href="%s">' . "\n", esc_url( lbff_switch_url( 'ar' ) ) );
	printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( lbff_switch_url( 'en' ) ) );
}
add_action( 'wp_head', 'lbff_hreflang', 3 );

/**
 * Language switcher (EN | عربي).
 *
 * @param string $class Extra class.
 */
function lbff_language_switcher( $class = '' ) {
	if ( ! lbff_multilingual_enabled() ) {
		return;
	}
	echo '<div class="ff-lang ' . esc_attr( $class ) . '" role="group" aria-label="' . esc_attr__( 'Language', 'littlebunny' ) . '">';
	foreach ( lbff_languages() as $code => $lang ) {
		$active = lbff_lang() === $code;
		printf(
			'<a class="ff-lang__opt%1$s" href="%2$s" hreflang="%3$s" lang="%3$s"%4$s data-no-transition>%5$s</a>',
			$active ? ' is-active' : '',
			esc_url( lbff_switch_url( $code ) ),
			esc_attr( $code ),
			$active ? ' aria-current="true"' : '',
			esc_html( $lang['label'] )
		);
	}
	echo '</div>';
}

/**
 * Customizer keys that can have their own Arabic text.
 *
 * @return array<string, string> key => label.
 */
function lbff_translatable_mods() {
	return array(
		'brand_kicker'       => __( 'Logo — small line', 'littlebunny' ),
		'brand_name'         => __( 'Logo — name', 'littlebunny' ),
		'book_title_1'       => __( 'Book title — first line', 'littlebunny' ),
		'book_title_2'       => __( 'Book title — second line', 'littlebunny' ),
		'book_blurb'         => __( 'Book description', 'littlebunny' ),
		'book_author'        => __( 'Author', 'littlebunny' ),
		'book_illustrator'   => __( 'Illustrator', 'littlebunny' ),
		'book_ages'          => __( 'Ages', 'littlebunny' ),
		'book_theme'         => __( 'Theme', 'littlebunny' ),
		'book_learning'      => __( 'Learning theme', 'littlebunny' ),
		'book_formats'       => __( 'Formats', 'littlebunny' ),
		'footer_heading'     => __( 'Footer heading', 'littlebunny' ),
		'footer_contact_txt' => __( 'Footer contact text', 'littlebunny' ),
		'newsletter_title'   => __( 'Newsletter title', 'littlebunny' ),
		'newsletter_text'    => __( 'Newsletter text', 'littlebunny' ),
		'footer_copyright'   => __( 'Copyright line', 'littlebunny' ),
	);
}
