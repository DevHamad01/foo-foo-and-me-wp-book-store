<?php
/**
 * Customizer: everything the client edits without touching code.
 *
 * Appearance → Customize →
 *   • Foo Foo — Settings  (brand, links, hero scene, Book 01, media, footer)
 *   • Foo Foo — Page Images (every photo on every page)
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register panels, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function lbff_customize_register( $wp_customize ) {
	$d = lbff_defaults();

	$wp_customize->add_panel(
		'lbff_panel',
		array(
			'title'       => __( 'Foo Foo — Settings', 'littlebunny' ),
			'description' => __( 'Brand details, store links, the book, media and footer.', 'littlebunny' ),
			'priority'    => 30,
		)
	);

	/* ---------- Helpers ---------- */
	$text = static function ( $key, $label, $section, $type = 'text', $description = '' ) use ( $wp_customize, $d ) {
		$sanitize = 'sanitize_text_field';
		if ( 'url' === $type ) {
			$sanitize = 'esc_url_raw';
		} elseif ( 'email' === $type ) {
			$sanitize = 'sanitize_email';
		} elseif ( 'textarea' === $type ) {
			$sanitize = 'sanitize_textarea_field';
		} elseif ( 'html' === $type ) {
			$sanitize = 'lbff_sanitize_inline_html';
			$type     = 'text';
		} elseif ( 'number' === $type ) {
			$sanitize = 'absint';
		}
		$wp_customize->add_setting(
			'lbff_' . $key,
			array(
				'default'           => isset( $d[ $key ] ) ? $d[ $key ] : '',
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			'lbff_' . $key,
			array(
				'label'       => $label,
				'section'     => $section,
				'type'        => $type,
				'description' => $description,
			)
		);
	};

	$media = static function ( $key, $label, $section, $mime = 'image', $description = '' ) use ( $wp_customize ) {
		$wp_customize->add_setting(
			'lbff_' . $key,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'lbff_' . $key,
				array(
					'label'       => $label,
					'section'     => $section,
					'mime_type'   => $mime,
					'description' => $description,
				)
			)
		);
	};

	/* ---------- Brand ---------- */
	$wp_customize->add_section( 'lbff_brand', array( 'title' => __( 'Brand & contact', 'littlebunny' ), 'panel' => 'lbff_panel' ) );
	$text( 'brand_kicker', __( 'Logo — small line', 'littlebunny' ), 'lbff_brand', 'text', __( 'Shown above the name, e.g. "Little Bunny". Upload a logo under Site Identity to replace the text logo.', 'littlebunny' ) );
	$text( 'brand_name', __( 'Logo — name', 'littlebunny' ), 'lbff_brand' );
	$text( 'contact_email', __( 'Public contact email', 'littlebunny' ), 'lbff_brand', 'email' );
	$text( 'contact_recipient', __( 'Send form messages to', 'littlebunny' ), 'lbff_brand', 'email', __( 'Leave empty to use the public contact email.', 'littlebunny' ) );

	/* ---------- Links ---------- */
	$wp_customize->add_section( 'lbff_links', array( 'title' => __( 'Store & social links', 'littlebunny' ), 'panel' => 'lbff_panel' ) );
	$text( 'link_amazon', __( 'Buy on Amazon (print)', 'littlebunny' ), 'lbff_links', 'url' );
	$text( 'link_kindle', __( 'Read on Kindle (ebook)', 'littlebunny' ), 'lbff_links', 'url' );
	$text( 'link_instagram', __( 'Instagram', 'littlebunny' ), 'lbff_links', 'url' );
	$text( 'link_youtube', __( 'YouTube', 'littlebunny' ), 'lbff_links', 'url' );
	$text( 'link_facebook', __( 'Facebook', 'littlebunny' ), 'lbff_links', 'url' );
	$text( 'link_privacy', __( 'Privacy page URL', 'littlebunny' ), 'lbff_links', 'url', __( 'Leave empty to use the WordPress privacy page.', 'littlebunny' ) );
	$text( 'link_terms', __( 'Terms page URL', 'littlebunny' ), 'lbff_links', 'url' );

	/* ---------- Hero scene ---------- */
	$wp_customize->add_section(
		'lbff_hero',
		array(
			'title'       => __( 'Desert hero scene', 'littlebunny' ),
			'panel'       => 'lbff_panel',
			'description' => __( 'The moving desert background used at the top of every main page.', 'littlebunny' ),
		)
	);
	$media( 'hero_video_id', __( 'Background video (MP4 upload)', 'littlebunny' ), 'lbff_hero', 'video', __( 'Recommended: 1920×1080, under 8 MB, no sound. Overrides the video URL below.', 'littlebunny' ) );
	$text( 'hero_video', __( 'Background video URL', 'littlebunny' ), 'lbff_hero', 'url', __( 'Used when no video is uploaded. Clear it to show the poster image only.', 'littlebunny' ) );
	$media( 'hero_poster', __( 'Poster image', 'littlebunny' ), 'lbff_hero', 'image', __( 'Shown while the video loads and on devices that save data.', 'littlebunny' ) );
	$wp_customize->add_setting( 'lbff_hero_particles', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'lbff_hero_particles', array( 'label' => __( 'Drifting sand particles', 'littlebunny' ), 'section' => 'lbff_hero', 'type' => 'checkbox' ) );

	/* ---------- Book ---------- */
	$wp_customize->add_section( 'lbff_book', array( 'title' => __( 'Book 01 (featured book)', 'littlebunny' ), 'panel' => 'lbff_panel' ) );
	$media( 'book_cover', __( 'Cover artwork', 'littlebunny' ), 'lbff_book', 'image', __( 'Portrait image (3:4). The title is drawn over it automatically.', 'littlebunny' ) );
	$text( 'book_num', __( 'Book number', 'littlebunny' ), 'lbff_book' );
	$text( 'book_title_1', __( 'Title — first line', 'littlebunny' ), 'lbff_book' );
	$text( 'book_title_2', __( 'Title — second line (italic)', 'littlebunny' ), 'lbff_book' );
	$text( 'book_blurb', __( 'Short description', 'littlebunny' ), 'lbff_book', 'textarea' );
	$text( 'book_author', __( 'Author', 'littlebunny' ), 'lbff_book' );
	$text( 'book_illustrator', __( 'Illustrator', 'littlebunny' ), 'lbff_book' );
	$text( 'book_ages', __( 'Ages', 'littlebunny' ), 'lbff_book' );
	$text( 'book_theme', __( 'Theme', 'littlebunny' ), 'lbff_book' );
	$text( 'book_learning', __( 'Learning theme', 'littlebunny' ), 'lbff_book' );
	$text( 'book_formats', __( 'Formats', 'littlebunny' ), 'lbff_book' );
	$text( 'book_series_total', __( 'Books planned in the series', 'littlebunny' ), 'lbff_book', 'number' );

	/* ---------- Media ---------- */
	$wp_customize->add_section(
		'lbff_media',
		array(
			'title'       => __( 'Read-aloud & videos', 'littlebunny' ),
			'panel'       => 'lbff_panel',
			'description' => __( 'Add real audio and video links. Until then the players show a demo state.', 'littlebunny' ),
		)
	);
	$text( 'audio_readaloud', __( 'Read-aloud audio (MP3 URL)', 'littlebunny' ), 'lbff_media', 'url', __( 'Upload the MP3 to Media → Add New, then paste its file URL here.', 'littlebunny' ) );
	$text( 'audio_duration', __( 'Read-aloud duration (mm:ss)', 'littlebunny' ), 'lbff_media' );
	$text( 'video_story', __( 'Animated story video URL', 'littlebunny' ), 'lbff_media', 'url' );
	$text( 'video_author', __( 'Reading-with-the-author video URL', 'littlebunny' ), 'lbff_media', 'url' );
	$text( 'youtube_channel', __( 'YouTube channel URL', 'littlebunny' ), 'lbff_media', 'url' );

	/* ---------- Footer ---------- */
	$wp_customize->add_section( 'lbff_footer', array( 'title' => __( 'Footer', 'littlebunny' ), 'panel' => 'lbff_panel' ) );
	$text( 'footer_heading', __( 'Large heading', 'littlebunny' ), 'lbff_footer', 'html', __( 'Wrap a word in <em></em> for the gold italic accent.', 'littlebunny' ) );
	$text( 'footer_contact_txt', __( 'Text under the email', 'littlebunny' ), 'lbff_footer', 'textarea' );
	$text( 'newsletter_title', __( 'Newsletter title', 'littlebunny' ), 'lbff_footer' );
	$text( 'newsletter_text', __( 'Newsletter text', 'littlebunny' ), 'lbff_footer', 'textarea' );
	$text( 'footer_copyright', __( 'Copyright line', 'littlebunny' ), 'lbff_footer', 'text', __( '{year} is replaced with the current year.', 'littlebunny' ) );

	/* ---------- Arabic ---------- */
	$wp_customize->add_section(
		'lbff_arabic',
		array(
			'title'       => __( 'Arabic texts (العربية)', 'littlebunny' ),
			'panel'       => 'lbff_panel',
			'description' => __( 'The Arabic version lives at yoursite.com/ar/. Theme texts are already translated; fill these only if you changed the English text above and want a matching Arabic version. Leave empty to use the built-in translation.', 'littlebunny' ),
		)
	);
	$wp_customize->add_setting( 'lbff_enable_arabic', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
	$wp_customize->add_control( 'lbff_enable_arabic', array( 'label' => __( 'Show the English / Arabic switch', 'littlebunny' ), 'section' => 'lbff_arabic', 'type' => 'checkbox' ) );
	foreach ( lbff_translatable_mods() as $key => $label ) {
		$is_long = in_array( $key, array( 'book_blurb', 'footer_contact_txt', 'newsletter_text' ), true );
		$wp_customize->add_setting(
			'lbff_' . $key . '_ar',
			array(
				'default'           => '',
				'sanitize_callback' => 'footer_heading' === $key ? 'lbff_sanitize_inline_html' : ( $is_long ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
			)
		);
		$wp_customize->add_control(
			'lbff_' . $key . '_ar',
			array(
				'label'       => $label,
				'section'     => 'lbff_arabic',
				'type'        => $is_long ? 'textarea' : 'text',
				'input_attrs' => array( 'dir' => 'rtl' ),
			)
		);
	}

	/* ---------- Page images ---------- */
	$wp_customize->add_panel(
		'lbff_images',
		array(
			'title'       => __( 'Foo Foo — Page Images', 'littlebunny' ),
			'description' => __( 'Every photo and illustration on the site. Empty slots show a drawn desert placeholder.', 'littlebunny' ),
			'priority'    => 31,
		)
	);
	foreach ( lbff_image_slot_groups() as $group_key => $group ) {
		$section = 'lbff_images_' . $group_key;
		$wp_customize->add_section( $section, array( 'title' => $group['title'], 'panel' => 'lbff_images' ) );
		foreach ( $group['slots'] as $slot_id => $slot ) {
			$setting = lbff_slot_setting( $slot_id );
			$wp_customize->add_setting( $setting, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$setting,
					array(
						'label'     => $slot[0],
						'section'   => $section,
						'mime_type' => 'image',
					)
				)
			);
		}
	}
}
add_action( 'customize_register', 'lbff_customize_register' );

/**
 * Sanitize short headings that may contain <em>/<br>.
 *
 * @param string $value Raw value.
 * @return string
 */
function lbff_sanitize_inline_html( $value ) {
	return wp_kses( (string) $value, lbff_inline_kses() );
}
