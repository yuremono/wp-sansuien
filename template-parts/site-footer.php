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

// closing（予約導線＋アクセス）は全ページ共通のフッター一部として常に表示する。
// ページテンプレートを追加するたびに個別に呼び出す必要はない。
get_template_part( 'template-parts/front/closing' );
?>

<footer class="site_footer">
	<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<span class="name"><?php echo esc_html( $shop_name ); ?></span><span class="sub">LAKESIDE RYOKAN SANSUIEN</span>
	</a>
	<span class="cr">© <?php echo esc_html( gmdate( 'Y' ) ); ?> SANSUIEN</span>
</footer>
