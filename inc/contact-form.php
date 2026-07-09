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
