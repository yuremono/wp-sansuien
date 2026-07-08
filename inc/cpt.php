<?php
/**
 * カスタム投稿タイプ。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 客室とお知らせの投稿タイプを登録する。
 */
function theme_register_content_types(): void {
	$post_types = array(
		'room' => array(
			'singular'    => '客室',
			'plural'      => '客室',
			'icon'        => 'dashicons-admin-multisite',
			'has_archive' => true,
		),
		'news' => array(
			'singular'    => 'お知らせ',
			'plural'      => 'お知らせ',
			'icon'        => 'dashicons-megaphone',
			'has_archive' => false,
		),
	);

	// 投稿タイプごとのラベルと表示設定をまとめて登録する。
	foreach ( $post_types as $slug => $labels ) {
		register_post_type(
			$slug,
			array(
				'labels'       => array(
					'name'          => $labels['plural'],
					'singular_name' => $labels['singular'],
					'add_new_item'  => $labels['singular'] . 'を追加',
					'edit_item'     => $labels['singular'] . 'を編集',
				),
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => $labels['has_archive'],
				'menu_icon'    => $labels['icon'],
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
				'rewrite'      => array( 'slug' => $slug ),
			)
		);
	}
}
add_action( 'init', 'theme_register_content_types' );
