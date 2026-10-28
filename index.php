<?php
/**
 * Blog index and fallback for every other view.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( is_home() && ! is_front_page() ) {
	$lbff_title = single_post_title( '', false );
} elseif ( is_search() ) {
	/* translators: %s: search query. */
	$lbff_title = sprintf( __( 'Results for <em>“%s”</em>', 'littlebunny' ), esc_html( get_search_query() ) );
} elseif ( is_archive() ) {
	$lbff_title = get_the_archive_title();
} else {
	$lbff_title = __( 'Stories & news', 'littlebunny' );
}

get_template_part(
	'template-parts/global/page-hero',
	null,
	array(
		'kicker' => is_search() ? __( 'Search', 'littlebunny' ) : __( 'From the dunes', 'littlebunny' ),
		'title'  => $lbff_title,
		'text'   => is_archive() ? get_the_archive_description() : '',
	)
);
?>
<section class="ff-section ff-bg-cream">
	<div class="ff-container">
		<?php if ( have_posts() ) : ?>
			<div class="ff-cards">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content' );
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'class'     => 'ff-pagination',
					'prev_text' => '←',
					'next_text' => '→',
				)
			);
			?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
