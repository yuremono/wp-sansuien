<?php
/**
 * Safely bootstrap the Sansuien Local WordPress site.
 *
 * Run with:
 * THEME_BOOTSTRAP_CONFIRM=sansuien-local tools-domain/run-bootstrap-site.example.sh
 *
 * @package Theme
 */

declare(strict_types=1);

$config = array(
	'confirmation' => 'sansuien-local',
	'expected_url' => 'http://localhost:10023',
	'theme_slug'   => 'sansuien',
	'menus'        => array(
		'primary' => '山翠苑 メインナビゲーション',
		'footer'  => '山翠苑 フッターナビゲーション',
	),
	'options'      => array(
		'field_theme_shop_name'            => '山翠苑',
		'field_theme_shop_phone'           => '0261-00-0000',
		'field_theme_shop_contact_url'     => '#reserve',
		'field_theme_shop_address'         => '長野県青木湖畔 ○○温泉郷',
		'field_theme_shop_access_note'     => 'JR大糸線「簗場駅」より送迎バスで約8分(要予約)',
		'field_theme_shop_reception_hours' => '9:00〜18:00',
		'field_theme_shop_instagram_url'   => '#',
	),
	'front'        => array(
		'slug'     => 'home',
		'title'    => 'ホーム',
		'template' => 'page-templates/top.php',
		'meta'     => array(),
		'acf'      => array(
			'field_theme_front_hero_eyebrow'   => 'HAVE A QUIET TIME BY THE LAKE — EST. 1972',
			'field_theme_front_hero_heading'   => "水と緑に抱かれて、\n心をほどく一夜を。",
			'field_theme_front_hero_lead'      => "湖畔にたたずむ全十二室の小さな宿。\n季節の湯と土地の恵みで、静かな時間をご用意しております。",
			'field_theme_front_rooms_heading'  => "湖に向かって開かれた、\n全十二室のしつらえ。",
			'field_theme_front_rooms_body'     => '露天風呂付き特別室「蒼」をはじめ、湖viewの和洋室、庭園沿いの和室まで。どの部屋も窓の外の景色を主役に、余計なものを置かないしつらえです。',
			'field_theme_front_onsen_heading'  => "湯けむりの向こうに、\n湖と山のいとなみ。",
			'field_theme_front_onsen_body'     => '大浴場と展望風呂のほか、貸切の露天風呂をご用意。朝は湖面の霧、夜は星空。季節と時間で表情を変える湯浴みをお楽しみください。',
			'field_theme_front_cuisine_heading' => "土地の恵みを、\n囲炉裏の火とともに。",
			'field_theme_front_cuisine_body'   => '信州の山菜や湖の幸を中心にした季節の会席。夕食後は炭火の灯る囲炉裏ラウンジで、地酒とともにゆっくりとお過ごしください。',
			'field_theme_front_about_heading'  => "創業から半世紀、\n湖畔とともに。",
			'field_theme_front_about_body'     => '創業から半世紀、湖畔の自然と地元の恵みを活かしたおもてなしを大切にしてまいりました。派手さはございませんが、また帰ってきたくなる——そんな宿でありたいと願っております。',
			'field_theme_front_about_okami_name' => '川井 美和子',
			'field_theme_front_about_okami_role' => 'OKAMI 女将',
			'field_theme_front_about_chef_name'  => '佐伯 隆',
			'field_theme_front_about_chef_role'  => 'ITACHO 板長',
		),
	),
	/*
	 * 山翠苑では追加の固定ページを使わない
	 * （トップページ内アンカーと客室CPTの一覧/個別だけで全ページを再現できる）。
	 */
	'pages'        => array(),
	/*
	 * Add records after the theme registers the corresponding post type.
	 * Stable keys prevent duplicate posts on repeated execution.
	 * 静的ソース tmp/sansuien/preview/room.html, index.html から抽出した実データ。
	 */
	'content'      => array(
		array(
			'category'   => 'room',
			'stable_key' => 'room-ao',
			'title'      => '露天風呂付き特別室「蒼」',
			'content'    => '湖を望む角部屋に配した、当宿で最も人気の高い特別室です。専用の露天風呂からは四季折々の湖畔の景色をひとり占めいただけます。テラスにご用意した籐椅子で、朝の澄んだ空気とともにゆったりとした時間をお過ごしください。',
			'menu_order' => 0,
			'thumbnail'  => 'images/room2.jpg',
			'gallery'    => array(
				'room_gallery_1' => 'images/room1.jpg',
				'room_gallery_2' => 'images/bath.jpg',
				'room_gallery_3' => 'images/lake2.jpg',
				'room_gallery_4' => 'images/kaiseki.jpg',
			),
			'meta'       => array(
				'room_catch'        => 'Special Room "AO"',
				'room_tags'         => '貸切露天風呂付,湖側テラス,禁煙,Wi-Fi完備',
				'room_size'         => '52㎡(和洋室)',
				'room_amenities'    => '貸切露天風呂・冷蔵庫・空気清浄機・浴衣2枚',
				'room_checkin_out'  => '15:00〜 / 11:00まで',
				'room_rate_weekday' => '¥32,000〜',
				'room_rate_holiday' => '¥38,000〜',
				'room_capacity'     => '2〜3名',
			),
		),
		array(
			'category'   => 'room',
			'stable_key' => 'room-lakeview',
			'title'      => '湖view客室・和洋室',
			'content'    => '',
			'menu_order' => 1,
			'thumbnail'  => 'images/room2.jpg',
			'meta'       => array(
				'room_rate_weekday' => '¥24,000〜',
			),
		),
		array(
			'category'   => 'room',
			'stable_key' => 'room-garden',
			'title'      => '庭園沿い和室',
			'content'    => '',
			'menu_order' => 2,
			'thumbnail'  => 'images/room3.jpg',
			'meta'       => array(
				'room_rate_weekday' => '¥18,000〜',
			),
		),
		array(
			'category'   => 'room',
			'stable_key' => 'room-standard',
			'title'      => 'スタンダード和室',
			'content'    => '',
			'menu_order' => 3,
			'thumbnail'  => 'images/room1.jpg',
			'meta'       => array(
				'room_rate_weekday' => '¥15,000〜',
			),
		),
		array(
			'category'   => 'news',
			'stable_key' => 'news-hotaru',
			'title'      => '夏季限定「蛍狩りプラン」販売開始のお知らせ',
			'content'    => '',
			'menu_order' => 0,
			'post_date'  => '2026-07-01 09:00:00',
			'thumbnail'  => 'images/lake2.jpg',
			'meta'       => array(),
		),
		array(
			'category'   => 'news',
			'stable_key' => 'news-wifi',
			'title'      => '館内Wi-Fi環境をリニューアルいたしました',
			'content'    => '',
			'menu_order' => 0,
			'post_date'  => '2026-06-20 09:00:00',
			'thumbnail'  => 'images/room1.jpg',
			'meta'       => array(),
		),
		array(
			'category'   => 'news',
			'stable_key' => 'news-obon',
			'title'      => 'お盆期間の営業時間についてのお知らせ',
			'content'    => '',
			'menu_order' => 0,
			'post_date'  => '2026-06-05 09:00:00',
			'thumbnail'  => 'images/breakfast.jpg',
			'meta'       => array(),
		),
	),
);

