<?php
/**
 * One-off migration: convert existing `room`/`news` CPT posts to standard
 * `post` + category (客室/room, お知らせ/news).
 *
 * Postmeta, ACF values, featured images, post_date, menu_order and post_name
 * (slug) are preserved untouched. Only `post_type` and the assigned
 * categories are changed.
 *
 * Safe to re-run: any post whose post_type is already `post` is skipped.
 *
 * LOCAL ONLY. Do not point this at production.
 *
 * Run with:
 *   WP_LOAD_PATH="/Users/yanoseiji/Local Sites/sansuien/app/public/wp-load.php"
 *   php -d mysqli.default_socket="/Users/yanoseiji/Library/Application Support/Local/run/XbvlWz2gP/mysql/mysqld.sock" \
 *     tools-domain/migrate-room-news-to-post.php
 *
 * @package Theme
 */

declare(strict_types=1);

$wp_load_path = getenv( 'WP_LOAD_PATH' );
if ( ! $wp_load_path ) {
	fwrite( STDERR, "WP_LOAD_PATH environment variable is required.\n" );
	exit( 1 );
}
if ( ! is_readable( $wp_load_path ) ) {
	fwrite( STDERR, "WP_LOAD_PATH does not point to a readable wp-load.php: {$wp_load_path}\n" );
	exit( 1 );
}

require_once $wp_load_path;

// Safety: refuse to run against anything that doesn't look like the local dev site.
$home_url = (string) get_option( 'home' );
if ( ! str_contains( $home_url, 'localhost' ) ) {
	fwrite( STDERR, "Refusing to run: site URL '{$home_url}' does not look like a local environment. This script must never touch production.\n" );
	exit( 1 );
}

/**
 * Ensure the target category exists and return its term_id.
 *
 * @param string $slug Category slug.
 * @param string $name Category display name.
 * @return int
 */
function theme_migration_get_category_id( string $slug, string $name ): int {
	$term = get_term_by( 'slug', $slug, 'category' );
	if ( $term instanceof WP_Term ) {
		return (int) $term->term_id;
	}

	$inserted = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
	if ( is_wp_error( $inserted ) ) {
		fwrite( STDERR, "Failed to create category '{$slug}': " . $inserted->get_error_message() . "\n" );
		exit( 1 );
	}

	return (int) $inserted['term_id'];
}

$category_map = array(
	'room' => theme_migration_get_category_id( 'room', '客室' ),
	'news' => theme_migration_get_category_id( 'news', 'お知らせ' ),
);

$migrated = 0;
$skipped  = 0;

foreach ( array( 'room', 'news' ) as $legacy_post_type ) {
	$posts = get_posts(
		array(
			'post_type'      => $legacy_post_type,
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);

	foreach ( $posts as $post ) {
		$post_id = (int) $post->ID;

		if ( 'post' === $post->post_type ) {
			echo "SKIP (already migrated): #{$post_id} {$post->post_title}\n";
			++$skipped;
			continue;
		}

		$updated = wp_update_post(
			array(
				'ID'        => $post_id,
				'post_type' => 'post',
			),
			true
		);

		if ( is_wp_error( $updated ) ) {
			fwrite( STDERR, "Failed to update post #{$post_id}: " . $updated->get_error_message() . "\n" );
			continue;
		}

		wp_set_post_categories( $post_id, array( $category_map[ $legacy_post_type ] ), false );

		echo "MIGRATED: #{$post_id} {$post->post_title} ({$legacy_post_type} -> post + category:{$legacy_post_type})\n";
		++$migrated;
	}
}

printf( "\nDone. Migrated: %d, Skipped (already post): %d\n", $migrated, $skipped );
