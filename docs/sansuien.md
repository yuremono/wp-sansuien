# 山水園テーマ構成ガイド

この文書は `sansuien` テーマの実装、管理画面、初期構築、本番反映を追跡するための案件用構成資料です。汎用テンプレートは `docs/theme.example.md` を参照し、この文書には現在の実値を記載します。

## 案件情報

| 項目 | 実値 |
| --- | --- |
| テーマ表示名 | 山翠苑（SANSUIEN） |
| テーマslug / ディレクトリ | `sansuien` |
| PHP関数接頭辞 | `theme_` |
| ACF key接頭辞 | `group_theme_` / `field_theme_` |
| Local URL / 公開URL / site_url | 非公開。`tools/local-wp-load.path`（gitignore 対象）と `.env.deploy`（gitignore 対象）を参照 |
| SSH host / user / port | 非公開。`.env.deploy`（gitignore 対象）を参照 |
| WordPressルート / `DEPLOY_PATH` | 非公開。`.env.deploy`（gitignore 対象）を参照 |

## 標準到達点

- トップページ、客室のご案内・お問い合わせの固定ページ、客室・お知らせの一覧/個別にWordPress側の入口がある
- `header.php` / `footer.php` が共通ヘッダー・フッターを内包し、ページ本文と分離されている
- トップページ本文が意味のあるセクションファイルへ分割されている
- ページ固有値がACF、客室・お知らせは標準投稿＋カテゴリー（`room` / `news`）へ接続されている
- ACF無効時、未入力時、該当カテゴリーの投稿がない場合に元表示相当のfallbackがある
- 固定ページ、テンプレート、フロントページ、メニューを非破壊で補完できる
- SSHで確認したテーマ配置先へ、dry-run監査後にapplyできる
- 本番では固定ページ、フロントページ設定、primary/footerメニュー、宿泊施設共通情報の ACF 初期値を非破壊で投入済み
- この文書、実装、`README.md`、`DEPLOYMENT.md` の値が一致している

## 実ファイル構成

```text
sansuien/
├── header.php
├── footer.php
├── front-page.php
├── page.php
├── page-room.php
├── page-contact.php
├── category-room.php
├── category-news.php
├── single.php
├── 404.php
├── index.php
├── template-parts/
│   ├── site-header.php
│   ├── site-footer.php
│   ├── reserve-tab.php
│   ├── front-page-content.php
│   ├── room-page-content.php
│   ├── contact-page-content.php
│   ├── single-room-content.php
│   ├── single-post-content.php
│   ├── front/
│   │   ├── hero.php
│   │   ├── gallery.php
│   │   ├── feature.php
│   │   ├── voices.php
│   │   ├── about.php
│   │   ├── news-feed.php
│   │   └── closing.php
│   └── room/
│       ├── hero.php
│       ├── gallery.php
│       ├── body.php
│       └── other-rooms.php
├── inc/
│   ├── helpers.php
│   ├── template-tags.php
│   ├── setup.php
│   ├── demo-content.php
│   ├── contact-form.php
│   ├── enqueue.php
│   └── acf-pages.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── tools/
│   ├── deploy.sh
│   └── local-wp-load.path
├── tools-domain/
│   ├── bootstrap-site.example.php
│   ├── run-bootstrap-site.example.sh
│   ├── sync-nav.example.php
│   └── deploy-theme.example.sh
├── DEPLOYMENT.md
└── docs/
    ├── theme.example.md
    └── sansuien.md
```

## ページ対応表

| 表示名 | URL / slug | WordPress入口 | 本文骨格 |
| --- | --- | --- | --- |
| トップ | `/` | `front-page.php` | `template-parts/front-page-content.php` |
| 客室のご案内 | `/room/` | `page-room.php`（固定ページ、スラッグ `room`） | `template-parts/room-page-content.php` |
| お問い合わせ・ご予約 | `/contact/` | `page-contact.php`（固定ページ、スラッグ `contact`） | `template-parts/contact-page-content.php` |
| 客室一覧 | `/category/room/` | `category-room.php`（カテゴリー `room` のアーカイブ） | 直接セクションを描画 |
| 客室個別 | `/<slug>/` | `single.php` → `template-parts/single-room-content.php`（カテゴリー `room` の投稿） | セクションパーツを呼び出し |
| お知らせ一覧 | `/news/`（リライトルールで短縮） | `category-news.php`（カテゴリー `news` のアーカイブ） | 直接セクションを描画 |
| お知らせ個別 | `/<slug>/` | `single.php` → `template-parts/single-post-content.php`（カテゴリー `room` 以外の投稿） | シンプルな本文レイアウト |

