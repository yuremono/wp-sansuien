---
name: html-to-wp
description: 別ディレクトリの静的 HTML サイトを、現在の WordPress クラシックテーマ基盤へ移植する。既存実装の検出、資産移植、ページ・セクション単位のテンプレート化、管理画面化、初期構築、文書化、検証までを扱う。
---

# html-to-wp

別ディレクトリにある静的 HTML サイトを、作業先リポジトリの既存 WordPress テーマ構成へ移植するときに使う。

## 前提条件

- 作業先は、WP Template Directory をユーザーが複製し、案件固有名へリネームしたテーマディレクトリとする。
- WP Template Directory 自体を案件用に編集しない。
- 移植元は `/Users/yanoseiji/projects/0604past-works/` 内にあり、ユーザーが事前に用意したドメイン名のディレクトリを静的 HTML サイトとして参照する。
- ユーザーが Local by Flywheel に WordPress をインストール済みであることを前提とする。
- ユーザーが Xserver に公開先の新規サブディレクトリを作成済みであることを前提とする。
- Local の WordPress テーマディレクトリへ、案件固有テーマディレクトリを指すシンボリックリンクを作成してから移植作業を開始する。
- シンボリックリンク名は案件固有テーマのディレクトリ名と一致させ、既存リンクや実ディレクトリを誤って上書きしないことを確認する。
- Local のサイトパス、テーマディレクトリ、公開先サブディレクトリなど前提情報が不足または矛盾している場合は、作業を中断してユーザーへ確認する。

## GitHub 運用

- WP Template Directory ではcommit / pushを行わない。
- `html-to-wp` の移植作業中は、複製された案件固有テーマでもcommit / pushを行わない。
- ローカル表示と実装内容に問題がないことをユーザーが確認するまで、新規GitHubリポジトリを作成しない。
- ユーザー確認後に案件固有テーマ用の新規GitHubリポジトリを作成し、完成状態をcommitしてSSH形式のリモートURLへpushする。

## 最優先ルール

- 作業先の `AGENTS.md`、`README.md`、`docs/theme.example.md`、実ファイルを正とし、このスキルの例より優先する。
- テンプレート基盤を直接案件化せず、案件用にコピーされた作業先で実装する。
- 移植元ディレクトリは参照専用とし、HTML、CSS、JavaScript、画像を編集しない。
- `.bak` は読込・編集・削除しない。
- 作業開始前に、対象工程がすでに実施済みか確認する。既存ファイルを機械的に上書きしない。
- ユーザーの未コミット変更を保持し、関係のない変更を戻さない。
- puppeteer は使わない。

## 目的

- 元サイトの見た目、DOM 構造、既存クラス、資産パスの意味、読み込み順、ページ間リンクを保つ。
- 現行テーマの責務分離、helper、ACF fallback、メニュー、エスケープ規約へ適合させる。
- 共通ヘッダー、共通フッター、ページ本文、ページ別アセットを重複なく分離する。
- 各ページを意味のあるセクション単位へ分割し、表示順と編集箇所がファイル構成から分かる状態にする。
- WordPress の URL、管理画面、初期データ、ローカル構築、本番反映へ進める状態ではなく、ユーザーから除外指示がない限りそこまで実装する。

## このスキルの標準到達点

このスキルは、静的 HTML を PHP へ貼り替えて表示できた段階では完了しない。ユーザーが工程を限定していない限り、次を一つの作業範囲として扱う。

1. 全ページの WordPress テンプレート化
2. 共通外枠とページ固有本文の分離
3. ページ内の意味あるセクション単位へのテンプレートパーツ分割
4. CSS、JavaScript、画像、リンクの WordPress 対応
5. 編集対象の ACF / CPT / WordPress メニュー化
6. ACF 無効時の fallback と用途別エスケープ
7. 固定ページ、テンプレート割り当て、メニュー、初期値を安全に作る初期構築手段
8. `README.md`、`docs/theme.example.md`、`DEPLOYMENT.md` など実装に対応する文書更新
9. コード検証とローカル表示確認

