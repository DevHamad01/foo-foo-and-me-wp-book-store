<?php
/**
 * Site header.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="ff-skip" href="#main"><?php esc_html_e( 'Skip to content', 'littlebunny' ); ?></a>

<?php get_template_part( 'template-parts/global/loader' ); ?>

<?php get_template_part( 'template-parts/global/site-nav' ); ?>

<main id="main" class="ff-main">
