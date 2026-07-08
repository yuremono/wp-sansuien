# 山水園 WordPress テーマ化 計画

## 目的

`tmp/sansuien/`（静的サイト：旅館「山水園」）を元に、居酒屋テーマ（コピー元: 0606wp-izakaya）の
構成を **できる限り温存** しつつ、コピー元固有の内容が残らない sansuien テーマへ書き換える。

## 前提（完了済み）

- シンボリックリンク作成済み: `/Users/yanoseiji/Local Sites/sansuien/app/public/wp-content/themes/sansuien` → 本リポジトリ
- 静的ソース複製済み: `./tmp/sansuien/`（preview/index.html, room.html, style.css, source/, images/, extract/）
- コピー元 `/Users/yanoseiji/projects/0413portfolio/tmp/sansuien` は削除しない

## 方針

- テーマ構成（`functions.php` + `inc/` 分割、`template-parts/`、`page-templates/`、ビルドツール類）は温存する
- 居酒屋固有の内容（CPT: drink/food/news、ACF フィールド、文言、画像、screenshot.jpg、style.css ヘッダー、text domain 等）を山水園の内容へ置換する
- CSS クラス名は `snake_case`（プロジェクトルールがない限り）
- テーマスラッグ / text domain: `sansuien`

## フェーズ

### フェーズ 1: 調査（Sonnet サブエージェント）

- 静的サイトの構造分析（ページ・セクション・CSS・アセット）
- 居酒屋固有項目の棚卸し（ファイル・関数・文言・設定）
- 変換対応表を本ファイル末尾に追記する

### フェーズ 2: 実装（Sonnet サブエージェント）

- フェーズ 1 の対応表に従いテーマを書き換える
- 画像アセットを `assets/images/` へ配置
- style.css ヘッダー・screenshot 差し替え

### フェーズ 3: 検証（Sonnet サブエージェント）

- 全 PHP の `php -l`
- 居酒屋固有文言の残存 grep チェック
- テーマとして構造的に成立しているかの確認

---

## 決定事項（ユーザー確認済み）

1. **ページ構成: 仕組みを温存して振替**
   - ページ別テンプレート（page-templates/）＋ページ別 CSS 切替（inc/enqueue.php の `theme_page_stylesheet()`）＋ template-parts/ のページ別ディレクトリという機構は温存する
   - ページ名を山水園向けに置換する。必要分のみ作成（例: トップ、客室一覧）。居酒屋固有ページ（genshu/shochu/other/otsumami/insta/info）の中身は山水園の内容へ置換または撤去
   - 客室は新規 CPT `room`（一覧＋個別）、お知らせは既存 CPT `news` を流用。CPT `drink`/`food` と焼酎系タクソノミーは廃止
2. **デプロイ設定**（ユーザー提供の実値で更新）: 本番 WordPress は `http://yuremono.com/sansuien/` にインストール済み、SSH ポートは **10023**。その他（host/user/サーバー構成）は居酒屋と同一。DEPLOYMENT.md・`.env.deploy`・`.env.deploy.example` を sansuien 用の実値で部分書き換えする（プレースホルダー化は撤回）
3. **画像**: `tmp/sansuien/images/` をそのまま `assets/images/` に使用（CREDITS.txt も同伴）。CC BY-NC / ND 画像（room2.jpg, room3.jpg）は本番公開前に差し替え要否をユーザーへ再確認
4. **ロゴ**: 静的サイトどおりテキストロゴ（山翠苑 / SANSUIEN）
5. **不可侵ファイル**: `NOTE.md` / `NOTE.2.md`（ユーザー専用メモ）、`tmp/` 配下のソース、コピー元 `/Users/yanoseiji/projects/0413portfolio/`（※`.env.deploy` は当初不可侵としたが、決定事項2のとおりユーザー提供の実値での更新対象に変更済み。担当は meta エージェントのみ）

### 担当区分（分業体制・排他）

- **builder**: テーマ本体のみ — PHP テンプレート、template-parts/、inc/、functions.php、style.css、assets/、tests/
- **meta**: ドキュメント・設定のみ — DEPLOYMENT.md、.env.deploy(.example)、deploy.sh、tools/、tools-domain/、README.md、package.json、composer.json、phpcs/phpunit 設定、AGENTS.md、bootstrap.md、docs/
- 本計画ファイルの編集は監督（メインセッション）のみが行う

