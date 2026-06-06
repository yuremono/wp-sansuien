<?php
/**
 * Genshu product-list section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drinks = theme_get_section_posts( 'drink', 'drink_category', 'genshu' );
if ( $drinks ) {
	?>
	<div class="fl50 mt20 gap3mi c267">
		<div class="form_wrap dl_menu c268">
			<?php theme_render_menu_posts( $drinks, 'drink_price' ); ?>
		</div>
	</div><!-- #c270 -->
	<?php
	return;
}
?>
<div class="fl50 mt20 gap3mi c267">
								<!-- #c267 -->
								<div class="form_wrap dl_menu c268">
										<dl>
												<dt>1330円</dt>
												<dd>居酒屋<br></dd>
										</dl>
										<dl>
												<dt>1330円</dt>
												<dd>居酒屋<br></dd>
										</dl>
										<dl>
												<dt>900円</dt>
												<dd>居酒屋<br></dd>
										</dl>
										<dl>
												<dt>1120円</dt>
												<dd>居酒屋<br></dd>
										</dl>
								</div>

						</div><!-- #c270 -->
						