管理画面化や初期構築を行わない場合は、ユーザーの明示指示、ライセンス、データモデル未確定などの理由を作業結果へ記録する。「後で ACF 化できる」だけでは標準到達点を満たさない。

## 現行テーマ基盤の前提

作業先に同等の構成がある場合は、新しい方式を追加せず既存構成を拡張する。

```text
header.php
  HTML 文書開始、language_attributes()、wp_head()、body_class()、wp_body_open()

footer.php
  wp_footer()、閉じタグ

template-parts/site-header.php
  共通表示ヘッダー

template-parts/site-footer.php
  共通表示フッター

front-page.php / page-templates/*.php
  ページの組み立て

template-parts/*-page-content.php
  #contents_wrap 以下のページ骨格

template-parts/<page>/*.php
  ページ固有セクション

inc/enqueue.php
  CSS / JavaScript の登録、依存、ページ条件

inc/helpers.php
  資産バージョンなどの低レベル helper

inc/template-tags.php
  資産 URI、body class、ページ判定、ACF fallback、安全な出力

inc/acf-pages.php
  ACF ローカルフィールド
```

- 通常は `get_header( 'name' )` / `get_footer( 'name' )` 用の専用 header/footer を新設しない。
- 静的サイトの `<header>` / `<footer>` は、それぞれ `site-header.php` / `site-footer.php` へ移す。
- `header.php` / `footer.php` は WordPress の文書骨格として維持する。
- `theme_source_uri()`、`theme_asset_version()`、`theme_meta()`、`theme_image()`、`theme_text()`、`theme_lines()`、`theme_rich()` など既存 helper があれば再利用する。
- PHP グローバル関数、ACF name は `snake_case`、新規独自 CSS クラスはプロジェクト規約に従う。移植元の既存クラスは変更しない。

## フェーズ 0: 読み取り専用の事前調査

編集前に、作業先と移植元を分けて調査する。

### 作業先

1. `AGENTS.md` と参照先の指示を読む。
2. `git status --short` で既存変更を把握する。
3. `README.md`、`docs/theme.example.md`、`functions.php` を読む。
4. `header.php`、`footer.php`、`front-page.php`、`page-templates/`、`template-parts/` を確認する。
5. `inc/enqueue.php`、`inc/helpers.php`、`inc/template-tags.php`、`inc/acf-pages.php` を確認する。
6. `assets/` を確認し、移植済みの CSS、JavaScript、画像がないか調べる。
7. `composer.json`、テスト、PHPCS、デプロイ手順を確認する。

### 移植元

1. 入口となる全 HTML と対応するページ名を列挙する。
2. 各 HTML の `head`、表示ヘッダー、本文、表示フッター、末尾 script を分離して比較する。
3. CSS、JavaScript、画像、フォント、iframe、外部 CDN を一覧化する。
4. HTML 内の `src`、`href`、CSS の `url()`、JavaScript 内の資産参照を確認する。
5. ページ別 CSS と共通 CSS、ページ別本文と共通部品を分類する。
6. 静的出力に含まれる動的生成物や外部サービス由来のスナップショットを特定する。

## 実施済み工程の判定

作業前に、次の状態を「未実施」「一部実施」「完了」に分類する。

- 案件名、テーマ名、slug、text domain の置換
- 静的資産の `assets/` へのコピー
- 共通ヘッダーとフッターの移植
- トップページ本文の移植
- 下層ページテンプレートの作成
- ページ別 CSS / JavaScript の enqueue
- 静的リンクの WordPress URL 化
- メニュー化
- ACF / CPT 化
- 初期ページ、メニュー、デモデータの投入
- ローカル表示確認
- 本番反映設定

一部実施済みの場合は、既存実装の意図と差分を確認して不足分だけを補う。完成済みの工程を別方式で作り直さない。

## 変換計画

編集前にページ対応表を作る。

| 静的 HTML | WordPress 側 | 本文パーツ | ページ別 CSS | 備考 |
| --- | --- | --- | --- | --- |
| `index.html` | `front-page.php` または `page-templates/top.php` | `template-parts/front-page-content.php` 以下 | 対応する CSS | トップ |
| 下層 HTML | `page-templates/<slug>.php` | `template-parts/<slug>-page-content.php` 以下 | 対応する CSS | 固定ページ |

