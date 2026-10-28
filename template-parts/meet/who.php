<?php
/**
 * Meet — 02 Who is Foo Foo?
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_traits = array(
	array( __( 'Curious', 'littlebunny' ), __( 'Always one more question before home.', 'littlebunny' ) ),
	array( __( 'Observant', 'littlebunny' ), __( 'Notices what others walk past — tracks, shadows, shifts in the wind.', 'littlebunny' ) ),
	array( __( 'Playful', 'littlebunny' ), __( 'Turns every dune into a game worth playing.', 'littlebunny' ) ),
	array( __( 'Adventurous', 'littlebunny' ), __( 'Goes a little further than he planned, every time.', 'littlebunny' ) ),
	array( __( 'Thoughtful', 'littlebunny' ), __( 'Stops to think about what he has seen — and who it affects.', 'littlebunny' ) ),
);
?>
<section class="ff-section ff-bg-cream ff-who">
	<div class="ff-container ff-split ff-split--top">
		<figure class="ff-who__figure" data-reveal>
			<div class="ff-arch"><?php lbff_slot( 'meet-who-portrait', array( 'alt' => __( 'Portrait of Foo Foo', 'littlebunny' ) ) ); ?></div>
			<figcaption class="ff-caption">
				<?php
				/* translators: %s: illustrator name. */
				echo esc_html( sprintf( __( 'Illustration · %s', 'littlebunny' ), lbff_mod( 'book_illustrator' ) ) );
				?>
			</figcaption>
		</figure>
		<div class="ff-copy" data-reveal>
			<?php lbff_eyebrow( '01', __( 'Who is Foo Foo?', 'littlebunny' ) ); ?>
			<h2 class="ff-display ff-display--md"><?php echo wp_kses( __( 'Small rabbit.<br><em>Very large questions.</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			<p><?php esc_html_e( 'Foo Foo lives where the desert meets the edge of the city. He is not the fastest or the bravest — but he is the one who stops, looks again, and asks why.', 'littlebunny' ); ?></p>
			<ul class="ff-traits" role="list">
				<?php foreach ( $lbff_traits as $lbff_i => $lbff_t ) : ?>
					<li class="ff-traits__row">
						<span class="ff-traits__num"><?php echo esc_html( sprintf( '%02d', $lbff_i + 1 ) ); ?></span>
						<span class="ff-traits__name"><?php echo esc_html( $lbff_t[0] ); ?></span>
						<span class="ff-traits__line"><?php echo esc_html( $lbff_t[1] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
