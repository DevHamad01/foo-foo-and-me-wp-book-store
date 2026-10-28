<?php
/**
 * Single blog post.
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
			'kicker' => get_the_date(),
			'title'  => get_the_title(),
		)
	);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'ff-section ff-bg-cream ff-article' ); ?>>
		<div class="ff-container ff-prose entry-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="ff-article__thumb"><?php the_post_thumbnail( 'lbff-wide' ); ?></figure>
			<?php endif; ?>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
			<footer class="ff-article__meta">
				<?php the_category( ' · ' ); ?>
				<?php the_tags( '<span class="ff-article__tags">', ' · ', '</span>' ); ?>
			</footer>
			<nav class="ff-postnav">
				<?php previous_post_link( '<div class="ff-postnav__prev">%link</div>', '← %title' ); ?>
				<?php next_post_link( '<div class="ff-postnav__next">%link</div>', '%title →' ); ?>
			</nav>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
