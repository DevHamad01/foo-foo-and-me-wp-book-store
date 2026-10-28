<?php
/**
 * Nothing found.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="ff-empty">
	<p class="ff-empty__title"><?php echo wp_kses( __( 'Nothing here <em>yet</em>.', 'littlebunny' ), lbff_inline_kses() ); ?></p>
	<p><?php esc_html_e( 'Try another search, or head back to the beginning of the journey.', 'littlebunny' ); ?></p>
	<?php get_search_form(); ?>
</div>
