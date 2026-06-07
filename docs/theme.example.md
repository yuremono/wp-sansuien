# ${theme_name} テーマ構成ガイド

この文書は、コピー後の案件テーマについて、ページ、セクション、管理画面、アセット、初期構築、本番反映の関係を追える状態にするためのテンプレートです。

静的 HTML を PHP に移しただけの記録ではありません。各ページがどの入口から表示され、本文がどの意味単位へ分割され、編集値がどこから渡るかまで記録します。

## プレースホルダー

| プレースホルダー | 用途 | 例 |
| --- | --- | --- |
| `${theme_name}` | テーマ表示名 | Example Theme |
| `${theme_slug}` | ディレクトリ名、text domain | example-theme |
| `${function_prefix}` | PHP 関数・定数の接頭辞 | example_theme |
| `${acf_prefix}` | ACF group / field key の固定接頭辞 | pc |
| `${site_url}` | 公開 URL | `https://example.com/` |
| `${page_summary}` | サイトの目的 | 飲食店公式サイト |
| `${front_page_title}` | フロントページ名 | Home |
| `${page_name}` | 追加固定ページ名 | Menu |
| `${page_slug}` | 追加固定ページ slug | menu |

コピー後は README の置換一覧と合わせ、実際の案件値へ変更します。公開後の ACF key は変更しません。

## 標準到達点

- 対象となる全静的ページに WordPress 側の入口がある
- 共通表示ヘッダー、共通表示フッター、ページ本文が分離されている
- ページ本文が意味のあるセクション単位へ分割されている
- CSS、JavaScript、画像、内部リンクが WordPress 経由で動作する
- 編集対象が ACF、CPT、WordPress メニューへ適切に割り当てられている
- ACF 無効時や未入力時も元表示を保つ fallback がある
- 固定ページ、テンプレート、メニュー、初期値を安全に補完できる
- この文書と README、DEPLOYMENT.md が実装と一致している

## 全体のファイルツリー

```text
${theme_slug}/
├── style.css
├── functions.php
├── header.php
├── footer.php
├── front-page.php
├── page.php
├── index.php
├── page-templates/
│   ├── top.php
│   └── ${page_slug}.php
├── template-parts/
│   ├── site-header.php
│   ├── site-footer.php
│   ├── front-page-content.php
│   ├── ${page_slug}-page-content.php
│   ├── front/
│   │   ├── hero.php
│   │   ├── introduction.php
│   │   ├── primary-content.php
│   │   ├── secondary-content.php
│   │   └── closing.php
│   └── ${page_slug}/
│       ├── hero.php
│       ├── introduction.php
│       ├── primary-content.php
│       ├── supplementary-content.php
│       └── closing.php
├── inc/
│   ├── helpers.php
│   ├── template-tags.php
│   ├── setup.php
│   ├── enqueue.php
│   └── acf-pages.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── tools/
│   ├── deploy.sh
│   └── local-wp-load.path.example
├── tools-domain/
│   ├── bootstrap-site.example.php
│   ├── run-bootstrap-site.example.sh
│   ├── sync-navigation.example.php
│   └── deploy-theme.example.sh
├── README.md
├── DEPLOYMENT.md
├── AGENTS.md
└── docs/
    └── theme.example.md
```

実際に存在しないディレクトリは作ったことにせず、案件で採用した構成へ更新します。移植元の `img/` と `images/` を両方保持する場合も、その理由を記録します。

## ページ対応表

全ページを省略せず記録します。

| 表示名 | 静的 HTML | URL / slug | WordPress 入口 | 本文呼び出し元 | ページ別アセット |
| --- | --- | --- | --- | --- | --- |
| `${front_page_title}` | `index.html` | `/` | `front-page.php` | `front-page-content.php` | `front.css`, `front.js` |
| `${page_name}` | `${page_slug}.html` | `/${page_slug}/` | `page-templates/${page_slug}.php` | `${page_slug}-page-content.php` | `${page_slug}.css`, `${page_slug}.js` |

## ページが表示されるまで

### フロントページ

```text
${site_url}
  ↓
front-page.php
  ├── get_header() → header.php
  ├── template-parts/site-header.php
  ├── template-parts/front-page-content.php
  │     ├── front/hero.php
  │     ├── front/introduction.php
  │     ├── front/primary-content.php
  │     ├── front/secondary-content.php
  │     └── front/closing.php
  ├── template-parts/site-footer.php
  └── get_footer() → footer.php
```

