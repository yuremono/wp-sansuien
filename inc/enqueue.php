<?php
/**
 * フロントエンド資産の enqueue。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * フロントエンドの stylesheet と script を enqueue する。
 *
 * サイト全体（トップ／客室個別／客室一覧／お知らせ）が単一の style.css で
 * 完結する構成のため、ページ別の切り替えは行わない。
 */
function theme_enqueue_assets(): void {
	wp_enqueue_style(
		'theme-google-fonts',
		'https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@100;200;300;400;500;600&family=Zen+Kaku+Gothic+New:wght@300;400;500&family=IBM+Plex+Mono:wght@400;500&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'theme-style',
		theme_source_uri( 'css/style.css' ),
		array( 'theme-google-fonts' ),
		theme_asset_version( 'assets/css/style.css' )
	);

	wp_enqueue_script(
		'theme-main',
		theme_source_uri( 'js/sansuien.js' ),
		array(),
		theme_asset_version( 'assets/js/sansuien.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );
