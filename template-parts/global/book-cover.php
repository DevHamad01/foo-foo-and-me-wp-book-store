<?php
/**
 * 3D book cover.
 *
 * Args: variant (revealed|future), num, class, title1, title2, author.
 *
 * @package LittleBunny
 */

defined( 'ABSPATH' ) || exit;

$lbff_variant = ( isset( $args['variant'] ) && 'future' === $args['variant'] ) ? 'future' : 'revealed';
$lbff_num     = isset( $args['num'] ) ? (string) $args['num'] : '01';
$lbff_class   = isset( $args['class'] ) ? (string) $args['class'] : '';
?>
<div class="ff-cover ff-cover--<?php echo esc_attr( $lbff_variant . ( $lbff_class ? ' ' . $lbff_class : '' ) ); ?>">
	<div class="ff-cover__shadow" aria-hidden="true"></div>
	<div class="ff-cover__book">
		<div class="ff-cover__pages" aria-hidden="true"></div>
		<?php if ( 'revealed' === $lbff_variant ) : ?>
			<div class="ff-cover__face" role="img" aria-label="<?php echo esc_attr( sprintf( /* translators: 1: book number, 2: title. */ __( 'Book %1$s cover: %2$s', 'littlebunny' ), $lbff_num, trim( $args['title1'] . ' ' . $args['title2'] ) ) ); ?>">
				<img class="ff-cover__img" src="<?php echo esc_url( lbff_book_cover_url() ); ?>" alt="" loading="lazy" decoding="async">
				<div class="ff-cover__tint"></div>
				<div class="ff-cover__top"><span><?php esc_html_e( 'Little Bunny Foo Foo', 'littlebunny' ); ?></span><span><?php echo esc_html( $lbff_num ); ?></span></div>
				<div class="ff-cover__rule"></div>
				<div class="ff-cover__title">
					<div><?php echo esc_html( $args['title1'] ); ?></div>
					<div class="ff-cover__title2"><?php echo esc_html( $args['title2'] ); ?></div>
				</div>
				<div class="ff-cover__author"><?php echo esc_html( $args['author'] ); ?></div>
			</div>
		<?php else : ?>
			<div class="ff-cover__face ff-cover__face--future" role="img" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: book number. */ __( 'Book %s — coming soon', 'littlebunny' ), $lbff_num ) ); ?>">
				<div class="ff-cover__dune"></div>
				<div class="ff-cover__top"><span><?php esc_html_e( 'Little Bunny Foo Foo', 'littlebunny' ); ?></span><span><?php echo esc_html( $lbff_num ); ?></span></div>
				<div class="ff-cover__bignum"><?php echo esc_html( $lbff_num ); ?></div>
			</div>
		<?php endif; ?>
		<div class="ff-cover__gloss" aria-hidden="true"></div>
		<div class="ff-cover__glare" aria-hidden="true"></div>
	</div>
</div>
