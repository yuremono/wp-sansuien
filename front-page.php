<?php
/**
 * Front page.
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
	<?php get_template_part( 'template-parts/front-page-content' ); ?>
</main>
<?php
get_footer();
