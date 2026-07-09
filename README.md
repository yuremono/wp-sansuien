# Sansuien WordPress Theme

湖畔の一軒宿「山水園」の静的サイトをクラシックWordPressテーマへ移植した案件テーマ。

## 環境

- テーマslug: `sansuien`
- Local URL、`wp-load.php` の絶対パス、公開URL、site_url は開発者のローカル環境・非公開ファイルに保持。`tools/local-wp-load.path`（gitignore 対象）と `.env.deploy`（gitignore 対象）を参照。

## 構成

客室・お知らせは標準「投稿」＋カテゴリー（`room` / `news`）で管理します（カスタム投稿タイプは不使用）。

- `header.php` / `footer.php`: 共通ヘッダー・フッター（`template-parts/site-header.php` / `reserve-tab.php` / `site-footer.php` を内包）
- `front-page.php`: トップページ（`template-parts/front-page-content.php` が hero/gallery/feature/voices/about/news-feed/closing の各セクションを呼び出す）
- `page-room.php`: 「客室のご案内」固定ページ（`template-parts/room-page-content.php` 以下のセクション）
- `page-contact.php`: 「お問い合わせ・ご予約」固定ページ
- `page.php`: その他の一般固定ページ
- `category-room.php`: 客室一覧ページ（カテゴリー `room` のアーカイブ）
- `category-news.php`: お知らせ一覧ページ（カテゴリー `news` のアーカイブ、`/news/` で提供）
- `single.php`: 標準投稿の個別ページ（カテゴリー `room` は客室詳細レイアウト、それ以外はシンプルなお知らせレイアウトへ振り分け）
- `404.php` / `index.php`: 404 ページ／その他の汎用 fallback
- `template-parts/front/`: トップページの実セクション
- `inc/template-tags.php`: ACF fallback、画像・Gallery、URL、安全な出力
- `inc/acf-pages.php`: 宿泊施設共通情報、トップページ、固定ページ、客室・お知らせカテゴリーの ACF field group
- `inc/demo-content.php`: ACF default_value・テンプレート fallback・bootstrap seed 値が共有するデモ文言の単一情報源
- `inc/contact-form.php`: Contact Form 7 連携（フォームID参照、ハニーポット）
- `tools-domain/`: 非破壊bootstrapとデプロイラッパー
- `docs/sansuien.md`: 実装、編集、初期構築、デプロイの案件用構成資料

`assets/css/`、`assets/js/`、`assets/images/` は案件の静的サイト資産（`tmp/sansuien/`）から移植した資産を置く領域です。

## 初期構築

1. LocalのWordPressが `tools/local-wp-load.path`（gitignore 対象）記載のURLで起動していることを確認する。
2. `bootstrap-site.example.php` のページ、メニュー、客室・お知らせの初期コンテンツ設定を確認する。
3. `THEME_BOOTSTRAP_CONFIRM=sansuien-local tools-domain/run-bootstrap-site.example.sh` を実行する。
4. 本番で固定ページや ACF の空欄補完を再実行する必要がある場合は、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を指定して `tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行する。

初期構築はフロントページ、primary/footerメニュー、宿泊施設共通情報の ACF 空欄を補完します。既存ページ、既存メニュー項目、入力済みメタは削除・上書きしません。客室・お知らせの初期コンテンツは、必要に応じて `content` 配列へ追加してから実行する。

## 検証

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
composer run phpcs
rtk git diff --check
```

本番 `DEPLOY_PATH` は `.env.deploy`（gitignore 対象）を参照。反映前に [DEPLOYMENT.md](./DEPLOYMENT.md) の停止条件とdry-run手順を確認。
./deploy.sh

配布ZIPと本番同期には、PHPテンプレートと実行時アセットだけを含める。README、デプロイ文書、開発ツール、タスク記録、依存パッケージは配布しない。