$expected_confirmation = getenv( 'THEME_BOOTSTRAP_EXPECTED_CONFIRM' );
if ( is_string( $expected_confirmation ) && '' !== $expected_confirmation ) {
	$config['confirmation'] = $expected_confirmation;
}

$expected_url = getenv( 'THEME_BOOTSTRAP_EXPECTED_URL' );
if ( is_string( $expected_url ) && '' !== $expected_url ) {
	$config['expected_url'] = $expected_url;
}

function theme_tools_expand_path( string $path ): string {
	$path = trim( $path );
	if ( str_starts_with( $path, '~' ) ) {
		$home = getenv( 'HOME' );
		return is_string( $home ) && '' !== $home ? $home . substr( $path, 1 ) : $path;
	}

	return $path;
}

function theme_tools_resolve_wp_load(): string {
	$env = getenv( 'WP_LOAD_PATH' );
	if ( is_string( $env ) && '' !== $env ) {
		return theme_tools_expand_path( $env );
	}

	$config_file = dirname( __DIR__ ) . '/tools/local-wp-load.path';
	if ( ! is_readable( $config_file ) ) {
		return '';
	}

	foreach ( preg_split( "/\r\n|\n|\r/", (string) file_get_contents( $config_file ) ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line && ! str_starts_with( $line, '#' ) ) {
			return theme_tools_expand_path( $line );
		}
	}

	return '';
}

