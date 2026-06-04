# Quests ページ構成

Quests 系ページの実装場所と、静的コピーとの対応をまとめたドキュメントです。

## テンプレート

- [page-quests.php](../page-templates/page-quests.php): Quests 通常ページのテンプレート
- [page-quests-service.php](../page-templates/page-quests-service.php): Quests サービスページのテンプレート
- [header-quests.php](../header-quests.php): Quests 専用ヘッダー
- [footer-quests.php](../footer-quests.php): Quests 専用フッター

## テンプレートパーツ

- [template-parts/quests/content-top.php](../template-parts/quests/content-top.php): トップページ本文
- [template-parts/quests/content-service.php](../template-parts/quests/content-service.php): サービスページ本文
- [template-parts/quests/header.php](../template-parts/quests/header.php): ページヘッダーの共通マークアップ
- [template-parts/quests/footer.php](../template-parts/quests/footer.php): ページフッターの共通マークアップ

## 共通ヘルパー

- [inc/quests-static.php](../inc/quests-static.php): Quests 共通ヘルパー
- `theme_quests_source_uri()`: `assets/quests/` 配下の静的ファイル参照を組み立てる helper
- `theme_quests_body_classes()`: Quests ページ用の body class を返す helper

## 静的ソース

- [assets/quests/index.html](../assets/quests/index.html): 通常ページの静的コピー
- [assets/quests/service.html](../assets/quests/service.html): サービスページの静的コピー

## 静的アセット

- [assets/quests/css/common.css](../assets/quests/css/common.css): 共通スタイル
- [assets/quests/css/common_style.css](../assets/quests/css/common_style.css): 共通の追加スタイル
- [assets/quests/css/style.css](../assets/quests/css/style.css): トップページ固有スタイル
- [assets/quests/css/service_html.css](../assets/quests/css/service_html.css): サービスページ固有スタイル
- [assets/quests/js/flipsnap.min.js](../assets/quests/js/flipsnap.min.js): 横スクロール用スクリプト
- [assets/quests/js/function.js](../assets/quests/js/function.js): Quests 共通の挙動

## 画像参照ルール

- PHP テンプレートでは、`assets/quests/images/...` を直接書かず `<?php echo esc_url( theme_quests_source_uri( 'images/...') ); ?>` を使う
- サービスページの画像は `template-parts/quests/content-service.php` で helper 化済み
- 静的 HTML のコピーを更新する場合も、同じファイル構成を前提に参照先を合わせる
