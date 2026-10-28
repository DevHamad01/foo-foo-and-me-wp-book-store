<?php
/**
 * Contact form + newsletter sign-up.
 *
 * - Works with and without JavaScript (AJAX when available, normal POST otherwise).
 * - Every contact message is emailed AND saved under "Messages" in the dashboard,
 *   so nothing is lost if email delivery fails.
 * - Newsletter emails are saved under Tools → Newsletter, with CSV export.
 * - Protected by nonce, honeypot field and a short per-visitor rate limit.
 *
 * Swap in a forms / mailing-list plugin later without touching the design.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

/**
 * Private "Messages" inbox.
 */
function lbff_register_message_type() {
	register_post_type(
		'lbff_message',
		array(
			'labels'          => array(
				'name'          => __( 'Messages', 'littlebunny' ),
				'singular_name' => __( 'Message', 'littlebunny' ),
				'all_items'     => __( 'Inbox', 'littlebunny' ),
				'edit_item'     => __( 'Message', 'littlebunny' ),
				'not_found'     => __( 'No messages yet.', 'littlebunny' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_position'   => 22,
			'menu_icon'       => 'dashicons-email-alt',
			'supports'        => array( 'title', 'editor' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);
}
add_action( 'init', 'lbff_register_message_type' );

/**
 * Contact roles shown as pills.
 *
 * @return array<string, array{0:string,1:string}> value => [ label, plural ].
 */
function lbff_contact_roles() {
	return array(
		'PARENT'    => array( __( 'Parent', 'littlebunny' ), __( 'parents', 'littlebunny' ) ),
		'SCHOOL'    => array( __( 'School', 'littlebunny' ), __( 'schools', 'littlebunny' ) ),
		'EDUCATOR'  => array( __( 'Educator', 'littlebunny' ), __( 'educators', 'littlebunny' ) ),
		'PUBLISHER' => array( __( 'Publisher', 'littlebunny' ), __( 'publishers', 'littlebunny' ) ),
		'PARTNER'   => array( __( 'Partner', 'littlebunny' ), __( 'partners', 'littlebunny' ) ),
	);
}

/**
 * Is this an AJAX (fetch) request?
 *
 * @return bool
 */
function lbff_is_ajax_post() {
	return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' === strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) );
}

/**
 * Finish a form request: JSON for AJAX, redirect otherwise.
 *
 * @param bool   $ok      Success.
 * @param string $message Message for the visitor.
 * @param string $form    contact|newsletter.
 */
function lbff_form_respond( $ok, $message, $form ) {
	if ( lbff_is_ajax_post() ) {
		if ( $ok ) {
			wp_send_json_success( array( 'message' => $message ) );
		}
		wp_send_json_error( array( 'message' => $message ), 400 );
	}

	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( array( 'lbff_form', 'lbff_status' ), $back );
	$back = preg_replace( '/#.*$/', '', $back );
	$back = add_query_arg(
		array(
			'lbff_form'   => $form,
			'lbff_status' => $ok ? 'ok' : 'error',
		),
		$back
	) . ( 'contact' === $form ? '#contact' : '#newsletter' );
	wp_safe_redirect( $back );
	exit;
}

/**
 * Basic per-IP throttle.
 *
 * @param string $form Form key.
 * @return bool True when the visitor must wait.
 */
function lbff_is_throttled( $form ) {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'lbff_t_' . $form . '_' . md5( $ip );
	if ( get_transient( $key ) ) {
		return true;
	}
	set_transient( $key, 1, 20 );
	return false;
}

/**
 * Handle the contact form.
 */
function lbff_handle_contact() {
	if ( ! isset( $_POST['lbff_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['lbff_nonce'] ) ), 'lbff_contact' ) ) {
		lbff_form_respond( false, __( 'Your session expired. Please refresh the page and try again.', 'littlebunny' ), 'contact' );
	}

	// Honeypot: real people never fill this hidden field.
	if ( ! empty( $_POST['website'] ) ) {
		lbff_form_respond( true, __( 'Thank you.', 'littlebunny' ), 'contact' );
	}

	$roles   = lbff_contact_roles();
	$role    = isset( $_POST['role'] ) ? sanitize_text_field( wp_unslash( $_POST['role'] ) ) : 'PARENT';
	$role    = isset( $roles[ $role ] ) ? $role : 'PARENT';
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$org     = isset( $_POST['organisation'] ) ? sanitize_text_field( wp_unslash( $_POST['organisation'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		lbff_form_respond( false, __( 'Please add your name, a valid email and a short message.', 'littlebunny' ), 'contact' );
	}

	if ( lbff_is_throttled( 'contact' ) ) {
		lbff_form_respond( false, __( 'Please wait a few seconds before sending another message.', 'littlebunny' ), 'contact' );
	}

	$body = sprintf(
		"%s: %s\n%s: %s\n%s: %s\n%s: %s\n\n%s",
		__( 'Writing as', 'littlebunny' ),
		$role,
		__( 'Name', 'littlebunny' ),
		$name,
		__( 'Email', 'littlebunny' ),
		$email,
		__( 'Organisation', 'littlebunny' ),
		$org ? $org : '—',
		$message
	);

	// Save to the dashboard inbox.
	wp_insert_post(
		array(
			'post_type'    => 'lbff_message',
			'post_status'  => 'private',
			/* translators: 1: role, 2: name. */
			'post_title'   => sprintf( __( '[%1$s] %2$s', 'littlebunny' ), $role, $name ),
			'post_content' => $body,
		)
	);

	$to = lbff_mod( 'contact_recipient' );
	$to = is_email( $to ) ? $to : lbff_mod( 'contact_email' );
	$to = is_email( $to ) ? $to : get_option( 'admin_email' );

	wp_mail(
		$to,
		/* translators: 1: site name, 2: role, 3: name. */
		sprintf( __( '[%1$s] New message from %3$s (%2$s)', 'littlebunny' ), wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), strtolower( $role ), $name ),
		$body,
		array( 'Reply-To: ' . $name . ' <' . $email . '>' )
	);

	lbff_form_respond( true, $roles[ $role ][1], 'contact' );
}
add_action( 'admin_post_nopriv_lbff_contact', 'lbff_handle_contact' );
add_action( 'admin_post_lbff_contact', 'lbff_handle_contact' );

/**
 * Handle the newsletter sign-up.
 */
function lbff_handle_newsletter() {
	if ( ! isset( $_POST['lbff_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['lbff_nonce'] ) ), 'lbff_newsletter' ) ) {
		lbff_form_respond( false, __( 'Please refresh the page and try again.', 'littlebunny' ), 'newsletter' );
	}
	if ( ! empty( $_POST['website'] ) ) {
		lbff_form_respond( true, __( 'Thank you — you’re on the list.', 'littlebunny' ), 'newsletter' );
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		lbff_form_respond( false, __( 'Please enter a valid email address.', 'littlebunny' ), 'newsletter' );
	}
	if ( lbff_is_throttled( 'newsletter' ) ) {
		lbff_form_respond( false, __( 'Please wait a few seconds and try again.', 'littlebunny' ), 'newsletter' );
	}

	$list = get_option( 'lbff_subscribers', array() );
	$list = is_array( $list ) ? $list : array();
	$key  = strtolower( $email );
	if ( ! isset( $list[ $key ] ) ) {
		$list[ $key ] = array(
			'email' => $email,
			'date'  => current_time( 'mysql' ),
		);
		update_option( 'lbff_subscribers', $list, false );
	}

	lbff_form_respond( true, __( 'Thank you — you’re on the list.', 'littlebunny' ), 'newsletter' );
}
add_action( 'admin_post_nopriv_lbff_newsletter', 'lbff_handle_newsletter' );
add_action( 'admin_post_lbff_newsletter', 'lbff_handle_newsletter' );

/**
 * Tools → Newsletter subscribers screen.
 */
function lbff_subscribers_menu() {
	add_management_page( __( 'Newsletter subscribers', 'littlebunny' ), __( 'Newsletter', 'littlebunny' ), 'manage_options', 'lbff-subscribers', 'lbff_subscribers_page' );
}
add_action( 'admin_menu', 'lbff_subscribers_menu' );

/**
 * CSV export (runs before any output).
 */
function lbff_subscribers_export() {
	if ( ! isset( $_GET['page'], $_GET['lbff_export'] ) || 'lbff-subscribers' !== $_GET['page'] ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'lbff_export' ) ) {
		return;
	}
	$list = get_option( 'lbff_subscribers', array() );
	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=newsletter-subscribers-' . gmdate( 'Y-m-d' ) . '.csv' );
	$out = fopen( 'php://output', 'w' );
	fputcsv( $out, array( 'email', 'date' ) );
	foreach ( (array) $list as $row ) {
		fputcsv( $out, array( $row['email'], $row['date'] ) );
	}
	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	exit;
}
add_action( 'admin_init', 'lbff_subscribers_export' );

/**
 * Subscribers screen markup.
 */
function lbff_subscribers_page() {
	$list = get_option( 'lbff_subscribers', array() );
	$list = is_array( $list ) ? array_reverse( $list ) : array();
	$csv  = wp_nonce_url( admin_url( 'tools.php?page=lbff-subscribers&lbff_export=1' ), 'lbff_export' );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Newsletter subscribers', 'littlebunny' ); ?></h1>
		<a href="<?php echo esc_url( $csv ); ?>" class="page-title-action"><?php esc_html_e( 'Export CSV', 'littlebunny' ); ?></a>
		<p><?php esc_html_e( 'Emails collected by the “Letters from the dunes” form in the footer. Import the CSV into Mailchimp, MailerLite or any mailing tool.', 'littlebunny' ); ?></p>
		<table class="widefat striped">
			<thead><tr><th><?php esc_html_e( 'Email', 'littlebunny' ); ?></th><th><?php esc_html_e( 'Signed up', 'littlebunny' ); ?></th></tr></thead>
			<tbody>
			<?php if ( ! $list ) : ?>
				<tr><td colspan="2"><?php esc_html_e( 'No subscribers yet.', 'littlebunny' ); ?></td></tr>
			<?php else : ?>
				<?php foreach ( $list as $row ) : ?>
					<tr><td><?php echo esc_html( $row['email'] ); ?></td><td><?php echo esc_html( $row['date'] ); ?></td></tr>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
	<?php
}

/**
 * Form status coming back from a non-JS submission.
 *
 * @param string $form contact|newsletter.
 * @return string ''|ok|error
 */
function lbff_form_status( $form ) {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['lbff_form'], $_GET['lbff_status'] ) && $form === $_GET['lbff_form'] ) {
		return 'ok' === $_GET['lbff_status'] ? 'ok' : 'error';
	}
	// phpcs:enable
	return '';
}
