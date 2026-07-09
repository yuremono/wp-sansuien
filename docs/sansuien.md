# 山水園テーマ構成ガイド

この文書は `sansuien` テーマの実装、管理画面、初期構築、本番反映を追跡するための案件用構成資料です。汎用テンプレートは `docs/theme.example.md` を参照し、この文書には現在の実値を記載します。

## 案件情報

| 項目 | 実値 |
| --- | --- |
| テーマ表示名 | 山翠苑（SANSUIEN） |
| テーマslug / ディレクトリ | `sansuien` |
| PHP関数接頭辞 | `theme_` |
| ACF key接頭辞 | `group_theme_` / `field_theme_` |
| Local URL | `http://localhost:10023/` |
| 公開URL | `http://yuremono.com/sansuien/` |
| 実際の site_url | `http://yuremono.com/sansuien` |
| SSH host | `xs966275.xsrv.jp` |
| SSH user | `xs966275` |
| SSH port | `10022` |
| WordPressルート | `/home/xs966275/yuremono.com/public_html/sansuien` |
| `DEPLOY_PATH` | `/home/xs966275/yuremono.com/public_html/sansuien/wp-content/themes/sansuien` |

## 標準到達点

- トップページと客室CPTの一覧/個別にWordPress側の入口がある
- `site-header.php`、`site-footer.php`、ページ本文が分離されている
- トップページ本文が意味のあるセクションファイルへ分割されている
- ページ固有値がACF、客室・お知らせがCPTへ接続されている
- ACF無効時、未入力時、CPT投稿がない場合に元表示相当のfallbackがある
- 固定ページ、テンプレート、フロントページ、メニューを非破壊で補完できる
- SSHで確認したテーマ配置先へ、dry-run監査後にapplyできる
- 本番では固定ページ、フロントページ設定、primary/footerメニュー、宿泊施設共通情報の ACF 初期値を非破壊で投入済み
- この文書、実装、`README.md`、`DEPLOYMENT.md` の値が一致している

## 実ファイル構成

```text
sansuien/
├── front-page.php
├── archive-room.php
├── single-room.php
├── page-templates/
│   └── top.php
├── template-parts/
│   ├── site-header.php
│   ├── site-footer.php
│   ├── reserve-tab.php
│   ├── front-page-content.php
│   └── front/
│       ├── hero.php
│       ├── gallery.php
│       ├── feature.php
│       ├── voices.php
│       ├── about.php
│       ├── news-feed.php
│       └── closing.php
├── inc/
│   ├── helpers.php
│   ├── template-tags.php
│   ├── setup.php
│   ├── cpt.php
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

`page-templates/example.php` とExample用テンプレートパーツは基盤サンプルとして残っていますが、実ページでは使用せず、デプロイ除外対象です。

## ページ対応表

| 表示名 | URL / slug | WordPress入口 | 本文骨格 |
| --- | --- | --- | --- |
| トップ | `/` | `front-page.php` | `template-parts/front-page-content.php` |
| 客室一覧 | `/room/` | `archive-room.php`（CPT `room` アーカイブ） | 直接セクションを描画 |
| 客室個別 | `/room/<slug>/` | `single-room.php`（CPT `room` シングル） | 直接セクションを描画 |

館内施設（ONSEN/CUISINE等）、お客様の声、山翠苑について、お知らせ、アクセスは独立ページではなく、すべてトップページ内のアンカーセクション（`#feature` `#news` `#access` `#reserve` 等）です。

各入口は `get_header()`、`template-parts/site-header.php`、`template-parts/reserve-tab.php`（固定予約タブ）、本文、`template-parts/site-footer.php`、`get_footer()` の順で表示します。

## ページが表示されるまで

### トップページ

```text
http://yuremono.com/sansuien/
  ↓
front-page.php
  ├── get_header()
  ├── template-parts/site-header.php
  ├── template-parts/reserve-tab.php
  ├── template-parts/front-page-content.php
  │     ├── front/hero.php
  │     ├── front/gallery.php
  │     ├── front/feature.php
  │     ├── front/voices.php
  │     ├── front/about.php
  │     ├── front/news-feed.php
  │     └── front/closing.php
  ├── template-parts/site-footer.php
  └── get_footer()
```

### 客室一覧・個別

