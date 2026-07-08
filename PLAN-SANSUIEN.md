# 山水園 WordPress テーマ — プロジェクト状況

最終更新: 2026-07-09。居酒屋テーマ（0606wp-izakaya）をベースに、静的サイト（旅館「山翠苑 / SANSUIEN」）を WordPress テーマ化するプロジェクト。**テーマ実装・検証・本番デプロイまで完了済み**。

## 現状サマリー

- リポジトリ: https://github.com/yuremono/wp-sansuien（public、リポジトリルート＝テーマルート）
- Local 開発環境: `/Users/yanoseiji/Local Sites/sansuien/.../themes/sansuien` → 本リポジトリへのシンボリックリンク。テーマ有効化済み、`http://localhost:10023` で全セクション描画確認済み
- 本番環境: `http://yuremono.com/sansuien/` にテーマ反映・有効化・bootstrap 実行済み（2026-07-09）。トップ / 客室アーカイブ / CSS・JS / 画像 / メニュー / 404 を確認済み
- ローカル・本番とも bootstrap 実行済み: フロントページ（top テンプレート）・primary/footer メニュー作成済み
- 検証済み: 全 PHP `php -l` パス、テストスイート 8/8 パス、居酒屋固有文言の残存ゼロ
- 静的ソース: `tmp/sansuien/`（gitignore 対象。原本は `/Users/yanoseiji/projects/0413portfolio/tmp/sansuien` — 削除禁止）

## テーマ構成の要点

- **CPT**: `room`（客室、has_archive 有効 → `archive-room.php` / `single-room.php`）、`news`（お知らせ、トップ `#news` に最新3件表示のみ）。タクソノミーなし
- **ACF**（`inc/acf-pages.php`、接頭辞 `group_theme_` / `field_theme_`）:
  - `shop_settings`（Options Page）: `shop_name` / `shop_phone` / `shop_contact_url` / `shop_address` / `shop_access_note` / `shop_reception_hours` / `shop_map_image` / `shop_instagram_url`
  - `page_front`: hero（eyebrow/heading/lead/image）、rooms・onsen・cuisine 各ブロック（heading/body/cta_url/image）、about（heading/body/image/女将・板長の name/role/image）
  - `room`: `room_catch` / `room_tags`（カンマ区切り）/ `room_size` / `room_amenities` / `room_checkin_out` / `room_rate_weekday` / `room_rate_holiday` / `room_capacity` / `room_gallery_1`〜`4`
  - `news`: `news_external_url`
- **テンプレート**: `front-page.php`（= `page-templates/top.php`）＋ `template-parts/front/`（hero / gallery / feature / voices / about / news-feed / closing）＋ `reserve-tab.php`。ギャラリー5枚とお客様の声3件は ACF 化せずテンプレートにハードコード
- **CSS/JS**: 単一 `assets/css/style.css`（静的ソース移植、クラス名 snake_case）＋ `assets/js/sansuien.js`（reveal / ヘッダースクロール / ギャラリーマーキー / feature スクロール連動）。ページ別 CSS 切替機構は廃止（実質2ページのため。ページが増えたら復活検討）
- **ロゴ**: テキストロゴ（山翠苑 / SANSUIEN）。text domain / slug: `sansuien`
- 詳細は `docs/sansuien.md` と `inc/` の各ファイルを参照

## デプロイ情報（確定値・デプロイ済み）

- 公開URL: `http://yuremono.com/sansuien/`（テーマ有効化・bootstrap 実行済み）
- SSH: `xs966275@xs966275.xsrv.jp` ポート **10022**（`~/.ssh/config` で確認済みの正しい値。Local by Flywheel のブラウザ用ポート `10023` とは無関係の別ポートなので混同しないこと）
- DEPLOY_PATH: `/home/xs966275/yuremono.com/public_html/sansuien/wp-content/themes/sansuien`
- 手順は `DEPLOYMENT.md`、値は `.env.deploy`（設定済み・gitignore 対象）。`./deploy.sh` は既定 dry-run、`--apply` で反映
- `wp eval-file` は内部で `eval()` を使うため `declare(strict_types=1)` と非互換。本番で `bootstrap-site.example.php` を再実行する場合はその1行を除いた一時コピーを使うこと（実行後は一時ファイルを削除）
- 画像ライセンス対応済み: room2.jpg（旧 CC BY-NC-ND）・room3.jpg（旧 CC BY-NC）を商用利用可の CC BY / CC BY-SA 素材（Wikimedia Commons）に差し替え済み。旧素材は `room2-orig-nc-nd.jpg` / `room3-orig-nc.jpg` としてバックアップのみ保持（テンプレート未参照）。詳細は `assets/images/CREDITS.txt`

## これからやること（TODO）

1. **コンテンツ入稿**: `room` / `news` の投稿は現在0件（ローカル・本番とも）。wp-admin から入稿（客室は room.html 相当の「蒼」など、静的ソース `tmp/sansuien/preview/` を参考に）
2. **本番の追加確認**: 実データ投入後、画像・リンク切れ・JSコンソールエラーがないか改めて確認
3. ギャラリー・お客様の声の ACF 化、ページ追加時のページ別 CSS 機構復活（任意）
