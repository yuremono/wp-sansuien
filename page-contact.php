<?php
/**
 * 「お問い合わせ・ご予約」固定ページ（スラッグ: contact）.
 *
 * ヘッダー右下の固定予約タブ（reserve_tab）のリンク先。ご予約とお問い合わせを
 * 同じ窓口（電話／外部フォーム）で受け付けていることを案内する。
 * 電話番号・受付時間・お問い合わせURLは「宿泊施設共通情報」の値を再利用する。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/site-header' );
get_template_part( 'template-parts/reserve-tab' );

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/contact-page-content' );
endwhile;

get_template_part( 'template-parts/site-footer' );
get_footer();