表には全ページを含め、slug、テンプレート名、ナビゲーション表示名も確定する。

続けて、全ページのセクション台帳を作る。

| ページ | 表示順 | 元 HTML の範囲 | セクションの役割 | テンプレートパーツ | 編集方式 |
| --- | ---: | --- | --- | --- | --- |
| トップ | 1 | `#hero` | 主訴求 | `template-parts/front/hero.php` | ACF |
| トップ | 2 | `.introduction` | 導入 | `template-parts/front/introduction.php` | ACF |
| 下層 | 1 | `.page_title` | ページ見出し | `template-parts/<slug>/hero.php` | ACF |

- 元 HTML の `section` タグ数だけで機械的に分けない。見出し、背景、レイアウト、責務、管理画面の編集単位を基準にする。
- 一つの巨大な `example.php` に本文全体を残さない。ページの主要領域が複数あるなら、役割名を付けた複数ファイルへ分ける。
- `hero.php`、`introduction.php`、`menu-list.php`、`access.php`、`closing.php` のように役割が伝わる名前を使う。
- DOM や JavaScript の都合で分割できない場合は、その理由を台帳へ記録する。
- ページ対応表とセクション台帳は、実装後の `docs/theme.example.md` または案件用構成文書へ反映する。

管理画面化する内容について、管理画面対応表も作る。

| 表示箇所 | データ種別 | 管理方法 | 保存先 | fallback | 出力方法 |
| --- | --- | --- | --- | --- | --- |
| Hero 見出し | 単体テキスト | ACF | 投稿メタ | 元 HTML 文言 | `theme_text()` |
| メニュー一覧 | 増減可能な一覧 | CPT | 投稿 + メタ | 元 HTML データ | Loop + 用途別 escape |
| Header ナビ | 並び替え可能なリンク | WordPress メニュー | nav menu | 固定 fallback | `wp_nav_menu()` |

## 推奨実装順

1. 作業先の案件用プレースホルダーが未置換なら、`README.md` と `docs/theme.example.md` に従って置換する。
2. 移植元の `css/`、`js/`、`images/`、`img/` など必要資産を、構造を保って作業先の `assets/` へコピーする。
3. 参照されていない管理画面用画像や不要な生成物は、参照調査なしに全コピーしない。
4. 共通表示ヘッダーを `template-parts/site-header.php` へ移植する。
5. 共通表示フッターを `template-parts/site-footer.php` へ移植する。
6. トップ本文を `front-page-content.php` と `template-parts/front/` 以下へ分割する。
7. 下層ページごとに `page-templates/<slug>.php`、`<slug>-page-content.php`、`template-parts/<slug>/` を作る。
8. `theme_is_custom_view()` と `theme_body_classes()` を全移植ページへ拡張する。
9. CSS / JavaScript を `inc/enqueue.php` に集約し、共通とページ固有を条件分岐する。
10. 画像、内部リンク、外部リンク、電話、アンカー、iframe を用途別に変換する。
11. 必要なページとメニューの初期構築ツールを案件値へ調整する。
12. 静的 HTML と WordPress 出力を比較し、構造と表示を確認する。
13. 表示が安定したら、管理画面対応表に従って ACF / CPT / `wp_nav_menu()` へ移す。
14. 元 HTML の文言・画像・URLを fallback または初期値として一元化し、管理画面が空でも元表示を保つ。
15. 固定ページ、テンプレート割り当て、フロントページ、メニュー、未設定メタを安全に補完する初期構築ツールを案件値へ調整する。
16. 実装後のファイルツリー、ページ表示フロー、全セクションの順序、ACF / CPT / メニューの対応、アセット、初期構築、本番反映を構成文書へ記録する。

## 標準必須工程

ユーザーが工程を明示的に限定していない限り、次の順序を一続きの必須工程として完了する。表示だけ、セクション分割だけ、管理画面の定義だけで終了しない。

