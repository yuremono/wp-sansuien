<?php
/**
 * Footer template (contact block reads front-page ACF via helpers).
 *
 * @package Theme
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

$pid          = theme_front_page_id();
$show_footer  = theme_front_meta('footer_contact_show', true);
$footer_title = theme_front_meta('footer_contact_heading', 'お問い合わせ・所在地');
$footer_body  = theme_front_meta(
	'footer_contact_body',
	"〒562-0001 大阪府箕面市小野原東 4-12-1 坂ノ上ビル 3F\n平日 9:30–18:30｜見学会・オンライン相談は事前予約制です"
);
$footer_phone = theme_front_meta('footer_phone', '072-736-2840');
$footer_email = theme_front_meta('footer_email', 'info@sakanoue-sekkei.example');

?>
</main>

<footer class="footer">
	<div class="wrap footer_grid">
		<div class="footer_intro">
			<p class="footer_brand">
				<?php echo esc_html(theme_brand()); ?>
			</p>
			<p class="footer_tagline">
				<?php esc_html_e('本サイトは情報提供を目的としています。', THEME_GETTEXT_DOMAIN); ?>
			</p>
		</div>

		<?php if ($show_footer && ($pid || is_front_page())) : ?>
			<div class="footer_contact">
				<h2 class="footer_contact_heading">
					<?php echo esc_html((string) $footer_title); ?>
				</h2>
				<p class="footer_contact_body">
					<?php echo esc_html((string) $footer_body); ?>
				</p>
				<p class="footer_contact_line">
					<a class="footer_link" href="<?php echo esc_url('tel:' . preg_replace('/[^\d+]/', '', (string) $footer_phone)); ?>">
						<?php echo esc_html((string) $footer_phone); ?>
					</a>
				</p>
				<p class="footer_contact_line">
					<?php
					$mailto = 'mailto:' . (string) $footer_email;
					?>
					<a class="footer_link" href="<?php echo esc_url($mailto); ?>">
						<?php echo esc_html((string) $footer_email); ?>
					</a>
				</p>
			</div>
		<?php endif; ?>
	</div>

	<div class="wrap footer_fine">
		© <?php echo esc_html(gmdate('Y')); ?>
		<?php echo esc_html(theme_brand()); ?> —
		<a class="footer_fine_link" href="<?php echo esc_url(__('https://wordpress.org/', THEME_GETTEXT_DOMAIN)); ?>">WordPress</a>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
