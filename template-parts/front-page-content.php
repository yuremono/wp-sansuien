<?php
/**
 * トップ page content.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
get_template_part( 'template-parts/front/hero' );
get_template_part( 'template-parts/front/gallery' );
get_template_part( 'template-parts/front/feature' );
get_template_part( 'template-parts/front/voices' );
get_template_part( 'template-parts/front/about' );
get_template_part( 'template-parts/front/news-feed' );
