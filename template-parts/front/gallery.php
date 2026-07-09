<?php
/**
 * Front gallery section（ドラッグ可能な自動スクロールマーキー）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gallery_images = theme_gallery_images( 'front_gallery_images' );

// 管理画面で未設定（導入直後）の場合のみ、テーマ内蔵のデモ画像を表示する。
if ( ! $gallery_images ) {
	$demo_files     = array(
		array( 'file' => 'room1.jpg', 'alt' => '和室の客室' ),
		array( 'file' => 'bath.jpg', 'alt' => '露天風呂' ),
		array( 'file' => 'irori.jpg', 'alt' => '囲炉裏ラウンジ' ),
		array( 'file' => 'okami.jpg', 'alt' => '女将のお出迎え' ),
		array( 'file' => 'lake2.jpg', 'alt' => '湖の眺望' ),
	);
	$gallery_images = array_map(
		static fn( array $demo ): array => array(
			'url' => theme_source_uri( 'images/' . $demo['file'] ),
			'alt' => $demo['alt'],
		),
		$demo_files
	);
}
?>
<section class="gallery reveal" aria-label="ギャラリー">
	<svg class="gallery_bg path_draw" viewBox="15 97.8 166.4 40" preserveAspectRatio="xMidYMid meet" fill="none" aria-hidden="true">
		<path pathLength="1" d="m23.6 121.8c9.9-1.7 22.4-7.3 28.3-10.1 7.2-3.4 8.9-4.7 10.1-4.6 2 0.1 5.3 2.7 6.7 3.1 1.6 0.5 2.3-0.5 3.8 0.2s3.4 2.8 4.5 2.9c1 0.2 1.5-0.9 3.1-0.5 1.9 0.6 6.7 3.8 13.6 6 6.4 2.2 14.8 4.3 25.3 4.8"/>
		<path pathLength="1" d="m85.9 128.8c10.2 1.9 22.1 2.9 37 2.5"/>
		<path pathLength="1" d="m26.1 127.2c18.4 0.8 27.3-3.7 37.7-6.5 11.1-2.9 15.2 0.2 25 3 12 3.6 21.4 5.2 32.4 4 7.1-0.7 14.3-3.4 18.7-4.7 11.1-3.7 14.6-6.6 26.5-5.6l8.2 1.6 0.4 0.1-0.4-0.1"/>
		<path pathLength="1" d="m111.7 126.7c10.7-0.4 16.9-2.7 27.7-6.1 8.6-2.8 13.1-4.3 20.8-3.9 4.1 0.4 9.3 1.5 21.1 1.8"/>
		<path pathLength="1" d="m96.5 116.3c7.9-1.1 13.2-5.3 15.9-6.5 1.5-0.6 2.1 0.2 3.8-0.5 1.8-0.7 6.2-3.6 7.5-4.4 2.3-1.2 2.9-0.6 4.7 0.5 3.3 2.1 2.9 2.3 5.2 1.8 1.5-0.1 1.9 0.2 3.3 1 3.3 2.1 6.5 4.4 8.4 5 2.2 0.9 2.6-0.4 3.9-0.3 1.3 0 1.9 1.1 3.7 1.2 2.1 0.1 3.8-1.3 6.2-1.4 3.5-0.1 9.8 3.6 22.2 5.7"/>
	</svg>
	<p class="gallery_note"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>SANSUIEN GALLERY</p>
	<div class="gallery_track" id="gTrack">
		<div class="g_set">
			<?php foreach ( $gallery_images as $image ) : ?>
				<figure><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"></figure>
			<?php endforeach; ?>
		</div>
		<div class="g_set" aria-hidden="true">
			<?php foreach ( $gallery_images as $image ) : ?>
				<figure><img src="<?php echo esc_url( $image['url'] ); ?>" alt=""></figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