1. 全ページを調査し、本文を表示・保守・編集上の意味を持つセクションへ分割する。
2. 各 `*-page-content.php` をページ骨格と表示順どおりの `get_template_part()` 呼び出しへ縮小する。
3. セクションの文言、画像、URLをACFへ実接続し、未入力時とACF無効時のfallbackを実装する。
4. 増減・並び替えが必要な商品、料理、投稿などをCPTとtaxonomyへ実接続し、各セクションが分類済み投稿を取得して既存DOMへ出力する。
5. 固定ページ、テンプレート、フロントページ、メニュー、空欄メタ、必要なtaxonomy termとCPT seedを補完する非破壊bootstrapを実装する。
6. bootstrapはURL、テーマslug、明示的な確認トークンを照合し、既存値を削除または無条件上書きしない。
7. 本番サーバーへSSHで読み取り専用接続し、公開URLに対応するWordPressルートと `wp-content/themes` の実在を確認してから `DEPLOY_PATH` を確定する。
8. 固定ページや ACF の初期値が本番で未投入なら、`tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行し、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を使って対象環境を照合する。
9. デプロイは最初にdry-runを実行し、対象テーマ外への書き込み、意図しない削除、開発用ファイルや秘密情報の混入がないか除外監査する。
10. dry-run結果に問題がない場合だけ、ユーザーの指示または既定の承認手順に従ってapplyする。
11. 汎用構成テンプレートを直接案件文書へ変えず、テンプレートを複製した案件用文書へ実値を記載する。
12. 案件文書には全ページ入口、全セクション順、ACF field group、CPT/taxonomy、共通設定、編集フロー、非破壊bootstrap、Local URL、公開URL、確定した配置先、dry-run/apply、除外対象、修正入口、検証結果を含める。

ACF field groupやCPTを登録しただけでは「実接続」と扱わない。テンプレートがhelperまたはqueryを通して管理画面値を読み、fallbackを保持したまま既存DOMへ出力していることまで確認する。

本番配置先は、公開URLや一般的なホスティング構成から推測しない。SSHで対象WordPressの `wp-config.php`、`wp-content/themes`、対象テーマディレクトリを確認し、テーマslugまで含む絶対パスを確定する。

案件文書は `docs/theme.example.md` などの汎用テンプレートを構成の基準として複製し、別名で作成する。汎用テンプレートへ案件固有URL、SSH値、店舗名、配置先を混入させない。

## HTML の切り分け

- `<html>`、`<head>`、`<body>` は本文パーツへコピーしない。
- 静的 `<header id="global_header">` は `site-header.php` の候補。
- 静的 `<footer id="global_footer">` は `site-footer.php` の候補。
- `#contents_wrap` 以下は各 `*-page-content.php` の候補。
- 複数ページで完全一致する本文ブロックだけを共通テンプレートパーツにする。
- ページ固有のまとまりは `template-parts/<slug>/` へ置く。
- 既存 JS の selector に使われている空要素、ID、class は、参照確認前に削除しない。
- 静的 HTML の不正な入れ子や重複 ID は、まず再現し、表示確認後に影響を調べて直す。

## アセット移植

- 移植元のディレクトリ構造を極力保ち、機械的な参照変換を可能にする。
- HTML の画像は `theme_source_uri()` または既存の画像 helper を使い、`esc_url()` する。
- CSS 内の相対 `url()` は、CSS の配置先を変えると壊れるため必ず確認する。
- JavaScript 内の相対パスも検索する。
- ファイル名の大文字小文字を変えない。
- `img/` と `images/` のように複数ルートがある場合は、統合による衝突を避け、必要なら両方を `assets/` 下へ保持する。
- HTML が参照するファイルの存在確認を行い、元から欠損している参照と移植漏れを区別する。
- 静的 HTML 自体を保存用としてテーマへコピーするのは、ユーザーが求める場合か、比較用成果物として明確な用途がある場合だけにする。

## enqueue 設計

