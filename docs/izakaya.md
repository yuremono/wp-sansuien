# 居酒屋テーマ構成ガイド

この文書は `0606wp-izakaya` テーマの実装、管理画面、初期構築、本番反映を追跡するための案件用構成資料です。汎用テンプレートは `docs/theme.example.md` を参照し、この文書には現在の実値を記載します。

## 案件情報

| 項目 | 実値 |
| --- | --- |
| テーマ表示名 | Izakaya |
| テーマslug / ディレクトリ | `0606wp-izakaya` |
| PHP関数接頭辞 | `theme_` |
| ACF key接頭辞 | `group_theme_` / `field_theme_` |
| Local URL | `http://localhost:10018/` |
| 公開URL | `https://yuremono.com/izakaya/` |
| 実際の site_url | `http://yuremono.com/izakaya` |
| SSH host | `xs966275.xsrv.jp` |
| SSH user | `xs966275` |
| SSH port | `10022` |
| WordPressルート | `/home/xs966275/yuremono.com/public_html/izakaya` |
| `DEPLOY_PATH` | `/home/xs966275/yuremono.com/public_html/izakaya/wp-content/themes/0606wp-izakaya` |

## 標準到達点

- ホームと下層6ページにWordPress側の入口がある
- `site-header.php`、`site-footer.php`、ページ本文が分離されている
- 全ページ本文が意味のあるセクションファイルへ分割されている
- ページ固有値がACF、一覧データがCPT/taxonomy、ナビゲーションがWordPressメニューへ接続されている
- ACF無効時、未入力時、CPT投稿がない場合に元表示相当のfallbackがある
- 固定ページ、テンプレート、フロントページ、メニューを非破壊で補完できる
- SSHで確認したテーマ配置先へ、dry-run監査後にapplyできる
- 本番では固定ページ、フロントページ設定、primary/footerメニュー、店舗共通情報の ACF 初期値を非破壊で投入済み
- この文書、実装、`README.md`、`DEPLOYMENT.md` の値が一致している

## 実ファイル構成

```text
0606wp-izakaya/
├── front-page.php
├── page-templates/
│   ├── top.php
│   ├── genshu.php
│   ├── shochu.php
│   ├── other.php
│   ├── otsumami.php
│   ├── insta.php
│   └── info.php
├── template-parts/
│   ├── site-header.php
│   ├── site-footer.php
│   ├── front-page-content.php
│   ├── genshu-page-content.php
│   ├── shochu-page-content.php
│   ├── other-page-content.php
│   ├── otsumami-page-content.php
│   ├── insta-page-content.php
│   ├── info-page-content.php
│   ├── front/
│   ├── genshu/
│   ├── shochu/
│   ├── other/
│   ├── otsumami/
│   ├── insta/
│   └── info/
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
│   ├── images/
│   └── img/
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
    └── izakaya.md
```

`page-templates/example.php` とExample用テンプレートパーツは基盤サンプルとして残っていますが、実ページでは使用せず、デプロイ除外対象です。

## ページ対応表

| 表示名 | URL / slug | WordPress入口 | 本文骨格 |
| --- | --- | --- | --- |
| ホーム | `/` / `home` | `front-page.php` | `template-parts/front-page-content.php` |
| ホーム選択テンプレート | `home` | `page-templates/top.php` | `template-parts/front-page-content.php` |
| 焼酎の原酒 | `/genshu/` | `page-templates/genshu.php` | `template-parts/genshu-page-content.php` |
| 本格焼酎 | `/shochu/` | `page-templates/shochu.php` | `template-parts/shochu-page-content.php` |
| その他のお酒 | `/other/` | `page-templates/other.php` | `template-parts/other-page-content.php` |
| おつまみ | `/otsumami/` | `page-templates/otsumami.php` | `template-parts/otsumami-page-content.php` |
| お知らせ | `/insta/` | `page-templates/insta.php` | `template-parts/insta-page-content.php` |
| 店舗案内 | `/info/` | `page-templates/info.php` | `template-parts/info-page-content.php` |

各入口は `get_header()`、`template-parts/site-header.php`、本文骨格、`template-parts/site-footer.php`、`get_footer()` の順で表示します。`front-page.php` と `page-templates/top.php` は同じホーム本文を共有します。

## ページが表示されるまで

### ホーム

