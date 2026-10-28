<?php
/**
 * Explore — 02 Read & listen (four ways into the story).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_books = lbff_page_url( 'books', 'listen' );
$lbff_yt    = lbff_mod( 'youtube_channel' ) ? lbff_mod( 'youtube_channel' ) : lbff_mod( 'link_youtube' );
$lbff_media = array(
	array( __( 'Read-aloud', 'littlebunny' ), __( 'The full story, read slowly — perfect for following along page by page.', 'littlebunny' ), __( 'Read-aloud', 'littlebunny' ), __( 'Listen', 'littlebunny' ), 'tall', $lbff_books ),
	array( __( 'Voice-over', 'littlebunny' ), __( 'Narrated pages with gentle desert soundscapes beneath.', 'littlebunny' ), __( 'Voice-over', 'littlebunny' ), __( 'Listen', 'littlebunny' ), 'mid', $lbff_books ),
	array( __( 'Story video', 'littlebunny' ), __( 'The illustrations brought to life in short animated films.', 'littlebunny' ), __( 'Video', 'littlebunny' ), __( 'Watch', 'littlebunny' ), 'tall', lbff_mod( 'video_story' ) ? lbff_mod( 'video_story' ) : $lbff_books ),
	array( __( 'YouTube', 'littlebunny' ), __( 'Readings, drawing sessions and behind-the-pages episodes.', 'littlebunny' ), __( 'YouTube', 'littlebunny' ), __( 'Subscribe', 'littlebunny' ), 'mid', $lbff_yt ? $lbff_yt : '#' ),
);
?>
<section class="ff-section ff-bg-cream ff-ways" id="listen">
	<div class="ff-container ff-stack-lg">
		<div class="ff-headrow" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( '01', __( 'Read & listen', 'littlebunny' ) ); ?>
				<h2 class="ff-display"><?php echo wp_kses( __( 'Four ways<br><em>into the story</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			</div>
			<p class="ff-headrow__note"><?php esc_html_e( 'For bedtime, the car, the classroom — or anywhere a story is better heard than read.', 'littlebunny' ); ?></p>
		</div>
		<div class="ff-ways__grid">
			<?php foreach ( $lbff_media as $lbff_i => $lbff_m ) : ?>
				<?php $lbff_ext = (bool) preg_match( '#^https?://#', $lbff_m[5] ) && 0 !== strpos( $lbff_m[5], home_url() ); ?>
				<a class="ff-way ff-way--<?php echo esc_attr( $lbff_m[4] ); ?> ff-way--n<?php echo (int) $lbff_i; ?>" href="<?php echo esc_url( $lbff_m[5] ); ?>"<?php echo $lbff_ext ? ' target="_blank" rel="noopener"' : ''; ?> data-reveal>
					<div class="ff-way__img">
						<?php lbff_slot( 'explore-media-' . ( $lbff_i + 1 ), array( 'alt' => $lbff_m[0] ) ); ?>
						<span class="ff-chip"><?php echo esc_html( $lbff_m[2] ); ?></span>
					</div>
					<div class="ff-way__text">
						<h3 class="ff-way__title"><?php echo esc_html( $lbff_m[0] ); ?></h3>
						<p><?php echo esc_html( $lbff_m[1] ); ?></p>
						<span class="ff-way__cta"><?php echo esc_html( $lbff_m[3] ); ?> <span class="ff-dir" aria-hidden="true">→</span></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
