<?php
/**
 * 404 — lost in the dunes.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="ff-hero ff-hero--404">
	<?php lbff_desert_scene( 'dusk', false ); ?>
	<div class="ff-hero__content ff-hero__content--center">
		<?php lbff_kicker( __( 'Error 404', 'littlebunny' ) ); ?>
		<h1 class="ff-hero__title"><?php echo wp_kses( __( 'Lost in<br><em>the dunes</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h1>
		<p class="ff-hero__lede"><?php esc_html_e( 'Even Foo Foo wanders a little too far sometimes. The page you were looking for has drifted away with the sand.', 'littlebunny' ); ?></p>
		<div class="ff-btn-row ff-btn-row--center">
			<?php lbff_button( __( 'Back home', 'littlebunny' ), home_url( '/' ) ); ?>
			<a class="ff-btn ff-btn--glass" href="<?php echo esc_url( lbff_page_url( 'books' ) ); ?>"><?php esc_html_e( 'See the books', 'littlebunny' ); ?></a>
		</div>
	</div>
</section>
<?php
get_footer();