```text
http://localhost:10018/
  ↓
front-page.php
  ├── header.php
  ├── template-parts/site-header.php
  ├── template-parts/front-page-content.php
  │     └── template-parts/front/*.php
  ├── template-parts/site-footer.php
  └── footer.php
```

`page-templates/top.php` も同じ本文を呼び出します。ただし、`group_theme_page_front` のACF locationは `front_page` であるため、ホーム編集値は固定フロントページに設定されたページで編集します。

### 下層ページ

```text
http://localhost:10018/<slug>/
  ↓
page-templates/<slug>.php
  ├── header.php
  ├── template-parts/site-header.php
  ├── template-parts/<slug>-page-content.php
  │     └── template-parts/<slug>/*.php
  ├── template-parts/site-footer.php
  └── footer.php
```

## セクション順

各 `*-page-content.php` は `#contents_wrap` と `#contents`、`main` またはトップの `section`、次の `get_template_part()` 呼び出しだけを担当します。

### ホーム

1. `front/hero.php`: メインビジュアル
2. `front/introduction.php`: 店舗紹介
3. `front/shochu-features.php`: 原酒・本格焼酎紹介
4. `front/other-link.php`: その他のお酒への導線
5. `front/otsumami-link.php`: おつまみへの導線
6. `front/news-feed.php`: `news` CPTのInstagram投稿
7. `front/news-link.php`: お知らせ一覧への導線

### 焼酎の原酒

1. `genshu/hero.php`: ページ見出し
2. `genshu/introduction.php`: 原酒の説明
3. `genshu/featured-heading.php`: おすすめ見出し
4. `genshu/featured-products.php`: おすすめ原酒カード
5. `genshu/product-list.php`: 原酒価格一覧
6. `genshu/contact.php`: 問い合わせ導線

### 本格焼酎

1. `shochu/hero.php`: ページ見出し
2. `shochu/introduction.php`: 本格焼酎の説明
3. `shochu/category-nav.php`: カテゴリー内アンカー
4. `shochu/imo.php`: 芋焼酎
5. `shochu/mugi.php`: 麦焼酎
6. `shochu/kome.php`: 米焼酎
7. `shochu/kokuto.php`: 黒糖焼酎
8. `shochu/other.php`: その他の焼酎
9. `shochu/contact.php`: 問い合わせ導線

### その他のお酒

1. `other/hero.php`: ページ見出し
2. `other/introduction.php`: 導入
3. `other/product-list.php`: 商品価格一覧
4. `other/contact.php`: 問い合わせ導線

### おつまみ

1. `otsumami/hero.php`: ページ見出し
2. `otsumami/charcoal-introduction.php`: 炭火焼き紹介
3. `otsumami/charcoal-menu.php`: 炭火焼き一覧
4. `otsumami/featured-dishes.php`: おすすめ料理
5. `otsumami/other-menu.php`: その他の料理
6. `otsumami/contact.php`: 問い合わせ導線

### お知らせ

1. `insta/hero.php`: ページ見出し
2. `insta/introduction.php`: Instagram案内
3. `insta/posts.php`: `news` CPT投稿一覧

### 店舗案内

1. `info/hero.php`: ページ見出し
2. `info/overview-heading.php`: 店舗名見出し
3. `info/overview.php`: 店舗概要
4. `info/gallery.php`: 店内画像
5. `info/access.php`: 住所、営業時間、地図

## 共通外枠

- `header.php`: HTML文書開始、`wp_head()`、`body_class()`、`wp_body_open()`
- `template-parts/site-header.php`: ロゴ、電話、問い合わせ、`primary` メニュー
- `template-parts/site-footer.php`: 店舗情報、地図、`footer` メニュー、コピーライト
- `footer.php`: `wp_footer()` とHTML文書終了
- `template-parts/*-page-content.php`: 本文骨格とセクション呼び出し順

`primary` と `footer` が未割り当ての場合は `theme_menu_fallback()` がホームと下層6ページの固定構造を表示します。

## functions.phpとinc

`functions.php` は次の順で読み込みます。

1. `inc/helpers.php`: 値判定、アセットバージョン
2. `inc/template-tags.php`: URL、ACF fallback、共通設定、CPT取得・描画
3. `inc/setup.php`: theme support、`primary` / `footer` メニュー
4. `inc/cpt.php`: `drink`、`food`、`news` とtaxonomy
5. `inc/enqueue.php`: 対象ページのCSS・JavaScript
6. `inc/acf-pages.php`: Options PageとACF field group

