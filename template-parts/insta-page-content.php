<?php
/**
 * Insta page content.
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
		<main>
		<?php get_template_part( 'template-parts/insta/hero' ); ?>
		<?php get_template_part( 'template-parts/insta/introduction' ); ?>
		<?php get_template_part( 'template-parts/insta/posts' ); ?>
		</main>
	</div>
</div>
