<?php
/**
 * Cinematic desert background: looping video, colour grading, parallax and
 * drifting sand particles (drawn by assets/js/main.js).
 *
 * Args: mood (teal|dusk), edge (bool — curved cream edge at the bottom).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_mood = ( isset( $args['mood'] ) && 'dusk' === $args['mood'] ) ? 'dusk' : 'teal';
$lbff_edge = ! isset( $args['edge'] ) || $args['edge'];

$lbff_video_id = absint( lbff_mod( 'hero_video_id' ) );
$lbff_video    = $lbff_video_id ? wp_get_attachment_url( $lbff_video_id ) : lbff_mod( 'hero_video' );
$lbff_poster   = absint( lbff_mod( 'hero_poster' ) ) ? wp_get_attachment_image_url( absint( lbff_mod( 'hero_poster' ) ), 'lbff-hero' ) : 'https://images.pexels.com/videos/26745835/arid-climate-backgrounds-beauty-beauty-in-nature-26745835.jpeg?auto=compress&w=1920';
$lbff_particle = (bool) lbff_mod( 'hero_particles' );
?>
<div class="ff-scene ff-scene--<?php echo esc_attr( $lbff_mood ); ?>" data-scene<?php echo $lbff_particle ? ' data-particles' : ''; ?> aria-hidden="true">
	<div class="ff-scene__media" data-depth=".25">
		<?php if ( $lbff_video ) : ?>
			<video class="ff-scene__video" autoplay muted loop playsinline preload="metadata" poster="<?php echo esc_url( $lbff_poster ); ?>">
				<source src="<?php echo esc_url( $lbff_video ); ?>" type="video/mp4">
			</video>
		<?php else : ?>
			<img class="ff-scene__video" src="<?php echo esc_url( $lbff_poster ); ?>" alt="" loading="eager" decoding="async">
		<?php endif; ?>
	</div>
	<div class="ff-scene__grade"></div>
	<div class="ff-scene__floor"></div>
	<canvas class="ff-scene__particles"></canvas>
	<?php if ( $lbff_edge ) : ?>
		<div class="ff-scene__edge"></div>
	<?php endif; ?>
</div>