- `inc/enqueue.php` の既存関数を拡張し、別の enqueue 系統を重複作成しない。
- 共通 CSS、ページ別 CSS、共通 JavaScript、ページ別 JavaScriptを分類する。
- 静的 HTML の読み込み順を記録し、WordPress の依存配列へ置き換える。
- ページ固有アセットは `is_front_page()` / `is_page_template()` などで限定する。
- 依存配列には、登録または enqueue される handle だけを書く。
- handle は `theme-` + kebab-case とする。
- ローカル資産の version は既存の `theme_asset_version()` を使う。
- WordPress 同梱 jQuery を優先し、外部 jQuery と二重読み込みしない。
- `$` グローバルが必要なら、対象ページ群に限定して既存方式の互換処理を使う。
- footer や本文へ script を直書きせず、原則 enqueue する。
- `async`、`defer`、inline script が順序に影響する場合は、その属性と実行位置を維持する実装を選ぶ。
- 実際に使われていない plugin や CDN は、HTML に記載されているだけで無条件に移植しない。JS / DOM / CSS の参照を確認する。
- Google Analytics などの計測コードは、ID と運用要件を確認し、開発環境で意図せず送信しない。

## URL とナビゲーション

- `index.html` は `home_url( '/' )` へ変換する。
- 下層の `*.html` は、確定した固定ページ URL、`get_permalink()`、専用 URL helper、または `wp_nav_menu()` へ変換する。
- `#anchor`、`tel:`、`mailto:`、外部 URL は静的ページリンクと区別する。
- 未確定リンクは勝手に公開 URL を推測せず、ダミーであることを記録する。
- `target="_blank"` の外部リンクには `rel="noopener noreferrer"` を付ける。
- 共通ナビゲーションは最終的に `wp_nav_menu()` を優先するが、初期再現時は固定 HTML を保ってもよい。
- メニュー化する場合は、既存 `primary` / `footer` location と fallback を再利用する。
- ナビゲーションの表示名、順序、現在ページ class、スマートフォンメニューの selector を維持する。

## 管理画面化

- 静的 HTML の全要素を最初から ACF 化しない。まず固定テンプレートで表示を安定させ、その後に管理画面対応表どおり実装する。
- レイアウト用ラッパー、装飾 class、固定アイコンはテンプレートへ残し、編集者が変更する内容をデータ化する。
- ACF は `inc/acf-pages.php`、値取得と出力は `inc/template-tags.php` に集約する。
- ACF 無効時は投稿メタへ fallback し、fatal error を起こさない。
- ACF key は `group_pc_*` / `field_pc_*` または案件で確定した固定接頭辞を使い、公開後に変更しない。
- text、textarea、URL、画像、WYSIWYG は既存 helper とエスケープ方式を再利用する。
- 編集頻度の高い単体文言、画像、CTA は ACF の候補。
- 投稿、事例、商品、メニュー、FAQ など増減・並び替えが必要な一覧は CPT を検討する。
- 静的な SNS 埋め込み一覧は、更新方法を確認してから CPT、外部 API、埋め込み、固定 HTML のいずれかを選ぶ。
- 初期データ投入は既存内容を上書きせず、未設定値だけを補完する。

## 初期構築と文書化

- `tools-domain/bootstrap-site.example.php` など既存の初期構築方式があれば、全固定ページ、テンプレート、フロントページ設定、メニュー、初期値へ拡張する。
- 初期構築は slug や安定した識別子で既存データを探し、存在しないものだけ作成し、空欄だけ補完する。
- 実行対象の WordPress と DB が確定するまで初期構築スクリプトを実行しない。
- `docs/theme.example.md` は汎用基盤では置換用テンプレート、案件テーマでは実装済み構成の説明書として更新する。
- 構成文書には最低限、プレースホルダーまたは案件値、全体ツリー、ページ表示フロー、ページ別セクション一覧、共通部品、`inc/`、管理画面対応、アセット、初期構築、デプロイ、修正入口を書く。
- README のファイル名や手順が実装と食い違う状態を残さない。

## セキュリティと出力

- 通常テキストは `esc_html()` または `theme_text()`。
- 属性値は `esc_attr()`。
- URL は `esc_url()`。
- 改行テキストは既存の `theme_lines()`。
- 画像は既存の `theme_image()` または用途に合う WordPress 画像 API。
- 許可 HTML は `wp_kses()` または `theme_rich()`。
- iframe は許可ドメインと属性を限定して出力する。
- 管理画面値、投稿メタ、URL パラメータを未エスケープで出力しない。
- 外部 script、古いライブラリ、追跡コードは、必要性とリスクを確認してから導入する。

