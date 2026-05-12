# AGENTS.md

## 命名

| 種別 | ルール | 例 |
| --- | --- | --- |
| PHP グローバル関数 | `theme_` + snake_case | `theme_front_meta` |
| 定数 | `THEME_` + SCREAMING_SNAKE_CASE | `THEME_GETTEXT_DOMAIN` |
| テーマ公開フィルター | `theme_` で開始 | `theme_brand` |
| ACF グループ／フィールドの `key` | `group_pc_*` / `field_pc_*`（公開後は変更しない） | `group_pc_front_page` |
| ACF フィールドの `name`（メタキー） | snake_case、ブロックごとに接頭辞をそろえる | `hero_*`, `service_1_*`, `footer_contact_*` |
| クラス名 | snake_case| `hero_*`, `service_*`, `footer_contact_*` |
| CPT スラッグ | 小文字の短い英単語 | `news` |
| メニュー位置 | 短い英単語 | `primary` |
| `wp_enqueue_*` ハンドル | `theme-` + kebab-case | `theme-main-css` |

## 出力（ACF 含む）

テンプレートでは **属性・本文・URL ごとに** `esc_attr` / `esc_html` / `esc_url`（など）を使う。ACF の戻りはそのまま `echo` しない。

## 入力欄をどう増やすか（このテーマの前提）

ページに載せる文章や画像の**中身**は、「そのページの編集画面」から入れる。

フロントページは `group_pc_front_page`（ロケーション: フロントページ）。その他のカスタムページテンプレートはテーマ内 `inc/acf-page-templates.php` で **テンプレートファイルごと** に `group_pc_page_*` を定義し、`page_template` ルールで表示を切り替える。

一方で、入力欄の**種類や並び**はテーマの PHP に書いてある想定。**種類を増やしたり並び替えたりするときはコードを直す前提**で、拡張機能の設定画面だけで項目を増やす運用は想定しない。

有料版のリピーター機能は使用予定なし。

## PHP の静的チェック（PHPCS）

テーマ直下で **`composer install`**（初回のみ）のあと **`composer run phpcs`**。WordPress のコーディング規約に沿っているかを機械的に検査する。自動修正できるものは **`composer run phpcbf`**。

## `tools/`

ブラウザでサイトを開いているだけでは**実行されない**。ターミナルから `php` で読み込んで動かす補助スクリプト。

つなぐデータベースやサイトは、実行するときの環境設定で決まる。**意図していないサイト／データに対してデモ投入などを流さない**こと（別フォルダのサイトを指していたら、そのサイトの内容が変わる）。

Cursor から Local WP を更新する手順は [LOCAL_CURSOR_CLI.md](./LOCAL_CURSOR_CLI.md)。

手順は [NOTE.md](./NOTE.md) と各ファイル先頭のコメント。

## メニューのテーマロケーション

`register_nav_menus` の **`primary`** がメインメニュー。**プライマリに紐付けたメニューをデモ生成する**ときは、`tools/` のシード用スクリプトや外観 → メニューの割り当てで `primary` を指定する。
