<?php
/**
 * Comments.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="ff-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="ff-comments__title">
			<?php
			/* translators: %s: number of comments. */
			printf( esc_html( _n( '%s comment', '%s comments', get_comments_number(), 'littlebunny' ) ), esc_html( number_format_i18n( get_comments_number() ) ) );
			?>
		</h2>
		<ol class="ff-comments__list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="ff-comments__closed"><?php esc_html_e( 'Comments are closed.', 'littlebunny' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit' => 'ff-btn ff-btn--teal',
			'title_reply'  => __( 'Leave a reply', 'littlebunny' ),
		)
	);
	?>
</section>