## ACF

ACFローカルフィールドは `inc/acf-pages.php` で登録します。ACF停止時は `inc/template-tags.php` が投稿メタまたはWordPress optionへfallbackし、未設定時はテンプレート内の元マークアップ相当値を使用します。

### 店舗共通情報

Options Page `theme-shop-settings`、field group `group_theme_shop_settings`:

- `shop_name`
- `shop_phone`
- `shop_contact_url`
- `shop_postcode`
- `shop_address`
- `shop_hours`
- `shop_closed`
- `shop_map_embed_url`
- `shop_instagram_url`

`site-header.php`、`site-footer.php`、各問い合わせCTA、店舗案内で共用します。取得は `theme_option()` / `theme_option_url()`、電話リンク生成は `theme_phone_uri()` を使用します。

### ページ別field group

| ページ | field group | location |
| --- | --- | --- |
| ホーム | `group_theme_page_front` | `front_page` |
| 焼酎の原酒 | `group_theme_page_genshu` | `page-templates/genshu.php` |
| 本格焼酎 | `group_theme_page_shochu` | `page-templates/shochu.php` |
| その他のお酒 | `group_theme_page_other` | `page-templates/other.php` |
| おつまみ | `group_theme_page_otsumami` | `page-templates/otsumami.php` |
| お知らせ | `group_theme_page_insta` | `page-templates/insta.php` |
| 店舗案内 | `group_theme_page_info` | `page-templates/info.php` |

各ページは `<slug>_eyebrow`、`<slug>_heading`、`<slug>_lead`、`<slug>_hero_image`、`<slug>_cta_label`、`<slug>_cta_url`、`<slug>_section_heading`、`<slug>_section_body`、`<slug>_image_1`、`<slug>_image_2` を持ちます。

本格焼酎はさらに `shochu_<category>_heading`、`shochu_<category>_body`、`shochu_<category>_image_1`、`shochu_<category>_image_2` を `imo`、`mugi`、`kome`、`kokuto`、`other` ごとに持ちます。

### CPT field group

| CPT | field group | fields |
| --- | --- | --- |
| `drink` | `group_theme_drink` | `drink_price`, `drink_featured`, `drink_external_url` |
| `food` | `group_theme_food` | `food_price`, `food_featured`, `food_external_url` |
| `news` | `group_theme_news` | `news_external_url` |

## CPTとtaxonomy

`inc/cpt.php` が次を登録します。全CPTはタイトル、本文、抜粋、アイキャッチ、並び順を使用し、REST APIを有効化しています。

| CPT | taxonomy | term slug |
| --- | --- | --- |
| `drink` | `drink_category` | `genshu`, `imo`, `mugi`, `kome`, `kokuto`, `other` |
| `food` | `food_category` | `charcoal`, `featured`, `other` |
| `news` | `news_category` | `instagram` |

表示順は原則 `menu_order ASC`、同順では `date DESC` です。セクションは `theme_get_section_posts()` でtaxonomy termを指定し、価格一覧、特集カード、ニュース一覧の既存DOMへ出力します。投稿がない場合は各テンプレート内の固定fallbackを表示します。

## 編集フロー

1. 店名、電話、住所、営業時間、定休日、地図、問い合わせ先は「店舗共通情報」で編集する。
2. ページ固有の見出し、本文、画像、CTAは対象固定ページを編集する。
3. ドリンク、料理、お知らせの追加・削除・並び替えは各CPTで行う。
4. CPT投稿へ対応taxonomyを設定し、表示セクションを決める。
5. ヘッダーとフッターのリンク順は「外観 > メニュー」の `primary` / `footer` で編集する。
6. ACFまたはCPTに値がない場合は元HTML相当のfallback表示を確認する。

表示経路は、管理画面値から `theme_meta()` / `theme_option()` / `theme_content_meta()` を経由し、`theme_text()`、`theme_rich()`、`theme_image()`、各CPT rendererで用途別にエスケープしてセクションへ出力します。

## CSS・JavaScript・画像

`inc/enqueue.php` は `theme_is_custom_view()` が真のホーム、`top.php`、下層6テンプレートだけへ資産を読み込みます。

