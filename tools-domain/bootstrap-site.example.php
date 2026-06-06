<?php
/**
 * Safely bootstrap the Izakaya Local WordPress site.
 *
 * Run with:
 * THEME_BOOTSTRAP_CONFIRM=izakaya-local tools-domain/run-bootstrap-site.example.sh
 *
 * @package Izakaya
 */

declare(strict_types=1);

$config = array(
	'confirmation' => 'izakaya-local',
	'expected_url' => 'http://localhost:10018',
	'theme_slug'   => '0606wp-izakaya',
	'menus'        => array(
		'primary' => '居酒屋 メインナビゲーション',
		'footer'  => '居酒屋 フッターナビゲーション',
	),
	'options'      => array(
		'field_theme_shop_name'         => '居酒屋',
		'field_theme_shop_phone'        => '000-0000-0000',
		'field_theme_shop_contact_url'  => '/info/',
		'field_theme_shop_postcode'     => '〒000-0000',
		'field_theme_shop_address'      => '東京都何何区何々市何々町０−０−０',
		'field_theme_shop_hours'        => "火～土曜日17:00～2:00\n日曜日15:00～0:00",
		'field_theme_shop_closed'       => '月曜日',
		'field_theme_shop_map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1662873.2451231668!2d139.7698121!3d35.50924045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2z5p2x5Lqs6YO9!5e0!3m2!1sja!2sjp!4v1780738443365!5m2!1sja!2sjp',
		'field_theme_shop_instagram_url' => '#',
	),
	'front'        => array(
		'slug'     => 'home',
		'title'    => 'ホーム',
		'template' => 'page-templates/top.php',
		'meta'     => array(),
		'acf'      => array(
			'field_theme_front_heading'      => "焼酎をゆっくり楽しめる居酒屋です。\n落ち着いた雰囲気でゆっくりと焼酎を楽しめるお店です。\n当店では１００銘柄以上の焼酎を揃えていますので、\nお好みの香りや、味を言っていただければお客様に合った焼酎をご提供いたします。",
			'field_theme_front_lead'         => '日頃、焼酎をあまり飲まない方でもお気軽に立ち寄っていただき、焼酎についてなんでも質問してください。<br>店名はテーマ名に合わせて「居酒屋」としています。<br>是非、居酒屋でお好みの焼酎と出会い、素敵な時間をお過ごしください。',
			'field_theme_front_cta_label'    => '詳しく見る',
			'field_theme_front_other_eyebrow' => 'Other',
			'field_theme_front_other_heading'  => 'その他のお酒',
			'field_theme_front_other_url'      => '/other/',
			'field_theme_front_otsumami_eyebrow' => 'Otsumami',
			'field_theme_front_otsumami_heading'  => 'おつまみ',
			'field_theme_front_otsumami_url'      => '/otsumami/',
			'field_theme_front_section_body'   => '皆さんがよく見かける焼酎は<br>25度や20度のものが多いと思いますが、<br>それらの焼酎は原酒に水を加えることによって<br>度数を調整しています。<br>水や添加物を一切加えない状態のお酒のことを<br>原酒と呼びます。',
		),
	),
	'pages'        => array(
		array(
			'slug'     => 'genshu',
			'title'    => '焼酎の原酒',
			'template' => 'page-templates/genshu.php',
			'meta'     => array(),
			'acf'      => array(
				'field_theme_genshu_eyebrow'    => 'Genshu',
				'field_theme_genshu_heading'    => '焼酎の原酒',
				'field_theme_genshu_lead'       => '皆さんがよく見かける焼酎は25度や20度のものが多いと思いますが、<br>それらの焼酎は原酒に水を加えることによって度数を調整しています。<br>水や添加物を一切加えない状態のお酒のことを原酒と呼びます。<br>しっかりしたアルコール感に、単式蒸留という日本の蒸留技術が成せる<br>深い香り、味が特徴的です。<br>ぜひ飲んでみて、海外の蒸留酒にも全く引けをとらない、抜群の飲みごたえを感じてください。',
				'field_theme_genshu_cta_label'  => 'お問い合わせ',
				'field_theme_genshu_cta_url'    => '/info/',
			),
		),
		array(
			'slug'     => 'shochu',
			'title'    => '本格焼酎',
			'template' => 'page-templates/shochu.php',
			'meta'     => array(),
			'acf'      => array(
				'field_theme_shochu_eyebrow'    => 'Shochu',
				'field_theme_shochu_heading'    => '本格焼酎',
				'field_theme_shochu_section_heading' => '本格焼酎とは',
				'field_theme_shochu_lead'       => '当店で扱っている焼酎は本格焼酎と言われるものです。<br>連続式蒸留機を使用して純粋なアルコール分を取り出したものではなく<br>単式蒸留機を使用してじっくりと蒸留していくことで出来る焼酎で、本格焼酎には原料の芋、米、麦などの風味が豊かで、深い味わいが楽しめます。<br>ぜひ一度、じっくりと本格焼酎の深い味わいを楽しんでみてください。',
				'field_theme_shochu_cta_label'  => 'お問い合わせ',
				'field_theme_shochu_cta_url'    => '/info/',
				'field_theme_shochu_imo_heading' => '芋焼酎',
				'field_theme_shochu_imo_body'    => '芋焼酎は、九州地方発祥の贅沢な焼酎です。<br>その特徴は、芋の風味豊かな香りと滑らかな口当たり。<br>焼酎愛好家にとって、この芋焼酎は絶対に欠かせない逸品です。<br>伝統的な製法とこだわりの材料が、美味しさを引き立てます。<br>日本の文化と歴史を感じながら、<br>芋焼酎を楽しむ贅沢なひとときをお楽しみください。',
				'field_theme_shochu_mugi_heading' => '麦焼酎',
				'field_theme_shochu_mugi_body'    => '麦焼酎は、日本の伝統的な蒸留酒で、主に麦から作られます。<br>その滑らかな味わいと香りは、麦の風味を引き立て、多くの人々に愛されています。<br>飲み方は様々で、ストレートやお湯割り、カクテルのベースとして楽しまれます。<br>麦焼酎は日本酒と同様、日本の酒文化の一環として、<br>料理との相性も抜群で、日本の食事をより楽しいものにします。',
				'field_theme_shochu_kome_heading' => '米焼酎',
				'field_theme_shochu_kome_body'   => '米焼酎は、日本の蒸留酒の一つで、主に米から醸造されます。<br>その特徴は、穏やかな風味とクリーンな味わい。<br>米の独特の甘さと香りを楽しむことができ、<br>ロックや水割り、カクテルのベースとして幅広い楽しみ方があります。<br>日本料理との相性が抜群で、豊かな米の風味と料理の組み合わせは、<br>日本食の愛好者にとって極上の経験となります。',
				'field_theme_shochu_kokuto_heading' => '黒糖焼酎',
				'field_theme_shochu_kokuto_body'   => '黒糖焼酎は、サトウキビの黒糖から醸造される、深い甘さとコクを持つ焼酎です。',
				'field_theme_shochu_other_heading' => 'その他の焼酎',
				'field_theme_shochu_other_body'   => '焼酎は主要原料をベースに色々なものから造られます。<br>ちょっと変わった味の焼酎を是非味わってみてください。',
			),
		),
		array(
			'slug'     => 'other',
			'title'    => 'その他のお酒',
			'template' => 'page-templates/other.php',
			'meta'     => array(),
			'acf'      => array(
				'field_theme_other_eyebrow'    => 'Other',
				'field_theme_other_heading'    => 'その他のお酒',
				'field_theme_other_section_heading' => 'その他のお酒',
				'field_theme_other_cta_label'   => 'お問い合わせ',
				'field_theme_other_cta_url'     => '/info/',
			),
		),
		array(
			'slug'     => 'otsumami',
			'title'    => 'おつまみ',
			'template' => 'page-templates/otsumami.php',
			'meta'     => array(),
			'acf'      => array(
				'field_theme_otsumami_eyebrow'    => 'Otsumami',
				'field_theme_otsumami_heading'    => 'おつまみ',
				'field_theme_otsumami_section_body' => '卓上用の小さなコンロを使い炭火で炙っておつまみをお召し上がりいただけます。<br>じっくりと炭火で炙ったおつまみを食べながら焼酎を飲み、贅沢な時間を過ごして下さい。',
				'field_theme_otsumami_cta_label'  => 'お問い合わせ',
				'field_theme_otsumami_cta_url'    => '/info/',
			),
		),
		array(
			'slug'     => 'insta',
			'title'    => 'お知らせ',
			'template' => 'page-templates/insta.php',
			'meta'     => array(),
			'acf'      => array(
				'field_theme_insta_eyebrow'    => 'Instagram',
				'field_theme_insta_heading'    => 'お知らせ',
				'field_theme_insta_lead'       => '焼酎の紹介や予約状況などを日々更新しています。<br>画像をクリックするとInstagramに移動しますので合わせてご利用ください。',
			),
		),
		array(
			'slug'     => 'info',
			'title'    => '店舗案内',
			'template' => 'page-templates/info.php',
			'meta'     => array(),
			'acf'      => array(
				'field_theme_info_eyebrow'    => 'Info',
				'field_theme_info_heading'    => '店舗案内',
				'field_theme_info_section_heading' => '居酒屋',
			),
		),
	),
	/*
	 * Add records after the theme registers the corresponding post type and
	 * taxonomy. Stable keys prevent duplicate posts on repeated execution.
	 */
	'content'      => array(
		/*
		array(
			'post_type' => 'news',
			'stable_key' => 'opening-notice',
			'title' => '営業のお知らせ',
			'content' => '',
			'menu_order' => 0,
			'meta' => array(),
			'terms' => array(
				'news_category' => array(
					array( 'slug' => 'instagram', 'name' => 'Instagram' ),
				),
			),
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

function theme_tools_upsert_term( string $taxonomy, array $term ): int {
	if ( ! taxonomy_exists( $taxonomy ) ) {
		theme_tools_fail( "taxonomy が登録されていません: {$taxonomy}" );
	}

	$existing = get_term_by( 'slug', $term['slug'], $taxonomy );
	if ( $existing instanceof WP_Term ) {
		return (int) $existing->term_id;
	}

	$result = wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'] ) );
	if ( is_wp_error( $result ) ) {
		theme_tools_fail( "taxonomy term を作成できませんでした: {$taxonomy}/{$term['slug']}" );
	}

	return (int) $result['term_id'];
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

	foreach ( $item['terms'] ?? array() as $taxonomy => $terms ) {
		$term_ids = array();
		foreach ( $terms as $term ) {
			$term_ids[] = theme_tools_upsert_term( (string) $taxonomy, $term );
		}
		wp_set_object_terms( $post_id, $term_ids, (string) $taxonomy, true );
	}

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
