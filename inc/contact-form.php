<?php
/**
 * Contact Form 7 用のテーマ側フック（ハニーポットによる簡易スパム対策）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ハニーポット項目（your-hp）に値が入っている送信をスパム扱いにする。
 * CSS（.Cf7Honeypot）で画面上は非表示にしており、人間の利用者が入力することはない。
 *
 * @param bool                  $spam       これまでの判定結果。
 * @param WPCF7_Submission|null $submission 送信データ。
 * @return bool
 */
function theme_cf7_honeypot_spam_check( bool $spam, $submission ): bool {
	if ( $spam || ! ( $submission instanceof WPCF7_Submission ) ) {
		return $spam;
	}

	$posted = $submission->get_posted_data();

	if ( ! empty( $posted['your-hp'] ) ) {
		return true;
	}

	return $spam;
}

if ( class_exists( 'WPCF7_ContactForm' ) ) {
	add_filter( 'wpcf7_spam', 'theme_cf7_honeypot_spam_check', 10, 2 );
}

/**
 * お問い合わせフォームの出力用 HTML を返す。
 *
 * Contact Form 7 が無効、またはフォームが未作成の場合は空文字を返す。
 * 呼び出し側でその場合の fallback（電話番号の案内など）を出す。
 *
 * @return string
 */
function theme_contact_form_html(): string {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return '';
	}

	$forms = WPCF7_ContactForm::find(
		array(
			'title'          => 'お問い合わせ・ご予約フォーム',
			'posts_per_page' => 1,
		)
	);

	if ( empty( $forms ) ) {
		return '';
	}

	return do_shortcode( '[contact-form-7 id="' . (int) $forms[0]->id() . '"]' );
}

/**
 * プライバシーポリシーモーダルの標準文面（ACF が空欄のときの fallback）を返す。
 *
 * @return string
 */
function theme_default_privacy_policy_content(): string {
	$shop_name    = (string) theme_option( 'shop_name', THEME_BRAND_DEFAULT );
	$shop_address = (string) theme_option( 'shop_address', '長野県青木湖畔 ○○温泉郷' );
	$shop_phone   = (string) theme_option( 'shop_phone', '0261-00-0000' );

	return '<h2>1. 事業者情報</h2>'
		. '<p>名称：' . esc_html( $shop_name ) . '<br>'
		. '所在地：' . esc_html( $shop_address ) . '<br>'
		. '電話番号：' . esc_html( $shop_phone ) . '</p>'
		. '<h2>2. 収集する情報</h2>'
		. '<p>' . esc_html( $shop_name ) . '（以下「当宿」といいます）は、お問い合わせフォームおよびお電話でのご予約・お問い合わせに際し、お名前、メールアドレス、電話番号、ご希望のご宿泊日、お問い合わせ内容等の個人情報をお客様よりご提供いただきます。</p>'
		. '<h2>3. 利用目的</h2>'
		. '<p>取得した個人情報は、ご予約・お問い合わせへの回答、ご宿泊に関するご案内・手続き、サービス向上を目的とした分析（個人を特定しない統計情報として）の範囲内で利用いたします。</p>'
		. '<h2>4. 第三者提供</h2>'
		. '<p>当宿は、法令に基づく場合を除き、お客様の同意なく個人情報を第三者に提供することはありません。</p>'
		. '<h2>5. 業務委託</h2>'
		. '<p>お問い合わせ・ご予約対応の一部を外部の業務委託先（メール配信システム等）に委託する場合があります。その場合、委託先に対して適切な監督を行います。</p>'
		. '<h2>6. 個人情報の管理</h2>'
		. '<p>当宿は、個人情報への不正アクセス、紛失、破壊、改ざん、漏えい等を防止するため、必要かつ適切な安全管理措置を講じます。</p>'
		. '<h2>7. 開示・訂正・削除等のご請求</h2>'
		. '<p>お客様がご自身の個人情報の開示・訂正・削除等をご希望される場合は、お問い合わせ窓口までご連絡ください。</p>'
		. '<h2>8. Cookie等の使用について</h2>'
		. '<p>当サイトは、利用状況の把握やサイト改善を目的として、Cookie等の技術を使用する場合があります。Cookieの利用を希望されない場合は、ブラウザの設定により無効化することができます。</p>'
		. '<h2>9. お問い合わせ窓口</h2>'
		. '<p>個人情報の取扱いに関するお問い合わせは、電話番号 ' . esc_html( $shop_phone ) . '、またはお問い合わせフォームよりご連絡ください。</p>'
		. '<h2>10. プライバシーポリシーの変更</h2>'
		. '<p>当宿は、必要に応じて本ポリシーの内容を変更することがあります。変更後のプライバシーポリシーは、本ページに掲載した時点から効力を生じるものとします。</p>';
}
