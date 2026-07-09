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
$map_embed_url    = theme_option_url( 'shop_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12810.641561945822!2d137.85172605!3d36.61048755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5ff7d9e50029316b%3A0xcd895b7fa3ed5edb!2z6Z2S5pyo5rmW!5e0!3m2!1sja!2sjp!4v1783558639512!5m2!1sja!2sjp' );
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
				<div class="map"><?php if ( '' !== $map_embed_url ) : ?><iframe src="<?php echo esc_url( $map_embed_url ); ?>" width="600" height="450" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin" title="<?php esc_attr_e( 'アクセスマップ', THEME_GETTEXT_DOMAIN ); ?>"></iframe><?php endif; ?></div>
				<p><?php echo esc_html( $shop_address ); ?><br><?php echo esc_html( $access_note ); ?></p>
			</div>
		</div>
	</div>
</section>