館内施設（ONSEN/CUISINE等）、お客様の声、山翠苑について、お知らせ、アクセスは独立ページではなく、すべてトップページ内のアンカーセクション（`#feature` `#news` `#access` `#reserve` 等）です。

`header.php` が `template-parts/site-header.php` と `template-parts/reserve-tab.php`（固定予約タブ）を、`footer.php` が `template-parts/site-footer.php` を内包しているため、各入口は `get_header()`、本文、`get_footer()` を呼ぶだけで共通チェイクロームが揃います（固定ページや今後追加するテンプレートも同様）。

## ページが表示されるまで

### トップページ

```text
公開URL のトップ
  ↓
front-page.php
  ├── get_header()（内部で site-header.php / reserve-tab.php を出力）
  ├── template-parts/front-page-content.php
  │     ├── front/hero.php
  │     ├── front/gallery.php
  │     ├── front/feature.php
  │     ├── front/voices.php
  │     ├── front/about.php
  │     ├── front/news-feed.php
  │     └── front/closing.php
  └── get_footer()（内部で site-footer.php を出力）
```

### 客室一覧・個別

```text
公開URL の /room/
  ↓
category-room.php
  ├── get_header()（内部で site-header.php / reserve-tab.php を出力）
  ├── (客室カード一覧を theme_get_content_posts('room') で取得)
  └── get_footer()（内部で site-footer.php を出力）

公開URL の /room/<slug>/
  ↓
single.php → template-parts/single-room-content.php
```

## 共通外枠

- `header.php`: HTML文書開始、`wp_head()`、`body_class()`、`wp_body_open()`
- `template-parts/site-header.php`: ロゴ（テキストロゴ「山翠苑 / SANSUIEN」）、`primary` メニュー
- `template-parts/reserve-tab.php`: 画面右下固定の予約導線
- `template-parts/site-footer.php`: ロゴ、コピーライト
- `footer.php`: `wp_footer()` とHTML文書終了

`primary` が未割り当ての場合は `theme_menu_fallback()` がトップページのアンカー構造を表示します。

## functions.phpとinc

`functions.php` は次の順で読み込みます。

1. `inc/helpers.php`: 値判定、アセットバージョン
2. `inc/template-tags.php`: URL、ACF fallback、共通設定、カテゴリー別投稿取得・描画、Gallery正規化
3. `inc/setup.php`: theme support、`primary` / `footer` メニュー、`room` / `news` カテゴリーの非破壊的な存在保証
4. `inc/enqueue.php`: CSS・JavaScript
5. `inc/demo-content.php`: デモ文言の単一情報源（`theme_demo_content()`）
6. `inc/acf-pages.php`: Options PageとACF field group
7. `inc/contact-form.php`: Contact Form 7 連携

## 必須プラグイン

- **Secure Custom Fields**（WordPress.org 公式、無料。または Advanced Custom Fields PRO）: `inc/acf-pages.php` のローカルフィールド登録に必須。ギャラリー（`front_gallery_images` / `room_gallery` / `page_room_gallery`）と お客様の声（`front_voices`）は Gallery / Repeater フィールドを使うため、無料版 ACF（Advanced Custom Fields）単体では利用できない。ACF 無効時・フィールド型未対応時も fatal error にはならず、各テンプレートはテーマ内蔵のデモ内容にフォールバックする。
- **並び順プラグイン（推奨・任意）**: 「Simple Custom Post Order」または「Intuitive Custom Post Order」（いずれも無料）。客室・お知らせは投稿+カテゴリー方式のままとする方針を確定したため、管理画面上で客室の表示順をドラッグ&ドロップで変更したい場合に導入する。`theme_get_content_posts()`（`inc/template-tags.php`）は既に `menu_order` ASC → `date` DESC の順でクエリしており、これらのプラグインが書き換える標準の `menu_order` をそのまま使うため、テーマ側の追加実装は不要（プラグインを有効化するだけで動く）。
- **Contact Form 7**: `/contact/`（お問い合わせ・ご予約ページ）のフォーム本体。`inc/contact-form.php` は「宿泊施設共通情報」の `shop_contact_form_id`（お問い合わせフォームのID）を優先して埋め込む。未入力の場合のみ、タイトル「お問い合わせ・ご予約フォーム」でフォームを検索する fallback が働く（導入直後の未設定状態でも動くようにするための保険）。ID を設定しておけば、フォームの投稿タイトルを変更しても表示が壊れない。プラグイン停止時はフォーム部分の代わりに電話番号の案内のみ表示され、fatal errorにはならない。

