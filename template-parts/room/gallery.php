<?php
/**
 * 客室のご案内ページ: ギャラリー.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gallery_images = theme_gallery_images( 'page_room_gallery' );

// 管理画面で未設定（導入直後）の場合のみ、テーマ内蔵のデモ画像を表示する。
if ( ! $gallery_images ) {
	$demo_files     = array(
		array( 'file' => 'room1.jpg', 'caption' => '客室内観' ),
		array( 'file' => 'bath.jpg', 'caption' => '貸切露天風呂' ),
		array( 'file' => 'lake2.jpg', 'caption' => '湖側テラス' ),
		array( 'file' => 'kaiseki.jpg', 'caption' => 'お食事イメージ' ),
	);
	$gallery_images = array_map(
		static fn( array $demo ): array => array(
			'url'     => theme_source_uri( 'images/' . $demo['file'] ),
			'alt'     => $demo['caption'],
			'caption' => $demo['caption'],
		),
		$demo_files
	);
}
?>
<div class="room_gallery">
	<?php foreach ( $gallery_images as $image ) : ?>
		<figure class="reveal">
			<a class="glightbox" href="<?php echo esc_url( $image['url'] ); ?>" data-gallery="room-gallery" data-description="<?php echo esc_attr( $image['caption'] ); ?>">
				<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( '' !== $image['alt'] ? $image['alt'] : $image['caption'] ); ?>">
			</a>
			<?php if ( '' !== $image['caption'] ) : ?><figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption><?php endif; ?>
		</figure>
	<?php endforeach; ?>
</div>
