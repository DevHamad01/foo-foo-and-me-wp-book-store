<?php
/**
 * Search form.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_id = wp_unique_id( 'ff-search-' );
?>
<form role="search" method="get" class="ff-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $lbff_id ); ?>"><?php esc_html_e( 'Search for:', 'littlebunny' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $lbff_id ); ?>" class="ff-search__input" placeholder="<?php esc_attr_e( 'Search the site', 'littlebunny' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button type="submit" class="ff-search__btn" aria-label="<?php esc_attr_e( 'Search', 'littlebunny' ); ?>"><span class="ff-dir" aria-hidden="true">→</span></button>
</form>
