<?php
/**
 * Site footer.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_nl_status = lbff_form_status( 'newsletter' );
$lbff_privacy   = lbff_mod( 'link_privacy' ) ? lbff_mod( 'link_privacy' ) : get_privacy_policy_url();
$lbff_terms     = lbff_mod( 'link_terms' );
$lbff_copyright = str_replace( '{year}', gmdate( 'Y' ), (string) lbff_mod( 'footer_copyright' ) );
$lbff_email     = lbff_mod( 'contact_email' );
$lbff_socials   = array(
	'link_instagram' => __( 'Instagram', 'littlebunny' ),
	'link_youtube'   => __( 'YouTube', 'littlebunny' ),
	'link_facebook'  => __( 'Facebook', 'littlebunny' ),
);
?>
<footer class="ff-footer">
	<div class="ff-footer__glow" aria-hidden="true"></div>
	<div class="ff-container ff-footer__inner">
		<div class="ff-footer__top" data-reveal>
			<div class="ff-footer__brand">
				<span class="ff-footer__kicker"><?php echo esc_html( lbff_mod( 'brand_kicker' ) . ' ' . lbff_mod( 'brand_name' ) ); ?></span>
				<p class="ff-footer__heading"><?php lbff_inline( lbff_mod( 'footer_heading' ) ); ?></p>
			</div>
			<?php lbff_text_link( __( 'Begin with Book 01', 'littlebunny' ), lbff_page_url( 'books', 'buy' ), true ); ?>
		</div>

		<div class="ff-footer__grid">
			<div class="ff-footer__col">
				<span class="ff-footer__label"><?php esc_html_e( 'Navigate', 'littlebunny' ); ?></span>
				<?php foreach ( lbff_menu_items( 'footer' ) as $lbff_item ) : ?>
					<a class="ff-footer__nav" href="<?php echo esc_url( $lbff_item['url'] ); ?>"><?php echo esc_html( $lbff_item['title'] ); ?></a>
				<?php endforeach; ?>
			</div>

			<div class="ff-footer__col">
				<span class="ff-footer__label"><?php esc_html_e( 'Contact', 'littlebunny' ); ?></span>
				<?php if ( $lbff_email ) : ?>
					<a class="ff-footer__text ff-footer__text--link" href="mailto:<?php echo esc_attr( antispambot( $lbff_email ) ); ?>"><?php echo esc_html( antispambot( $lbff_email ) ); ?></a>
				<?php endif; ?>
				<span class="ff-footer__text ff-footer__text--muted"><?php echo nl2br( esc_html( lbff_mod( 'footer_contact_txt' ) ) ); ?></span>
			</div>

			<div class="ff-footer__col">
				<span class="ff-footer__label"><?php esc_html_e( 'Follow', 'littlebunny' ); ?></span>
				<?php foreach ( $lbff_socials as $lbff_key => $lbff_label ) : ?>
					<a class="ff-footer__text ff-footer__text--link" href="<?php lbff_link( $lbff_key ); ?>"<?php lbff_link_target( $lbff_key ); ?>><?php echo esc_html( $lbff_label ); ?></a>
				<?php endforeach; ?>
			</div>

			<div class="ff-footer__col" id="newsletter">
				<span class="ff-footer__label"><?php echo esc_html( lbff_mod( 'newsletter_title' ) ); ?></span>
				<span class="ff-footer__text ff-footer__text--muted"><?php echo esc_html( lbff_mod( 'newsletter_text' ) ); ?></span>
				<form class="ff-newsletter<?php echo 'ok' === $lbff_nl_status ? ' is-done' : ''; ?>" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-ajax-form="newsletter" novalidate>
					<input type="hidden" name="action" value="lbff_newsletter">
					<input type="hidden" name="lang" value="<?php echo esc_attr( lbff_lang() ); ?>">
					<?php wp_nonce_field( 'lbff_newsletter', 'lbff_nonce', false ); ?>
					<label class="ff-hp" aria-hidden="true">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
					<label class="screen-reader-text" for="ff-newsletter-email"><?php esc_html_e( 'Your email', 'littlebunny' ); ?></label>
					<div class="ff-newsletter__row">
						<input id="ff-newsletter-email" type="email" name="email" required placeholder="<?php esc_attr_e( 'Your email', 'littlebunny' ); ?>" autocomplete="email">
						<button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'littlebunny' ); ?>"><span class="ff-dir" aria-hidden="true">→</span></button>
					</div>
					<p class="ff-newsletter__msg" role="status" aria-live="polite">
						<?php
						if ( 'ok' === $lbff_nl_status ) {
							esc_html_e( 'Thank you — you’re on the list.', 'littlebunny' );
						} elseif ( 'error' === $lbff_nl_status ) {
							esc_html_e( 'Please enter a valid email address.', 'littlebunny' );
						}
						?>
					</p>
				</form>
			</div>
		</div>

		<div class="ff-footer__bottom">
			<span><?php echo esc_html( $lbff_copyright ); ?></span>
			<div class="ff-footer__legal">
				<?php
				if ( has_nav_menu( 'legal' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'legal',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					?>
					<a href="<?php echo esc_url( $lbff_privacy ? $lbff_privacy : '#' ); ?>"><?php esc_html_e( 'Privacy', 'littlebunny' ); ?></a>
					<a href="<?php echo esc_url( $lbff_terms ? $lbff_terms : '#' ); ?>"><?php esc_html_e( 'Terms', 'littlebunny' ); ?></a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</footer>
