<?php
/**
 * 「お問い合わせ・ご予約」固定ページ本文.
 *
 * page-contact.php のループ内（the_post() 実行後）から呼び出される。
 * ヒーロー＋導入文＋連絡方法（電話／外部フォーム）の1ページ構成のため、
 * template-parts/ ディレクトリへは分割せずこの1ファイルにまとめている。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_catch      = (string) theme_meta( 'page_contact_hero_catch', '' );
$hero_image      = theme_image_data( 'page_contact_hero_image', 'images/lake2.jpg', get_the_title() );
$lead            = (string) theme_meta( 'page_contact_lead', '' );
$shop_phone      = (string) theme_option( 'shop_phone', '0261-00-0000' );
$reception_hours = (string) theme_option( 'shop_reception_hours', '9:00〜18:00' );
$contact_url     = theme_option_url( 'shop_contact_url', '' );
?>

<section class="page_hero">
	<img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ); ?>">
	<div class="shade"></div>
	<div class="hd">
		<?php if ( '' !== $hero_catch ) : ?>
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg><?php echo esc_html( $hero_catch ); ?></span>
		<?php endif; ?>
		<h2><?php the_title(); ?></h2>
	</div>
</section>

<nav class="crumbs" aria-label="パンくずリスト">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a><span>›</span><span><?php the_title(); ?></span>
</nav>

<div class="wrap">
	<div class="ContactIntro reveal">
		<?php if ( '' !== $lead ) : ?>
			<p class="ContactIntro_lead"><?php echo nl2br( esc_html( $lead ) ); ?></p>
		<?php else : ?>
			<div class="entry-content"><?php the_content(); ?></div>
		<?php endif; ?>
	</div>
</div>

<div class="wrap">
	<div class="ContactMethods">
		<div class="ContactMethods_card reveal-l">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>お電話でのご予約・お問い合わせ</span>
			<p class="ContactMethods_value"><a href="<?php echo esc_url( theme_phone_uri( $shop_phone ) ); ?>"><?php echo esc_html( $shop_phone ); ?></a></p>
			<p class="ContactMethods_note">受付時間 <?php echo esc_html( $reception_hours ); ?><br>繁忙期はお電話が繋がりにくい場合がございます。あらかじめご了承ください。</p>
		</div>
		<div class="ContactMethods_card reveal-r">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>フォームでのご予約・お問い合わせ</span>
			<p class="ContactMethods_note">空室状況のご確認や、お部屋・お食事に関するご相談はこちらのフォームからも承っております。</p>
			<a class="ContactMethods_btn" href="<?php echo esc_url( '' !== $contact_url ? $contact_url : '#' ); ?>">ご予約・お問い合わせフォームへ<svg class="sym sym-sm bsym"><use href="#sym-tri"></use></svg></a>
		</div>
	</div>
</div>
