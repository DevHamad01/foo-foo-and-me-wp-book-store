<?php
/**
 * One-click setup on theme activation.
 *
 * Creates the four pages with the right templates, sets the static front
 * page and builds the main menu — so the site looks complete the moment the
 * theme is activated. Existing pages are reused, never duplicated.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pages the theme needs.
 *
 * @return array<string, array{title:string, slug:string, template:string}>
 */
function lbff_required_pages() {
	return array(
		'home'    => array(
			'title'    => __( 'Home', 'littlebunny' ),
			'slug'     => 'home',
			'template' => '',
		),
		'meet'    => array(
			'title'    => __( 'Meet Foo Foo', 'littlebunny' ),
			'slug'     => 'meet-foo-foo',
			'template' => 'page-templates/template-meet.php',
		),
		'books'   => array(
			'title'    => __( 'The Books', 'littlebunny' ),
			'slug'     => 'the-books',
			'template' => 'page-templates/template-books.php',
		),
		'explore' => array(
			'title'    => __( 'Explore', 'littlebunny' ),
			'slug'     => 'explore',
			'template' => 'page-templates/template-explore.php',
		),
	);
}

/**
 * Run setup.
 */
function lbff_run_setup() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$ids = array();

	foreach ( lbff_required_pages() as $key => $page ) {
		$existing = 0;

		if ( $page['template'] ) {
			$found = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => array( 'publish', 'draft', 'private' ),
					'posts_per_page' => 1,
					'fields'         => 'ids',
					'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
					'meta_value'     => $page['template'], // phpcs:ignore WordPress.DB.SlowDBQuery
				)
			);
			$existing = $found ? (int) $found[0] : 0;
		}

		if ( ! $existing ) {
			$by_slug  = get_page_by_path( $page['slug'] );
			$existing = $by_slug ? (int) $by_slug->ID : 0;
		}

		if ( 'home' === $key && ! $existing && 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) {
			$existing = (int) get_option( 'page_on_front' );
		}

		if ( ! $existing ) {
			$existing = wp_insert_post(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_title'  => $page['title'],
					'post_name'   => $page['slug'],
				)
			);
		} elseif ( 'publish' !== get_post_status( $existing ) ) {
			wp_update_post( array( 'ID' => $existing, 'post_status' => 'publish' ) );
		}

		if ( $existing && ! is_wp_error( $existing ) ) {
			if ( $page['template'] ) {
				update_post_meta( $existing, '_wp_page_template', $page['template'] );
			}
			$ids[ $key ] = (int) $existing;
		}
	}

	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	// Main menu.
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( empty( $locations['primary'] ) ) {
		$menu_name = __( 'Main menu', 'littlebunny' );
		$menu      = wp_get_nav_menu_object( $menu_name );
		$menu_id   = $menu ? (int) $menu->term_id : wp_create_nav_menu( $menu_name );

		if ( $menu_id && ! is_wp_error( $menu_id ) && ! wp_get_nav_menu_items( $menu_id ) ) {
			foreach ( array( 'home', 'meet', 'books', 'explore' ) as $order => $key ) {
				if ( empty( $ids[ $key ] ) ) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-object-id' => $ids[ $key ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $order + 1,
					)
				);
			}
		}

		if ( $menu_id && ! is_wp_error( $menu_id ) ) {
			$locations['primary'] = $menu_id;
			if ( empty( $locations['footer'] ) ) {
				$locations['footer'] = $menu_id;
			}
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	update_option( 'lbff_setup_done', LBFF_VERSION );
	set_transient( 'lbff_welcome_notice', 1, HOUR_IN_SECONDS );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'lbff_run_setup' );

/**
 * Welcome notice after activation.
 */
function lbff_welcome_notice() {
	if ( ! get_transient( 'lbff_welcome_notice' ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	delete_transient( 'lbff_welcome_notice' );
	?>
	<div class="notice notice-success is-dismissible">
		<p><strong><?php esc_html_e( 'Little Bunny Foo Foo is ready.', 'littlebunny' ); ?></strong>
		<?php esc_html_e( 'Home, Meet Foo Foo, The Books and Explore pages and the main menu have been set up.', 'littlebunny' ); ?></p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=lbff_images' ) ); ?>"><?php esc_html_e( 'Add page images', 'littlebunny' ); ?></a>
			<a class="button" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=lbff_panel' ) ); ?>"><?php esc_html_e( 'Edit links, book & contact details', 'littlebunny' ); ?></a>
			<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'View site', 'littlebunny' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'lbff_welcome_notice' );
