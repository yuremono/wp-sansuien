<?php
/**
 * 客室のご案内ページ: 他の客室カード（客室カテゴリーの投稿一覧）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$other_rooms = theme_get_content_posts( 'room' );
?>
<?php if ( $other_rooms ) : ?>
	<section class="other_rooms">
		<div class="wrap">
			<div class="sec_head sm reveal">
				<span class="en">Other Rooms</span>
				<svg class="sym"><use href="#sym-tri"></use></svg>
				<span class="jp">その他のお部屋</span>
			</div>
			<div class="or_cards reveal">
				<?php foreach ( $other_rooms as $other_room ) : ?>
					<?php
					$other_image = theme_content_image_data( $other_room->ID, 'images/room1.jpg' );
					$other_rate  = (string) theme_content_meta( $other_room->ID, 'room_rate_weekday', '' );
					?>
					<a href="<?php echo esc_url( get_permalink( $other_room ) ); ?>">
						<div class="ph"><img src="<?php echo esc_url( $other_image['url'] ); ?>" alt="<?php echo esc_attr( $other_image['alt'] ); ?>"></div>
						<div class="bd">
							<svg class="sym sym-sm csym"><use href="#sym-tri"></use></svg>
							<div class="nm"><?php echo esc_html( get_the_title( $other_room ) ); ?></div>
							<?php if ( '' !== $other_rate ) : ?><div class="pr"><?php echo esc_html( $other_rate ); ?> / 1泊2食付</div><?php endif; ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
