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

$gallery_fields = array(
	array( 'field' => 'page_room_gallery_1', 'fallback' => 'images/room1.jpg', 'caption' => '客室内観' ),
	array( 'field' => 'page_room_gallery_2', 'fallback' => 'images/bath.jpg', 'caption' => '貸切露天風呂' ),
	array( 'field' => 'page_room_gallery_3', 'fallback' => 'images/lake2.jpg', 'caption' => '湖側テラス' ),
	array( 'field' => 'page_room_gallery_4', 'fallback' => 'images/kaiseki.jpg', 'caption' => 'お食事イメージ' ),
);
?>
<div class="room_gallery">
	<?php foreach ( $gallery_fields as $gallery ) : ?>
		<?php $image = theme_image_data( $gallery['field'], $gallery['fallback'] ); ?>
		<?php if ( '' !== $image['url'] ) : ?>
			<figure class="reveal"><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( '' !== $image['alt'] ? $image['alt'] : $gallery['caption'] ); ?>"><figcaption><?php echo esc_html( $gallery['caption'] ); ?></figcaption></figure>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
