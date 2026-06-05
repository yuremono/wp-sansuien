<?php
/**
 * Theme setup.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme supports and menus.
 */
function theme_setup(): void {
	load_theme_textdomain( THEME_GETTEXT_DOMAIN, get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'caption',
			'gallery',
			'script',
			'style',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', THEME_GETTEXT_DOMAIN ),
		)
	);
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Fallback navigation used until a menu is assigned in the admin screen.
 */
function theme_quests_primary_menu_fallback(): void {
	$items = array(
		array(
			'label' => 'home',
			'url'   => home_url( '/' ),
		),
		array(
			'label' => 'Service',
			'url'   => home_url( '/service/' ),
		),
		array(
			'label' => 'Staff',
			'url'   => '#',
		),
		array(
			'label' => 'Recruit',
			'url'   => '#',
		),
		array(
			'label' => 'Instagram',
			'url'   => '#',
		),
		array(
			'label' => 'Contact',
			'url'   => '#',
		),
	);
	?>
	<ul>
		<?php foreach ( $items as $item ) : ?>
			<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}
