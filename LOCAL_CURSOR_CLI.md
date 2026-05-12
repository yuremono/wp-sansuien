# Cursor から Local WordPress を更新する手順

Local by Flywheel のサイトが起動している状態で、Cursor のエージェントシェルから以下を実行する。

```bash
export MYSQL_HOME="/Users/yanoseiji/Library/Application Support/Local/run/KI-O9iGY_/conf/mysql"
export PHPRC="/Users/yanoseiji/Library/Application Support/Local/run/KI-O9iGY_/conf/php"
export WP_CLI_CONFIG_PATH="/Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/config.yaml"
export WP_CLI_DISABLE_AUTO_CHECK_UPDATE=1
export PATH="/Users/yanoseiji/Library/Application Support/Local/lightning-services/mysql-8.4.0/bin/darwin-arm64/bin:/Users/yanoseiji/Library/Application Support/Local/lightning-services/php-8.2.29+0/bin/darwin-arm64/bin:/Applications/Local.app/Contents/Resources/extraResources/bin/wp-cli/posix:/Applications/Local.app/Contents/Resources/extraResources/bin/composer/posix:$PATH"
cd "/Users/yanoseiji/Local Sites/yuremono-wp/app/public"
php -r 'require "./wp-load.php"; require "./wp-content/themes/portfolio-corporate/tools/seed-standard-pages.php";'
```

固定ページの追加・更新をテストする場合は、同じ環境で以下を実行する。

```bash
php -r 'require "./wp-load.php"; $slug="cursor-agent-smoke-test"; $page=get_page_by_path($slug, OBJECT, "page"); $postarr=["post_title"=>"Cursor更新テスト", "post_name"=>$slug, "post_content"=>"<!-- wp:paragraph -->\n<p>Cursor agent update smoke test: ".date("Y-m-d H:i:s")."</p>\n<!-- /wp:paragraph -->", "post_status"=>"publish", "post_type"=>"page", "post_author"=>1]; if ($page instanceof WP_Post) { $postarr["ID"]=$page->ID; $id=wp_update_post(wp_slash($postarr), true); } else { $id=wp_insert_post(wp_slash($postarr), true); } if ($id instanceof WP_Error || ! $id) { exit(1); } echo admin_url("post.php?post={$id}&action=edit")."\n";'
```

`wp eval-file` は `declare(strict_types=1);` を含むスクリプトで fatal になるため、上記のように `wp-load.php` を読み込む `php -r` 経由を使う。
