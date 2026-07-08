<?php
/**
 * Site header.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $shop_name = (string) theme_option( 'shop_name', THEME_BRAND_DEFAULT ); ?>
<header class="site_header" role="banner">
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="name"><?php echo esc_html( $shop_name ); ?></span><span class="sub">SANSUIEN</span>
	</a>
	<nav class="gnav" aria-label="グローバルナビゲーション">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'gnav_list',
				'fallback_cb'    => 'theme_menu_fallback',
				'depth'          => 1,
			)
		);
		?>
	</nav>
</header>
