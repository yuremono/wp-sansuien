<?php
/**
 * デモ投稿（post / news）と画像メディア1件をスラッグ基準で投入・更新する。
 *
 * php -r 'require "./wp-load.php"; require get_template_directory() . "/tools/seed-posts-news-media.php";'
 *
 * @package Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return int Post ID (>0) or 0.
 */
function pc_seed_get_post_id_by_slug( string $slug, string $post_type ): int {
	$posts = get_posts(
		array(
			'name'             => $slug,
			'post_type'        => $post_type,
			'post_status'      => 'any',
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'suppress_filters' => true,
		)
	);

	return isset( $posts[0] ) ? (int) $posts[0] : 0;
}

/**
 * @return int|WP_Error
 */
function pc_seed_upsert_post( array $args ) {
	$defaults = array(
		'title'   => '',
		'slug'    => '',
		'type'    => 'post',
		'content' => '',
		'author'  => 1,
	);
	$args     = array_merge( $defaults, $args );

	$postarr = array(
		'post_title'   => $args['title'],
		'post_name'    => $args['slug'],
		'post_content' => $args['content'],
		'post_status'  => 'publish',
		'post_type'    => $args['type'],
		'post_author'  => (int) $args['author'],
	);

	$existing_id = pc_seed_get_post_id_by_slug( $args['slug'], $args['type'] );
	if ( $existing_id ) {
		$postarr['ID'] = $existing_id;
		return wp_update_post( wp_slash( $postarr ), true );
	}

	return wp_insert_post( wp_slash( $postarr ), true );
}

/**
 * Block エディター用 paragraph 連結。
 *
 * @param string ...$paragraphs プレーンテキスト（自動エスケープ）。
 */
function pc_seed_paragraph_blocks( string ...$paragraphs ): string {
	$out = '';
	foreach ( $paragraphs as $p ) {
		$out .= "<!-- wp:paragraph -->\n<p>" . esc_html( $p ) . "</p>\n<!-- /wp:paragraph -->\n";
	}
	return $out;
}

/**
 * ミニPNGの添付ファイルを upsert。
 *
 * @return int|WP_Error Attachment ID.
 */
function pc_seed_ensure_demo_image_attachment() {
	$upload_dir = wp_upload_dir();
	if ( ! empty( $upload_dir['error'] ) ) {
		return new WP_Error( 'upload_dir', $upload_dir['error'] );
	}

	$subdir    = trailingslashit( $upload_dir['basedir'] ) . 'pc-seed';
	$file_rel  = 'pc-seed/cursor-demo.png';
	$file_path = trailingslashit( $subdir ) . 'cursor-demo.png';

	wp_mkdir_p( $subdir );

	$png_binary = base64_decode( 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==', true );
	if ( false === $png_binary ) {
		return new WP_Error( 'decode', 'Failed to decode placeholder PNG.' );
	}

	if ( false === file_put_contents( $file_path, $png_binary ) ) {
		return new WP_Error( 'write', 'Could not write ' . $file_path );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$public_url    = trailingslashit( $upload_dir['baseurl'] ) . $file_rel;
	$attachment_id = attachment_url_to_postid( $public_url );

	$filetype = wp_check_filetype( basename( $file_path ), null );

	if ( $attachment_id > 0 ) {
		$update = wp_update_post(
			wp_slash(
				array(
					'ID'             => $attachment_id,
					'post_title'     => 'デモ画像（Cursorシード）',
					'post_content'   => '',
					'post_status'    => 'inherit',
					'post_mime_type' => $filetype['type'],
				)
			),
			true
		);

		if ( $update instanceof WP_Error ) {
			return $update;
		}

		update_attached_file( $attachment_id, $file_path );
		wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $file_path ) );
		return $attachment_id;
	}

	$attachment = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => 'デモ画像（Cursorシード）',
		'post_content'   => '',
		'post_status'    => 'inherit',
		'post_author'    => 1,
	);

	$attach_id = wp_insert_attachment( $attachment, $file_path );
	if ( $attach_id instanceof WP_Error ) {
		return $attach_id;
	}
	if ( ! is_int( $attach_id ) || $attach_id <= 0 ) {
		return new WP_Error( 'attachment', 'wp_insert_attachment failed.' );
	}

	wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $file_path ) );
	return $attach_id;
}

$items = array(
	array(
		'type'    => 'post',
		'slug'    => 'jp-demo-post-chiiki-design',
		'title'   => '地域に根ざした設計の勘所（デモ）',
		'content' => pc_seed_paragraph_blocks(
			'この記事はローカル検証用のデモ段落です。トップページが「投稿一覧」のときの表示確認に使えます。',
			'実際の原稿へ差し替える際は、見出しブロックや画像ブロックもあわせて構成してください。',
		),
	),
	array(
		'type'    => 'post',
		'slug'    => 'jp-demo-post-sha-goi',
		'title'   => '社寺プロジェクトでの合意形成メモ（デモ）',
		'content' => pc_seed_paragraph_blocks(
			'ワークショップと図面上の論理、その両輪が揃って初めて現場での合意が安定します。',
			'本稿はポートフォリオ用テーマのブロックコンテンツ例として用意したプレーン段落のみです。',
		),
	),
	array(
		'type'    => 'news',
		'slug'    => 'jp-demo-news-fuyukyugyo',
		'title'   => '冬季休業のお知らせ（デモ）',
		'content' => pc_seed_paragraph_blocks(
			'年末年始の窓口対応についてのサンプル文です（実在日付・条件はサイト運用ポリシーに合わせて編集してください）。',
		),
	),
	array(
		'type'    => 'news',
		'slug'    => 'jp-demo-news-kengaku',
		'title'   => '見学会の予約受付を再開しました（デモ）',
		'content' => pc_seed_paragraph_blocks(
			'定員・時間帯は別途お問い合わせください。お知らせ CPT のブロック本文の動作確認用テキストです。',
		),
	),
);

$lines = array( 'RESULTS' );

foreach ( $items as $row ) {
	$res = pc_seed_upsert_post(
		array(
			'title'   => $row['title'],
			'slug'    => $row['slug'],
			'type'    => $row['type'],
			'content' => $row['content'],
			'author'  => 1,
		)
	);

	if ( $res instanceof WP_Error || ! is_int( $res ) || $res <= 0 ) {
		$lines[] = 'FAIL ' . $row['type'] . ' ' . $row['slug'] . ' ' . ( $res instanceof WP_Error ? $res->get_error_message() : 'unknown' );
		continue;
	}
	$lines[] = strtoupper( $row['type'] ) . '_OK id=' . $res . ' edit=' . admin_url( 'post.php?post=' . $res . '&action=edit' );
}

$img = pc_seed_ensure_demo_image_attachment();
if ( $img instanceof WP_Error ) {
	$lines[] = 'MEDIA_FAIL ' . $img->get_error_message();
} else {
	$lines[] = 'MEDIA_OK id=' . $img . ' edit=' . admin_url( 'post.php?post=' . $img . '&action=edit' );
}

echo implode( "\n", $lines ) . "\n";
