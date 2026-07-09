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
$shop_phone      = (string) theme_option( 'shop_phone', theme_demo_content( 'shop_phone' ) );
$reception_hours = (string) theme_option( 'shop_reception_hours', theme_demo_content( 'shop_reception_hours' ) );
$form_html       = theme_contact_form_html();
?>

<section class="page_hero">
	<img src="<?php echo esc_url( $hero_image['url'] ); ?>" alt="<?php echo esc_attr( $hero_image['alt'] ); ?>">
	<div class="shade"></div>
	<div class="hd">
		<?php if ( '' !== $hero_catch ) : ?>
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg><?php echo esc_html( $hero_catch ); ?></span>
		<?php endif; ?>
		<h1><?php the_title(); ?></h1>
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
		<p class="ContactIntro_note">※本サイトはデモサイトです。送信された内容はデモサイト制作者のメールアドレスに送信されます。</p>
	</div>
</div>

<div class="wrap">
	<div class="ContactLayout">
		<aside class="ContactLayout_aside reveal-l">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>お電話でのご予約・お問い合わせ</span>
			<p class="ContactMethods_value"><a href="<?php echo esc_url( theme_phone_uri( $shop_phone ) ); ?>"><?php echo esc_html( $shop_phone ); ?></a></p>
			<p class="ContactMethods_note">受付時間 <?php echo esc_html( $reception_hours ); ?><br>繁忙期はお電話が繋がりにくい場合がございます。あらかじめご了承ください。</p>
		</aside>
		<div class="ContactForm reveal-r">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>お問い合わせフォーム</span>
			<?php if ( '' !== $form_html ) : ?>
				<?php echo $form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Contact Form 7 が自身でエスケープ済みの HTML を返す。 ?>
			<?php else : ?>
				<p>現在フォームをご利用いただけません。お手数ですが、お電話にてお問い合わせください。</p>
			<?php endif; ?>
		</div>
	</div>
</div>