- ホームと `top.php`: `assets/css/index_html.css`
- 下層ページ: `<slug>_html.css`
- 共通CSS: ``、`common.css`、`style.css`、`style.css`
- 共通JavaScript: WordPress同梱jQuery、Magnific Popup、BeerSlider、Slick、`function.js`、``、`flipsnap.min.js`、Viewport Extra
- 画像: `assets/images/` と `assets/img/` を元サイトの参照構造に合わせて保持

テンプレート画像は `theme_image()` を通し、ACFメディアが未設定ならテーマ内画像をfallbackとして使用します。

## 初期構築

実行入口:

```bash
THEME_BOOTSTRAP_CONFIRM=izakaya-local tools-domain/run-bootstrap-site.example.sh
```

前提:

- Local URLが `http://localhost:10018/` と一致する
- `WP_LOAD_PATH` または `tools/local-wp-load.path` が正しい
- テーマ `0606wp-izakaya` がLocalのテーマディレクトリから参照できる

処理内容:

1. URLと確認トークンを照合する
2. テーマを確認し、必要なら有効化する
3. `home` と下層6固定ページをslugで検索し、不足分だけ作成する
4. 未設定またはdefaultのページだけへテンプレートを割り当てる
5. `home` を固定フロントページへ設定する
6. `primary` と `footer` メニューを作成し、不足ページだけ追加する
7. メタは空欄だけ補完する
8. CPT初期データは `_theme_seed_key` で重複を防止する
9. taxonomy termをslugで再利用し、不足分だけ作成する

既存ページ、既存メニュー項目、入力済みメタ、既存CPT投稿を削除または無条件上書きしません。現在の `content` 設定は空のため、CPT投稿データは管理画面または別途確定したseed定義から投入します。
本番では `tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行し、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を使って対象環境を照合したうえで、固定ページ、フロントページ設定、メニュー、店舗共通 ACF を投入済みです。

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
DEPLOY_PATH=/home/xs966275/yuremono.com/public_html/izakaya/wp-content/themes/0606wp-izakaya \
tools-domain/deploy-theme.example.sh
```

apply:

```bash
DEPLOY_HOST=xs966275.xsrv.jp \
DEPLOY_USER=xs966275 \
DEPLOY_PORT=10022 \
DEPLOY_PATH=/home/xs966275/yuremono.com/public_html/izakaya/wp-content/themes/0606wp-izakaya \
tools-domain/deploy-theme.example.sh --apply
```

通常実行はdry-runで、`--apply` なしではリモートを変更しません。同期前にSSHでWordPressルート、`wp-content/themes`、対象テーマディレクトリを確認します。`DEPLOY_PATH` は絶対パス、`wp-content/themes` 配下、末尾がテーマslugと完全一致する必要があります。

dry-runでは、テーマ実行ファイルだけが対象であることを確認します。`.serena/`、`tasks/`、`tools/`、`tools-domain/`、`docs/`、エージェント設定、依存パッケージ、README、DEPLOYMENTなどの開発・運用ファイルが同期・削除対象へ混入していないことを監査してからapplyします。

実際の除外定義は `tools/deploy.sh` の `theme_rsync_excludes()` を正とします。主な対象は `.codex/`、`.git/`、`.serena/`、`docs/`、`tasks/`、`tools/`、`tools-domain/`、`vendor/`、`node_modules/`、環境変数ファイル、Markdown、設定ファイル、Exampleテンプレートです。

## 修正入口

- ページ文章、画像、CTA: WordPress固定ページ
- 店舗共通情報: ACF Options Page「店舗共通情報」
- ドリンク、料理、お知らせ: 対応CPT
- 表示カテゴリー: 対応taxonomy
- セクションのHTML: `template-parts/<page>/<section>.php`
- セクション順: `template-parts/*-page-content.php`
- 共通ヘッダー・フッター: `template-parts/site-header.php` / `template-parts/site-footer.php`
- ACF field: `inc/acf-pages.php`
- CPT / taxonomy: `inc/cpt.php`
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

Localでは `http://localhost:10018/` と下層6URLについてHTTP 200、本文、body class、CSS、JavaScript、画像、メニュー、アンカー、CPT表示、ACF fallback、コンソールエラー、404を確認します。本番apply後は `https://yuremono.com/izakaya/` で同じ全ページ確認を行います。テストがある場合は最小カバレッジ80%を維持します。
