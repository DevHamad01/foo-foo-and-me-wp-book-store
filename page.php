<?php
/**
 * Default page template (privacy policy, terms, any new page).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part(
		'template-parts/global/page-hero',
		null,
		array(
			'kicker' => get_bloginfo( 'name' ),
			'title'  => get_the_title(),
		)
	);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ff-section ff-bg-cream ff-article' ); ?>>
		<div class="ff-container ff-prose entry-content">
			<?php
			if ( has_post_thumbnail() ) {
				echo '<figure class="ff-article__thumb">';
				the_post_thumbnail( 'lbff-wide' );
				echo '</figure>';
			}
			the_content();
			wp_link_pages(
				array(
					'before' => '<nav class="ff-pagelinks">' . esc_html__( 'Pages:', 'littlebunny' ),
					'after'  => '</nav>',
				)
			);
			?>
		</div>
		<?php if ( comments_open() || get_comments_number() ) : ?>
			<div class="ff-container ff-prose"><?php comments_template(); ?></div>
		<?php endif; ?>
	</article>
	<?php
endwhile;

get_footer();
