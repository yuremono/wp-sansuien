<?php
/**
 * Theme helper functions.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normalize a theme-relative path.
 *
 * @param string $relative_path Relative path.
 * @return string
 */
function theme_normalize_relative_path( string $relative_path ): string {
	$path = trim( $relative_path );
	if ( '' === $path ) {
		return '';
	}

	return ltrim( str_replace( '\\', '/', $path ), '/' );
}

/**
 * ACF の値が未設定かどうか。
 *
 * @param mixed $value Raw field value.
 * @return bool
 */
function theme_acf_value_absent( $value ): bool {
	if ( null === $value || '' === $value || false === $value ) {
		return true;
	}

	return is_array( $value ) && array() === $value;
}

/**
 * Cache-busting version from file modification time.
 *
 * @param string $relative_path Relative asset path.
 * @return string
 */
function theme_asset_version( string $relative_path ): string {
	$path = get_template_directory() . '/' . theme_normalize_relative_path( $relative_path );

	return file_exists( $path ) ? (string) filemtime( $path ) : THEME_VERSION;
}
