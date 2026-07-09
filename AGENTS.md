# AGENTS.md

湖畔の一軒宿「山水園」の静的サイトをクラシックWordPressテーマへ移植した案件テーマ。

### GitHub 運用

- ユーザーレベルのAGENTS.md/CLAUDE.mdに従う

### 命名

- PHP グローバル関数: `snake_case`
- 定数: `THEME_` + `SCREAMING_SNAKE_CASE`
- ACF key: `group_pc_*` / `field_pc_*` または案件で決めた固定接頭辞
- ACF name: `snake_case`
- CSS設計についてはユーザーの指示があれば優先する。
- `wp_enqueue_*` ハンドル: `theme-` + kebab-case

### コマンド

#### 検証

| コマンド | 用途 |
|---|---|
| `find . -name '*.php' -not -path './vendor/*' -print0 \| xargs -0 -n1 php -l` | PHP構文チェック |
| `composer run phpcs` | コーディング規約チェック（`phpcs.xml.dist`） |
| `composer run phpcbf` | 自動整形 |
| `composer run test` | `tests/run.php` によるテスト実行 |
| `composer run test:coverage` | カバレッジ付きテスト実行 |
| `rtk git diff --check` | 差分の空白・改行チェック |

#### デプロイ

| コマンド | 用途 |
|---|---|
| `./deploy.sh` | `tools/deploy.sh` のラッパー。既定はdry-run |
| `./tools/deploy.sh --apply` | 本番への実反映 |
| `./tools/deploy.sh --apply --import-xml` | 実反映と同時にXML取り込み（`--apply` 併用時のみ有効） |

`DEPLOY_PATH` が未確定・相対パス・`wp-content/themes` 配下でない・末尾のテーマslugが不一致、のいずれかの場合、`tools/deploy.sh` は実行を停止する。本番反映前に `DEPLOYMENT.md` を確認し、対象テーマディレクトリ以外へ同期しない。

### 主要ディレクトリ・ファイル

| パス | 役割 |
|---|---|
| `inc/acf-pages.php` | ACF field group 定義 |
| `inc/template-tags.php` | ACF値取得・fallback・エスケープ済み出力の集約 |
| `template-parts/` | ヘッダー・フッター・セクション単位のテンプレート |
| `assets/css/`、`assets/js/`、`assets/images/` | 案件ごとの静的資産 |
| `tools/`、`tools-domain/` | デプロイ・bootstrap 等の開発ツール（配布ZIP・本番同期の対象外） |
| `tests/` | 依存なしのテストランナーとテストケース |
| `docs/theme.example.md` | 置換一覧・案件初期設定の手引き |

### 行動原則

- 外科的な変更: 既存コードを編集する際、必要な部分だけ触る。自分の変更で出た問題だけ片付ける。
- 初めて編集するファイルは、編集前に必ず内容を確認する。
- `.gitignore` に含まれるファイルを強制 push しない。公開が必要な場合はユーザーへ報告する。
- ユーザーの指示がないのに勝手に本ファイル（AGENTS.md）を編集しない。
- ブラウザ確認、ビルド、テストをユーザーの指示がない時に実行しない。問題が生じたときに実行すればよい。
- 全ての色は`oklch`で書かれた変数を定義する。WH50などで指定。
- 変数をそのまま使用するクラスを定義し優先的に使う(`wid PX BorderXY BGgrad`等)
- 確実に必要な場合以外、`overflow` プロパティを指定しない。`hidden` が必要に見える場合も、まず  `overflow-clip` / `overflow-x-clip` / `overflow-y-clip` を優先する。

### WordPress用スキル

- html-to-wp: 静的HTMLサイトを、現在のWordPressクラシックテーマ基盤へ移植する
- wp-admin: 表示内容（ACFフィールド、固定ページ、CPT、メニュー、WYSIWYG本文等）を管理画面から編集できるようにする
- wp-deploy: 本番反映・SSH同期・配布ZIP・XML取り込みなどデプロイ関連を扱う
- anonymize: 旧案件の店名・人名・住所・電話番号・画像内文字などの固有名詞を案件用に置換する

### ブラウザ確認

- ブラウザでの見た目確認やスクリーンショット比較が必要なときは、`agent-browser` スキルを実行する。
- スクリーンショットはプロジェクト内の `tmp/browser-checks/` を既定の保存先とする。

### 禁止事項

<important if="creating or editing files">
- 調査・検討段階で作業を始めない（ユーザーの口調で判断する）
- 秘密情報やファイルパスに含まれるユーザー名を、公開されるファイルに書かない
- 仕様系ドキュメントには「今の状態」だけを書く。「どこから移動した」「〜に統合済み」等の編集履歴・経緯のメモは残さない（進捗ドキュメントは例外）
</important>

<important if="overwriting, deleting, or resetting">
- 調査・検討段階で作業を始めない（ユーザーの口調で判断する）
- コメントアウトされたコードはユーザーが意図的に残しているので、作業に関連があっても削除しない。ファイル削除の指示がある場合は、その意図がないと判断し、削除してよい。
</important>
