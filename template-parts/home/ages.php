<?php
/**
 * Home — 06 Age groups.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_cards = array(
	array(
		'slot'  => 'home-age-little',
		'href'  => lbff_page_url( 'explore', 'little' ),
		'tag'   => __( 'Destination I', 'littlebunny' ),
		'title' => __( 'Little<br><em>Explorers</em>', 'littlebunny' ),
		'ages'  => '5–6',
		'text'  => __( 'Picture-led reading, gentle questions and simple activities for first explorers.', 'littlebunny' ),
	),
	array(
		'slot'  => 'home-age-big',
		'href'  => lbff_page_url( 'explore', 'big' ),
		'tag'   => __( 'Destination II', 'littlebunny' ),
		'title' => __( 'Foo Foo’s<br><em>Big Adventure</em>', 'littlebunny' ),
		'ages'  => '7–9',
		'text'  => __( 'Longer reading, writing prompts and challenges for independent young explorers.', 'littlebunny' ),
	),
);
?>
<section class="ff-section ff-bg-cream ff-ages">
	<div class="ff-container ff-stack-lg">
		<div class="ff-headrow" data-reveal>
			<div class="ff-stack-sm">
				<?php lbff_eyebrow( '05', __( 'Age groups', 'littlebunny' ) ); ?>
				<h2 class="ff-display"><?php echo wp_kses( __( 'Two destinations,<br><em>one journey</em>', 'littlebunny' ), lbff_inline_kses() ); ?></h2>
			</div>
			<p class="ff-headrow__note"><?php esc_html_e( 'The same story, met at two different heights — so younger readers and older explorers each find their way in.', 'littlebunny' ); ?></p>
		</div>
		<div class="ff-ages__grid">
			<?php foreach ( $lbff_cards as $lbff_c ) : ?>
				<a class="ff-agecard" href="<?php echo esc_url( $lbff_c['href'] ); ?>" data-reveal>
					<div class="ff-agecard__img"><?php lbff_slot( $lbff_c['slot'] ); ?></div>
					<div class="ff-agecard__shade" aria-hidden="true"></div>
					<div class="ff-agecard__body">
						<span class="ff-label ff-label--gold"><?php echo esc_html( $lbff_c['tag'] ); ?></span>
						<div class="ff-agecard__row">
							<span class="ff-agecard__title"><?php echo wp_kses( $lbff_c['title'], lbff_inline_kses() ); ?></span>
							<span class="ff-agecard__ages"><?php echo esc_html( $lbff_c['ages'] ); ?></span>
						</div>
						<span class="ff-agecard__text"><?php echo esc_html( $lbff_c['text'] ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
