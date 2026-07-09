<?php
/**
 * Theme bootstrap.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'THEME_GETTEXT_DOMAIN', 'sansuien' );

/** Cache-busting version for theme assets. */
define( 'THEME_VERSION', '1.0.0' );

if ( ! defined( 'THEME_BRAND_DEFAULT' ) ) {
	define( 'THEME_BRAND_DEFAULT', '山翠苑' );
}

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/acf-pages.php';
require_once get_template_directory() . '/inc/contact-form.php';
