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

## フェーズ 1 調査結果（サブエージェントが追記）
