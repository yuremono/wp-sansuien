<?php
/**
 * Example page content skeleton.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
		exit;
}
?>
<div id="contents_wrap">
		<div id="contents" class="clearfix ">

				<main>
						<?php get_template_part( 'template-parts/example/example' ); ?>
				</main>

		</div>
		<!-- #contents_wrap -->
</div>