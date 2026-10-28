<?php
/**
 * Meet — 07 About the author.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_author = (string) lbff_mod( 'book_author' );
$lbff_parts  = preg_split( '/\s+/', trim( $lbff_author ), 2 );
?>
<section class="ff-section ff-bg-cream ff-author">
	<div class="ff-container ff-split ff-split--center">
		<div class="ff-collage ff-collage--author" data-reveal>
			<?php lbff_slot( 'meet-author-portrait', array( 'class' => 'ff-collage__main', 'alt' => $lbff_author ) ); ?>
			<?php lbff_slot( 'meet-author-medina', array( 'class' => 'ff-collage__inset' ) ); ?>
		</div>
		<div class="ff-copy" data-reveal>
			<?php lbff_eyebrow( '07', __( 'About the author', 'littlebunny' ) ); ?>
			<h2 class="ff-display ff-display--lg"><?php echo esc_html( $lbff_parts[0] ); ?><?php if ( ! empty( $lbff_parts[1] ) ) : ?><br><em><?php echo esc_html( $lbff_parts[1] ); ?></em><?php endif; ?></h2>
			<p><?php esc_html_e( 'An educator whose years in Saudi Arabia — and a lasting connection to Medina — shaped the world of Foo Foo. With a background in education and experiential learning, Brent created the series to give children stories where learning happens the way it does in life: outdoors, through curiosity, one observation at a time.', 'littlebunny' ); ?></p>
			<blockquote class="ff-quote"><?php esc_html_e( '“I wanted children to see this country the way Foo Foo does — as a place full of questions worth asking.”', 'littlebunny' ); ?></blockquote>
		</div>
	</div>
</section>
