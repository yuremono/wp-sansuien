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
	 */
	'content'      => array(
		/*
		array(
			'post_type'  => 'room',
			'stable_key' => 'room-ao',
			'title'      => '露天風呂付き特別室「蒼」',
			'content'    => '湖を望む角部屋に配した、当宿で最も人気の高い特別室です。',
			'menu_order' => 0,
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
			'post_type'  => 'news',
			'stable_key' => 'opening-notice',
			'title'      => '夏季限定「蛍狩りプラン」販売開始のお知らせ',
			'content'    => '',
			'menu_order' => 0,
			'meta'       => array(),
		),
		*/
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

function theme_tools_sync_menu( string $location, string $menu_name, array $pages ): int {
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

	$locations              = get_nav_menu_locations();
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	return $menu_id;
}

function theme_tools_upsert_content( array $item ): int {
	$post_type = (string) $item['post_type'];
	if ( ! post_type_exists( $post_type ) ) {
		theme_tools_fail( "CPT が登録されていません: {$post_type}" );
	}

	$existing = get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_theme_seed_key',
			'meta_value'     => $item['stable_key'],
		)
	);
	$post_id  = $existing ? (int) $existing[0] : 0;

	if ( ! $post_id ) {
		$post_id = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => $post_type,
					'post_status'  => 'publish',
					'post_title'   => $item['title'],
					'post_content' => $item['content'] ?? '',
					'menu_order'   => (int) ( $item['menu_order'] ?? 0 ),
				)
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			theme_tools_fail( "CPT初期投稿を作成できませんでした: {$post_type}/{$item['stable_key']}" );
		}
		$post_id = (int) $post_id;
		update_post_meta( $post_id, '_theme_seed_key', $item['stable_key'] );
	}

	theme_tools_fill_empty_meta( $post_id, $item['meta'] ?? array() );

	return $post_id;
}

$front_id = theme_tools_upsert_page( $config['front'] );
theme_tools_fill_empty_acf_fields( 'option', $config['options'] ?? array() );
theme_tools_fill_empty_acf_fields( $front_id, $config['front']['acf'] ?? array() );
$pages    = array(
	array(
		'id'    => $front_id,
		'title' => $config['front']['title'],
	),
);

foreach ( $config['pages'] as $definition ) {
	$pages[] = array(
		'id'    => theme_tools_upsert_page( $definition ),
		'title' => $definition['title'],
	);
	theme_tools_fill_empty_acf_fields( $pages[ count( $pages ) - 1 ]['id'], $definition['acf'] ?? array() );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $front_id );

$menu_ids = array();
foreach ( $config['menus'] as $location => $menu_name ) {
	$menu_ids[ $location ] = theme_tools_sync_menu( $location, $menu_name, $pages );
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
