<?php
/**
 * Front closing section（予約導線＋アクセス）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_phone       = (string) theme_option( 'shop_phone', '0261-00-0000' );
$reception_hours  = (string) theme_option( 'shop_reception_hours', '9:00〜18:00' );
$contact_url      = theme_option_url( 'shop_contact_url', '#reserve' );
$shop_address     = (string) theme_option( 'shop_address', '長野県青木湖畔 ○○温泉郷' );
$access_note      = (string) theme_option( 'shop_access_note', 'JR大糸線「簗場駅」より送迎バスで約8分(要予約)' );
// 客室個別ページでは #reserve が予約カード側で既に使われているため、ここでは付与しない。
$closing_id = ( ( is_singular( 'post' ) && in_category( 'room' ) ) || is_page( 'room' ) ) ? '' : ' id="reserve"';
?>
<section class="closing"<?php echo $closing_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="bg_wrap"><div class="bg_sticky"><img src="<?php echo esc_url( theme_source_uri( 'images/bg_teal.jpg' ) ); ?>" alt=""></div></div>
	<div class="wrap">
		<div class="cl_grid">
			<div class="cl_res reveal-l">
				<span class="en_label">Reservation<svg class="sym sym-sm"><use href="#sym-tri"></use></svg><span class="jp_s">ご予約</span></span>
				<h3>ご宿泊のご予約は<br>こちらから</h3>
				<p class="nt">空室状況の確認、ご宿泊に関するご相談は、お電話またはフォームより承っております。</p>
				<a class="cta_btn" href="<?php echo esc_url( $contact_url ); ?>">空室状況・お問い合わせフォームへ<svg class="sym sym-sm bsym"><use href="#sym-tri"></use></svg></a>
				<p class="tel">お電話でのご予約 <?php echo esc_html( $shop_phone ); ?>(<?php echo esc_html( $reception_hours ); ?>)</p>
				<nav class="fnav" aria-label="フッターナビゲーション">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'menu_class'     => 'fnav_list',
							'fallback_cb'    => 'theme_menu_fallback',
							'depth'          => 1,
							'link_before'    => '<svg class="sym sym-sm"><use href="#sym-tri"></use></svg>',
						)
					);
					?>
				</nav>
			</div>
			<div class="cl_acc reveal-r" id="access">
				<span class="en_label">Access<svg class="sym sym-sm"><use href="#sym-tri"></use></svg><span class="jp_s">アクセス</span></span>
				<div class="map"><?php theme_image( 'shop_map_image', 'images/lake2.jpg', '青木湖周辺の空撮' ); ?></div>
				<p><?php echo esc_html( $shop_address ); ?><br><?php echo esc_html( $access_note ); ?></p>
			</div>
		</div>
	</div>
</section>