### 追加固定ページ

```text
${site_url}${page_slug}/
  ↓
page-templates/${page_slug}.php
  ├── get_header() → header.php
  ├── template-parts/site-header.php
  ├── template-parts/${page_slug}-page-content.php
  │     ├── ${page_slug}/hero.php
  │     ├── ${page_slug}/introduction.php
  │     ├── ${page_slug}/primary-content.php
  │     ├── ${page_slug}/supplementary-content.php
  │     └── ${page_slug}/closing.php
  ├── template-parts/site-footer.php
  └── get_footer() → footer.php
```

## セクション設計

`front/example.php` や `${page_slug}/example.php` 一つへページ全体を置かず、表示上・保守上・管理画面上の意味単位へ分割します。

### 分割基準

- 見出しと目的が独立している
- 背景、幅、レイアウトが切り替わる
- 管理画面で一まとまりとして編集する
- 別ページでも再利用できる
- JavaScript の初期化単位が分かれる

元 HTML に `<section>` がないことは、分割しない理由にはなりません。一方、selector や DOM 順序への依存が強い場合は、無理に分割せず理由を記録します。

### フロントページのセクション台帳

| 順序 | 元 HTML の範囲 | 役割 | テンプレートパーツ | 主な編集内容 | 管理方式 |
| ---: | --- | --- | --- | --- | --- |
| 1 | `#hero` | 主訴求 | `front/hero.php` | 見出し、画像、CTA | ACF |
| 2 | `.introduction` | 導入 | `front/introduction.php` | リード、説明 | ACF |
| 3 | `.primary_content` | 主要情報 | `front/primary-content.php` | 見出し、本文、一覧 | ACF / CPT |
| 4 | `.secondary_content` | 補足情報 | `front/secondary-content.php` | 補足文、画像 | ACF |
| 5 | `.closing` | 最終導線 | `front/closing.php` | CTA、リンク | ACF |

### 追加固定ページのセクション台帳

| 順序 | 元 HTML の範囲 | 役割 | テンプレートパーツ | 主な編集内容 | 管理方式 |
| ---: | --- | --- | --- | --- | --- |
| 1 | `.page_title` | ページ見出し | `${page_slug}/hero.php` | 見出し、背景画像 | ACF |
| 2 | `.introduction` | 導入 | `${page_slug}/introduction.php` | リード | ACF |
| 3 | `.primary_content` | 主要情報 | `${page_slug}/primary-content.php` | 本文、項目一覧 | ACF / CPT |
| 4 | `.supplementary_content` | 補足 | `${page_slug}/supplementary-content.php` | 注意事項、補足 | ACF |
| 5 | `.closing` | 次の導線 | `${page_slug}/closing.php` | CTA、戻りリンク | ACF |

案件化後はサンプル行を残さず、全ページの実際のセクション名、順序、ファイル名へ更新します。

## 共通外枠とページ部品

### `header.php` / `footer.php`

- `header.php`: `<!DOCTYPE html>`、`language_attributes()`、`wp_head()`、`body_class()`、`wp_body_open()`
- `footer.php`: `wp_footer()`、`</body>`、`</html>`

サイト上に見えるヘッダーとフッターは、ここへ混在させず `site-header.php` と `site-footer.php` が担当します。

### `site-header.php` / `site-footer.php`

- ロゴ、グローバルナビ、主要導線、補助リンク、コピーライトを担当
- 内部 URL は WordPress API を使う
- 並び替えるリンク一覧は `wp_nav_menu()` を優先する
- 未割り当て時の fallback は元 HTML の構造を維持する

### `*-page-content.php`

- `#contents_wrap` などページ本文の共通骨格を担当
- セクションパーツを表示順に呼び出す
- 長い本文マークアップや全フィールド取得を直接抱えない

## `functions.php` と `inc/`

```text
functions.php
  ├── inc/helpers.php
  ├── inc/template-tags.php
  ├── inc/setup.php
  ├── inc/enqueue.php
  └── inc/acf-pages.php
```

- `helpers.php`: 値判定、アセット更新日時など低レベル処理
- `template-tags.php`: アセット URI、ページ判定、ACF fallback、安全な表示
- `setup.php`: theme support、メニュー位置、管理画面通知
- `enqueue.php`: 共通・ページ別 CSS / JavaScript と依存順
- `acf-pages.php`: ページ別 ACF field group