投稿一覧の視認性向上（サムネイル列・料金列の追加）はプラグインを使わず `inc/setup.php` の `theme_posts_list_columns()` / `theme_posts_list_column_content()` で対応済み（追加インストール不要）。

## ACF

ACFローカルフィールドは `inc/acf-pages.php` で登録します。ACF停止時は `inc/template-tags.php` が投稿メタへfallbackし、未設定時はテンプレート内の元マークアップ相当値を使用します。

### 宿泊施設共通情報

Options Page `theme-shop-settings`、field group `group_theme_shop_settings`:

- `shop_name`（デフォルト: 山翠苑）
- `shop_phone`（デフォルト: `0261-00-0000`）
- `shop_contact_url`
- `shop_address`（デフォルト: 長野県青木湖畔 ○○温泉郷）
- `shop_access_note`（デフォルト: JR大糸線「簗場駅」より送迎バスで約8分(要予約)）
- `shop_reception_hours`（デフォルト: `9:00〜18:00`）
- `shop_map_embed_url`（Googleマップの「地図を埋め込む」で取得した embed URL）
- `shop_instagram_url`

`site-header.php`、`site-footer.php`、各予約導線で共用します。取得は `theme_option()` / `theme_option_url()` を使用します。

### トップページ field group（`group_theme_page_front`、location: `front_page`）

- Hero: `front_hero_eyebrow`、`front_hero_heading`、`front_hero_lead`、`front_hero_image`
- 館内の過ごし方（ROOMS/ONSEN/CUISINE）: `front_{rooms|onsen|cuisine}_heading`、`_body`、`_cta_url`、`_image`
- About: `front_about_heading`、`front_about_body`、`front_about_image`、`front_about_okami_name`、`front_about_okami_role`、`front_about_okami_image`、`front_about_chef_name`、`front_about_chef_role`、`front_about_chef_image`

### カテゴリー別 field group（post_category location）

| カテゴリー | field group | fields |
| --- | --- | --- |
| `room` | `group_theme_room` | `room_catch`, `room_tags`, `room_size`, `room_amenities`, `room_checkin_out`, `room_rate_weekday`, `room_rate_holiday`, `room_capacity`, `room_gallery`（Gallery フィールド、枚数自由。Secure Custom Fields または ACF PRO が必要） |
| `news` | `group_theme_news` | `news_external_url` |

## 客室・お知らせ（標準投稿 + カテゴリー）

客室・お知らせはカスタム投稿タイプではなく、標準の「投稿」＋カテゴリー（`room` / `news`）で管理します（経緯は `docs/archive-cpt-acf-decision.md` 参照）。`inc/setup.php` の `theme_ensure_content_categories()` が、この2カテゴリーが常に存在するよう非破壊的に保証します。並び順は投稿の `menu_order` を使用し、`Simple Custom Post Order` 等の並び順プラグインで管理画面から変更できます。

| カテゴリー | 用途 | 一覧ページ |
| --- | --- | --- |
| `room` | 客室（一覧・個別） | `category-room.php`（`/category/room/`）。「客室のご案内」固定ページ（`/room/`）とは別物 |
| `news` | お知らせ | `category-news.php`（`/news/`、リライトルールで短縮） |

## 編集フロー

1. 施設名、電話、住所、アクセス補足、受付時間、地図画像、Instagramは「宿泊施設共通情報」で編集する。
2. トップページの見出し、本文、画像、CTAは固定フロントページ（`group_theme_page_front`）で編集する。
3. 客室の追加・削除は「投稿」で行い、カテゴリーに `room`（客室）を必ず付ける。料金・タグ・設備等は客室詳細フィールドに入力する。並び順は並び順プラグイン（Simple Custom Post Order 等）で管理画面からドラッグ&ドロップで変更する。
4. お知らせの追加・削除は「投稿」で行い、カテゴリーに `news`（お知らせ）を必ず付ける。**カテゴリーを付け忘れると ACF の編集項目も出ず、サイトのどこにも表示されないため要注意。**
5. ヘッダーのリンク順は「外観 > メニュー」の `primary` で編集する。
6. ACFまたは該当カテゴリーの投稿がない場合は元HTML相当のfallback表示を確認する。