function theme_tools_fail( string $message ): void {
	fwrite( STDERR, "ERROR: {$message}\n" );
	exit( 1 );
}

if ( ! defined( 'ABSPATH' ) ) {
	$wp_load = theme_tools_resolve_wp_load();
	if ( '' === $wp_load || ! is_readable( $wp_load ) ) {
		theme_tools_fail( 'wp-load.php が見つかりません。WP_LOAD_PATH または tools/local-wp-load.path を確認してください。' );
	}

	require $wp_load;
}

$confirmation = getenv( 'THEME_BOOTSTRAP_CONFIRM' );
if ( $config['confirmation'] !== $confirmation ) {
	theme_tools_fail( "実行確認がありません。THEME_BOOTSTRAP_CONFIRM={$config['confirmation']} を指定してください。" );
}

$actual_url = untrailingslashit( (string) get_option( 'home' ) );
if ( untrailingslashit( $config['expected_url'] ) !== $actual_url ) {
	theme_tools_fail( "対象URLが一致しません。expected={$config['expected_url']} actual={$actual_url}" );
}

$theme = wp_get_theme( $config['theme_slug'] );
if ( ! $theme->exists() ) {
	theme_tools_fail( "テーマが見つかりません: {$config['theme_slug']}" );
}

if ( get_stylesheet() !== $config['theme_slug'] ) {
	switch_theme( $config['theme_slug'] );
	if ( get_stylesheet() !== $config['theme_slug'] ) {
		theme_tools_fail( "テーマを有効化できませんでした: {$config['theme_slug']}" );
	}
}

function theme_tools_is_empty( $value ): bool {
	return '' === $value || null === $value || false === $value || array() === $value;
}

function theme_tools_fill_empty_meta( int $post_id, array $meta ): void {
	foreach ( $meta as $key => $value ) {
		$current = get_post_meta( $post_id, (string) $key, true );
		if ( theme_tools_is_empty( $current ) && ! theme_tools_is_empty( $value ) ) {
			update_post_meta( $post_id, (string) $key, $value );
		}
	}
}

function theme_tools_fill_empty_acf_fields( $target, array $fields ): void {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	foreach ( $fields as $field_key => $value ) {
		$current = function_exists( 'get_field' ) ? get_field( (string) $field_key, $target ) : null;
		if ( theme_tools_is_empty( $current ) && ! theme_tools_is_empty( $value ) ) {
			update_field( (string) $field_key, $value, $target );
		}
	}
}

function theme_tools_upsert_page( array $definition ): int {
	$page = get_page_by_path( $definition['slug'], OBJECT, 'page' );

	if ( $page instanceof WP_Post ) {
		$page_id = (int) $page->ID;
	} else {
		$page_id = wp_insert_post(
			wp_slash(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_title'  => $definition['title'],
					'post_name'   => $definition['slug'],
				)
			),
			true
		);
		if ( is_wp_error( $page_id ) || ! $page_id ) {
			theme_tools_fail( "固定ページを作成できませんでした: {$definition['title']}" );
		}
		$page_id = (int) $page_id;
	}

	$current_template = (string) get_post_meta( $page_id, '_wp_page_template', true );
	if ( '' === $current_template || 'default' === $current_template ) {
		update_post_meta( $page_id, '_wp_page_template', $definition['template'] );
	}

	theme_tools_fill_empty_meta( $page_id, $definition['meta'] ?? array() );

	return $page_id;
}

function theme_tools_find_menu_item( int $menu_id, int $object_id ): bool {
	foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
		if ( $item instanceof WP_Post && 'page' === $item->object && $object_id === (int) $item->object_id ) {
			return true;
		}
	}

	return false;
}

