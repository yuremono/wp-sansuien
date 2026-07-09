# Sansuien WordPress Theme

湖畔の一軒宿「山水園」の静的サイトをクラシックWordPressテーマへ移植した案件テーマ。
https://yuremono.com/sansuien/

## 動作要件

- WordPress 6.0以上（6.8で動作確認）
- PHP 8.0以上
- 必須プラグイン: Secure Custom Fields（無料。または Advanced Custom Fields PRO）、Contact Form 7
- 推奨プラグイン（任意）: Simple Custom Post Order または Intuitive Custom Post Order（客室・お知らせの並び替え用）

いずれのプラグインも無効時に fatal error は起きず、テーマ内蔵のデモ内容や電話番号案内へフォールバックします。詳細は [docs/sansuien.md](./docs/sansuien.md) の「必須プラグイン」を参照。

## 環境

- テーマslug: `sansuien`
- Local URL、`wp-load.php` の絶対パス、公開URL、site_url は開発者のローカル環境・非公開ファイルに保持。`tools/local-wp-load.path`（gitignore 対象）と `.env.deploy`（gitignore 対象）を参照。

## 管理画面構成

客室・お知らせは標準「投稿」＋カテゴリー（`room` / `news`）で管理。（カスタム投稿タイプは不使用）。

## ディレクトリ構成

```
0606wp-sansuien/
├── assets/
│   ├── css/               スタイルシート（style.css）
│   ├── images/             画像素材
│   └── js/                 フロントエンドJS（theme.js）
├── docs/                    実装・編集・初期構築・デプロイの案件用構成資料
├── inc/
│   ├── acf-pages.php        ACF field group定義
│   ├── contact-form.php      Contact Form 7連携
│   ├── demo-content.php      デモ文言の一元管理
│   ├── enqueue.php           CSS/JS読み込み
│   ├── helpers.php           汎用ヘルパー
│   ├── setup.php             theme support・メニュー・カテゴリー登録
│   └── template-tags.php     ACF取得・fallback・エスケープ出力
├── template-parts/
│   ├── front/               トップページの実セクション（hero.php...）
│   ├── room/                 下層ページの実セクション（hero.php...）
│   ├── contact-page-content.php
│   ├── front-page-content.php
│   ├── reserve-tab.php
│   ├── room-page-content.php
│   ├── single-post-content.php
│   ├── single-room-content.php
│   ├── site-footer.php
│   └── site-header.php
├── tests/                   依存なしのテストランナーとテストケース
├── tools/                   デプロイラッパーとローカル設定（配布ZIP・本番同期の対象外）
├── tools-domain/             非破壊bootstrap・移行・同期スクリプト（配布ZIP・本番同期の対象外）
├── .env.deploy.example       本番デプロイ用環境変数のテンプレート
├── .gitignore                 Git管理対象外パターンの定義
├── 404.php                   404ページ
├── AGENTS.md                 エージェント向け指示
├── AGENTS_TEMPLATE.md         エージェント向け指示汎用テンプレート
├── category-news.php         お知らせ一覧ページ（カテゴリー `news` のアーカイブ）
├── category-room.php         客室一覧ページ（カテゴリー `room` のアーカイブ）
├── CLAUDE.md                 AGENTS.mdを読み込むエントリーポイント
├── composer.json              PHP依存パッケージとcomposerスクリプト定義
├── composer.lock               composer.jsonのロックファイル
├── DEPLOYMENT.md              本番デプロイの停止条件とdry-run手順
├── deploy.sh                  tools/deploy.sh のラッパー
├── footer.php                 共通フッター
├── front-page.php             トップページ
├── functions.php              読み込み順の起点
├── header.php                 共通ヘッダー
├── index.php                  汎用fallbackテンプレート
├── package-lock.json           package.jsonのロックファイル
├── package.json                Node依存パッケージとnpmスクリプト定義
├── page-contact.php           「お問い合わせ・ご予約」固定ページ
├── page-room.php               「客室のご案内」固定ページ
├── page.php                    その他の一般固定ページ
├── phpcs.xml.dist              コーディング規約チェックの設定
├── phpunit.xml.dist            composer run test:coverage 用の設定
├── README.md                   案件概要・構成・初期構築・検証手順
├── screenshot.jpg             テーマ一覧画面用サムネイル
├── single.php                  標準投稿の個別ページ（客室／お知らせをカテゴリーで振り分け）
└── style.css                   テーマヘッダー情報（実スタイルは assets/css/ 側）
```

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

配布ZIPと本番同期には、PHPテンプレートと実行時アセットだけを含める。README、デプロイ文書、開発ツール、依存パッケージは配布しない。

## ライセンス

GPL-2.0-or-later（`style.css` のテーマヘッダー、`composer.json` を参照）。画像素材のライセンス・クレジットは `assets/images/CREDITS.txt` と `docs/sansuien.md` の「画像ライセンスに関する注意」を参照。
