# 山水園 WordPress テーマ — プロジェクト状況

最終更新: 2026-07-08。居酒屋テーマ（0606wp-izakaya）をベースに、静的サイト（旅館「山翠苑 / SANSUIEN」）を WordPress テーマ化するプロジェクト。**テーマ実装・検証は完了済み**。

## 現状サマリー

- リポジトリ: https://github.com/yuremono/wp-sansuien（public、リポジトリルート＝テーマルート）
- Local 開発環境: `/Users/yanoseiji/Local Sites/sansuien/.../themes/sansuien` → 本リポジトリへのシンボリックリンク。テーマ有効化済み、`http://localhost:10023` で全セクション描画確認済み
- ローカル bootstrap 実行済み: フロントページ（page id=5、top テンプレート）・primary/footer メニュー作成済み
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

## デプロイ情報（確定値・未デプロイ）

- 公開URL: `http://yuremono.com/sansuien/`（WordPress インストール済み）
- SSH: `xs966275@xs966275.xsrv.jp` ポート **10023**
- DEPLOY_PATH: `/home/xs966275/yuremono.com/public_html/sansuien/wp-content/themes/sansuien`
- 手順は `DEPLOYMENT.md`、値は `.env.deploy`（設定済み・gitignore 対象）。`./deploy.sh` は既定 dry-run、`--apply` で反映

## これからやること（TODO）

1. **本番デプロイ**: `./deploy.sh` の dry-run 確認 → `--apply`。その後、本番で `tools-domain/bootstrap-site.example.php` を `wp eval-file` 実行（`THEME_BOOTSTRAP_CONFIRM` / `THEME_BOOTSTRAP_EXPECTED_URL=http://yuremono.com/sansuien` を指定）。**リモート本番サーバーへの接続を伴うため、実行前に必ずユーザーへ確認すること**
2. **コンテンツ入稿**: `room` / `news` の投稿は現在0件。wp-admin から入稿（客室は room.html 相当の「蒼」など、静的ソース `tmp/sansuien/preview/` を参考に）
3. ~~画像ライセンス確認~~ **完了（2026-07-09）**: room2.jpg（旧 CC BY-NC-ND）・room3.jpg（旧 CC BY-NC）を商用利用可の CC BY / CC BY-SA 素材（Wikimedia Commons）に差し替え済み。旧素材は `room2-orig-nc-nd.jpg` / `room3-orig-nc.jpg` としてバックアップのみ保持（テンプレート未参照）。詳細は `assets/images/CREDITS.txt`
4. **本番公開後の確認**: 全ページ・画像・メニュー・404・JS エラー（DEPLOYMENT.md 手順5）。ローカル（`http://localhost:10023`）・本番（`http://yuremono.com/sansuien/`）の両方で確認
5. ギャラリー・お客様の声の ACF 化、ページ追加時のページ別 CSS 機構復活
