<?php
/**
 * Explore — 03 Activities with filters (managed under Dashboard → Activities).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_acts    = lbff_get_activities();
$lbff_filters = array(
	'all'  => __( 'All', 'littlebunny' ),
	'5–6'  => __( 'Ages 5–6', 'littlebunny' ),
	'7–9'  => __( 'Ages 7–9', 'littlebunny' ),
	'free' => __( 'Free', 'littlebunny' ),
);
?>
<section class="ff-section ff-bg-sand ff-activities" id="activities" data-filter-group>
	<div class="ff-container ff-split ff-split--top">
		<div class="ff-stack-md" data-reveal>
			<?php lbff_eyebrow( '02', __( 'Activities', 'littlebunny' ) ); ?>
			<h2 class="ff-display"><?php echo wp_kses( __( 'Take the story<br><em>off the page</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			<div class="ff-activities__preview">
				<?php lbff_slot( 'explore-activity-preview', array( 'alt' => __( 'Colouring page preview', 'littlebunny' ) ) ); ?>
				<span class="ff-chip ff-chip--gold"><?php esc_html_e( 'Free sample', 'littlebunny' ); ?></span>
			</div>
		</div>

		<div class="ff-activities__list" data-reveal>
			<div class="ff-pills" role="group" aria-label="<?php esc_attr_e( 'Filter activities', 'littlebunny' ); ?>">
				<?php foreach ( $lbff_filters as $lbff_key => $lbff_label ) : ?>
					<button type="button" class="ff-pill<?php echo 'all' === $lbff_key ? ' is-active' : ''; ?>" data-filter="<?php echo esc_attr( $lbff_key ); ?>" aria-pressed="<?php echo 'all' === $lbff_key ? 'true' : 'false'; ?>"><?php echo esc_html( $lbff_label ); ?></button>
				<?php endforeach; ?>
			</div>
			<ul class="ff-acts" role="list">
				<?php foreach ( $lbff_acts as $lbff_a ) : ?>
					<li class="ff-act" data-age="<?php echo esc_attr( $lbff_a['age'] ); ?>" data-free="<?php echo $lbff_a['free'] ? '1' : '0'; ?>">
						<div class="ff-act__text">
							<span class="ff-act__title"><?php echo esc_html( $lbff_a['title'] ); ?></span>
							<span class="ff-act__meta">
								<span><?php echo esc_html( lbff_activity_type_label( $lbff_a['type'] ) ); ?></span>
								<span>
									<?php
									/* translators: %s: age range. */
									echo esc_html( sprintf( __( 'Ages %s', 'littlebunny' ), $lbff_a['age'] ) );
									?>
								</span>
								<?php if ( $lbff_a['pages'] ) : ?>
									<span>PDF · <?php echo esc_html( $lbff_a['pages'] ); ?></span>
								<?php endif; ?>
								<?php if ( $lbff_a['free'] ) : ?>
									<span class="is-free"><?php esc_html_e( 'Free', 'littlebunny' ); ?></span>
								<?php endif; ?>
							</span>
						</div>
						<?php if ( $lbff_a['file'] ) : ?>
							<a class="ff-btn ff-btn--teal ff-btn--sm" href="<?php echo esc_url( $lbff_a['file'] ); ?>" download><?php esc_html_e( 'Download', 'littlebunny' ); ?> <span aria-hidden="true">↓</span></a>
						<?php else : ?>
							<a class="ff-btn ff-btn--teal ff-btn--sm" href="#contact"><?php esc_html_e( 'Download', 'littlebunny' ); ?> <span aria-hidden="true">↓</span></a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<p class="ff-acts__empty" hidden data-filter-empty><?php esc_html_e( 'No activities in this group yet — check back soon.', 'littlebunny' ); ?></p>
		</div>
	</div>
</section>
