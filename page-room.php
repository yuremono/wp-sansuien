<?php
/**
 * 「客室のご案内」固定ページ（スラッグ: room）.
 *
 * ナビゲーションの「客室のご案内」リンク先。静的ソース room.html と同様、
 * 特別室「蒼」の詳細を主内容として表示し、末尾で他の客室（投稿）へ誘導する。
 * 本文は template-parts/room-page-content.php 以下のセクションパーツへ分割している。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/room-page-content' );
	endwhile;
	?>
</main>
<?php
get_footer();
