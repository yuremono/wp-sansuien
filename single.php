<?php
/**
 * 標準投稿の個別ページ.
 *
 * 客室カテゴリー（room）の投稿は客室詳細レイアウト、それ以外
 * （お知らせなど）はシンプルな標準投稿レイアウトを表示する。
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

	if ( in_category( 'room' ) ) {
		get_template_part( 'template-parts/single-room-content' );
	} else {
		get_template_part( 'template-parts/single-post-content' );
	}

endwhile;

get_template_part( 'template-parts/front/closing' );
get_template_part( 'template-parts/site-footer' );
get_footer();