テンプレートから `get_field()` を直接呼び続けず、既存の `theme_meta()`、`theme_text()`、`theme_lines()`、`theme_image()`、`theme_rich()` などを経由します。

## 管理画面対応表

| 表示箇所 | データ | 管理方式 | 実装 | fallback |
| --- | --- | --- | --- | --- |
| Hero 見出し | 単体テキスト | ACF | `inc/acf-pages.php` + `theme_text()` | 元 HTML 文言 |
| Hero 画像 | 単体画像 | ACF | `theme_image()` | テーマ画像 |
| カード・商品・メニュー | 増減可能な一覧 | CPT | query + template part | 元 HTML の初期データ |
| Header / Footer リンク | 並び替え可能なリンク | WordPress メニュー | `wp_nav_menu()` | 固定 fallback |
| 長文本文 | 許可 HTML | WYSIWYG / 投稿本文 | `theme_rich()` | 元 HTML 本文 |

案件化後は「どのページのどのセクションか」「field name / CPT slug / menu location は何か」まで記載します。

## ACF 値の表示経路

```text
固定ページ編集画面
  ↓ 保存
ACF または投稿メタ
  ↓
inc/template-tags.php
  ├── theme_meta()
  ├── theme_text()
  ├── theme_lines()
  ├── theme_image()
  └── theme_rich()
  ↓
template-parts/<page>/<section>.php
  ↓
対象セクションへ安全に出力
```

ACF が無効でも投稿メタへ fallback し、未設定時は元 HTML 相当の値を表示します。通常テキスト、属性、URL、許可 HTML は用途別にエスケープします。

## CSS・JavaScript・画像

```text
inc/enqueue.php
  ├── 共通 CSS / JavaScript
  ├── フロントページ固有アセット
  └── 固定ページテンプレート固有アセット

セクションテンプレート
  └── theme_image()
        ├── ACF メディア
        └── assets/ 内の fallback
```

- 静的 HTML の読み込み順を依存関係へ変換する
- ページ固有アセットを全ページへ無条件に読み込まない
- CSS の `url()` と JavaScript 内の相対パスも確認する
- 未使用ライブラリを残す場合は、未読込であることと理由を記録する

## 初期構築

`tools-domain/bootstrap-site.example.php` と実行ラッパーは、案件値へ変更してから使用します。

標準処理:

1. 対象テーマを確認する
2. 必要な固定ページを slug で検索し、なければ作成する
3. 各ページへテンプレートを割り当てる
4. `${front_page_title}` をフロントページへ設定する
5. メニューを作成または更新し、menu location へ割り当てる
6. ACF / 投稿メタの空欄だけへ初期値を補完する
7. CPT を使う場合は安定した識別子で重複を防いで初期投稿を作る

既存ページ、既存メニュー、編集済みメタを無条件に削除・上書きしません。対象 WordPress と DB が確定するまで実行しません。

## 本番反映

- `DEPLOYMENT.md` に本番テーマ配置先、SSH、環境変数、除外ファイルを記載する
- `tools/deploy.sh` は対象テーマディレクトリ以外へ同期しない
- DB、uploads、別サイトをテーマ同期へ含めない
- GitHub 運用は `AGENTS.md` に従い、ローカル確認前に commit / push しない

## 修正するときの入口

- ページ内の文章・画像・URL: WordPress 管理画面
- 入力欄の追加・削除: `inc/acf-pages.php`
- 一覧項目の追加・並び替え: 対応する CPT
- HTML 構造: `template-parts/<page>/<section>.php`
- セクション順序: `template-parts/*-page-content.php`
- 共通ヘッダー・フッター: `site-header.php` / `site-footer.php`
- 読み込みアセット: `inc/enqueue.php`
- 見た目: `assets/css/`
- インタラクション: `assets/js/`
- fallback とエスケープ: `inc/template-tags.php`
- 固定ページ・メニュー・初期値: `tools-domain/`

## 案件化後の確認

- ページ対応表に全ページがある
- セクション台帳に全主要領域が表示順である
- `*-page-content.php` の呼び出し順と台帳が一致する
- 管理画面対応表と ACF / CPT / menu location が一致する
- README、DEPLOYMENT.md、実ファイル名が一致する
- ACF 無効時、未入力時、メニュー未割り当て時も fatal error にならない
- PHP lint、PHPCS、`rtk git diff --check`、既存テスト、ブラウザ確認を実施する
