<?php
/**
 * Site footer.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_name = (string) theme_option( 'shop_name', THEME_BRAND_DEFAULT );
?>

<footer class="site_footer">
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="name"><?php echo esc_html( $shop_name ); ?></span><span class="sub">LAKESIDE RYOKAN SANSUIEN</span>
	</a>
	<span class="cr">© <?php echo esc_html( gmdate( 'Y' ) ); ?> SANSUIEN</span>
</footer>
