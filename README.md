# 坂ノ上設計コーポレート（WordPress）

学習・個人制作の **WordPress テーマ**です。架空の地域建築設計事務所「**坂ノ上設計**」を想定したコーポレート構成で、配色・タイポグラフィ・レイアウトは Dawn 系グレーの汎用 LP と差別化しています。本文は **Noto Sans JP**（Google Fonts）で読み込みます。

## 要件

- WordPress 6.x / PHP 8.0+
- **Advanced Custom Fields（無料版で可）** — *Repeater は未使用*（無料プランでもフィールドがそのまま使えます）。

## ACF：手動でのフィールド作成は不要

テーマの `functions.php` が `acf_add_local_field_group` で **フロントページ用フィールド一式** を登録します。プラグインを有効化したうえで **固定ページをフロントに指定**すれば、編集画面にメタボックスが現れます。

| 名前（フィールド名） | 用途 |
| --- | --- |
| `tagline` | ヘッダー上の細い帯テキスト |
| `hero_kicker` / `hero_title` / `hero_lead` | ヒーローゾーン |
| `hero_image` | ヒーロー画像（未設定時はテーマ内 `assets/hero.jpg`） |
| `services_heading` | サービス見出し |
| `service_1_*` … `service_3_*` | サービスカード各3つ（`_title` / `_body` / `_image`）。画像未設定時は `hero.jpg` / `studio.jpg` を交代で表示 |
| `highlight_show` | サービス直下ブロック（見出し・本文・画像）の表示オン／オフ |
| `highlight_heading` / `highlight_body` / `highlight_image` | サービス直下ブロック。画像未設定時は `assets/studio.jpg` |
| `footer_contact_show` | 連絡先ブロックの表示オン／オフ |
| `footer_contact_heading` / `footer_contact_body` / `footer_phone` / `footer_email` | フッター連絡先 |

すべてローカル登録時に **`default_value`** を付けているため、値が未保存でもテンプレート側のフォールバックで **トップページの文言一式が表示**されます。

## セットアップ手順（概要）

1. `portfolio-corporate` を `wp-content/themes/` に配置し、外観 → テーマで有効化。  
2. プラグイン **Advanced Custom Fields** を有効化。  
3. 固定ページを1件作成し、**設定 → 表示設定**で「ホームページ」に指定。  
4. **設定 → パーマリンク** を「投稿名」に保存（リライトルール更新）。  
5. カスタム投稿タイプ **`news`** のアーカイブは `/news/`（テーマ有効化後にパーマリンク設定を一度保存すると確実です）。

## 開発用ツール（`tools/`）

**WordPress が読むテンプレートの一部ではありません。** Local と同じ Mac 上で PHP を実行し、ホーム固定ページへのデモ `post_meta` 投入などに使う補助スクリプトです。手順・パスの例は [NOTE.md](./NOTE.md) および親リポジトリの `shopify/MAC-ユーザーが操作する手順.md`（セクション 3-9）を参照してください。`WP_LOAD_PATH` または **`tools/local-wp-load.path`**（`local-wp-load.path.example` をコピー）で `wp-load.php` を指定します。

## 同梱画像のクレジット（テーマ `assets/`）

| ファイル | クレジット |
| --- | --- |
| `hero.jpg` | Unsplash · `photo-1487958449943-2429e8be8625`（撮影者名・ページ URL は Unsplash の該当写真ページに準拠してください） |
| `studio.jpg` | Unsplash · `photo-1497366216548-37526070297c`（同上） |

ライセンスは各プラットフォームの規約に従います。
