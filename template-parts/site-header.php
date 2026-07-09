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
	<?php if ( has_custom_logo() ) : ?>
		<div class="brand brand_logo"><?php the_custom_logo(); ?></div>
	<?php else : ?>
		<a class="brand brand_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( theme_source_uri( 'images/logo.png' ) ); ?>" alt="<?php echo esc_attr( $shop_name ); ?>">
		</a>
	<?php endif; ?>
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
	<button type="button" class="hbg_btn" aria-expanded="false" aria-controls="mobile-nav" aria-label="メニューを開く">
		<span class="hbg_bar"></span>
		<span class="hbg_bar"></span>
		<span class="hbg_bar"></span>
	</button>
</header>

<nav class="mobile_nav" id="mobile-nav" aria-label="モバイルナビゲーション" aria-hidden="true">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'mobile_nav_list',
			'fallback_cb'    => 'theme_menu_fallback',
			'depth'          => 1,
		)
	);
	?>
</nav>
