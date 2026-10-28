<?php
/**
 * Home — 02 Introduction.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ff-section ff-bg-cream ff-intro">
	<div class="ff-container ff-stack-xl">
		<div class="ff-intro__head" data-reveal>
			<?php lbff_eyebrow( '01', __( 'Introduction', 'littlebunny' ) ); ?>
			<p class="ff-intro__statement"><?php echo wp_kses( __( 'Little Bunny Foo Foo is a storybook series set among the dunes, oases and old cities of Saudi Arabia — where a small rabbit with an <em>enormous curiosity</em> learns how the world works by watching it closely.', 'littlebunny' ), lbff_inline_kses() ); ?></p>
		</div>

		<div class="ff-split ff-split--center">
			<div class="ff-collage ff-collage--intro" data-reveal>
				<?php lbff_slot( 'home-intro-medina', array( 'class' => 'ff-collage__main' ) ); ?>
				<?php lbff_slot( 'home-intro-ripple', array( 'class' => 'ff-collage__inset' ) ); ?>
				<span class="ff-caption ff-collage__caption"><?php esc_html_e( 'Al-Madinah · Artwork by Alaa Al Rehaili', 'littlebunny' ); ?></span>
			</div>
			<div class="ff-copy" data-reveal>
				<h3 class="ff-h3"><?php echo wp_kses( __( 'Stories that begin outside, <em>and stay with you</em>.', 'littlebunny' ), lbff_inline_kses() ); ?></h3>
				<p><?php esc_html_e( 'Each book follows Foo Foo into a real Saudi landscape and turns what he notices into a gentle lesson — about energy and rest, patience, nature and the people around him.', 'littlebunny' ); ?></p>
				<p><?php esc_html_e( 'Written for children aged five to nine, and designed to be read aloud, listened to and explored together.', 'littlebunny' ); ?></p>
				<?php lbff_text_link( __( 'Enter the world', 'littlebunny' ), lbff_page_url( 'meet' ) ); ?>
			</div>
		</div>
	</div>
</section>