function theme_tools_find_menu_item_by_title( int $menu_id, string $title ): bool {
	foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
		if ( $item instanceof WP_Post && $title === $item->title ) {
			return true;
		}
	}

	return false;
}

/**
 * @param array<int, array{id:int,title:string}>   $pages 固定ページをメニューへ追加する場合の一覧。
 * @param array<int, array{title:string,url:string}> $links アンカーやCPTアーカイブなどカスタムURLリンクの一覧。
 */
function theme_tools_sync_menu( string $location, string $menu_name, array $pages, array $links = array() ): int {
	$menu    = wp_get_nav_menu_object( $menu_name );
	$menu_id = $menu instanceof WP_Term ? (int) $menu->term_id : (int) wp_create_nav_menu( $menu_name );
	if ( ! $menu_id ) {
		theme_tools_fail( "メニューを作成できませんでした: {$menu_name}" );
	}

	foreach ( $pages as $page ) {
		if ( theme_tools_find_menu_item( $menu_id, $page['id'] ) ) {
			continue;
		}

		$result = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $page['title'],
				'menu-item-object-id' => $page['id'],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
		if ( is_wp_error( $result ) ) {
			theme_tools_fail( "メニュー項目を追加できませんでした: {$page['title']}" );
		}
	}

	foreach ( $links as $link ) {
		if ( theme_tools_find_menu_item_by_title( $menu_id, $link['title'] ) ) {
			continue;
		}

		$result = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => $link['title'],
				'menu-item-url'    => $link['url'],
				'menu-item-type'   => 'custom',
				'menu-item-status' => 'publish',
			)
		);
		if ( is_wp_error( $result ) ) {
			theme_tools_fail( "メニュー項目を追加できませんでした: {$link['title']}" );
		}
	}

	$locations              = get_nav_menu_locations();
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	return $menu_id;
}

/**
 * テーマ同梱画像(assets/<相対パス>)をメディアライブラリへ非破壊でインポートし、添付ID を返す。
 * 同一相対パスは _theme_seed_source_path で照合し、二重インポートしない。
 */
function theme_tools_import_theme_image( string $relative_path ): int {
	static $cache = array();
	if ( isset( $cache[ $relative_path ] ) ) {
		return $cache[ $relative_path ];
	}

	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_theme_seed_source_path',
			'meta_value'     => $relative_path,
		)
	);
	if ( $existing ) {
		$cache[ $relative_path ] = (int) $existing[0];
		return $cache[ $relative_path ];
	}

	$file_path = get_template_directory() . '/assets/' . ltrim( $relative_path, '/' );
	if ( ! is_readable( $file_path ) ) {
		$cache[ $relative_path ] = 0;
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$upload = wp_upload_bits( basename( $file_path ), null, (string) file_get_contents( $file_path ) );
	if ( ! empty( $upload['error'] ) ) {
		$cache[ $relative_path ] = 0;
		return 0;
	}

	$filetype   = wp_check_filetype( $upload['file'], null );
	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_file_name( basename( $file_path ) ),
			'post_status'    => 'inherit',
		),
		$upload['file']
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		$cache[ $relative_path ] = 0;
		return 0;
	}

	$attachment_id = (int) $attachment_id;
	$metadata      = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
	wp_update_attachment_metadata( $attachment_id, $metadata );
	update_post_meta( $attachment_id, '_theme_seed_source_path', $relative_path );

	$cache[ $relative_path ] = $attachment_id;
	return $attachment_id;
}