---

## フェーズ 1 調査結果（サブエージェントが追記）

### 1. 静的サイト（tmp/sansuien）の構造分析

#### ページ構成

**`preview/index.html`（トップページ）** — セクション上から順に:

| セクション | class | 内容 |
| --- | --- | --- |
| ヘッダー | `.site_header` | ロゴ（山翠苑/SANSUIEN）+ グローバルナビ（客室のご案内 room.html／#feature／#access／#news） |
| 予約タブ（固定） | `.reserve_tab` | 画面右下固定の「Reserve 予約する」リンク |
| ヒーロー | `.hero` | `hero.jpg` 背景、英字コピー「HAVE A QUIET TIME BY THE LAKE — EST. 1972」、h1見出し、リード文、右下に最新お知らせ1件（`.hero_news`） |
| ギャラリー | `.gallery` | ドラッグ可能な自動スクロールマーキー。room1/bath/irori/okami/lake2 の5枚をループ表示（JS で2セット複製） |
| 館内の過ごし方 | `.feature` id="feature" | 背景teal。ROOMS/ONSEN/CUISINE の3ブロック（見出し+本文+View More）と、スクロール連動で重なる3枚の画像（room1/bath/kaiseki）。JSでスクロール量に応じてtranslate/rotateする演出あり |
| お客様の声 | `.voices` | 3件のレビュー（星評価+コメント+属性） |
| 山翠苑について | `.about` | irori.jpg大きい画像＋沿革文＋女将/板長の紹介（okami.jpg, chef.jpg） |
| お知らせ | `.news_sec` id="news" | 3件のニュースリスト（サムネ+日付+タイトル）+ View More |
| 予約導線+アクセス | `.closing` id="reserve"/`#access` | 左: 予約CTA+電話番号+フッターナビ、右: 地図画像(lake2.jpg)+住所+アクセス文 |
| フッター | `.site_footer` | ロゴ+コピーライト |

**`preview/room.html`（客室個別ページ、特別室「蒼」の例）**:

| セクション | class | 内容 |
| --- | --- | --- |
| ページヒーロー | `.page_hero` | room2.jpg背景、部屋名見出し |
| パンくず | `.crumbs` | トップ › 客室のご案内 › 露天風呂付き特別室「蒼」 |
| 客室ギャラリー | `.room_gallery` | room1/bath/lake2/kaiseki の4枚（キャプション付き） |
| 客室本文+予約カード | `.room_body` | 左: 説明文+タグ(貸切露天風呂付/湖側テラス/禁煙/Wi-Fi完備)+Room Data定義リスト(広さ/設備/チェックイン・アウト)。右: `.book_card`（sticky）に平日/休前日料金、定員、予約ボタン、電話番号 |
| 他の客室 | `.other_rooms` | room2/room3/room1 の3枚カード（名称+料金） |
| 予約導線+アクセス | `.closing` | index.htmlと同一構造（アンカーは`index.html#feature`等に変化） |
| フッター | 同上 | |

ナビゲーション項目は一貫して「客室のご案内／館内施設／アクセス／お知らせ」の4項目＋フッターに同内容。電話番号は `0261-00-0000` で固定。

`source/Sansuien Website (standalone).html` は28MBのMHTML的な単一ファイル（ブラウザ保存形式、画像がインライン化されている可能性が高い）。`preview/` と重複する内容のため、`preview/` を正としてこのファイルの詳細解析は行っていない（指示通り差分確認のみ想定していたが、構造上 preview と同一と判断できるため参照不要と判断）。

#### `preview/style.css` の設計

