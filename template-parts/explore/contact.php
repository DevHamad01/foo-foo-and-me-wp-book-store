<?php
/**
 * Explore — 07 Contact (glass form over the dusk desert).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_status = lbff_form_status( 'contact' );
$lbff_roles  = lbff_contact_roles();
$lbff_email  = lbff_mod( 'contact_email' );
?>
<section class="ff-contact" id="contact">
	<?php lbff_desert_scene( 'dusk', false ); ?>
	<div class="ff-container ff-contact__inner">
		<div class="ff-copy ff-copy--light" data-reveal>
			<?php lbff_eyebrow( '07', __( 'Contact', 'littlebunny' ), true ); ?>
			<h2 class="ff-display ff-display--lg"><?php echo wp_kses( __( 'Let’s explore<br><em>together</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			<p><?php esc_html_e( 'For parents, schools, educators, publishers and partners — we’d love to hear where you’d like Foo Foo to go next.', 'littlebunny' ); ?></p>
			<?php if ( $lbff_email ) : ?>
				<a class="ff-contact__email" href="mailto:<?php echo esc_attr( antispambot( $lbff_email ) ); ?>"><?php echo esc_html( antispambot( $lbff_email ) ); ?></a>
			<?php endif; ?>
		</div>

		<div class="ff-glass ff-formcard<?php echo 'ok' === $lbff_status ? ' is-sent' : ''; ?>" data-contact data-reveal>
			<form class="ff-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" data-ajax-form="contact">
				<input type="hidden" name="action" value="lbff_contact">
				<input type="hidden" name="role" value="PARENT" data-role-input>
				<input type="hidden" name="lang" value="<?php echo esc_attr( lbff_lang() ); ?>">
				<?php wp_nonce_field( 'lbff_contact', 'lbff_nonce', false ); ?>
				<label class="ff-hp" aria-hidden="true">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>

				<fieldset class="ff-form__roles">
					<legend class="ff-label ff-label--gold"><?php esc_html_e( 'I am writing as', 'littlebunny' ); ?></legend>
					<div class="ff-pills ff-pills--light">
						<?php $lbff_first = true; ?>
						<?php foreach ( $lbff_roles as $lbff_value => $lbff_role ) : ?>
							<button type="button" class="ff-pill<?php echo $lbff_first ? ' is-active' : ''; ?>" data-role="<?php echo esc_attr( $lbff_value ); ?>" data-plural="<?php echo esc_attr( $lbff_role[1] ); ?>" aria-pressed="<?php echo $lbff_first ? 'true' : 'false'; ?>"><?php echo esc_html( $lbff_role[0] ); ?></button>
							<?php $lbff_first = false; ?>
						<?php endforeach; ?>
					</div>
				</fieldset>

				<div class="ff-form__grid">
					<label class="ff-field"><span class="ff-label ff-label--gold"><?php esc_html_e( 'Name', 'littlebunny' ); ?></span><input type="text" name="name" required autocomplete="name" placeholder="<?php esc_attr_e( 'Your name', 'littlebunny' ); ?>"></label>
					<label class="ff-field"><span class="ff-label ff-label--gold"><?php esc_html_e( 'Email', 'littlebunny' ); ?></span><input type="email" name="email" required autocomplete="email" placeholder="<?php esc_attr_e( 'you@school.edu', 'littlebunny' ); ?>"></label>
				</div>
				<label class="ff-field"><span class="ff-label ff-label--gold"><?php esc_html_e( 'Organisation', 'littlebunny' ); ?></span><input type="text" name="organisation" autocomplete="organization" placeholder="<?php esc_attr_e( 'School, publisher or organisation (optional)', 'littlebunny' ); ?>"></label>
				<label class="ff-field"><span class="ff-label ff-label--gold"><?php esc_html_e( 'Message', 'littlebunny' ); ?></span><textarea name="message" rows="4" required placeholder="<?php esc_attr_e( 'Tell us a little about what you have in mind', 'littlebunny' ); ?>"></textarea></label>

				<p class="ff-form__error" role="alert" data-form-error<?php echo 'error' === $lbff_status ? '' : ' hidden'; ?>><?php esc_html_e( 'Please add your name, a valid email and a short message.', 'littlebunny' ); ?></p>

				<button type="submit" class="ff-btn ff-btn--primary ff-btn--submit"><span data-submit-label><?php esc_html_e( 'Send message', 'littlebunny' ); ?></span><span class="ff-btn__icon" aria-hidden="true">→</span></button>
			</form>

			<div class="ff-thanks" role="status" aria-live="polite">
				<span class="ff-thanks__diamond" aria-hidden="true"></span>
				<span class="ff-thanks__title"><?php echo wp_kses( __( 'Thank you.<br><em>We’ll be in touch.</em>', 'littlebunny' ), lbff_inline_kses() ); ?></span>
				<span class="ff-thanks__text">
					<?php
					/* translators: %s: audience, e.g. "parents". */
					printf( esc_html__( 'Messages from %s usually receive a reply within a few days.', 'littlebunny' ), '<span data-role-name>' . esc_html( $lbff_roles['PARENT'][1] ) . '</span>' );
					?>
				</span>
				<button type="button" class="ff-thanks__again" data-contact-reset><?php esc_html_e( 'Send another →', 'littlebunny' ); ?></button>
			</div>
		</div>
	</div>
</section>
