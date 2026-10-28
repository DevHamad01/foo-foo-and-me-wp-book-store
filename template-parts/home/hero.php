<?php
/**
 * Home — 01 Hero.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_panels = array(
	array( 'home-hero-p1', __( 'The Empty Quarter', 'littlebunny' ), 'I' ),
	array( 'home-hero-p2', __( 'Medina at dusk', 'littlebunny' ), 'II' ),
	array( 'home-hero-p3', __( 'AlUla', 'littlebunny' ), 'III' ),
);
?>
<section class="ff-hero ff-hero--home" aria-label="<?php esc_attr_e( 'Introduction', 'littlebunny' ); ?>">
	<?php lbff_desert_scene( 'teal' ); ?>

	<div class="ff-hero__content">
		<?php lbff_kicker( __( 'Stories • Adventures • Family Experiences', 'littlebunny' ) ); ?>
		<div class="ff-hero__titles">
			<h1 class="ff-hero__title ff-hero__title--home"><?php esc_html_e( 'Foo Foo & Me', 'littlebunny' ); ?></h1>
			<p class="ff-hero__subtitle"><?php esc_html_e( 'A Little World of Wonder', 'littlebunny' ); ?></p>
		</div>
		<p class="ff-hero__lede"><?php esc_html_e( 'Bringing joy to children, creating memories for families, and inspiring a lifelong love of discovery.', 'littlebunny' ); ?></p>
		<nav class="ff-pillars" aria-label="<?php esc_attr_e( 'Foo Foo & Me', 'littlebunny' ); ?>">
			<?php foreach ( lbff_hero_pillars() as $lbff_pillar ) : ?>
				<a class="ff-pillar" href="<?php echo esc_url( lbff_page_url( $lbff_pillar['page'] ) ); ?>">
					<span class="ff-pillar__label"><?php echo esc_html( $lbff_pillar['label'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</nav>
	</div>

	<div class="ff-hero__book">
		<?php lbff_book_cover(); ?>
	</div>

	<div class="ff-hero__slider" data-hero-slider>
		<div class="ff-hero__slider-nav">
			<button type="button" class="ff-round ff-round--glass" data-next aria-label="<?php esc_attr_e( 'Next place', 'littlebunny' ); ?>">›</button>
			<button type="button" class="ff-round ff-round--glass" data-prev aria-label="<?php esc_attr_e( 'Previous place', 'littlebunny' ); ?>">‹</button>
		</div>
		<div class="ff-hero__slider-view">
			<div class="ff-hero__track" data-track>
				<?php foreach ( $lbff_panels as $lbff_p ) : ?>
					<figure class="ff-hero__panel">
						<?php lbff_slot( $lbff_p[0], array( 'class' => 'ff-hero__panel-img', 'alt' => $lbff_p[1] ) ); ?>
						<figcaption><span><?php echo esc_html( $lbff_p[1] ); ?></span><span class="ff-hero__panel-num"><?php echo esc_html( $lbff_p[2] ); ?></span></figcaption>
					</figure>
				<?php endforeach; ?>
			</div>
			<div class="ff-progress"><span data-progress></span></div>
		</div>
	</div>
</section>