## 初期構築

実行入口:

```bash
THEME_BOOTSTRAP_CONFIRM=sansuien-local tools-domain/run-bootstrap-site.example.sh
```

前提:

- Local URLが `tools/local-wp-load.path`（gitignore 対象）記載の値と一致する
- `WP_LOAD_PATH` または `tools/local-wp-load.path` が正しい
- テーマ `sansuien` がLocalのテーマディレクトリから参照できる

既存ページ、既存メニュー項目、入力済みメタ、既存投稿（客室・お知らせ）を削除または無条件上書きしません。
本番では `tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行し、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を使って対象環境を照合したうえで、固定ページ、フロントページ設定、メニュー、宿泊施設共通 ACF を投入済みです。

## デプロイ

ラッパー:

```bash
tools-domain/deploy-theme.example.sh
```

dry-run（`.env.deploy` に値を用意した上で読み込む、または各変数を直接指定）:

```bash
set -a; source .env.deploy; set +a
tools-domain/deploy-theme.example.sh
```

apply:

```bash
set -a; source .env.deploy; set +a
tools-domain/deploy-theme.example.sh --apply
```

`DEPLOY_HOST` / `DEPLOY_USER` / `DEPLOY_PORT` / `DEPLOY_PATH` の実値は `.env.deploy`（gitignore 対象）を参照してください。`.env.deploy.example` に必要なキーの一覧があります。

通常実行はdry-runで、`--apply` なしではリモートを変更しません。同期前にSSHでWordPressルート、`wp-content/themes`、対象テーマディレクトリを確認します。`DEPLOY_PATH` は絶対パス、`wp-content/themes` 配下、末尾がテーマslugと完全一致する必要があります。

実際の除外定義は `tools/deploy.sh` の `theme_rsync_excludes()` を正とします。主な対象は `.codex/`、`.git/`、`.serena/`、`docs/`、`tasks/`、`tools/`、`tools-domain/`、`vendor/`、`node_modules/`、環境変数ファイル、Markdown、設定ファイル、Exampleテンプレートです。

## 修正入口

- ページ文章、画像、CTA: WordPress固定ページ（トップ）
- 宿泊施設共通情報: ACF Options Page「宿泊施設共通情報」
- 客室、お知らせ: 「投稿」＋カテゴリー（`room` / `news`）
- セクションのHTML: `template-parts/front/<section>.php`
- セクション順: `template-parts/front-page-content.php`
- 共通ヘッダー・フッター: `header.php` / `footer.php`（内部で `template-parts/site-header.php` / `reserve-tab.php` / `site-footer.php` を出力）
- ACF field: `inc/acf-pages.php`
- デモ文言（初期表示用の見本文章）: `inc/demo-content.php`
- カテゴリーの非破壊的な存在保証: `inc/setup.php`
- fallback、取得、エスケープ、Gallery正規化: `inc/template-tags.php`
- メニュー位置、theme support: `inc/setup.php`
- CSS / JavaScript読込: `inc/enqueue.php`
- お問い合わせフォーム連携: `inc/contact-form.php`
- 見た目: `assets/css/`
- 動作: `assets/js/`
- 固定ページ、メニュー、seed: `tools-domain/bootstrap-site.example.php`
- デプロイ条件: `tools/deploy.sh` / `tools-domain/deploy-theme.example.sh`

## 検証

実装変更後は次を実行します。

```bash
rtk test 'find . -name "*.php" -not -path "./vendor/*" -print0 | xargs -0 -n1 php -l'
rtk composer run phpcs
rtk git diff --check
```

Localの公開URL（`tools/local-wp-load.path` 記載の環境）ではトップページと客室一覧・個別についてHTTP 200、本文、body class、CSS、JavaScript、画像、メニュー、アンカー、ACF fallback、コンソールエラー、404を確認します。本番apply後は本番公開URL（`.env.deploy` 参照）で同じ全ページ確認を行います。テストがある場合は最小カバレッジ80%を維持します。

## 画像ライセンスに関する注意

room2.jpg / room3.jpg は商用利用可の CC BY / CC BY-SA 素材に差し替え済み（2026-07-09）。旧 NC/ND 素材は `room2-orig-nc-nd.jpg` / `room3-orig-nc.jpg` としてバックアップのみ保持し、テンプレートからは参照していない。クレジットは `assets/images/CREDITS.txt` 参照。
