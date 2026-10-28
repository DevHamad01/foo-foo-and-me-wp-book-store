<?php
/**
 * Books — 04 Read & listen (waveform player + videos).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_audio  = lbff_mod( 'audio_readaloud' );
$lbff_dur    = lbff_mod( 'audio_duration' );
$lbff_videos = array(
	array( 'books-video-1', __( 'The animated story', 'littlebunny' ), __( 'Video · 08:30', 'littlebunny' ), lbff_mod( 'video_story' ) ),
	array( 'books-video-2', __( 'Reading with the author', 'littlebunny' ), __( 'YouTube · 12:05', 'littlebunny' ), lbff_mod( 'video_author' ) ),
);
?>
<section class="ff-section ff-bg-ink ff-booklisten" id="listen">
	<div class="ff-container ff-stack-lg">
		<div class="ff-headrow" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( '03', __( 'Read & listen', 'littlebunny' ), true ); ?>
				<h2 class="ff-display"><?php echo wp_kses( __( 'The story,<br><em>read aloud</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			</div>
			<p class="ff-headrow__note"><?php esc_html_e( 'Listen along with the book, or watch the pages come to life on screen.', 'littlebunny' ); ?></p>
		</div>

		<div class="ff-wave" data-wave data-duration="<?php echo esc_attr( lbff_duration_seconds( $lbff_dur ) ); ?>"<?php echo $lbff_audio ? ' data-audio="' . esc_url( $lbff_audio ) . '"' : ''; ?> data-reveal>
			<div class="ff-wave__cover"><?php lbff_book_cover(); ?></div>
			<div class="ff-wave__main">
				<div class="ff-wave__head">
					<div class="ff-stack-xs">
						<span class="ff-label ff-label--gold">
							<?php
							/* translators: %s: book number. */
							echo esc_html( sprintf( __( 'Read-aloud · Book %s', 'littlebunny' ), lbff_mod( 'book_num' ) ) );
							?>
						</span>
						<span class="ff-wave__title"><?php echo esc_html( trim( lbff_mod( 'book_title_1' ) . ' ' . lbff_mod( 'book_title_2' ) ) ); ?></span>
					</div>
					<span class="ff-wave__time"><span data-elapsed>00:00</span> / <?php echo esc_html( $lbff_dur ); ?></span>
				</div>
				<div class="ff-wave__bars" data-bars aria-hidden="true">
					<?php
					for ( $lbff_i = 0; $lbff_i < 64; $lbff_i++ ) {
						$lbff_h = min( 100, 18 + abs( sin( $lbff_i * 0.7 ) * 50 + sin( $lbff_i * 0.23 ) * 30 ) );
						echo '<span style="height:' . esc_attr( round( $lbff_h ) ) . '%"></span>';
					}
					?>
				</div>
				<div class="ff-wave__foot">
					<button type="button" class="ff-btn ff-btn--gold" data-wave-play><span class="ff-icon-play" aria-hidden="true"></span><span data-wave-label><?php esc_html_e( 'Play the story', 'littlebunny' ); ?></span></button>
					<span class="ff-label ff-label--muted"><?php esc_html_e( 'Narrated · With page-turn chimes', 'littlebunny' ); ?></span>
				</div>
			</div>
		</div>

		<div class="ff-videos">
			<?php foreach ( $lbff_videos as $lbff_v ) : ?>
				<?php $lbff_tag = $lbff_v[3] ? 'a' : 'div'; ?>
				<<?php echo esc_html( $lbff_tag ); ?> class="ff-video" data-reveal<?php echo $lbff_v[3] ? ' href="' . esc_url( $lbff_v[3] ) . '" target="_blank" rel="noopener"' : ''; ?>>
					<div class="ff-video__frame">
						<?php lbff_slot( $lbff_v[0], array( 'alt' => $lbff_v[1] ) ); ?>
						<span class="ff-video__play" aria-hidden="true"><span class="ff-icon-play"></span></span>
					</div>
					<div class="ff-video__meta"><span class="ff-video__title"><?php echo esc_html( $lbff_v[1] ); ?></span><span class="ff-label ff-label--gold"><?php echo esc_html( $lbff_v[2] ); ?></span></div>
				</<?php echo esc_html( $lbff_tag ); ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
