<?php
/**
 * Dependency-free theme test runner.
 *
 * @package Theme
 */

declare(strict_types=1);

// Test output and local fixture reads intentionally bypass WordPress runtime APIs.
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped,WordPress.Security.EscapeOutput.ExceptionNotEscaped,WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents,WordPress.WP.AlternativeFunctions.file_system_operations_file_get_contents,WordPress.WP.AlternativeFunctions.file_system_operations_fwrite,Squiz.Commenting.FunctionComment.MissingThrows,Squiz.Commenting.FunctionCommentThrowTag.Missing

require_once __DIR__ . '/bootstrap.php';

// phpcs:disable Generic.Formatting.MultipleStatementAlignment
$tests  = array();
$failed = 0;
$coverage_requested = in_array( '--coverage', $argv, true );

if ( $coverage_requested && function_exists( 'phpdbg_start_oplog' ) ) {
	phpdbg_start_oplog();
}

/**
 * Register a test.
 *
 * @param string   $name Test name.
 * @param callable $callback Test callback.
 */
function theme_test( string $name, callable $callback ): void {
	global $tests;
	$tests[] = array( $name, $callback );
}

/**
 * Assert a condition.
 *
 * @param bool   $condition Condition.
 * @param string $message Failure message.
 */
function theme_assert( bool $condition, string $message ): void {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

/**
 * Read a project file.
 *
 * @param string $relative_path Project-relative path.
 * @return string
 */
function theme_test_file( string $relative_path ): string {
	$contents = file_get_contents( THEME_TEST_ROOT . '/' . $relative_path );
	if ( false === $contents ) {
		throw new RuntimeException( "Unable to read {$relative_path}" );
	}

	return $contents;
}

theme_test(
	'Path normalization trims whitespace and leading slashes',
	static function (): void {
		theme_assert( '' === theme_normalize_relative_path( '   ' ), 'Empty path should stay empty' );
		theme_assert( 'assets/css/common.css' === theme_normalize_relative_path( ' /assets/css/common.css ' ), 'Leading slash should be removed' );
		theme_assert( 'assets/css/common.css' === theme_normalize_relative_path( '\\assets\\css\\common.css' ), 'Backslashes should be normalized' );
	}
);

theme_test(
	'ACF absent helper recognizes only empty values',
	static function (): void {
		foreach ( array( null, '', false, array() ) as $value ) {
			theme_assert( theme_acf_value_absent( $value ), 'Expected value to be absent' );
		}
		foreach ( array( 0, '0', true, array( 0 ), 'text' ) as $value ) {
			theme_assert( ! theme_acf_value_absent( $value ), 'Expected value to be present' );
		}
	}
);

theme_test(
	'Asset version uses file mtime and fallback version',
	static function (): void {
		theme_assert( (string) filemtime( THEME_TEST_ROOT . '/inc/helpers.php' ) === theme_asset_version( 'inc/helpers.php' ), 'Existing file must use mtime' );
		theme_assert( THEME_VERSION === theme_asset_version( 'missing-file' ), 'Missing file must use theme version' );
	}
);

theme_test(
	'Functions no longer requires the removed CPT file and still loads setup/ACF files',
	static function (): void {
		$source = theme_test_file( 'functions.php' );
		theme_assert( ! str_contains( $source, "'/inc/cpt.php'" ), 'Removed CPT file must not be required' );
		theme_assert( ! file_exists( THEME_TEST_ROOT . '/inc/cpt.php' ), 'inc/cpt.php should be deleted; content types were replaced by post categories' );
		theme_assert( str_contains( $source, "'/inc/setup.php'" ), 'Setup file (category bootstrap) is not required' );
		theme_assert( str_contains( $source, "'/inc/acf-pages.php'" ), 'ACF file is not required' );
		theme_assert( strpos( $source, "'/inc/template-tags.php'" ) < strpos( $source, "'/inc/setup.php'" ), 'Template helpers must load before setup callbacks' );
	}
);

theme_test(
	'Content categories are bootstrapped non-destructively and match section queries',
	static function (): void {
		$setup = theme_test_file( 'inc/setup.php' );
		theme_assert( str_contains( $setup, 'theme_ensure_content_categories' ), 'Missing category bootstrap function' );
		theme_assert( str_contains( $setup, "term_exists( \$slug, 'category' )" ), 'Category bootstrap must check for existing terms before inserting' );
		theme_assert( str_contains( $setup, 'wp_insert_term(' ), 'Category bootstrap must create missing categories' );
		theme_assert( str_contains( $setup, "add_action( 'init', 'theme_ensure_content_categories', 1 )" ), 'Category bootstrap must run early on init (before acf/init at priority 5)' );

		$templates = '';
		foreach ( glob( THEME_TEST_ROOT . '/template-parts/front/*.php', GLOB_BRACE ) as $file ) {
			$templates .= (string) file_get_contents( $file );
		}
		$templates .= theme_test_file( 'single.php' );
		$templates .= theme_test_file( 'template-parts/single-room-content.php' );
		$templates .= theme_test_file( 'template-parts/single-post-content.php' );
		$templates .= theme_test_file( 'category-room.php' );

		foreach ( array( 'room', 'news' ) as $slug ) {
			theme_assert( str_contains( $setup, "'{$slug}'" ), "Missing content category {$slug}" );
			theme_assert( str_contains( $templates, "'{$slug}'" ), "Category {$slug} is not queried by a section" );
		}
	}
);

theme_test(
	'ACF registration is guarded and covers page and post-category structures',
	static function (): void {
		$source = theme_test_file( 'inc/acf-pages.php' );
		theme_assert( str_contains( $source, "function_exists( 'acf_add_local_field_group' )" ), 'ACF field registration must be guarded' );
		theme_assert( str_contains( $source, "function_exists( 'acf_add_options_page' )" ), 'ACF options registration must be guarded' );
		theme_assert( str_contains( $source, "'group_theme_page_front'" ), 'Missing ACF front page group' );
		theme_assert( str_contains( $source, "'param'    => 'post_category'" ), 'Room/news field groups must target post_category location, not post_type' );
		theme_assert( ! str_contains( $source, "'value'    => 'room'" ), 'ACF location must resolve the room category dynamically, not hardcode a post_type value' );
		theme_assert( ! str_contains( $source, "'value'    => 'news'" ), 'ACF location must resolve the news category dynamically, not hardcode a post_type value' );
		foreach ( array( 'room', 'news' ) as $slug ) {
			theme_assert( str_contains( $source, "theme_acf_category_location( '{$slug}' )" ), "Missing ACF category-location group for {$slug}" );
		}
	}
);

theme_test(
	'Bootstrap is confirmation-gated and non-destructive',
	static function (): void {
		$source = theme_test_file( 'tools-domain/bootstrap-site.example.php' );
		theme_assert( str_contains( $source, 'THEME_BOOTSTRAP_CONFIRM' ), 'Bootstrap confirmation is required' );
		theme_assert( str_contains( $source, "get_option( 'home' )" ), 'Bootstrap must verify the target URL' );
		theme_assert( str_contains( $source, 'theme_tools_fill_empty_meta' ), 'Bootstrap must fill only empty metadata' );
		theme_assert( str_contains( $source, 'theme_tools_find_menu_item' ), 'Bootstrap must avoid duplicate menu items' );
		theme_assert( ! str_contains( $source, 'wp_delete_post(' ), 'Bootstrap must not delete posts' );
		theme_assert( ! str_contains( $source, 'wp_delete_nav_menu(' ), 'Bootstrap must not delete menus' );
		theme_assert( str_contains( $source, "'category'   => 'room'" ), 'Bootstrap example must assign content to the room category' );
		theme_assert( str_contains( $source, "'category'   => 'news'" ), 'Bootstrap example must assign content to the news category' );
		theme_assert( str_contains( $source, 'wp_set_post_categories' ), 'Bootstrap must assign posts to categories, not a removed CPT' );
	}
);

theme_test(
	'Deploy requires safe paths and defaults to dry-run',
	static function (): void {
		$source = theme_test_file( 'tools/deploy.sh' );
		theme_assert( str_contains( $source, 'rsync_dry_run=(--dry-run)' ), 'Deploy must default to dry-run' );
		theme_assert( str_contains( $source, '"/wp-content/themes/"' ), 'Deploy must require a themes path' );
		theme_assert( str_contains( $source, 'remote_theme_slug' ), 'Deploy must verify the remote theme slug' );
		theme_assert( str_contains( $source, 'DEPLOY_APPLY' ), 'Deploy must require explicit apply mode' );
		theme_assert( str_contains( $source, '--exclude=vendor/' ), 'Deploy must exclude vendor' );
		theme_assert( str_contains( $source, '--exclude=*.bak' ), 'Deploy must exclude backup files' );
		theme_assert( str_contains( $source, '--import-xml は --apply と同時に指定してください。' ), 'Content import must require apply mode' );
	}
);

foreach ( $tests as $test ) {
	$name     = $test[0];
	$callback = $test[1];
	try {
		$callback();
		echo "PASS: {$name}\n";
	} catch ( Throwable $error ) {
		++$failed;
		echo "FAIL: {$name}\n";
		echo '  ' . $error->getMessage() . "\n";
	}
}

printf( "\n%d tests, %d failures\n", count( $tests ), $failed );

if ( $coverage_requested ) {
	if ( function_exists( 'phpdbg_end_oplog' ) && function_exists( 'phpdbg_get_executable' ) ) {
		$oplog        = phpdbg_end_oplog();
		$executable   = phpdbg_get_executable();
		$exec_count   = 0;
		$covered      = 0;
		$project_root = THEME_TEST_ROOT;

		foreach ( $executable as $file => $lines ) {
			if ( str_starts_with( $file, $project_root . '/inc/' ) ) {
				foreach ( $lines as $line => $is_executable ) {
					if ( $is_executable >= 0 ) {
						++$exec_count;
						if ( isset( $oplog[ $file ][ $line ] ) ) {
							++$covered;
						}
					}
				}
			}
		}

		$coverage = 0.0;
		if ( $exec_count > 0 ) {
			$coverage = ( $covered / $exec_count ) * 100;
		}

		printf( "Coverage: %.2f%% (%d/%d executable lines)\n", $coverage, $covered, $exec_count );

		if ( $coverage < 80.0 ) {
			fwrite( STDERR, "Coverage below 80%.\n" );
			exit( 2 );
		}
	} else {
		fwrite( STDERR, "Coverage unavailable: run under phpdbg.\n" );
		exit( 2 );
	}
}

exit( $failed > 0 ? 1 : 0 );
// phpcs:enable Generic.Formatting.MultipleStatementAlignment
