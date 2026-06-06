<?php
/**
 * Front page content.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="contents_wrap">
	<div id="contents" class="clearfix">
		<section>
		<?php get_template_part( 'template-parts/front/hero' ); ?>
		<?php get_template_part( 'template-parts/front/introduction' ); ?>
		<?php get_template_part( 'template-parts/front/shochu-features' ); ?>
		<?php get_template_part( 'template-parts/front/other-link' ); ?>
		<?php get_template_part( 'template-parts/front/otsumami-link' ); ?>
		<?php get_template_part( 'template-parts/front/news-feed' ); ?>
		<?php get_template_part( 'template-parts/front/news-link' ); ?>
		</section>
	</div>
</div>
