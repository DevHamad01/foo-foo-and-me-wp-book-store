<?php
/**
 * Floating glass navigation + full-screen mobile menu.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_items = lbff_menu_items( 'primary' );
?>
<header class="ff-nav" data-nav>
	<div class="ff-nav__bar">
		<a class="ff-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'medium', false, array( 'class' => 'ff-logo__img', 'alt' => get_bloginfo( 'name' ) ) ); ?>
			<?php else : ?>
				<span class="ff-logo__kicker"><?php echo esc_html( lbff_mod( 'brand_kicker' ) ); ?></span>
				<span class="ff-logo__name"><?php echo esc_html( lbff_mod( 'brand_name' ) ); ?></span>
			<?php endif; ?>
		</a>

		<nav class="ff-nav__links" aria-label="<?php esc_attr_e( 'Primary', 'littlebunny' ); ?>">
			<?php foreach ( $lbff_items as $lbff_item ) : ?>
				<a class="ff-nav__link<?php echo $lbff_item['current'] ? ' is-current' : ''; ?>" href="<?php echo esc_url( $lbff_item['url'] ); ?>"<?php echo $lbff_item['current'] ? ' aria-current="page"' : ''; ?>>
					<span><?php echo esc_html( $lbff_item['title'] ); ?></span>
					<span class="ff-nav__dot" aria-hidden="true"></span>
				</a>
			<?php endforeach; ?>
		</nav>

		<div class="ff-nav__end">
		<?php lbff_language_switcher( 'ff-lang--nav' ); ?>
		</div>

		<button class="ff-nav__toggle" type="button" aria-expanded="false" aria-controls="ff-menu" data-menu-open>
			<?php esc_html_e( 'Menu', 'littlebunny' ); ?>
			<span class="ff-burger" aria-hidden="true"><span></span><span></span></span>
		</button>
	</div>
</header>

<div class="ff-menu" id="ff-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menu', 'littlebunny' ); ?>" hidden data-menu>
	<div class="ff-menu__top">
		<span class="ff-menu__brand"><?php echo esc_html( lbff_mod( 'brand_kicker' ) . ' ' . lbff_mod( 'brand_name' ) ); ?></span>
		<?php lbff_language_switcher( 'ff-lang--menu' ); ?>
		<button class="ff-menu__close" type="button" data-menu-close><?php esc_html_e( 'Close', 'littlebunny' ); ?></button>
	</div>
	<nav class="ff-menu__links" aria-label="<?php esc_attr_e( 'Mobile', 'littlebunny' ); ?>">
		<?php foreach ( $lbff_items as $lbff_i => $lbff_item ) : ?>
			<a class="ff-menu__link<?php echo $lbff_item['current'] ? ' is-current' : ''; ?>" href="<?php echo esc_url( $lbff_item['url'] ); ?>" style="--i:<?php echo (int) $lbff_i; ?>">
				<span class="ff-menu__num"><?php echo esc_html( sprintf( '%02d', $lbff_i + 1 ) ); ?></span>
				<span class="ff-menu__title"><?php echo esc_html( $lbff_item['title'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</nav>
</div>
