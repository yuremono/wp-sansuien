<?php
/**
 * 404 template.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main">
	<section class="archive wrap">
		<h1 class="archive_title"><?php echo esc_html( THEME_BRAND_DEFAULT ); ?></h1>
		<p class="archive_empty"><?php echo esc_html( 'ページが見つかりませんでした。メニューからお進みください。' ); ?></p>
	</section>
</main>

<?php
get_footer();
