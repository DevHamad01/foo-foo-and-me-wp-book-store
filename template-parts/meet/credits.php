<?php
/**
 * Meet — 08 Artists & credits.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_credits = array(
	array( 'meet-credit-riaz', __( 'Story illustrations', 'littlebunny' ), lbff_mod( 'book_illustrator' ), __( 'The hand behind Foo Foo — every dune, expression and page of the story.', 'littlebunny' ) ),
	array( 'meet-credit-alaa', __( 'Medina artwork', 'littlebunny' ), 'Alaa Al Rehaili', __( 'Medina, Saudi Arabia. Original artwork of the city that anchors Foo Foo’s world.', 'littlebunny' ) ),
);
?>
<section class="ff-section ff-section--short ff-bg-sand ff-credits">
	<div class="ff-container ff-stack-lg">
		<?php lbff_eyebrow( '08', __( 'Artists & credits', 'littlebunny' ) ); ?>
		<div class="ff-credits__grid">
			<?php foreach ( $lbff_credits as $lbff_c ) : ?>
				<?php $lbff_name = preg_split( '/\s+/', trim( (string) $lbff_c[2] ), 2 ); ?>
				<div class="ff-credit" data-reveal>
					<div class="ff-credit__img"><?php lbff_slot( $lbff_c[0] ); ?></div>
					<div class="ff-credit__text">
						<span class="ff-label ff-label--earth"><?php echo esc_html( $lbff_c[1] ); ?></span>
						<h3 class="ff-credit__name"><?php echo esc_html( $lbff_name[0] ); ?><?php if ( ! empty( $lbff_name[1] ) ) : ?><br><?php echo esc_html( $lbff_name[1] ); ?><?php endif; ?></h3>
						<p><?php echo esc_html( $lbff_c[3] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
