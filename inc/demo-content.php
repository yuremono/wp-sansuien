<?php
/**
 * デモ文言の単一情報源。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF の default_value・テンプレート側の fallback 引数・bootstrap の seed 値の
 * 3箇所で同じデモ文言を別々に書くと、修正時に同期漏れが起きる。
 * この関数を唯一の情報源として、3箇所すべてがここを参照する。
 *
 * @param string $key      フィールド名（例: 'shop_phone'）。
 * @param string $fallback キー未登録時のフォールバック。
 * @return string
 */
function theme_demo_content( string $key, string $fallback = '' ): string {
	static $map = null;

	if ( null === $map ) {
		$map = array(
			// 宿泊施設共通情報（Options Page）。
			'shop_name'            => THEME_BRAND_DEFAULT,
			'shop_phone'           => '0261-00-0000',
			'shop_contact_url'     => '#reserve',
			'shop_address'         => '長野県青木湖畔 ○○温泉郷',
			'shop_access_note'     => 'JR大糸線「簗場駅」より送迎バスで約8分(要予約)',
			'shop_reception_hours' => '9:00〜18:00',
			'shop_map_embed_url'   => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12810.641561945822!2d137.85172605!3d36.61048755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5ff7d9e50029316b%3A0xcd895b7fa3ed5edb!2z6Z2S5pyo5rmW!5e0!3m2!1sja!2sjp!4v1783558639512!5m2!1sja!2sjp',

			// トップページ: ヒーロー。
			'front_hero_eyebrow'   => 'HAVE A QUIET TIME BY THE LAKE — EST. 1972',
			'front_hero_heading'   => "水と緑に抱かれて、\n心をほどく一夜を。",
			'front_hero_lead'      => "湖畔にたたずむ全十二室の小さな宿。\n季節の湯と土地の恵みで、静かな時間をご用意しております。",

			// トップページ: 館内の過ごし方（ROOMS / ONSEN / CUISINE）。
			'front_rooms_heading'   => "湖に向かって開かれた、\n全十二室のしつらえ。",
			'front_rooms_body'      => '露天風呂付き特別室「蒼」をはじめ、湖viewの和洋室、庭園沿いの和室まで。どの部屋も窓の外の景色を主役に、余計なものを置かないしつらえです。',
			'front_onsen_heading'   => "湯けむりの向こうに、\n湖と山のいとなみ。",
			'front_onsen_body'      => '大浴場と展望風呂のほか、貸切の露天風呂をご用意。朝は湖面の霧、夜は星空。季節と時間で表情を変える湯浴みをお楽しみください。',
			'front_cuisine_heading' => "土地の恵みを、\n囲炉裏の火とともに。",
			'front_cuisine_body'    => '信州の山菜や湖の幸を中心にした季節の会席。夕食後は炭火の灯る囲炉裏ラウンジで、地酒とともにゆっくりとお過ごしください。',

			// トップページ: About。
			'front_about_heading'    => "創業から半世紀、\n湖畔とともに。",
			'front_about_body'       => '創業から半世紀、湖畔の自然と地元の恵みを活かしたおもてなしを大切にしてまいりました。派手さはございませんが、また帰ってきたくなる——そんな宿でありたいと願っております。',
			'front_about_okami_name' => '川井 美和子',
			'front_about_okami_role' => 'OKAMI 女将',
			'front_about_chef_name'  => '佐伯 隆',
			'front_about_chef_role'  => 'ITACHO 板長',

			// 客室のご案内ページ（固定ページ）。
			'page_room_hero_catch'    => 'Special Room "AO"',
			'page_room_lead'          => "湖をひとり占めする、\n当宿いちばんの特等席。",
			'page_room_tags'          => '貸切露天風呂付,湖側テラス,禁煙,Wi-Fi完備',
			'page_room_size'          => '52㎡(和洋室)',
			'page_room_amenities'     => '貸切露天風呂・冷蔵庫・空気清浄機・浴衣2枚',
			'page_room_checkin_out'   => '15:00〜 / 11:00まで',
			'page_room_rate_weekday'  => '¥32,000〜',
			'page_room_rate_holiday'  => '¥38,000〜',
			'page_room_capacity'      => '2〜3名',

			// お問い合わせ・ご予約ページ（固定ページ）。
			'page_contact_hero_catch' => 'Contact & Reservation',
			'page_contact_lead'       => 'ご宿泊のご予約、空室状況のご確認、お部屋やお食事に関するご相談まで、どのようなことでもお電話またはお問い合わせフォームより承っております。ご不明な点がございましたら、お気軽にご連絡くださいませ。',
		);
	}

	return $map[ $key ] ?? $fallback;
}
