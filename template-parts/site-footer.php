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
	<?php
	// closing（予約導線＋アクセス）は全ページ共通のフッター一部として常に表示する。
	// ページテンプレートを追加するたびに個別に呼び出す必要はない。
	get_template_part( 'template-parts/front/closing' );
	?>

	<div class="site_footer_bottom">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="name"><?php echo esc_html( $shop_name ); ?></span><span class="sub">LAKESIDE RYOKAN SANSUIEN</span>
		</a>
		<span class="cr">© <?php echo esc_html( gmdate( 'Y' ) ); ?> SANSUIEN</span>
	</div>
</footer>

<div class="Modal" id="privacy-policy-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="privacy-policy-modal-title">
	<div class="Modal_dialog" tabindex="-1">
		<button type="button" class="Modal_close" data-modal-close aria-label="閉じる">×</button>
		<h2 class="Modal_title" id="privacy-policy-modal-title">プライバシーポリシー</h2>
		<div class="Modal_body">
			<?php theme_rich( 'shop_privacy_policy_content', theme_default_privacy_policy_content() ); ?>
		</div>
	</div>
</div>
