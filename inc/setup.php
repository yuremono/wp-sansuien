<?php
/**
 * テーマ初期設定。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * テーマサポートとメニュー位置を設定する。
 */
function theme_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array(
			'caption',
			'gallery',
			'script',
			'style',
		)
	);

	register_nav_menus(
		array(
			'primary' => 'Primary Navigation',
			'footer'  => 'Footer Navigation',
		)
	);
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * 客室・お知らせを区別するための標準カテゴリーが常に存在するよう保証する。
 *
 * 既存のカテゴリーやその設定を一切変更しない、非破壊的な処理。
 * ACF のフィールドグループ location（post_category）がこのカテゴリーの
 * term_id を参照するため、acf/init（WP init 優先度5）より前に実行する必要がある。
 */
function theme_ensure_content_categories(): void {
	$categories = array(
		'room' => '客室',
		'news' => 'お知らせ',
	);

	foreach ( $categories as $slug => $name ) {
		if ( term_exists( $slug, 'category' ) ) {
			continue;
		}

		wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
	}
}
add_action( 'init', 'theme_ensure_content_categories', 1 );

/**
 * 「お知らせ」カテゴリーを `/category/news/` ではなく `/news/` の
 * ような短い URL で提供するためのリライトルールを追加する。
 *
 * 「客室」は固定ページ（page-room.php, スラッグ room）が `/room/` を使うため、
 * カテゴリー側のリライトルールはここでは追加しない（固定ページの URL と競合するため）。
 *
 * 標準の `register_taxonomy('category', ...)` を再登録すると全カテゴリーの
 * ベースが変わってしまうため、news カテゴリーだけに限定した個別ルールを
 * 追加する方式にしている。
 */
function theme_register_content_category_rewrites(): void {
	add_rewrite_rule( '^news/?$', 'index.php?category_name=news', 'top' );
}
add_action( 'init', 'theme_register_content_category_rewrites', 2 );

/**
 * `get_category_link()` が「お知らせ」カテゴリーに対して、上記の
 * 短縮リライトルールに対応する URL（`/news/`）を返すようにする。
 * これが無いと、リンク生成側は `/category/news/` を返す一方でアクセス側は
 * `/news/` も受け付けるという不整合になり、正規化リダイレクトが混乱する。
 *
 * @param string $link    生成されたカテゴリーリンク。
 * @param int    $term_id カテゴリーのterm_id。
 * @return string
 */
function theme_short_category_link( string $link, int $term_id ): string {
	$term = get_term( $term_id, 'category' );
	if ( ! ( $term instanceof WP_Term ) || 'news' !== $term->slug ) {
		return $link;
	}

	return home_url( '/' . $term->slug . '/' );
}
add_filter( 'category_link', 'theme_short_category_link', 10, 2 );

/**
 * 客室・お知らせを CPT からカテゴリーへ移行したことに伴い、古い CPT の
 * リライトルール（`/room/` 等）が残っていると新しいカテゴリーアーカイブ
 * URL と競合するため、リライトルールを一度だけ再生成する。
 *
 * バージョン番号を保存したオプションで管理し、毎リクエストでの
 * flush_rewrite_rules() 実行（重い処理）を避ける。ルールを追加・変更した
 * ときは、このバージョン文字列を更新して再フラッシュを発火させること。
 */
function theme_flush_rewrite_rules_once(): void {
	$flush_version = '2025-room-page-fixed-page-v3';

	if ( get_option( 'theme_rewrite_flush_version' ) === $flush_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'theme_rewrite_flush_version', $flush_version );
}
add_action( 'init', 'theme_flush_rewrite_rules_once', 20 );

/**
 * ACF が無効なときに管理画面へ通知を出す。
 */
function theme_acf_admin_notice(): void {
	if ( function_exists( 'acf_add_local_field_group' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-warning">
		<p><?php echo esc_html( 'Advanced Custom Fields が有効化されていません。テーマの編集項目を利用するには ACF を有効化してください。' ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'theme_acf_admin_notice' );

/**
 * 管理画面でメニュー未設定のときに使うフォールバック。
 */
function theme_primary_menu_fallback(): void {
	theme_menu_fallback();
}

/**
 * 投稿一覧（客室・お知らせが混在する）にサムネイルと客室料金の列を追加する。
 *
 * カテゴリー方式では投稿一覧に客室とお知らせが混在するため、一覧の視認性を
 * 補うための最小限のカラム追加。並び順の変更 UI は並び順プラグイン
 * （Simple Custom Post Order 等）側の機能に委ねる。
 *
 * @param array<string, string> $columns 既存のカラム定義。
 * @return array<string, string>
 */
function theme_posts_list_columns( array $columns ): array {
	$new_columns = array();

	foreach ( $columns as $key => $label ) {
		$new_columns[ $key ] = $label;
		if ( 'title' === $key ) {
			$new_columns['theme_thumbnail'] = 'サムネイル';
		}
		if ( 'categories' === $key ) {
			$new_columns['theme_room_rate'] = '料金（平日）';
		}
	}

	return $new_columns;
}
add_filter( 'manage_post_posts_columns', 'theme_posts_list_columns' );

/**
 * 追加した投稿一覧カラムの中身を出力する。
 *
 * @param string $column  カラム識別子。
 * @param int    $post_id 投稿 ID。
 */
function theme_posts_list_column_content( string $column, int $post_id ): void {
	if ( 'theme_thumbnail' === $column ) {
		if ( has_post_thumbnail( $post_id ) ) {
			echo get_the_post_thumbnail( $post_id, array( 48, 48 ), array( 'style' => 'object-fit:cover;border-radius:4px' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_the_post_thumbnail() はコア側でエスケープ済みの HTML を返す。
		}
		return;
	}

	if ( 'theme_room_rate' === $column ) {
		if ( ! in_category( 'room', $post_id ) ) {
			echo esc_html( '—' );
			return;
		}
		$rate = (string) theme_content_meta( $post_id, 'room_rate_weekday', '' );
		echo esc_html( '' !== $rate ? $rate : '—' );
	}
}
add_action( 'manage_post_posts_custom_column', 'theme_posts_list_column_content', 10, 2 );
