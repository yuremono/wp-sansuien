<?php
/**
 * トップ page content.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<div id="contents" >
		<main>
			<?php
			get_template_part( 'template-parts/front/hero' );
			get_template_part( 'template-parts/front/introduction' );
			get_template_part( 'template-parts/front/shochu-features' );
			get_template_part( 'template-parts/front/other-link' );
			get_template_part( 'template-parts/front/otsumami-link' );
			get_template_part( 'template-parts/front/news-feed' );
			get_template_part( 'template-parts/front/news-link' );
			?>
		</main>
	</div>
