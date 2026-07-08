<?php
/**
 * 客室個別ページの詳細レイアウト（カテゴリー: room の投稿）.
 *
 * single.php のループ内（the_post() 実行後）から呼び出される。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$room_id           = get_the_ID();
$room_catch        = (string) theme_content_meta( $room_id, 'room_catch', '' );
$room_tags         = theme_split_tags( (string) theme_content_meta( $room_id, 'room_tags', '' ) );
$room_size         = (string) theme_content_meta( $room_id, 'room_size', '' );
$room_amenities    = (string) theme_content_meta( $room_id, 'room_amenities', '' );
$room_checkin_out  = (string) theme_content_meta( $room_id, 'room_checkin_out', '' );
$room_rate_weekday = (string) theme_content_meta( $room_id, 'room_rate_weekday', '' );
$room_rate_holiday = (string) theme_content_meta( $room_id, 'room_rate_holiday', '' );
$room_capacity     = (string) theme_content_meta( $room_id, 'room_capacity', '' );
$hero_image        = theme_content_image_data( $room_id, 'images/room2.jpg' );
$shop_phone        = (string) theme_option( 'shop_phone', '0261-00-0000' );
$reception_hours   = (string) theme_option( 'shop_reception_hours', '9:00〜18:00' );
$room_archive_url  = home_url( '/room/' );

$gallery_fields = array(
	array( 'field' => 'room_gallery_1', 'fallback' => 'images/room1.jpg', 'caption' => '客室内観' ),
	array( 'field' => 'room_gallery_2', 'fallback' => 'images/bath.jpg', 'caption' => '貸切露天風呂' ),
	array( 'field' => 'room_gallery_3', 'fallback' => 'images/lake2.jpg', 'caption' => '湖側テラス' ),
	array( 'field' => 'room_gallery_4', 'fallback' => 'images/kaiseki.jpg', 'caption' => 'お食事イメージ' ),
);

$other_rooms = theme_get_content_posts(
	'room',
	array(
		'posts_per_page' => 3,
		'post__not_in'   => array( $room_id ),
	)
);
?>

<section class="page_hero">
	<img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ); ?>">
	<div class="shade"></div>
	<div class="hd">
		<?php if ( '' !== $room_catch ) : ?>
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg><?php echo esc_html( $room_catch ); ?></span>
		<?php endif; ?>
		<h2><?php the_title(); ?></h2>
	</div>
</section>

<nav class="crumbs" aria-label="パンくずリスト">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a><span>›</span>
	<a href="<?php echo esc_url( $room_archive_url ); ?>">客室のご案内</a><span>›</span>
	<span><?php the_title(); ?></span>
</nav>

<div class="room_gallery">
	<?php foreach ( $gallery_fields as $gallery ) : ?>
		<?php $image = theme_image_data( $gallery['field'], $gallery['fallback'] ); ?>
		<?php if ( '' !== $image['url'] ) : ?>
			<figure class="reveal"><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( '' !== $image['alt'] ? $image['alt'] : $gallery['caption'] ); ?>"><figcaption><?php echo esc_html( $gallery['caption'] ); ?></figcaption></figure>
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<div class="wrap">
	<div class="room_body">
		<div class="reveal-l">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>About This Room</span>
			<h3><?php the_title(); ?></h3>
			<div class="desc"><?php the_content(); ?></div>
			<?php if ( $room_tags ) : ?>
				<div class="tags">
					<?php foreach ( $room_tags as $tag ) : ?>
						<span><?php echo esc_html( $tag ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>Room Data</span>
			<dl class="data_tbl" style="margin-top:16px">
				<?php if ( '' !== $room_size ) : ?><div><dt>広さ</dt><dd><?php echo esc_html( $room_size ); ?></dd></div><?php endif; ?>
				<?php if ( '' !== $room_amenities ) : ?><div><dt>お部屋設備</dt><dd><?php echo esc_html( $room_amenities ); ?></dd></div><?php endif; ?>
				<?php if ( '' !== $room_checkin_out ) : ?><div><dt>チェックイン・アウト</dt><dd><?php echo esc_html( $room_checkin_out ); ?></dd></div><?php endif; ?>
			</dl>
		</div>

		<aside class="book_card reveal-r" id="reserve">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>Rates &amp; Booking</span>
			<?php if ( '' !== $room_rate_weekday ) : ?>
				<div class="rate"><span class="lb">平日 1泊2食付</span><span class="pr"><?php echo esc_html( $room_rate_weekday ); ?></span></div>
			<?php endif; ?>
			<?php if ( '' !== $room_rate_holiday ) : ?>
				<div class="rate"><span class="lb">休前日 1泊2食付</span><span class="pr"><?php echo esc_html( $room_rate_holiday ); ?></span></div>
			<?php endif; ?>
			<?php if ( '' !== $room_capacity ) : ?>
				<div class="rate"><span class="lb">ご定員</span><span><?php echo esc_html( $room_capacity ); ?></span></div>
			<?php endif; ?>
			<a class="book_btn" href="<?php echo esc_url( theme_option_url( 'shop_contact_url', '#reserve' ) ); ?>">このお部屋を予約する<svg class="sym sym-sm bsym"><use href="#sym-tri"></use></svg></a>
			<p class="tel">お電話でのご予約 <?php echo esc_html( $shop_phone ); ?>(<?php echo esc_html( $reception_hours ); ?>)</p>
		</aside>
	</div>
</div>

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
