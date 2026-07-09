<?php
/**
 * 客室のご案内ページ: 本文（About This Room / 客室データ / 料金・予約）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$lead              = (string) theme_meta( 'page_room_lead', '' );
$room_tags         = theme_split_tags( (string) theme_meta( 'page_room_tags', '' ) );
$room_size         = (string) theme_meta( 'page_room_size', '' );
$room_amenities    = (string) theme_meta( 'page_room_amenities', '' );
$room_checkin_out  = (string) theme_meta( 'page_room_checkin_out', '' );
$room_rate_weekday = (string) theme_meta( 'page_room_rate_weekday', '' );
$room_rate_holiday = (string) theme_meta( 'page_room_rate_holiday', '' );
$room_capacity     = (string) theme_meta( 'page_room_capacity', '' );
$shop_phone        = (string) theme_option( 'shop_phone', '0261-00-0000' );
$reception_hours   = (string) theme_option( 'shop_reception_hours', '9:00〜18:00' );
?>
<div class="wrap">
	<div class="room_body">
		<div class="reveal-l">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>About This Room</span>
			<?php if ( '' !== $lead ) : ?>
				<h3><?php echo nl2br( esc_html( $lead ) ); ?></h3>
			<?php endif; ?>
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
