# Sansuien WordPress Theme

湖畔の一軒宿「山水園」の静的サイトをクラシックWordPressテーマへ移植した案件テーマです。

## 環境

- Local URL: `http://localhost:10023`
- `wp-load.php`: `/Users/yanoseiji/Local Sites/sansuien/app/public/wp-load.php`
- 公開URL: `http://yuremono.com/sansuien/`
- 実際の site_url: `http://yuremono.com/sansuien`
- テーマslug: `sansuien`

## 構成

- `front-page.php`: トップページ（`template-parts/front-page-content.php` が hero/gallery/feature/voices/about/news-feed/closing の各セクションを呼び出す）
- `single-room.php`: 客室個別ページ（CPT `room`）
- `archive-room.php`: 客室一覧ページ（CPT `room` のアーカイブ）
- `template-parts/site-header.php` / `site-footer.php`: 共通ヘッダー・フッター
- `template-parts/reserve-tab.php`: 画面右下固定の予約導線タブ
- `template-parts/front/`: トップページの実セクション
- `inc/template-tags.php`: ACF fallback、画像、URL、安全な出力
- `inc/acf-pages.php`: 宿泊施設共通情報、トップページ、客室・お知らせ CPT の ACF field group
- `inc/cpt.php`: 客室（room）、お知らせ（news）
- `tools-domain/`: 非破壊bootstrapとデプロイラッパー
- `docs/sansuien.md`: 実装、編集、初期構築、デプロイの案件用構成資料

`assets/css/`、`assets/js/`、`assets/images/` は案件の静的サイト資産（`tmp/sansuien/`）から移植した資産を置く領域です。

## 初期構築

1. LocalのWordPressが `http://localhost:10023` で起動していることを確認する。
2. `bootstrap-site.example.php` のページ、メニュー、CPT設定を確認する。
3. `THEME_BOOTSTRAP_CONFIRM=sansuien-local tools-domain/run-bootstrap-site.example.sh` を実行する。
4. 本番で固定ページや ACF の空欄補完を再実行する必要がある場合は、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を指定して `tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行する。

初期構築はフロントページ、primary/footerメニュー、宿泊施設共通情報の ACF 空欄を補完します。既存ページ、既存メニュー項目、入力済みメタは削除・上書きしません。客室・お知らせの初期コンテンツは、必要に応じて `content` 配列へ追加してから実行してください。

## 検証

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
composer run phpcs
rtk git diff --check
```

本番 `DEPLOY_PATH` は `/home/xs966275/yuremono.com/public_html/sansuien/wp-content/themes/sansuien` です。反映前に [DEPLOYMENT.md](./DEPLOYMENT.md) の停止条件とdry-run手順を確認してください。
./deploy.sh

配布ZIPと本番同期には、PHPテンプレートと実行時アセットだけを含めます。README、デプロイ文書、開発ツール、タスク記録、依存パッケージは配布しません。
