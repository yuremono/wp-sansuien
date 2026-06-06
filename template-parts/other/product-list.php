<?php
/**
 * Other product-list section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drinks = theme_get_section_posts( 'drink', 'drink_category', 'other' );
if ( $drinks ) {
	?>
	<div class="bg100in pdb-bl05 card gap3mi c296">
		<div class="form_wrap dl_menu box c297">
			<?php theme_render_menu_posts( $drinks, 'drink_price' ); ?>
		</div>
	</div><!-- #c300 -->
	<?php
	return;
}
?>
<div class="bg100in pdb-bl05 card gap3mi c296">
																<!-- #c296 -->
																<div class="form_wrap dl_menu box c297">
																		<dl>
																				<dt>750円</dt>
																				<dd>ビンビール（小）<br></dd>
																		</dl>
																		<dl>
																				<dt>960円</dt>
																				<dd>ビンビール（中）<br></dd>
																		</dl>
																		<dl>
																				<dt>690円</dt>
																				<dd>ハイボール<br></dd>
																		</dl>
																		<dl>
																				<dt>640円～</dt>
																				<dd>サワー・お茶割り<br></dd>
																		</dl>
																</div>
																<div class="form_wrap dl_menu box c299">
																		<dl>
																				<dt>690円</dt>
																				<dd>梅酒<br></dd>
																		</dl>
																		<dl>
																				<dt>690円</dt>
																				<dd>フルーツリキュール 居酒屋<br></dd>
																		</dl>
																</div>

														</div><!-- #c300 -->
														
