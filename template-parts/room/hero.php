<?php
/**
 * 客室のご案内ページ: ヒーロー + パンくず.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_catch = (string) theme_meta( 'page_room_hero_catch', '' );
$hero_image = theme_image_data( 'page_room_hero_image', 'images/room2.jpg', get_the_title() );
?>
<section class="page_hero">
	<img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ); ?>">
	<div class="shade"></div>
	<div class="hd">
		<?php if ( '' !== $hero_catch ) : ?>
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg><?php echo esc_html( $hero_catch ); ?></span>
		<?php endif; ?>
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<nav class="crumbs" aria-label="パンくずリスト">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a><span>›</span><span>客室のご案内</span><span>›</span><span><?php the_title(); ?></span>
</nav>
