<?php
/**
 * Meet — 04 The journey (chapter carousel).
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_chapters = array(
	array( __( 'Desert', 'littlebunny' ), __( 'Where every story begins — vast, quiet, full of hidden life.', 'littlebunny' ) ),
	array( __( 'Nature', 'littlebunny' ), __( 'Palms, wadis and the water that makes them possible.', 'littlebunny' ) ),
	array( __( 'Animals', 'littlebunny' ), __( 'Oryx, falcons, hares — each with its own way of living here.', 'littlebunny' ) ),
	array( __( 'Medina', 'littlebunny' ), __( 'The city of community, kindness and everyday rhythm.', 'littlebunny' ) ),
	array( __( 'Discovery', 'littlebunny' ), __( 'Putting the pieces together, like a map drawn by hand.', 'littlebunny' ) ),
	array( __( 'Learning', 'littlebunny' ), __( 'What he noticed becomes something he understands.', 'littlebunny' ) ),
);
$lbff_roman    = array( 'I', 'II', 'III', 'IV', 'V', 'VI' );
?>
<section class="ff-section ff-section--bleed ff-bg-ink ff-journey" data-journey>
	<div class="ff-container ff-stack-md">
		<div class="ff-headrow" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( '03', __( 'The journey', 'littlebunny' ), true ); ?>
				<h2 class="ff-display"><?php echo wp_kses( __( 'From the dunes<br><em>to understanding</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			</div>
			<div class="ff-arrows">
				<button type="button" class="ff-round ff-round--line-light" data-j-prev aria-label="<?php esc_attr_e( 'Previous chapter', 'littlebunny' ); ?>">←</button>
				<button type="button" class="ff-round ff-round--gold" data-j-next aria-label="<?php esc_attr_e( 'Next chapter', 'littlebunny' ); ?>">→</button>
			</div>
		</div>
		<div class="ff-chapters-nav" role="tablist" aria-label="<?php esc_attr_e( 'Chapters', 'littlebunny' ); ?>">
			<?php foreach ( $lbff_chapters as $lbff_i => $lbff_c ) : ?>
				<button type="button" class="ff-chapters-nav__btn<?php echo 0 === $lbff_i ? ' is-active' : ''; ?>" data-j-go="<?php echo (int) $lbff_i; ?>"><?php echo esc_html( $lbff_c[0] ); ?><?php if ( $lbff_i < count( $lbff_chapters ) - 1 ) : ?><span aria-hidden="true">→</span><?php endif; ?></button>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="ff-rail ff-rail--snap ff-journey__rail" data-j-track tabindex="0">
		<?php foreach ( $lbff_chapters as $lbff_i => $lbff_c ) : ?>
			<article class="ff-chapter">
				<?php lbff_slot( 'meet-journey-' . ( $lbff_i + 1 ), array( 'alt' => $lbff_c[0] ) ); ?>
				<div class="ff-chapter__shade" aria-hidden="true"></div>
				<div class="ff-chapter__body">
					<span class="ff-chapter__roman"><?php echo esc_html( $lbff_roman[ $lbff_i ] ); ?></span>
					<div class="ff-chapter__text">
						<span class="ff-label ff-label--gold">
							<?php
							/* translators: %s: roman numeral. */
							echo esc_html( sprintf( __( 'Chapter %s', 'littlebunny' ), $lbff_roman[ $lbff_i ] ) );
							?>
						</span>
						<h3 class="ff-chapter__name"><?php echo esc_html( $lbff_c[0] ); ?></h3>
						<p><?php echo esc_html( $lbff_c[1] ); ?></p>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
		<span class="ff-rail__end" aria-hidden="true"></span>
	</div>
</section>
