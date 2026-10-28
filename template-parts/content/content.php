<?php
/**
 * Post card used on the blog, archives and search.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ff-card' ); ?> data-reveal>
	<a class="ff-card__img" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'lbff-card' ); ?>
		<?php else : ?>
			<div class="ff-slot ff-slot--art ff-art--dawn"><?php lbff_illustration( 'dunes', 'dawn' ); ?></div>
		<?php endif; ?>
	</a>
	<div class="ff-card__body">
		<span class="ff-label ff-label--earth"><?php echo esc_html( get_the_date() ); ?></span>
		<h2 class="ff-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="ff-card__excerpt"><?php the_excerpt(); ?></div>
		<a class="ff-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'littlebunny' ); ?> <span class="ff-link__arrow" aria-hidden="true">→</span><span class="screen-reader-text"> <?php the_title(); ?></span></a>
	</div>
</article>