function theme_tools_upsert_content( array $item ): int {
	$category_slug = (string) $item['category'];
	$term          = get_term_by( 'slug', $category_slug, 'category' );
	if ( ! ( $term instanceof WP_Term ) ) {
		theme_tools_fail( "カテゴリーが見つかりません: {$category_slug}（テーマ有効化後に theme_ensure_content_categories() で作成されるはずです）" );
	}

	$existing = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_theme_seed_key',
			'meta_value'     => $item['stable_key'],
		)
	);
	$post_id  = $existing ? (int) $existing[0] : 0;

	if ( ! $post_id ) {
		$post_args = array(
			'post_type'    => 'post',
			'post_status'  => 'publish',
			'post_title'   => $item['title'],
			'post_name'    => $item['stable_key'],
			'post_content' => $item['content'] ?? '',
			'menu_order'   => (int) ( $item['menu_order'] ?? 0 ),
		);
		if ( ! empty( $item['post_date'] ) ) {
			$post_args['post_date']     = $item['post_date'];
			$post_args['post_date_gmt'] = get_gmt_from_date( $item['post_date'] );
		}

		$post_id = wp_insert_post( wp_slash( $post_args ), true );
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			theme_tools_fail( "初期投稿を作成できませんでした: {$category_slug}/{$item['stable_key']}" );
		}
		$post_id = (int) $post_id;
		update_post_meta( $post_id, '_theme_seed_key', $item['stable_key'] );
		wp_set_post_categories( $post_id, array( (int) $term->term_id ), false );
	}

	theme_tools_fill_empty_meta( $post_id, $item['meta'] ?? array() );

	if ( ! empty( $item['thumbnail'] ) && ! has_post_thumbnail( $post_id ) ) {
		$attachment_id = theme_tools_import_theme_image( (string) $item['thumbnail'] );
		if ( $attachment_id ) {
			set_post_thumbnail( $post_id, $attachment_id );
		}
	}

	if ( ! empty( $item['gallery'] ) && is_array( $item['gallery'] ) ) {
		$gallery_meta = array();
		foreach ( $item['gallery'] as $field_name => $gallery_relative_path ) {
			$attachment_id = theme_tools_import_theme_image( (string) $gallery_relative_path );
			if ( $attachment_id ) {
				$gallery_meta[ (string) $field_name ] = $attachment_id;
			}
		}
		theme_tools_fill_empty_acf_fields( $post_id, $gallery_meta );
	}

	return $post_id;
}

$front_id = theme_tools_upsert_page( $config['front'] );
theme_tools_fill_empty_acf_fields( 'option', $config['options'] ?? array() );
theme_tools_fill_empty_acf_fields( $front_id, $config['front']['acf'] ?? array() );
/*
 * ブランドロゴ(header/footerのtheme_source_uri)が既にホームリンクの役割を持つため、
 * ホームページ自体はナビメニューへ追加しない。
 */
$pages    = array();

foreach ( $config['pages'] as $definition ) {
	$pages[] = array(
		'id'    => theme_tools_upsert_page( $definition ),
		'title' => $definition['title'],
	);
	theme_tools_fill_empty_acf_fields( $pages[ count( $pages ) - 1 ]['id'], $definition['acf'] ?? array() );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $front_id );

/*
 * ヘッダー・フッター共通ナビ。客室のご案内は「客室」カテゴリーのアーカイブ、他はトップページ内アンカー。
 * 静的ソース tmp/sansuien/preview/index.html の <nav class="gnav"> / <nav class="fnav"> に対応。
 */
$room_archive_url = theme_category_url( 'room', home_url( '/room/' ) );
$nav_links         = array(
	array(
		'title' => '客室のご案内',
		'url'   => $room_archive_url,
	),
	array(
		'title' => '館内施設',
		'url'   => home_url( '/#feature' ),
	),
	array(
		'title' => 'アクセス',
		'url'   => home_url( '/#access' ),
	),
	array(
		'title' => 'お知らせ',
		'url'   => home_url( '/#news' ),
	),
);

$menu_ids = array();
foreach ( $config['menus'] as $location => $menu_name ) {
	$menu_ids[ $location ] = theme_tools_sync_menu( $location, $menu_name, $pages, $nav_links );
}

$content_ids = array();
foreach ( $config['content'] as $item ) {
	$content_ids[] = theme_tools_upsert_content( $item );
}

flush_rewrite_rules( false );

echo "OK: site bootstrapped without deleting existing content.\n";
echo 'site_url=' . esc_url_raw( $actual_url ) . "\n";
echo "front_id={$front_id}\n";
echo 'menu_ids=' . wp_json_encode( $menu_ids ) . "\n";
echo 'content_ids=' . wp_json_encode( $content_ids ) . "\n";
