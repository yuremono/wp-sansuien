# 居酒屋テーマ デプロイ手順

## 確定済み設定

- 公開URL: `https://yuremono.com/izakaya/`
- 実際の site_url: `http://yuremono.com/izakaya`
- SSH host: `xs966275.xsrv.jp`
- SSH user: `xs966275`
- SSH port: `10022`
- テーマslug: `0606wp-izakaya`
- WordPressルート: `/home/xs966275/yuremono.com/public_html/izakaya`
- 本番 `DEPLOY_PATH`: `/home/xs966275/yuremono.com/public_html/izakaya/wp-content/themes/0606wp-izakaya`

SSHの読み取り専用調査で、公開URL専用の `wp-config.php` と `wp-content/themes` が上記WordPressルート内に実在することを確認済みです。
本番では `tools-domain/bootstrap-site.example.php` を `wp eval-file` 経由で実行し、固定ページ、フロントページ設定、メニュー、ACF の空欄補完を非破壊で流し込み済みです。

## テーマ反映

1. `.env.deploy.example` を `.env.deploy` へコピーする。
2. `DEPLOY_HOST`、`DEPLOY_USER`、`DEPLOY_PORT`、`DEPLOY_PATH` を再確認する。
3. `tools-domain/deploy-theme.example.sh` でdry-run結果を確認する。
4. 必要なら `tools-domain/deploy-theme.example.sh --zip-only` でZIPだけを生成する。
5. 差分に問題がなければ `tools-domain/deploy-theme.example.sh --apply` で同期する。
6. 固定ページや ACF の初期値を再投入する必要があるときは、`THEME_BOOTSTRAP_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_CONFIRM`、`THEME_BOOTSTRAP_EXPECTED_URL` を指定して `wp eval-file` で `tools-domain/bootstrap-site.example.php` を実行する。
7. 公開URLで全ページ、画像、メニュー、404、JavaScriptエラーを確認する。

`tools/deploy.sh` は次の場合に停止します。

- `DEPLOY_PATH` が未確定プレースホルダー
- 絶対パスではない
- `/wp-content/themes/` 配下ではない
- パス末尾がテーマslug `0606wp-izakaya` と完全一致しない

通常実行はdry-runです。`--apply` なしではリモートを変更しません。`--import-xml` は `--apply` と同時指定した場合だけ実行されます。

ZIPとリモート同期にはテーマ実行ファイルだけを含めます。`.serena/`、`tasks/`、`tools/`、`tools-domain/`、`docs/`、各種エージェント設定、依存パッケージ、README、DEPLOYMENTなどの開発・運用ファイルは除外されます。
