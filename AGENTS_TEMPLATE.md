# AGENTS.md

このリポジトリは、案件ごとにディレクトリ全体をコピーして使う WordPress クラシックテーマ基盤。
常に日本語で回答する。

## 作成中の指示

案件用にディレクトリをコピーした直後から、テーマ実装が一通り完成するまで従う。

### HTML から WordPress への移植

- 静的 HTML サイトを WordPress テーマへ移植する場合は、 `html-to-wp` スキルを使用する。
- 作業対象が「Current Directory のみ」か「Current Directory と WP Template Directory の両方」かを、ユーザーの指示から判定する。
- 反映範囲が明確でない場合は、編集を始める前に必ずユーザーへ確認する。

### GitHub 運用

- ユーザーの指示があるまでGitHubへの commit / push を行わない。
- 特に指定がない限り基本的にテーマ固有の新規GitHubリポジトリをSSH形式のリモートURLで作成する

### コピー後の設定

- コピー元を直接案件用に変更せず、コピー先で作業する。
- `Example Theme`、`example-theme`、`Example`、`example` などのファイル、ディレクトリ、記述を案件値へ置換する。
- `docs/theme.example.md` と `README.md` の置換一覧を確認する。
- `.bak` は予備ファイル。読込・編集・削除をしない。

### 実装

- `assets/css/`、`assets/js/`、`assets/images/` は案件ごとの静的資産領域。
- ヘッダーは `template-parts/site-header.php` を基礎として維持する。
- フッターと本文は骨格から案件ごとに構築する。
- ACF は `inc/acf-pages.php`、値取得は `inc/template-tags.php` に集約する。
- ACF 無効時に fatal error を起こさず、投稿メタへ fallback する。
- 属性、本文、URL、許可 HTML は用途別にエスケープする。
- リピーターを前提にせず、増減可能な一覧には CPT を検討する。

---

## 完成後のルール

テーマ実装が一通り完成した後に適用する、命名・検証・運用のルール。

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

### Execution rules

- 外科的な変更: 既存コードを編集する際、必要な部分だけ触る。自分の変更で出た問題だけ片付ける。
- 初めて編集するファイルは、編集前に必ず内容を確認する。
- `.gitignore` に含まれるファイルを強制 push しない。公開が必要な場合はユーザーへ報告する。
- ユーザーの指示がないのに勝手に本ファイル（AGENTS.md）を編集しない。
- ブラウザ確認、ビルド、テストをユーザーの指示がない時に実行しない。問題が生じたときに実行すればよい。
- 全ての色は`oklch`で書かれた変数を定義する。WH50などで指定。
- 変数をそのまま使用するクラスを定義し優先的に使う(`wid PX BorderXY BGgrad`等)
- 確実に必要な場合以外、`overflow` プロパティを指定しない。`hidden` が必要に見える場合も、まず  `overflow-clip` / `overflow-x-clip` / `overflow-y-clip` を優先する。

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
