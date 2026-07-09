<?php
/**
 * 標準投稿のシンプルな個別ページレイアウト（お知らせなど、客室カテゴリー以外）.
 *
 * single.php のループ内（the_post() 実行後）から呼び出される。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id     = get_the_ID();
$hero_image  = theme_content_image_data( $post_id, 'images/lake2.jpg' );
$external    = (string) theme_content_meta( $post_id, 'news_external_url', '' );
?>

<section class="page_hero">
	<img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ); ?>">
	<div class="shade"></div>
	<div class="hd">
		<h1><?php the_title(); ?></h1>
	</div>
</section>

<nav class="crumbs" aria-label="パンくずリスト">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a><span>›</span>
	<span><?php the_title(); ?></span>
</nav>

<div class="wrap page_body_wrap">
	<p class="date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
	<div class="entry-content entry">
		<?php the_content(); ?>
	</div>
	<?php if ( '' !== $external ) : ?>
		<p class="entry_external"><a href="<?php echo esc_url( $external ); ?>" target="_blank" rel="noopener noreferrer">関連リンクを見る</a></p>
	<?php endif; ?>
</div>
