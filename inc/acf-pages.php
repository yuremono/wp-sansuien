<?php
/**
 * ACF フィールド登録。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF が options page に対応している場合だけ共通設定ページを登録する。
 */
function theme_register_acf_options_page(): void {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	// 管理画面の共通設定ページを追加する。
	acf_add_options_page(
		array(
			'page_title' => '宿泊施設共通情報',
			'menu_title' => '宿泊施設共通情報',
			'menu_slug'  => 'theme-shop-settings',
			'capability' => 'edit_theme_options',
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', 'theme_register_acf_options_page', 5 );

/**
 * 安定した ACF フィールド定義を組み立てる。
 *
 * @param string $key フィールドキーの末尾。
 * @param string $label 管理画面ラベル。
 * @param string $name メタキー名。
 * @param string $type ACF フィールド型。
 * @param array  $extra 追加設定。
 * @return array<string, mixed>
 */
function theme_acf_field( string $key, string $label, string $name, string $type = 'text', array $extra = array() ): array {
	return array_merge(
		array(
			'key'   => 'field_theme_' . $key,
			'label' => $label,
			'name'  => $name,
			'type'  => $type,
		),
		$extra
	);
}

/**
 * 画像フィールドの共通設定を組み立てる。
 *
 * @param string $key フィールドキーの末尾。
 * @param string $label 管理画面ラベル。
 * @param string $name メタキー名。
 * @return array<string, mixed>
 */
function theme_acf_image_field( string $key, string $label, string $name ): array {
	return theme_acf_field(
		$key,
		$label,
		$name,
		'image',
		array(
			'return_format' => 'id',
			'preview_size'  => 'medium',
		)
	);
}

/**
 * Gallery フィールドの共通設定を組み立てる。
 *
 * ACF 無料版には Gallery / Repeater フィールド型がない。Secure Custom Fields
 * （WordPress.org 公式の無料 ACF 互換プラグイン）か ACF PRO の導入を前提とする。
 * 未導入の環境でも fatal error にはならず、管理画面にフィールド型未対応の
 * 表示が出るだけで済む。
 *
 * @param string $key フィールドキーの末尾。
 * @param string $label 管理画面ラベル。
 * @param string $name メタキー名。
 * @return array<string, mixed>
 */
function theme_acf_gallery_field( string $key, string $label, string $name ): array {
	return theme_acf_field(
		$key,
		$label,
		$name,
		'gallery',
		array(
			'return_format' => 'array',
			'preview_size'  => 'medium',
		)
	);
}

/**
 * 管理画面をタブ切り替え UI にするための ACF タブ区切りフィールドを組み立てる。
 *
 * @param string $key   フィールドキーの末尾。
 * @param string $label タブのラベル。
 * @return array<string, mixed>
 */
function theme_acf_tab( string $key, string $label ): array {
	return array(
		'key'   => 'field_theme_tab_' . $key,
		'label' => $label,
		'name'  => '',
		'type'  => 'tab',
	);
}

/**
 * スラッグから ACF の page location ルールを組み立てる。
 *
 * `page-{slug}.php` はテンプレート階層により自動適用されるため
 * `_wp_page_template` を持たず、ACF 標準の `page_template` location では
 * 検知できない。固定ページ ID を直接解決し `page` location ルールへ変換する。
 * ページ未作成時（テーマ有効化直後など）は空の location を返し、
 * フィールドグループがどの画面にも表示されないフェイルセーフにする。
 *
 * @param string $slug 固定ページのスラッグ。
 * @return array<int, array<int, array<string, string>>>
 */
function theme_acf_page_location( string $slug ): array {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( ! ( $page instanceof WP_Post ) ) {
		return array();
	}

	return array(
		array(
			array(
				'param'    => 'page',
				'operator' => '==',
				'value'    => (string) $page->ID,
			),
		),
	);
}

/**
 * カテゴリースラッグから ACF の post_category location ルールを組み立てる。
 *
 * post_category location ルールは term_id を要求するため、カテゴリーを
 * 動的に解決する。カテゴリー未作成時（テーマ有効化直後など）は空の
 * location を返し、フィールドグループがどの画面にも表示されないよう
 * フェイルセーフにする（fatal error にはならない）。
 *
 * @param string $slug カテゴリースラッグ。
 * @return array<int, array<int, array<string, string>>>
 */
function theme_acf_category_location( string $slug ): array {
	$term = get_term_by( 'slug', $slug, 'category' );
	if ( ! ( $term instanceof WP_Term ) ) {
		return array();
	}

	return array(
		array(
			array(
				'param'    => 'post_category',
				'operator' => '==',
				'value'    => (string) $term->term_id,
			),
		),
	);
}

/**
 * ページ別、共通、投稿カテゴリー別のフィールドグループを登録する。
 */
function theme_register_acf_fields(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// まず、宿泊施設全体で使う共通設定を登録する。
	acf_add_local_field_group(
		array(
			'key'      => 'group_theme_shop_settings',
			'title'    => '宿泊施設共通情報',
			'fields'   => array(
				theme_acf_field( 'shop_name', '施設名', 'shop_name', 'text', array( 'default_value' => THEME_BRAND_DEFAULT ) ),
				theme_acf_field( 'shop_phone', '電話番号', 'shop_phone', 'text', array( 'default_value' => theme_demo_content( 'shop_phone' ) ) ),
				theme_acf_field( 'shop_contact_url', 'ご予約・お問い合わせURL', 'shop_contact_url', 'url', array( 'default_value' => theme_demo_content( 'shop_contact_url' ) ) ),
				theme_acf_field(
					'shop_contact_form_id',
					'お問い合わせフォームのID',
					'shop_contact_form_id',
					'number',
					array(
						'instructions' => '「お問い合わせ」→「コンタクトフォーム」の一覧に表示されているID番号を入力してください。空欄の場合はフォームのタイトル（変更しないでください）で自動検索します。',
					)
				),
				theme_acf_field(
					'shop_address',
					'所在地',
					'shop_address',
					'textarea',
					array(
						'rows'          => 2,
						'default_value' => theme_demo_content( 'shop_address' ),
					)
				),
				theme_acf_field(
					'shop_access_note',
					'アクセス補足',
					'shop_access_note',
					'textarea',
					array(
						'rows'          => 2,
						'default_value' => theme_demo_content( 'shop_access_note' ),
					)
				),
				theme_acf_field( 'shop_reception_hours', '電話受付時間', 'shop_reception_hours', 'text', array( 'default_value' => theme_demo_content( 'shop_reception_hours' ) ) ),
				theme_acf_field(
					'shop_map_embed_url',
					'Googleマップ 埋め込みURL',
					'shop_map_embed_url',
					'url',
					array(
						'instructions'  => 'Googleマップで地図を表示し「共有」→「地図を埋め込む」を開いて、表示されたiframeタグ内の src="..." のURLだけをコピーして貼り付けてください。表示範囲（縮尺・中心位置）はGoogleマップ側で調整してから埋め込みURLを取得します。',
						'default_value' => theme_demo_content( 'shop_map_embed_url' ),
					)
				),
				theme_acf_field( 'shop_instagram_url', 'Instagram URL', 'shop_instagram_url', 'url' ),
				theme_acf_field(
					'shop_privacy_policy_content',
					'プライバシーポリシー本文',
					'shop_privacy_policy_content',
					'wysiwyg',
					array(
						'instructions' => 'お問い合わせフォームの同意チェックから開くモーダルに表示される本文です。空欄の場合はテーマ内の標準文面が表示されます。',
						'tabs'         => 'visual',
						'toolbar'      => 'basic',
						'media_upload' => 0,
					)
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'theme-shop-settings',
					),
				),
			),
		)
	);

	// 次に、トップページの編集項目を登録する（タブ UI で画面を分割）。
	$front_fields = array(
		theme_acf_tab( 'front_hero', 'ヒーロー' ),
		theme_acf_field( 'front_hero_eyebrow', '英字コピー', 'front_hero_eyebrow', 'text', array( 'default_value' => theme_demo_content( 'front_hero_eyebrow' ) ) ),
		theme_acf_field( 'front_hero_heading', '見出し', 'front_hero_heading', 'textarea', array(
			'rows'          => 2,
			'default_value' => theme_demo_content( 'front_hero_heading' ),
		) ),
		theme_acf_field( 'front_hero_lead', 'リード文', 'front_hero_lead', 'textarea', array(
			'rows'          => 2,
			'default_value' => theme_demo_content( 'front_hero_lead' ),
		) ),
		theme_acf_image_field( 'front_hero_image', 'メインビジュアル', 'front_hero_image' ),
		theme_acf_tab( 'front_gallery', 'ギャラリー' ),
		theme_acf_gallery_field( 'front_gallery_images', 'ギャラリー画像（枚数自由）', 'front_gallery_images' ),
		theme_acf_tab( 'front_voices', 'お客様の声' ),
		array(
			'key'          => 'field_theme_front_voices',
			'label'        => 'お客様の声（件数自由）',
			'name'         => 'front_voices',
			'type'         => 'repeater',
			'instructions' => '「行を追加」で件数を増減できます。',
			'layout'       => 'block',
			'button_label' => '声を追加',
			'sub_fields'   => array(
				theme_acf_field(
					'front_voices_stars',
					'評価（星の数）',
					'stars',
					'select',
					array(
						'choices'       => array(
							'5' => '★★★★★',
							'4' => '★★★★☆',
							'3' => '★★★☆☆',
						),
						'default_value' => '5',
					)
				),
				theme_acf_field( 'front_voices_comment', 'コメント', 'comment', 'textarea', array( 'rows' => 3 ) ),
				theme_acf_field( 'front_voices_who', '属性（例: 40代・ご夫婦での利用）', 'who', 'text' ),
			),
		),
	);

	// 館内の過ごし方（ROOMS / ONSEN / CUISINE）3ブロック分をまとめて組み立てる。
	$feature_blocks = array(
		'rooms'   => array(
			'label'   => 'ROOMS',
			'heading' => theme_demo_content( 'front_rooms_heading' ),
			'body'    => theme_demo_content( 'front_rooms_body' ),
		),
		'onsen'   => array(
			'label'   => 'ONSEN',
			'heading' => theme_demo_content( 'front_onsen_heading' ),
			'body'    => theme_demo_content( 'front_onsen_body' ),
		),
		'cuisine' => array(
			'label'   => 'CUISINE',
			'heading' => theme_demo_content( 'front_cuisine_heading' ),
			'body'    => theme_demo_content( 'front_cuisine_body' ),
		),
	);
	foreach ( $feature_blocks as $slug => $block ) {
		$front_fields[] = theme_acf_tab( "front_{$slug}", $block['label'] );
		$front_fields[] = theme_acf_field( "front_{$slug}_heading", $block['label'] . ' 見出し', "front_{$slug}_heading", 'textarea', array(
			'rows'          => 2,
			'default_value' => $block['heading'],
		) );
		$front_fields[] = theme_acf_field( "front_{$slug}_body", $block['label'] . ' 本文', "front_{$slug}_body", 'textarea', array(
			'rows'          => 3,
			'default_value' => $block['body'],
		) );
		$front_fields[] = theme_acf_field( "front_{$slug}_cta_url", $block['label'] . ' リンク先', "front_{$slug}_cta_url", 'url' );
		$front_fields[] = theme_acf_image_field( "front_{$slug}_image", $block['label'] . ' 画像', "front_{$slug}_image" );
	}

	// 山翠苑についてセクションの項目を追加する。
	$front_fields[] = theme_acf_tab( 'front_about', 'About' );
	$front_fields[] = theme_acf_field( 'front_about_heading', 'About 見出し', 'front_about_heading', 'textarea', array(
		'rows'          => 2,
		'default_value' => theme_demo_content( 'front_about_heading' ),
	) );
	$front_fields[] = theme_acf_field(
		'front_about_body',
		'About 本文',
		'front_about_body',
		'textarea',
		array(
			'rows'          => 3,
			'default_value' => theme_demo_content( 'front_about_body' ),
		)
	);
	$front_fields[] = theme_acf_image_field( 'front_about_image', 'About メイン画像', 'front_about_image' );
	$front_fields[] = theme_acf_field( 'front_about_okami_name', '女将 氏名', 'front_about_okami_name', 'text', array( 'default_value' => theme_demo_content( 'front_about_okami_name' ) ) );
	$front_fields[] = theme_acf_field( 'front_about_okami_role', '女将 肩書き', 'front_about_okami_role', 'text', array( 'default_value' => theme_demo_content( 'front_about_okami_role' ) ) );
	$front_fields[] = theme_acf_image_field( 'front_about_okami_image', '女将 写真', 'front_about_okami_image' );
	$front_fields[] = theme_acf_field( 'front_about_chef_name', '板長 氏名', 'front_about_chef_name', 'text', array( 'default_value' => theme_demo_content( 'front_about_chef_name' ) ) );
	$front_fields[] = theme_acf_field( 'front_about_chef_role', '板長 肩書き', 'front_about_chef_role', 'text', array( 'default_value' => theme_demo_content( 'front_about_chef_role' ) ) );
	$front_fields[] = theme_acf_image_field( 'front_about_chef_image', '板長 写真', 'front_about_chef_image' );

	acf_add_local_field_group(
		array(
			'key'      => 'group_theme_page_front',
			'title'    => 'トップページ 編集項目',
			'fields'   => $front_fields,
			'hide_on_screen' => array( 'the_content' ),
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
		)
	);

	// 「客室のご案内」固定ページ（page-room.php, スラッグ room）の編集項目を登録する。
	// 本文（概要説明）は WordPress 標準の本文エディタ（post_content）を使う。
	acf_add_local_field_group(
		array(
			'key'      => 'group_theme_page_room',
			'title'    => '客室のご案内ページ 編集項目',
			'fields'   => array(
				theme_acf_tab( 'page_room_hero', 'ヒーロー' ),
				theme_acf_field( 'page_room_hero_catch', '英字キャッチ', 'page_room_hero_catch', 'text', array( 'default_value' => theme_demo_content( 'page_room_hero_catch' ) ) ),
				theme_acf_image_field( 'page_room_hero_image', 'メイン画像', 'page_room_hero_image' ),
				theme_acf_tab( 'page_room_gallery', 'ギャラリー' ),
				theme_acf_gallery_field( 'page_room_gallery', 'ギャラリー画像（枚数自由）', 'page_room_gallery' ),
				theme_acf_tab( 'page_room_about', 'About This Room' ),
				theme_acf_field( 'page_room_lead', '見出し（本文タイトル）', 'page_room_lead', 'textarea', array(
					'rows'          => 2,
					'instructions'  => '本文エディタの上に表示される、キャッチコピー風の見出しです。',
					'default_value' => theme_demo_content( 'page_room_lead' ),
				) ),
				theme_acf_field(
					'page_room_tags',
					'特徴タグ（カンマ区切り）',
					'page_room_tags',
					'text',
					array(
						'instructions'  => 'ギャラリー画像の下に、タグとして1つずつ表示されます。例: 貸切露天風呂付,湖側テラス,禁煙,Wi-Fi完備（区切りは半角カンマ）。',
						'default_value' => theme_demo_content( 'page_room_tags' ),
					)
				),
				theme_acf_tab( 'page_room_data', '客室データ' ),
				theme_acf_field( 'page_room_size', '広さ', 'page_room_size', 'text', array( 'default_value' => theme_demo_content( 'page_room_size' ) ) ),
				theme_acf_field( 'page_room_amenities', 'お部屋設備', 'page_room_amenities', 'text', array( 'default_value' => theme_demo_content( 'page_room_amenities' ) ) ),
				theme_acf_field( 'page_room_checkin_out', 'チェックイン・アウト', 'page_room_checkin_out', 'text', array( 'default_value' => theme_demo_content( 'page_room_checkin_out' ) ) ),
				theme_acf_tab( 'page_room_rate', '料金・予約' ),
				theme_acf_field( 'page_room_rate_weekday', '平日1泊2食付料金', 'page_room_rate_weekday', 'text', array( 'default_value' => theme_demo_content( 'page_room_rate_weekday' ) ) ),
				theme_acf_field( 'page_room_rate_holiday', '休前日1泊2食付料金', 'page_room_rate_holiday', 'text', array( 'default_value' => theme_demo_content( 'page_room_rate_holiday' ) ) ),
				theme_acf_field( 'page_room_capacity', 'ご定員', 'page_room_capacity', 'text', array( 'default_value' => theme_demo_content( 'page_room_capacity' ) ) ),
			),
			'location' => theme_acf_page_location( 'room' ),
		)
	);

	// 「お問い合わせ・ご予約」固定ページ（page-contact.php）の編集項目を登録する。
	// 電話番号・受付時間・予約フォームURLは「宿泊施設共通情報」（shop_settings）の値を再利用するため、
	// ここではヒーローと導入文のみ登録する。項目数が少ないためタブ UI は使わない。
	acf_add_local_field_group(
		array(
			'key'      => 'group_theme_page_contact',
			'title'    => 'お問い合わせページ 編集項目',
			'fields'   => array(
				theme_acf_field( 'page_contact_hero_catch', '英字キャッチ', 'page_contact_hero_catch', 'text', array( 'default_value' => theme_demo_content( 'page_contact_hero_catch' ) ) ),
				theme_acf_image_field( 'page_contact_hero_image', 'メイン画像', 'page_contact_hero_image' ),
				theme_acf_field(
					'page_contact_lead',
					'導入文',
					'page_contact_lead',
					'textarea',
					array(
						'rows'          => 3,
						'instructions'  => 'ヒーロー下に表示される案内文です。ご予約とお問い合わせを同じ窓口で承っていることが伝わる内容にしてください。',
						'default_value' => theme_demo_content( 'page_contact_lead' ),
					)
				),
			),
			'location' => theme_acf_page_location( 'contact' ),
		)
	);

	// 客室カテゴリー（category: room）の投稿に表示する編集項目を登録する。
	acf_add_local_field_group(
		array(
			'key'      => 'group_theme_room',
			'title'    => '客室詳細',
			'fields'   => array(
				theme_acf_field( 'room_catch', '英字キャッチ', 'room_catch', 'text', array( 'instructions' => '客室ページ上部、写真の上に小さく表示される英字の一言です。例: Special Room "AO"' ) ),
				theme_acf_field( 'room_tags', '特徴タグ（カンマ区切り）', 'room_tags', 'text', array( 'instructions' => 'ギャラリー画像の下に、タグとして1つずつ表示されます。例: 貸切露天風呂付,湖側テラス,禁煙,Wi-Fi完備（区切りは半角カンマ）。' ) ),
				theme_acf_field( 'room_size', '広さ', 'room_size', 'text' ),
				theme_acf_field( 'room_amenities', 'お部屋設備', 'room_amenities', 'text' ),
				theme_acf_field( 'room_checkin_out', 'チェックイン・アウト', 'room_checkin_out', 'text' ),
				theme_acf_field( 'room_rate_weekday', '平日1泊2食付料金', 'room_rate_weekday', 'text' ),
				theme_acf_field( 'room_rate_holiday', '休前日1泊2食付料金', 'room_rate_holiday', 'text' ),
				theme_acf_field( 'room_capacity', 'ご定員', 'room_capacity', 'text' ),
				theme_acf_gallery_field( 'room_gallery', 'ギャラリー画像（枚数自由）', 'room_gallery' ),
			),
			'location' => theme_acf_category_location( 'room' ),
		)
	);

	// お知らせカテゴリー（category: news）の投稿に表示する編集項目を登録する。
	acf_add_local_field_group(
		array(
			'key'      => 'group_theme_news',
			'title'    => 'お知らせ詳細',
			'fields'   => array(
				theme_acf_field( 'news_external_url', '外部URL', 'news_external_url', 'url' ),
			),
			'location' => theme_acf_category_location( 'news' ),
		)
	);
}
add_action( 'acf/init', 'theme_register_acf_fields' );
