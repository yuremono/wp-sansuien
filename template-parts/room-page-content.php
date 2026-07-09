<?php
/**
 * 「客室のご案内」固定ページ本文.
 *
 * page-room.php のループ内（the_post() 実行後）から呼び出される。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_template_part( 'template-parts/room/hero' );
get_template_part( 'template-parts/room/gallery' );
get_template_part( 'template-parts/room/body' );
get_template_part( 'template-parts/room/other-rooms' );
