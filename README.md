# Izakaya WordPress Theme

居酒屋サイトをクラシックWordPressテーマへ移植した案件テーマです。

## 環境

- Local URL: `http://localhost:10018`
- `wp-load.php`: `/Users/yanoseiji/Local Sites/izakaya/app/public/wp-load.php`
- 公開URL: `https://yuremono.com/izakaya/`
- 実際の site_url: `http://yuremono.com/izakaya`
- テーマslug: `0606wp-izakaya`

## 構成

- `page-templates/top.php`: トップ固定ページ用テンプレート
- `page-templates/genshu.php`: 焼酎の原酒
- `page-templates/shochu.php`: 本格焼酎
- `page-templates/other.php`: その他のお酒
- `page-templates/otsumami.php`: おつまみ
- `page-templates/insta.php`: お知らせ
- `page-templates/info.php`: 店舗案内
- `template-parts/site-header.php`: 維持して使う共通表示ヘッダー
- `template-parts/site-footer.php`: 店舗共通情報、地図、フッターメニュー
- `template-parts/front/`: トップページの実セクション
- `template-parts/genshu/` ほか: 各固定ページの実セクション
- `inc/template-tags.php`: ACF fallback、画像、URL、安全な出力
- `inc/acf-pages.php`: 店舗共通情報、全ページ、CPTのACF field group
- `inc/cpt.php`: ドリンク、料理、お知らせと各taxonomy
- `tools-domain/`: 非破壊bootstrapとデプロイラッパー
- `docs/izakaya.md`: 実装、編集、初期構築、デプロイの案件用構成資料

`assets/css/`、`assets/js/`、`assets/images/` は案件の静的サイト資産を置く領域です。

## 初期構築

1. LocalのWordPressが `http://localhost:10018` で起動していることを確認する。
2. `bootstrap-site.example.php` のページ、メニュー、CPT/taxonomy設定を確認する。
3. `THEME_BOOTSTRAP_CONFIRM=izakaya-local tools-domain/run-bootstrap-site.example.sh` を実行する。
4. 本番で固定ページや ACF の空欄補完を再実行する必要がある場合は、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を指定して `tools-domain/bootstrap-site.example.php` を `wp eval-file` で実行する。

初期構築は全固定ページ、テンプレート、フロントページ、primary/footerメニュー、空欄メタを補完します。既存ページ、既存メニュー項目、入力済みメタは削除・上書きしません。CPT/taxonomy初期データはテーマ側で型が登録済みの場合だけ設定配列へ追加できます。
本番では `home`、`genshu`、`shochu`、`other`、`otsumami`、`insta`、`info` の固定ページと、店舗共通情報の ACF 初期値を投入済みです。

## 検証

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
composer run phpcs
rtk git diff --check
```

本番 `DEPLOY_PATH` は `/home/xs966275/yuremono.com/public_html/izakaya/wp-content/themes/0606wp-izakaya` です。反映前に [DEPLOYMENT.md](./DEPLOYMENT.md) の停止条件とdry-run手順を確認してください。

配布ZIPと本番同期には、PHPテンプレートと実行時アセットだけを含めます。README、デプロイ文書、開発ツール、タスク記録、依存パッケージは配布しません。
