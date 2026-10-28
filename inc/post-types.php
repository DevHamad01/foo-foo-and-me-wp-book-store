<?php
/**
 * "Activities" — downloadable worksheets, colouring pages and packs
 * shown on the Explore page (with the age / free filters).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Activity post type.
 */
function lbff_register_post_types() {
	register_post_type(
		'lbff_activity',
		array(
			'labels'              => array(
				'name'               => __( 'Activities', 'littlebunny' ),
				'singular_name'      => __( 'Activity', 'littlebunny' ),
				'add_new'            => __( 'Add activity', 'littlebunny' ),
				'add_new_item'       => __( 'Add new activity', 'littlebunny' ),
				'edit_item'          => __( 'Edit activity', 'littlebunny' ),
				'all_items'          => __( 'All activities', 'littlebunny' ),
				'search_items'       => __( 'Search activities', 'littlebunny' ),
				'not_found'          => __( 'No activities yet.', 'littlebunny' ),
				'not_found_in_trash' => __( 'No activities in the bin.', 'littlebunny' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-media-document',
			'supports'            => array( 'title', 'page-attributes' ),
			'has_archive'         => false,
			'exclude_from_search' => true,
			'show_in_rest'        => false,
		)
	);
}
add_action( 'init', 'lbff_register_post_types' );

/**
 * Field definitions for the activity meta box.
 *
 * @return array<string, array>
 */
function lbff_activity_fields() {
	return array(
		'type'  => array(
			'label'   => __( 'Type', 'littlebunny' ),
			'options' => array(
				'COLOURING'       => __( 'Colouring', 'littlebunny' ),
				'WORKSHEETS'      => __( 'Worksheets', 'littlebunny' ),
				'ACTIVITY PACK'   => __( 'Activity pack', 'littlebunny' ),
				'WRITING PROMPTS' => __( 'Writing prompts', 'littlebunny' ),
			),
		),
		'age'   => array(
			'label'   => __( 'Age group', 'littlebunny' ),
			'options' => array(
				'5–6' => __( 'Ages 5–6 (Little Explorers)', 'littlebunny' ),
				'7–9' => __( 'Ages 7–9 (Big Adventure)', 'littlebunny' ),
			),
		),
		'pages' => array( 'label' => __( 'Length, e.g. "6 pages"', 'littlebunny' ) ),
		'free'  => array( 'label' => __( 'Free download', 'littlebunny' ) ),
		'file'  => array( 'label' => __( 'PDF file', 'littlebunny' ) ),
	);
}

/**
 * Meta box.
 */
function lbff_activity_meta_box() {
	add_meta_box( 'lbff_activity_details', __( 'Activity details', 'littlebunny' ), 'lbff_activity_meta_box_html', 'lbff_activity', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'lbff_activity_meta_box' );

/**
 * Meta box markup.
 *
 * @param WP_Post $post Post.
 */
function lbff_activity_meta_box_html( $post ) {
	wp_nonce_field( 'lbff_activity_save', 'lbff_activity_nonce' );
	$fields = lbff_activity_fields();
	$val    = static function ( $key ) use ( $post ) {
		return get_post_meta( $post->ID, '_lbff_' . $key, true );
	};
	?>
	<table class="form-table" role="presentation">
		<?php foreach ( array( 'type', 'age' ) as $key ) : ?>
			<tr>
				<th scope="row"><label for="lbff_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $fields[ $key ]['label'] ); ?></label></th>
				<td>
					<select name="lbff_<?php echo esc_attr( $key ); ?>" id="lbff_<?php echo esc_attr( $key ); ?>">
						<?php foreach ( $fields[ $key ]['options'] as $opt => $label ) : ?>
							<option value="<?php echo esc_attr( $opt ); ?>" <?php selected( $val( $key ), $opt ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<th scope="row"><label for="lbff_pages"><?php echo esc_html( $fields['pages']['label'] ); ?></label></th>
			<td><input type="text" class="regular-text" name="lbff_pages" id="lbff_pages" value="<?php echo esc_attr( $val( 'pages' ) ); ?>" placeholder="6 pages"></td>
		</tr>
		<tr>
			<th scope="row"><?php echo esc_html( $fields['free']['label'] ); ?></th>
			<td><label><input type="checkbox" name="lbff_free" value="1" <?php checked( $val( 'free' ), '1' ); ?>> <?php esc_html_e( 'Show the FREE label and include in the "Free" filter', 'littlebunny' ); ?></label></td>
		</tr>
		<tr>
			<th scope="row"><label for="lbff_file"><?php echo esc_html( $fields['file']['label'] ); ?></label></th>
			<td>
				<input type="url" class="regular-text" name="lbff_file" id="lbff_file" value="<?php echo esc_attr( $val( 'file' ) ); ?>" placeholder="https://">
				<button type="button" class="button" id="lbff_file_pick"><?php esc_html_e( 'Choose / upload PDF', 'littlebunny' ); ?></button>
				<p class="description"><?php esc_html_e( 'The DOWNLOAD button links to this file.', 'littlebunny' ); ?></p>
			</td>
		</tr>
	</table>
	<script>
	( function () {
		var btn = document.getElementById( 'lbff_file_pick' );
		if ( ! btn || ! window.wp || ! wp.media ) { return; }
		var frame;
		btn.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			if ( ! frame ) {
				frame = wp.media( { title: '<?php echo esc_js( __( 'Choose activity file', 'littlebunny' ) ); ?>', multiple: false } );
				frame.on( 'select', function () {
					var file = frame.state().get( 'selection' ).first().toJSON();
					document.getElementById( 'lbff_file' ).value = file.url;
				} );
			}
			frame.open();
		} );
	} )();
	</script>
	<?php
}

/**
 * Load the media modal on the activity screen.
 *
 * @param string $hook Admin page hook.
 */
function lbff_activity_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( $screen && 'lbff_activity' === $screen->post_type && in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
	}
}
add_action( 'admin_enqueue_scripts', 'lbff_activity_admin_assets' );

/**
 * Save meta.
 *
 * @param int $post_id Post id.
 */
function lbff_activity_save( $post_id ) {
	if ( ! isset( $_POST['lbff_activity_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['lbff_activity_nonce'] ) ), 'lbff_activity_save' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$fields = lbff_activity_fields();
	foreach ( array( 'type', 'age' ) as $key ) {
		$value = isset( $_POST[ 'lbff_' . $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'lbff_' . $key ] ) ) : '';
		if ( isset( $fields[ $key ]['options'][ $value ] ) ) {
			update_post_meta( $post_id, '_lbff_' . $key, $value );
		}
	}
	update_post_meta( $post_id, '_lbff_pages', isset( $_POST['lbff_pages'] ) ? sanitize_text_field( wp_unslash( $_POST['lbff_pages'] ) ) : '' );
	update_post_meta( $post_id, '_lbff_free', isset( $_POST['lbff_free'] ) ? '1' : '' );
	update_post_meta( $post_id, '_lbff_file', isset( $_POST['lbff_file'] ) ? esc_url_raw( wp_unslash( $_POST['lbff_file'] ) ) : '' );
}
add_action( 'save_post_lbff_activity', 'lbff_activity_save' );

/**
 * Admin list columns.
 */
add_filter(
	'manage_lbff_activity_posts_columns',
	static function ( $cols ) {
		$date = $cols['date'];
		unset( $cols['date'] );
		$cols['lbff_type'] = __( 'Type', 'littlebunny' );
		$cols['lbff_age']  = __( 'Ages', 'littlebunny' );
		$cols['lbff_free'] = __( 'Free', 'littlebunny' );
		$cols['date']      = $date;
		return $cols;
	}
);
add_action(
	'manage_lbff_activity_posts_custom_column',
	static function ( $col, $post_id ) {
		if ( 'lbff_type' === $col ) {
			echo esc_html( get_post_meta( $post_id, '_lbff_type', true ) );
		} elseif ( 'lbff_age' === $col ) {
			echo esc_html( get_post_meta( $post_id, '_lbff_age', true ) );
		} elseif ( 'lbff_free' === $col ) {
			echo get_post_meta( $post_id, '_lbff_free', true ) ? '✓' : '—';
		}
	},
	10,
	2
);

/**
 * Translated label for an activity type.
 *
 * @param string $type Stored type value.
 * @return string
 */
function lbff_activity_type_label( $type ) {
	$labels = array(
		'COLOURING'       => __( 'Colouring', 'littlebunny' ),
		'WORKSHEETS'      => __( 'Worksheets', 'littlebunny' ),
		'ACTIVITY PACK'   => __( 'Activity pack', 'littlebunny' ),
		'WRITING PROMPTS' => __( 'Writing prompts', 'littlebunny' ),
	);
	return isset( $labels[ $type ] ) ? $labels[ $type ] : $type;
}

/**
 * Activities for the Explore page. Uses the demo list from the design
 * until real activities are added.
 *
 * @return array<int, array{title:string,type:string,age:string,pages:string,free:bool,file:string}>
 */
function lbff_get_activities() {
	$posts = get_posts(
		array(
			'post_type'      => 'lbff_activity',
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		)
	);

	if ( $posts ) {
		return array_map(
			static function ( $p ) {
				return array(
					'title' => get_the_title( $p ),
					'type'  => (string) get_post_meta( $p->ID, '_lbff_type', true ),
					'age'   => (string) get_post_meta( $p->ID, '_lbff_age', true ),
					'pages' => (string) get_post_meta( $p->ID, '_lbff_pages', true ),
					'free'  => (bool) get_post_meta( $p->ID, '_lbff_free', true ),
					'file'  => (string) get_post_meta( $p->ID, '_lbff_file', true ),
				);
			},
			$posts
		);
	}

	$demo = array(
		array( __( 'Foo Foo on the dunes — colouring page', 'littlebunny' ), 'COLOURING', '5–6', 1, true ),
		array( __( 'Energy & Rest worksheet set', 'littlebunny' ), 'WORKSHEETS', '5–6', 6, false ),
		array( __( 'Desert animals spotter cards', 'littlebunny' ), 'ACTIVITY PACK', '5–6', 8, true ),
		array( __( 'My day: energy and rest diary', 'littlebunny' ), 'WORKSHEETS', '7–9', 4, false ),
		array( __( 'Write your own desert adventure', 'littlebunny' ), 'WRITING PROMPTS', '7–9', 5, true ),
		array( __( 'The observer’s challenge pack', 'littlebunny' ), 'ACTIVITY PACK', '7–9', 12, false ),
	);

	return array_map(
		static function ( $a ) {
			return array(
				'title' => $a[0],
				'type'  => $a[1],
				'age'   => $a[2],
				/* translators: %d: number of pages. */
				'pages' => sprintf( _n( '%d page', '%d pages', $a[3], 'littlebunny' ), $a[3] ),
				'free'  => $a[4],
				'file'  => '',
			);
		},
		$demo
	);
}
