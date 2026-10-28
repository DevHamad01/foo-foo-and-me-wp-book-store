<?php
/**
 * Home — 07 Read & Listen (playlist + mini player).
 *
 * The first track uses the read-aloud MP3 from the Customizer when set;
 * otherwise the player runs a gentle demo state.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_tracks = array(
	array( sprintf( /* translators: %s: book title. */ __( '%s — the full story', 'littlebunny' ), trim( lbff_mod( 'book_title_1' ) . ' ' . lbff_mod( 'book_title_2' ) ) ), __( 'Read-aloud', 'littlebunny' ), lbff_mod( 'audio_duration' ), lbff_mod( 'audio_readaloud' ) ),
	array( __( 'A morning in the dunes', 'littlebunny' ), __( 'Story video', 'littlebunny' ), '03:45', '' ),
	array( sprintf( /* translators: %s: illustrator. */ __( 'Drawing Foo Foo with %s', 'littlebunny' ), lbff_mod( 'book_illustrator' ) ), __( 'Behind the pages', 'littlebunny' ), '06:10', '' ),
);
?>
<section class="ff-section ff-bg-ink ff-listen" id="listen" data-player>
	<div class="ff-container ff-split ff-split--center">
		<div class="ff-copy ff-copy--light ff-listen__copy" data-reveal>
			<?php lbff_eyebrow( '06', __( 'Read & listen', 'littlebunny' ), true ); ?>
			<h2 class="ff-display"><?php echo wp_kses( __( 'Hear the desert<br><em>come alive</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			<p><?php esc_html_e( 'Read-alouds, narrated stories and short films — for bedtime, car journeys and the classroom.', 'littlebunny' ); ?></p>
			<ol class="ff-tracks" role="list">
				<?php foreach ( $lbff_tracks as $lbff_i => $lbff_t ) : ?>
					<li>
						<button type="button" class="ff-track<?php echo 0 === $lbff_i ? ' is-active' : ''; ?>" data-track data-title="<?php echo esc_attr( $lbff_t[0] ); ?>" data-duration="<?php echo esc_attr( $lbff_t[2] ); ?>"<?php echo $lbff_t[3] ? ' data-audio="' . esc_url( $lbff_t[3] ) . '"' : ''; ?> aria-pressed="<?php echo 0 === $lbff_i ? 'true' : 'false'; ?>">
							<span class="ff-track__num"><?php echo esc_html( sprintf( '%02d', $lbff_i + 1 ) ); ?></span>
							<span class="ff-track__main"><span class="ff-track__title"><?php echo esc_html( $lbff_t[0] ); ?></span><span class="ff-track__kind"><?php echo esc_html( $lbff_t[1] ); ?></span></span>
							<span class="ff-track__dur"><?php echo esc_html( $lbff_t[2] ); ?></span>
						</button>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>

		<div class="ff-screen" data-reveal>
			<?php lbff_slot( 'home-video-still', array( 'alt' => __( 'Read-aloud in a desert camp at dusk', 'littlebunny' ) ) ); ?>
			<div class="ff-screen__shade" aria-hidden="true"></div>
			<div class="ff-miniplayer">
				<button type="button" class="ff-miniplayer__btn" data-play aria-label="<?php esc_attr_e( 'Play', 'littlebunny' ); ?>"><span class="ff-icon-play" aria-hidden="true"></span></button>
				<div class="ff-miniplayer__info">
					<div class="ff-miniplayer__row"><span class="ff-miniplayer__title" data-now-title><?php echo esc_html( $lbff_tracks[0][0] ); ?></span><span class="ff-miniplayer__dur" data-now-dur><?php echo esc_html( $lbff_tracks[0][2] ); ?></span></div>
					<div class="ff-miniplayer__bar"><span data-bar></span></div>
				</div>
			</div>
		</div>
	</div>
</section>