```text
http://yuremono.com/sansuien/room/
  ↓
archive-room.php
  ├── get_header()
  ├── template-parts/site-header.php
  ├── template-parts/reserve-tab.php
  ├── (客室カード一覧を theme_get_content_posts('room') で取得)
  ├── template-parts/front/closing.php
  ├── template-parts/site-footer.php
  └── get_footer()

http://yuremono.com/sansuien/room/<slug>/
  ↓
single-room.php（構成は archive-room.php に準じる）
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
2. `inc/template-tags.php`: URL、ACF fallback、共通設定、CPT取得・描画
3. `inc/setup.php`: theme support、`primary` / `footer` メニュー
4. `inc/cpt.php`: `room`、`news` を登録
5. `inc/enqueue.php`: CSS・JavaScript
6. `inc/acf-pages.php`: Options PageとACF field group

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

### CPT field group

| CPT | field group | fields |
| --- | --- | --- |
| `room` | `group_theme_room` | `room_catch`, `room_tags`, `room_size`, `room_amenities`, `room_checkin_out`, `room_rate_weekday`, `room_rate_holiday`, `room_capacity`, `room_gallery_1〜4` |
| `news` | `group_theme_news` | `news_external_url` |

## CPT

`inc/cpt.php` が次を登録します。両CPTともタイトル、本文、抜粋、アイキャッチ、並び順を使用し、REST APIを有効化しています。焼酎業態のタクソノミー（旧 `drink_category` 等）は廃止済みです。

| CPT | 用途 | アーカイブ |
| --- | --- | --- |
| `room` | 客室（一覧・個別） | あり（`/room/`） |
| `news` | お知らせ | なし（トップページ内 `#news` セクションで一覧表示） |

## 編集フロー

1. 施設名、電話、住所、アクセス補足、受付時間、地図画像、Instagramは「宿泊施設共通情報」で編集する。
2. トップページの見出し、本文、画像、CTAは固定フロントページ（`group_theme_page_front`）で編集する。
3. 客室の追加・削除・並び替えはCPT `room` で行い、料金・タグ・設備等は客室詳細フィールドに入力する。
4. お知らせの追加・削除はCPT `news` で行う。
5. ヘッダーのリンク順は「外観 > メニュー」の `primary` で編集する。
6. ACFまたはCPTに値がない場合は元HTML相当のfallback表示を確認する。

## 初期構築

実行入口:

```bash
THEME_BOOTSTRAP_CONFIRM=sansuien-local tools-domain/run-bootstrap-site.example.sh
```

前提:

- Local URLが `http://localhost:10023/` と一致する
- `WP_LOAD_PATH` または `tools/local-wp-load.path` が正しい
- テーマ `sansuien` がLocalのテーマディレクトリから参照できる

既存ページ、既存メニュー項目、入力済みメタ、既存CPT投稿を削除または無条件上書きしません。
本番では `tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行し、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を使って対象環境を照合したうえで、固定ページ、フロントページ設定、メニュー、宿泊施設共通 ACF を投入済みです。

## デプロイ

ラッパー:

```bash
tools-domain/deploy-theme.example.sh
```

dry-run:

```bash
DEPLOY_HOST=xs966275.xsrv.jp \
DEPLOY_USER=xs966275 \
DEPLOY_PORT=10022 \
DEPLOY_PATH=/home/xs966275/yuremono.com/public_html/sansuien/wp-content/themes/sansuien \
tools-domain/deploy-theme.example.sh
```

apply:

```bash
DEPLOY_HOST=xs966275.xsrv.jp \
DEPLOY_USER=xs966275 \
DEPLOY_PORT=10022 \
DEPLOY_PATH=/home/xs966275/yuremono.com/public_html/sansuien/wp-content/themes/sansuien \
tools-domain/deploy-theme.example.sh --apply
```

通常実行はdry-runで、`--apply` なしではリモートを変更しません。同期前にSSHでWordPressルート、`wp-content/themes`、対象テーマディレクトリを確認します。`DEPLOY_PATH` は絶対パス、`wp-content/themes` 配下、末尾がテーマslugと完全一致する必要があります。

実際の除外定義は `tools/deploy.sh` の `theme_rsync_excludes()` を正とします。主な対象は `.codex/`、`.git/`、`.serena/`、`docs/`、`tasks/`、`tools/`、`tools-domain/`、`vendor/`、`node_modules/`、環境変数ファイル、Markdown、設定ファイル、Exampleテンプレートです。

## 修正入口

- ページ文章、画像、CTA: WordPress固定ページ（トップ）
- 宿泊施設共通情報: ACF Options Page「宿泊施設共通情報」
- 客室、お知らせ: 対応CPT
- セクションのHTML: `template-parts/front/<section>.php`
- セクション順: `template-parts/front-page-content.php`
- 共通ヘッダー・フッター: `template-parts/site-header.php` / `template-parts/site-footer.php`
- ACF field: `inc/acf-pages.php`
- CPT: `inc/cpt.php`
- fallback、取得、エスケープ: `inc/template-tags.php`
- メニュー位置、theme support: `inc/setup.php`
- CSS / JavaScript読込: `inc/enqueue.php`
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

Localでは `http://localhost:10023/` のトップページと客室一覧・個別についてHTTP 200、本文、body class、CSS、JavaScript、画像、メニュー、アンカー、CPT表示、ACF fallback、コンソールエラー、404を確認します。本番apply後は `http://yuremono.com/sansuien/` で同じ全ページ確認を行います。テストがある場合は最小カバレッジ80%を維持します。

## 画像ライセンスに関する注意

room2.jpg / room3.jpg は商用利用可の CC BY / CC BY-SA 素材に差し替え済み（2026-07-09）。旧 NC/ND 素材は `room2-orig-nc-nd.jpg` / `room3-orig-nc.jpg` としてバックアップのみ保持し、テンプレートからは参照していない。クレジットは `assets/images/CREDITS.txt` 参照。