## 既存テーマとの干渉確認

- `body_class()` の追加 class と CSS selector を確認する。
- `visibility: hidden`、ローディング、overlay、scroll lock、pending class がないか確認する。
- 共通 JS を除外する場合、JS が解除する前提の class や要素も対象ページから除外する。
- `theme_is_custom_view()` の追加漏れでアセットが読み込まれない状態を防ぐ。
- `theme_body_classes()` が全下層ページをトップ扱いしないよう、ページ別 class を設計する。
- `page.php` や `index.php` など、移植対象外ページの挙動を壊さない。

## 検証

### 静的比較

- 全ページについて、header、本文、footer、CSS、JavaScript、画像、リンクの対応を確認する。
- 元 HTML に存在する参照先が、移植先にも存在するか機械的に確認する。
- 共通部品の差分が意図したページ固有差分だけか確認する。

### HTTP / DOM

- `curl -sS -D - <url>` で HTTP `200` を確認する。
- HTML に `wp_head()` / `wp_footer()` の出力があることを確認する。
- 対象本文、body class、ページ別 CSS / JavaScript が出力されることを確認する。
- 二重 script、404 asset、不要な pending class、意図しないダミーリンクがないことを確認する。

### ブラウザ

- プロジェクトで指定されたブラウザ手段を使い、puppeteer は使わない。
- デスクトップとモバイル幅で、初期表示、画像、メニュー、アンカー、スライダー、モーダル、スクロール、iframe を確認する。
- コンソールの JavaScript error とネットワークの 404 を確認する。
- JavaScript 有効時と、必要に応じて無効時の初期表示を確認する。

### コード

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
composer run phpcs
rtk git diff --check
```

- リポジトリのテストを実行する。
- テスト対象がある場合は最小カバレッジ 80% を維持する。
- Composer、WordPress、ローカル URL などがなく実行できない検証は、理由と未確認範囲を報告する。

## 完了条件

- 対象となる全静的ページに WordPress 側の対応先がある。
- 共通 header / footer とページ固有本文の責務が分離されている。
- CSS / JavaScript が必要なページだけへ正しい順序で読み込まれる。
- 画像、内部リンク、外部リンク、電話、アンカー、iframe が用途に合う形で動作する。
- `wp_head()`、`wp_footer()`、`body_class()`、`wp_body_open()` が保たれている。
- ACF が無効でも fatal error にならない。
- 各ページの主要領域が役割名を持つセクションパーツへ分割され、呼び出し順が追える。
- 編集対象の文言、画像、URL、一覧、ナビゲーションが管理画面対応表どおり実装されている。
- 初期構築ツールが既存データを壊さず、必要なページ・テンプレート・メニュー・初期値を補完できる。
- 構成文書が実装済みのページ、セクション、管理画面、アセット、運用手順と一致している。
- PHP lint、PHPCS、diff check、既存テスト、ブラウザ確認の結果が記録されている。
- 移植元と無関係な作業先ファイルを変更していない。
- 移植元ディレクトリを変更していない。

## やってはいけないこと

- 移植元 HTML を直接編集して辻褄を合わせる。
- 現行テーマに既存の header/footer/helper/enqueue があるのに、並行する独自方式を追加する。
- 全ページを一つの巨大テンプレートへ貼り付ける。
- ページ本文を `example.php` のような一つの汎用名ファイルへ残し、セクションの役割と順序を文書化しない。
- すでに完了している資産コピーやテンプレート化を無条件にやり直す。
- 静的リンクを根拠なく仮 slug へ置換する。
- ACF の存在を前提に直接 `get_field()` の結果を出力する。
- CSS 内 `url()` や JavaScript 内の相対参照を確認せず、資産ディレクトリを再編する。
- 古い外部ライブラリや計測コードを必要性の確認なしにそのまま有効化する。
- 表示確認だけで完了とし、lint、PHPCS、リンク、404、コンソール error を確認しない。
- 「管理画面化の前段」「後で初期構築できる状態」を完了扱いし、標準到達点の工程を未実装のまま終える。
