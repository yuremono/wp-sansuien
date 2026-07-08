# 【アーカイブ】管理画面構成（CPT/ACF設計）の決定箇所

このファイルは `PLAN-SANSUIEN.md` が現状サマリー形式へ全面書き換えされる前（コミット `a4109ad`、2026-07-08時点）の内容から、**管理画面の構成（客室・お知らせをどう管理するか）を決定していた箇所のみ**を抜粋して復元したものです。

現在（2026-07-09）、この決定内容（客室をCPT `room` で管理する設計）についてユーザーから「固定ページやCPTではなく、標準の投稿＋カテゴリーを使うべき」との指摘があり、再設計中です。過去の判断根拠を確認できるよう、このファイルに保存します。

---

## 決定事項（ユーザー確認済み）— 該当項目のみ抜粋

> 元ファイルの「決定事項（ユーザー確認済み）」1番より。実際にはAskUserQuestionで選ばれたのは「ページ構成: 仕組みを温存して振替（推奨）」という大枠の選択肢のみで、「客室を新規CPT `room` にする」という技術的詳細は、この大枠選択を受けて調査エージェントが解釈・提案した内容であり、その技術選択自体を個別にユーザーへ確認したものではない。

1. **ページ構成: 仕組みを温存して振替**
   - ページ別テンプレート（page-templates/）＋ページ別 CSS 切替（inc/enqueue.php の `theme_page_stylesheet()`）＋ template-parts/ のページ別ディレクトリという機構は温存する
   - ページ名を山水園向けに置換する。必要分のみ作成（例: トップ、客室一覧）。居酒屋固有ページ（genshu/shochu/other/otsumami/insta/info）の中身は山水園の内容へ置換または撤去
   - 客室は新規 CPT `room`（一覧＋個別）、お知らせは既存 CPT `news` を流用。CPT `drink`/`food` と焼酎系タクソノミーは廃止

---

## 3-2. 動的化の提案（CPT / ACF 設計）

既存の `inc/cpt.php`（`theme_register_content_types()` + `theme_register_content_taxonomy()`）と `inc/acf-pages.php`（`theme_acf_field()` ヘルパー、`group_theme_*`/`field_theme_*`キー命名）のパターンをそのまま踏襲する。

**CPT再設計**:

| 既存CPT | 山水園での扱い |
| --- | --- |
| `news`（お知らせ） | **そのまま流用**。`news_category` タクソノミーは `instagram` タームのみのため、山水園では不要か「お知らせ種別」に読み替えて再定義（例: `general`, `plan`=プラン情報等）。フィールド `news_external_url` は流用可。 |
| `drink`（ドリンク） | **廃止**。山水園には該当業態なし。 |
| `food`（料理） | **廃止 or `room`(客室) へ転用**。ただし `food` は価格・おすすめ表示・外部URLのフィールド構造を持ち、客室（価格2種:平日/休前日、定員、設備タグ、広さ等）とは形が異なるため、**新規CPT `room`（客室）を新設**するのが妥当。 |

**新規CPT `room`（客室）の提案**:

```php
'room' => array(
    'singular' => '客室',
    'plural'   => '客室',
    'icon'     => 'dashicons-admin-multisite', // 要検討
),
```
- タクソノミー: `room_category` は不要そう（room.htmlの「他のお部屋」は単純な一覧のため、`menu_order`での並び順のみで十分）。
- ACFフィールド（`group_theme_room`、location: `post_type == room`）案:
  - `room_catch`（アイキャッチ副題、例:「Special Room "AO"」の英字ラベル部分）
  - `room_tags`（タグ複数、repeaterまたはtext+カンマ区切り。例: 貸切露天風呂付/湖側テラス/禁煙/Wi-Fi完備）
  - `room_size`（広さ、例:52㎡）
  - `room_amenities`（お部屋設備、textarea）
  - `room_checkin_out`（チェックイン・アウト、text）
  - `room_rate_weekday`（平日1泊2食付料金）
  - `room_rate_holiday`（休前日1泊2食付料金）
  - `room_capacity`（定員）
  - `room_gallery_1〜4`（客室ギャラリー画像、image×4 or gallery型）
  - サムネイル（アイキャッチ）を一覧カード・page_heroに利用
- 一覧: `template-parts/front/feature.php`（ROOMSブロックの導線）や `room.html`の「他のお部屋」ブロックは `theme_get_content_posts('room')` で取得し `menu_order` で表示順制御（既存の `theme_get_content_posts` 関数をそのまま利用可）。
- 個別ページ: `single-room.php` を新規作成（既存テーマに `single-*.php` 相当のファイルがまだ無いため新規パターン）。room.htmlの構造（page_hero, crumbs, room_gallery, room_body+book_card, other_rooms, closing, footer）をそのまま踏襲。

**ACF 店舗共通情報（`group_theme_shop_settings`）の流用**:

既存フィールド（`shop_name`, `shop_phone`, `shop_contact_url`, `shop_postcode`, `shop_address`, `shop_hours`, `shop_closed`, `shop_map_embed_url`, `shop_instagram_url`）はほぼそのまま流用可能。デフォルト値のみ山水園向けに変更（例: `shop_name`のデフォルトを「山翠苑」、`shop_phone`を`0261-00-0000`、`shop_address`を「長野県青木湖畔 ○○温泉郷」等）。`shop_hours`（営業時間）は宿泊業なのでチェックイン/アウト時間に読み替えるか、フィールド自体を`room`CPT側の`room_checkin_out`に寄せて共通設定からは削除するか要検討。

**トップページ用ACF（`group_theme_page_front`）の再設計**: 既存の `front_{slug}_eyebrow/heading/lead/hero_image/cta_label/cta_url/section_heading/section_body/image_1/image_2` という命名規則パターンを、山水園の `.feature`（ROOMS/ONSEN/CUISINE）、`.about`（女将挨拶）向けに転用。例: `front_rooms_heading`, `front_rooms_body`, `front_onsen_heading`... のように既存の `shochu_{section}_*` パターン（`inc/acf-pages.php` 226-234行目、居酒屋当時）を模して3ブロック分のフィールドセットを組む。

---

## 参照

- この抜粋の全文（削除・置換ファイル一覧、CSS/画像配置方針なども含む完全版）は `git show a4109ad:PLAN-SANSUIEN.md` で確認可能。
- 現在進行中の再設計（投稿＋カテゴリー方式への変更）の経緯は `PLAN-SANSUIEN.md` を参照。