- CSS変数（`:root`）: `--teal`(#24413e), `--teal_deep`(#1c3330), `--paper`(#f4f1e8) 系3種, `--paper_dim`, `--ink`, `--bronze`(#a8845c), `--wh`, `--bar_h`, `--wid`(1320px), `--head`, `--PX`, `--into`(calc式), `--serif`/`--sans`/`--mono`
- フォント: Google Fonts の `Shippori Mincho`（serif, 見出し用）、`Zen Kaku Gothic New`（sans, 本文用）、`IBM Plex Mono`（mono, 現状本文中では未使用気味）
- 配色: 深緑（teal）×紙色ベージュ（paper）×ブロンズのアクセントという落ち着いた温泉宿トーン
- クラス命名規則: **既に snake_case**（`site_header`, `hero_copy`, `f_txt`, `news_list` 等）。プロジェクトルールと合致するためほぼそのまま流用可能
- 共通パーツ: `.sym`（三角形アイコン, SVG symbol再利用）、`.en_label`（英字ラベル+三角+日本語ラベルの複合パターン）、`.sec_head`（セクション見出し共通形）、`[class*=reveal]`（IntersectionObserverでのフェード+移動アニメーション。`reveal`/`reveal-l`/`reveal-r`/`reveal-tr`/`reveal-br`）、`.path_draw`（山の稜線SVGを線描画するアニメーション）
- レスポンシブ: ブレークポイント1点のみ `@media (max-width:83.75rem)`（1340px）でグリッド解除・ナビ非表示・パディング調整
- JS依存演出（style.cssとセットでHTML内`<script>`に実装）: ドラッグ可能マーキー（ギャラリー）、スクロール連動画像アニメーション（feature）、ヘッダーのスクロール時背景変化、reveal系のIntersectionObserver監視

#### `images/` の用途対応

| ファイル | 用途 | ライセンス（CREDITS.txt） |
| --- | --- | --- |
| hero.jpg | トップヒーロー背景（青木湖） | Wikimedia Commons CC BY 3.0 |
| room1.jpg | ギャラリー/feature/客室ギャラリー/他の客室カード等、多用途の和室客室写真 | Flickr by-sa 2.0 |
| room2.jpg | room.htmlページヒーロー、他の客室カード | Flickr by-nc-nd 2.0 |
| room3.jpg | 他の客室カード（庭園沿い和室） | Flickr by-nc 2.0 |
| bath.jpg | ギャラリー/feature/客室ギャラリー（露天風呂） | Wikimedia Commons CC BY-SA 3.0 |
| irori.jpg | ギャラリー/about大画像（囲炉裏） | Wikimedia Commons CC BY-SA 4.0 |
| okami.jpg | ギャラリー/about（女将紹介） | Wikimedia Commons CC BY-SA 4.0 |
| chef.jpg | about（板長紹介） | Wikimedia Commons Attribution |
| kaiseki.jpg | feature/客室ギャラリー（会席料理） | Wikimedia Commons CC BY-SA 3.0 |
| lake2.jpg | ギャラリー/news サムネ/アクセス地図画像として流用 | Wikimedia Commons CC BY 2.0 |
| breakfast.jpg | news サムネの1枚 | Wikimedia Commons CC BY-SA 3.0 |
| bg_teal.jpg | feature/closing の sticky背景画像 | CREDITS記載なし（要確認） |
| bg_beige.jpg | about セクション背景 | CREDITS記載なし（要確認） |
| mountain.svg / mountain2.svg | 未使用確認（HTML内で直接参照箇所なし。装飾用SVGの可能性、path_draw用は別途インラインSVGなので予備素材の可能性） | — |

**注意**: 各写真はWikimedia Commons/Flickrの外部素材で `CC BY` / `CC BY-SA` / `CC BY-NC` / `CC BY-NC-ND` が混在している。特にNC(非営利)・ND(改変禁止)ライセンスの画像（room2.jpg, room3.jpg）が含まれるため、本番の商用サイトとして公開する場合はクレジット表記または画像差し替えの要否をユーザーに確認すべき（今回の調査スコープ外だが実装フェーズ前にリスクとして共有推奨）。

### 2. 現行テーマ（居酒屋）固有項目の棚卸し

#### style.css ヘッダー

`/Users/yanoseiji/projects/0606wp-sansuien/style.css`: `Theme Name: izakaya`, `Text Domain: izakaya`, Author/Author URIに `izakaya`。全面的に山水園向けへ書き換えが必要。

#### functions.php / inc/

- `functions.php`: `THEME_GETTEXT_DOMAIN = 'izakaya'`、`THEME_BRAND_DEFAULT = '居酒屋'` を定義。値の置換が必要（text domainは `sansuien` へ）。require構成（helpers→template-tags→setup→cpt→enqueue→acf-pages）自体は温存可能。
- `inc/cpt.php`: CPT `drink`（ドリンク）/`food`（料理）/`news`（お知らせ）と、タクソノミー `drink_category`（genshu/imo/mugi/kome/kokuto/other=焼酎の種類）、`food_category`（charcoal/featured/other）、`news_category`（instagram）を登録。**山水園では焼酎分類は不要**。`news`（お知らせ）はそのまま流用可、`drink`/`food` は業態が違うため要再設計（後述の対応表参照）。
- `inc/acf-pages.php`: 店舗共通情報（`shop_name`など9項目、デフォルト値が居酒屋向け＝営業時間「17:00〜2:00」等）と、7つのページテンプレート（front/genshu/shochu/other/otsumami/insta/info）ごとのACFフィールド群、CPT（drink/food/news）ごとのフィールド群を定義。命名パターン `theme_acf_field($key, $label, $name, $type, $extra)` とキー接頭辞 `field_theme_`／グループキー接頭辞 `group_theme_` は再利用可能な設計。ページ別フィールドの中身（`shochu`カテゴリ別4セクション分岐、`front`の`other`/`otsumami`リンク分岐など）は焼酎業態に強く紐づいており作り直しが必要。
- `inc/setup.php`: `THEME_GETTEXT_DOMAIN`のロード、`add_theme_support`、`register_nav_menus(primary, footer)` は汎用。居酒屋固有文言なし（他ファイルの定数経由でのみ影響を受ける）。
- `inc/enqueue.php`: `theme_page_stylesheet()` が `genshu/shochu/other/otsumami/insta/info` の6ページ名をハードコードしCSSファイル名を切り替える設計。CDN（line-awesome, magnific-popup, slick）とテーマ内`assets/css/{page}_html.css`+`assets/css/style.css`を読み込む構成。ページ名配列の全面書き換えが必要。
- `inc/helpers.php`: 完全に汎用（居酒屋固有文言なし）。そのまま流用可。
- `inc/template-tags.php`: 概ね汎用のACFラッパー関数群（`theme_meta`, `theme_image`, `theme_text`, `theme_rich`等）だが、`theme_body_classes()`と`theme_is_custom_view()`に `genshu/shochu/other/otsumami/insta/info` のページ名配列がハードコードされている。また `theme_render_shochu_section()`（焼酎カテゴリ別セクション描画）と `theme_menu_fallback()`（メニュー項目に「焼酎の原酒」「本格焼酎」等をハードコード）は居酒屋固有ロジックで全面差し替えが必要。`@package Izakaya` などのdocblockタグは軽微な文言。

#### front-page.php, page.php, index.php, header.php, footer.php, page-templates/, template-parts/

- `front-page.php` / `page.php` / `index.php`: **ほぼ完全に汎用**。`index.php`は `THEME_BRAND_DEFAULT` を出力するのみ（定数変更で自動追従）。
- `header.php` / `footer.php`: 汎用（`wp_head`/`wp_body_open`/`wp_footer`のみ、居酒屋固有文言なし）。
- `page-templates/`: `top.php`（フロント代替）、`genshu.php`（焼酎の原酒）、`shochu.php`（本格焼酎）、`other.php`（その他のお酒）、`otsumami.php`（おつまみ）、`insta.php`（お知らせ）、`info.php`（店舗案内）、`example.php`（雛形）。各ファイルの `Template Name:` コメントが日本語で焼酎業態の名称になっている。ファイル数=7ページ相当は山水園側のページ構成（トップ／客室一覧+客室個別／館内施設or温泉/料理／お知らせ／アクセス+予約／店舗案内相当）に合わせて再設計が必要。
- `template-parts/`: `site-header.php`・`site-footer.php`（電話番号・住所・営業時間などACF経由の汎用表示だが、ロゴ画像パスやデフォルト値が居酒屋向け）、`front-page-content.php`ほか6つの `*-page-content.php`（各ページのセクション呼び出し順序を定義するオーケストレーター、そのまま構造だけ流用できる）、そして `front/`, `genshu/`, `info/`, `insta/`, `other/`, `otsumami/`, `shochu/`, `service/`(空), `example/` の9サブディレクトリに実セクションPHPが分散（合計約35ファイル）。中身は全て居酒屋の商品・焼酎文言や独自クラス名（`mv`, `second`, `fl50wide`, `wrapGrid`等 —lower camelやBEM崩れの命名）で書かれており、静的サイトのsnake_caseクラスとは体系が異なる。

#### assets/（CSS/JS/画像）

- `assets/css/`: ページ別CSS（`genshu_html.css`, `index_html.css`, `info_html.css`, `insta_html.css`, `other_html.css`, `otsumami_html.css`, `service_html.css`(空ファイル), `shochu_html.css`）＋ `style.css`（86KB、居酒屋サイト全体の変換済みCSS）＋ `style.bak`（357KB、旧バックアップ）＋Bootstrap関連（`bootstrap.css`, `bootstrap.css.map`）。ページ別CSSファイル群は `inc/enqueue.php` の `theme_page_stylesheet()` と1対1対応しているため、ページ構成を変えると命名も総入れ替えになる。
- `assets/images/`: `common/`(67点、主に汎用UI用ボタン・アイコンpng — ECサイト風の「カートに追加」等の画像も含まれており、山水園では大半不要と思われる)、`home/`(29点、居酒屋トップページ写真・ロゴ)、`otsumami/`(4点)、`placeholder/`(11点、汎用プレースホルダー画像＝再利用可)、`shoutyuu/`(14点、焼酎ページ写真)、`sns/`(1点)、`tennai/`(4点、店内写真)。合計130点規模。山水園の`images/`(16点、hero/room/bath/kaiseki等)へ差し替え、居酒屋写真は削除対象。
- `assets/js/`: `function.js`（16.5KB、パンくず生成ロジックの中に `HOME_TEXT = '居酒屋'` のハードコード文言あり。他はスライダー等のUI制御で汎用性あり）、`flipsnap.min.js`／`magnific-popup/`／`slick/`／`scroll-hint/`（すべて汎用ライブラリ、流用可）。
- `assets/scss/`: `bootstrap.scss`, `_variables.scss`, `main.scss` — Bootstrap取り込み用、居酒屋固有文言なし。
- `src/`: 空ディレクトリ。

#### screenshot.jpg、README.md、package.json 等の固有名

- `/Users/yanoseiji/projects/0606wp-sansuien/screenshot.jpg`: 居酒屋サイトのスクリーンショット。差し替え対象。
- `README.md`: タイトル「Izakaya WordPress Theme」、Local URL/公開URL/テーマslug(`0606wp-izakaya`)等すべて居酒屋案件の実値。全面書き換えが必要。
- `package.json`: `name: "0606wp-izakaya"`, `description`（居酒屋サイト移植）, `repository.url`（wp-izakaya.git）, `bugs`, `homepage` すべて居酒屋固有。
- `composer.json`: `name: "yuremono/wp-izakaya"`, `description: "Development tooling for the Izakaya WordPress theme"` が固有。
- `docs/izakaya.md`（18KB）: 案件固有の構成ガイド（Local URL, デプロイ先SSH情報等の実値を含む）。`docs/theme.example.md`（汎用テンプレート、13KB）と`docs/theme.example.bak`は雛形として温存可能。
- `DEPLOYMENT.md`, `.env.deploy`, `.env.deploy.example`: 居酒屋の本番デプロイ先（`yuremono.com/izakaya`等）の実値を含む。山水園用に書き換えが必要（別サイトへのデプロイ設定になるため要ユーザー確認）。
- `tools-domain/bootstrap-site.example.php`（18.5KB）: grep結果には出なかったため文言としては汎用寄りだが、ページ/メニュー/CPT初期データ配列の中身は居酒屋の7ページ構成を前提にしている可能性が高く、中身の確認・書き換えが必要（今回は深く未読）。
- `NOTE.md` / `NOTE.2.md`: ファイル冒頭に **「エージェントは一切関与、言及、削除しないこと」** と明記されたユーザー専用メモ。**実装フェーズでも触れてはいけない**。
- `tests/run.php`: grep該当なし（居酒屋固有文言は含まれていない）。

#### 居酒屋固有文言のgrep結果（`tmp/`, `node_modules/`, `vendor/`, `dist/` 除外）

`izakaya|居酒屋|焼酎|おつまみ|genshu|shochu|otsumami` でヒットしたファイル一覧（README/DEPLOYMENT/docs等のドキュメント類を除く、書き換え対象のコード/アセット）:

```
assets/js/function.js
functions.php
inc/acf-pages.php
inc/cpt.php
inc/enqueue.php
inc/template-tags.php
page-templates/genshu.php
page-templates/otsumami.php
page-templates/shochu.php
style.css
template-parts/front-page-content.php
template-parts/front/introduction.php
template-parts/front/news-feed.php
template-parts/front/otsumami-link.php
template-parts/front/shochu-features.php
template-parts/genshu-page-content.php
template-parts/genshu/*.php（6ファイル）
template-parts/info/access.php, overview.php
template-parts/insta/introduction.php, posts.php
template-parts/other/product-list.php
template-parts/otsumami-page-content.php
template-parts/otsumami/*.php（5ファイル）
template-parts/shochu-page-content.php
template-parts/shochu/*.php（8ファイル）
```

なお `page-templates/other.php` / `page-templates/insta.php` / `page-templates/info.php` / `template-parts/other/hero.php` 等、直接その文言を含まないファイルも「テンプレート構造として焼酎業態の7ページ構成を前提にしている」ため、実質的に書き換え対象に含まれる（grepでは検出されない構造依存も多い点に注意）。

### 3. 変換対応表

#### 3-1. セクション → template-parts 対応（既存構成に寄せる案）

トップページは既存の `template-parts/front/*.php` のファイル粒度（1セクション1ファイル、`get_template_part()`で連結する`front-page-content.php`）をそのまま踏襲する。

| 静的サイトのセクション | 新設する template-part | 備考 |
| --- | --- | --- |
| `.site_header`（共通ヘッダー） | `template-parts/site-header.php`（既存ファイルを書き換え） | ロゴ・ナビ項目（客室のご案内/館内施設/アクセス/お知らせ）に差し替え |
| `.reserve_tab`（固定予約タブ） | `template-parts/site-header.php` 内 or 新規 `template-parts/reserve-tab.php` | header直後に出す固定要素のため独立partも検討可 |
| `.hero`（トップヒーロー+最新お知らせ1件） | `template-parts/front/hero.php`（既存書き換え） | 最新お知らせは `theme_get_content_posts('news', ['posts_per_page'=>1])` 等で動的化 |
| `.gallery`（マーキー） | `template-parts/front/gallery.php`（新規） | 画像5点は当面ACF不要の固定表示 or 新設ACFリピーターで検討 |
| `.feature`（ROOMS/ONSEN/CUISINE） | `template-parts/front/feature.php`（新規、`introduction.php`を役割変更 or 新規追加） | 3ブロックはACFで見出し/本文/画像を編集可能にする案（後述） |
| `.voices`（お客様の声） | `template-parts/front/voices.php`（新規） | 当面は固定表示 or 新CPT `voice` 化も可能（要相談） |
| `.about`（山翠苑について） | `template-parts/front/about.php`（新規、`introduction.php`の位置づけを踏襲） | 女将/板長の紹介はACFの画像+テキストで編集可能に |
| `.news_sec`（お知らせ一覧） | `template-parts/front/news-feed.php`（既存書き換え） | 既存の `news`CPT をそのまま利用（後述） |
| `.closing`（予約導線+アクセス） | `template-parts/front/closing.php`（新規、`other-link.php`/`otsumami-link.php`相当を統合再設計） | 電話番号・住所は既存の店舗共通情報ACF（`shop_phone`, `shop_address`等）をそのまま活用 |
| `.site_footer` | `template-parts/site-footer.php`（既存書き換え） | 既存の店舗共通情報ACFをほぼそのまま流用可能（電話/住所/営業時間/地図） |
| room.html 全体 | 新規 `page-templates/room.php` 相当、または CPT `room` のsingleテンプレート | 後述3-2参照 |

#### 3-2. 動的化の提案（CPT / ACF 設計）

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
  - `room_catch`（アイキャッチ副題、例:「Special Room “AO”」の英字ラベル部分）
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

**ページテンプレート（`page-templates/`）の再設計案**:

既存が7ファイル（top/genshu/shochu/other/otsumami/insta/info）なのに対し、山水園の静的サイトは実質2ページ（トップ+客室個別、客室個別はCPT化するためページテンプレートとしては不要）+アンカーセクションのみ、という非常にシンプルな構成。したがって:

| 既存ファイル | 山水園での扱い |
| --- | --- |
| `top.php` | **`front-page.php`と統合し廃止**、または残してフロントページ代替として維持（既存の`front-page.php`が既にfront_page相当を処理しているため実質重複。`index.php`のフォールバック処理と合わせて要判断） |
| `genshu.php`, `shochu.php`, `other.php`, `otsumami.php` | **廃止**（静的サイトに対応セクションなし。#feature内のROOMS/ONSEN/CUISINEはアンカーであり独立ページではない） |
| `insta.php` | **廃止**（お知らせは`#news`アンカー+`news`CPTアーカイブで完結、独立の固定ページテンプレートは不要と思われるが、「お知らせ一覧ページ」を別途作るなら`page-templates/news.php`として新設検討） |
| `info.php` | **廃止 or 転用検討**（静的サイトに店舗案内的な独立ページは存在しない。アクセス情報は`.closing`内で完結） |
| `example.php` | 雛形として温存可（新規テンプレート作成の参考） |

→ 実質的に **`front-page.php` 一本＋CPT `room` の archive/single** だけで静的サイトの全ページを再現できる可能性が高い。「館内施設」「アクセス」「お知らせ」は全てトップページ内アンカー(`#feature`, `#access`, `#news`)であり、独立ページではない点に注意（`room.html`のみ真に独立したページ）。

**ACF 店舗共通情報（`group_theme_shop_settings`）の流用**:

既存フィールド（`shop_name`, `shop_phone`, `shop_contact_url`, `shop_postcode`, `shop_address`, `shop_hours`, `shop_closed`, `shop_map_embed_url`, `shop_instagram_url`）はほぼそのまま流用可能。デフォルト値のみ山水園向けに変更（例: `shop_name`のデフォルトを「山翠苑」、`shop_phone`を`0261-00-0000`、`shop_address`を「長野県青木湖畔 ○○温泉郷」等）。`shop_hours`（営業時間）は宿泊業なのでチェックイン/アウト時間に読み替えるか、フィールド自体を`room`CPT側の`room_checkin_out`に寄せて共通設定からは削除するか要検討。

**トップページ用ACF（`group_theme_page_front`）の再設計**: 既存の `front_{slug}_eyebrow/heading/lead/hero_image/cta_label/cta_url/section_heading/section_body/image_1/image_2` という命名規則パターンを、山水園の `.feature`（ROOMS/ONSEN/CUISINE）、`.about`（女将挨拶）向けに転用。例: `front_rooms_heading`, `front_rooms_body`, `front_onsen_heading`... のように既存の `shochu_{section}_*` パターン（`inc/acf-pages.php` 226-234行目）を模して3ブロック分のフィールドセットを組む。

#### 3-3. 静的CSS → 既存テーマCSS構成へのマッピング方針

- 静的サイトの `preview/style.css`（16KB、単一ファイル）を、既存の `assets/css/style.css` の位置に相当するテーマ本体CSSとして配置する方針を推奨（`assets/css/sansuien_style.css` 等の新規ファイル名、または既存の `assets/css/style.css` を全面置換）。
- 既存の `theme_page_stylesheet()`（`inc/enqueue.php`）によるページ別CSS切り替えの仕組みは、山水園では**実質不要になる**（ページがトップ+客室個別の2種のみで、両者とも同一の `style.css` で完結する設計のため）。関数を簡略化し、単一CSSの読み込みに変更するのが妥当。
- クラス名は静的ソースのものをそのまま維持（既にsnake_case、プロジェクトルールと合致）。既存の `assets/css/genshu_html.css` 等のページ別CSSファイル群、`bootstrap.css`/`bootstrap.scss`関連、`style.bak` は削除対象。
- Google Fonts（Shippori Mincho / Zen Kaku Gothic New / IBM Plex Mono）の `<link>` 読み込みをheader.phpまたはenqueueに追加する必要がある（現行teamaは外部CDNとしてline-awesome/magnific-popup/slickを読み込んでいるが、山水園デザインではスライダーライブラリ等は不要。ギャラリーのドラッグ機能とscroll-scrub演出は素のJS実装のため `magnific-popup`/`slick`/`flipsnap` は不要になり削除候補）。
- JS: 静的サイトの `<script>`内ロジック（IntersectionObserver reveal、header scroll、gallery marquee drag、feature scroll-scrub）をテーマの `assets/js/` に新規ファイルとして切り出し、`inc/enqueue.php` から `wp_enqueue_script` する。既存の `function.js`（居酒屋固有のパンくずロジック等）は不要となり削除、`jquery`依存も不要になる可能性が高い（静的サイトのJSはVanilla JS）。

#### 3-4. images/ → assets/images/ 配置対応

- `tmp/sansuien/images/*.jpg,*.svg` を `assets/images/sansuien/`（新設ディレクトリ）へ配置する案を推奨（既存の `common/home/otsumami/placeholder/shoutyuu/sns/tennai` はすべて居酒屋固有につき削除、`placeholder/`のみ再利用の可能性を検討する価値あり）。
- CREDITS.txtも `assets/images/sansuien/` 配下、または `docs/` 配下にコピーして出典情報を保持することを推奨（商用利用時のライセンス遵守のため）。
- ロゴ画像は静的サイト側に存在しない（テキストロゴ「山翠苑」のみ）。既存 `site-header.php` の `<img class="h_logoimg">` 部分はテキストロゴへの置き換え、または新規ロゴ画像作成が必要（ユーザー確認事項）。

#### 3-5. 削除・置換が必要な居酒屋固有ファイル一覧

**削除候補**:
- `page-templates/genshu.php`, `shochu.php`, `other.php`, `otsumami.php`, `insta.php`, `info.php`
- `template-parts/genshu/`, `template-parts/shochu/`, `template-parts/other/`, `template-parts/otsumami/`, `template-parts/insta/`, `template-parts/info/`（各ディレクトリ丸ごと）
- `template-parts/genshu-page-content.php`, `shochu-page-content.php`, `otsumami-page-content.php`, `info-page-content.php`, `insta-page-content.php`, `other-page-content.php`
- `template-parts/service/`（既存も空ディレクトリ）
- `template-parts/front/shochu-features.php`, `other-link.php`, `otsumami-link.php`（山水園の新規セクションに置換）
- `assets/css/genshu_html.css`, `shochu_html.css`, `other_html.css`, `otsumami_html.css`, `insta_html.css`, `info_html.css`, `service_html.css`, `index_html.css`, `style.bak`
- `assets/css/bootstrap.css`, `bootstrap.css.map`, `assets/scss/bootstrap.scss`（山水園デザインはBootstrap不使用のため不要と推測、要確認）
- `assets/images/common/`, `home/`, `otsumami/`, `shoutyuu/`, `sns/`, `tennai/`（居酒屋固有写真・UI画像）
- `assets/js/function.js`, `flipsnap.min.js`, `magnific-popup/`, `slick/`, `scroll-hint/`（山水園デザインには不要な演出ライブラリ、要最終確認）
- `screenshot.jpg`（山水園用に差し替え）

**書き換え必須（削除ではなく内容変更）**:
- `style.css`（テーマヘッダー）, `functions.php`（定数）, `inc/cpt.php`, `inc/acf-pages.php`, `inc/enqueue.php`, `inc/template-tags.php`（ハードコードされたページ名配列・焼酎ロジック部分）
- `header.php`（Google Fonts追加）, `template-parts/site-header.php`, `template-parts/site-footer.php`, `front-page.php`（または`top.php`との統合整理）
- `README.md`, `package.json`, `composer.json`, `docs/izakaya.md`（→`docs/sansuien.md`へリネーム推奨）, `DEPLOYMENT.md`, `.env.deploy`, `.env.deploy.example`

**保持（変更不要、既に汎用）**:
- `page.php`, `index.php`, `footer.php`, `inc/helpers.php`, `inc/setup.php`（ロジック部分）, `docs/theme.example.md`, `docs/theme.example.bak`, `page-templates/example.php`, `template-parts/example/`, `tests/run.php`, `assets/images/placeholder/`（再利用検討）
- **`NOTE.md` / `NOTE.2.md` は明示的にエージェント関与禁止のため一切触れない**

**未確認・実装フェーズでの要調査**:
- `tools-domain/bootstrap-site.example.php`（18.5KB、中身未読。居酒屋の7ページ構成を前提にした初期化データが含まれる可能性が高く、山水園向けに書き換えるか、汎用テンプレートとして残すか要判断）
- `source/Sansuien Website (standalone).html`（28MB、詳細未解析。previewと同一と判断し参照不要としたが、差分が必要になった場合は個別に確認）

