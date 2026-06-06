# tools-domain/

テーマごとに値を変更する補助ツールの雛形を置く。

## 使用前の手順

1. このリポジトリ自体を直接案件用に書き換えず、ディレクトリ全体をコピーする。
2. `bootstrap-site.example.php` 冒頭のURL、テーマslug、ページ、メニュー、初期データを確認する。
3. `THEME_BOOTSTRAP_CONFIRM=izakaya-local` を明示し、対象URLが `http://localhost:10018` であることを確認して実行する。
4. 本番用 `DEPLOY_PATH` は未確定。サーバー上の絶対パスを確認するまで設定・実行しない。

## ファイル

- `bootstrap-site.example.php`: 対象確認、全固定ページ、テンプレート、ホーム設定、primary/footerメニュー、空欄メタ、登録済みCPT/taxonomy初期値を非破壊で補完。
- `run-bootstrap-site.example.sh`: ローカル PHP から bootstrap を実行するラッパー。
- `sync-nav.example.php`: bootstrap と同じ設定でメニューを同期する入口。
- `deploy-theme.example.sh`: `tools/deploy.sh` に案件固有のテーマスラッグと ZIP 名を渡す。

既存ページ、既存メニュー項目、入力済みメタは削除・上書きしない。CPT/taxonomy初期値はテーマ側で登録済みの型だけを扱う。
