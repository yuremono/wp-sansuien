<?php
/**
 * Dependency-free test bootstrap.
 *
 * @package Izakaya
 */

declare(strict_types=1);

define( 'THEME_TEST_ROOT', dirname( __DIR__ ) );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', THEME_TEST_ROOT . '/' );
}

if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', 'test' );
}

/**
 * Minimal theme path stub used by pure helper tests.
 *
 * @return string
 */
function get_template_directory(): string {
	return THEME_TEST_ROOT;
}

require_once THEME_TEST_ROOT . '/inc/helpers.php';
