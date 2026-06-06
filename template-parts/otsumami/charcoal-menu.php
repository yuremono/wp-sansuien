<?php
/**
 * Otsumami charcoal-menu section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foods = theme_get_section_posts( 'food', 'food_category', 'charcoal' );
if ( $foods ) {
	?>
	<div class="fl50 mt20 gap3mi c319">
		<div class="form_wrap dl_menu c320">
			<?php theme_render_menu_posts( $foods, 'food_price' ); ?>
		</div>
	</div><!-- #c322 -->
	<?php
	return;
}
?>
<div class="fl50 mt20 gap3mi c319">
																<!-- #c319 -->
																<div class="form_wrap dl_menu c320">
																		<dl>
																				<dt>850円</dt>
																				<dd>さつま揚げ盛り（紅ショウガ、蓮根、チーズ、他）<br></dd>
																		</dl>
																		<dl>
																				<dt>530円</dt>
																				<dd>きびなご一夜干し<br></dd>
																		</dl>
																		<dl>
																				<dt>530円</dt>
																				<dd>豆アジみりん干し<br></dd>
																		</dl>
																</div>
																<div class="form_wrap dl_menu c321">
																		<dl>
																				<dt>450円</dt>
																				<dd>えいひれ<br></dd>
																		</dl>
																		<dl>
																				<dt>850円</dt>
																				<dd>珍味盛り（えいひれ、豆アジ、ほたるいか、他）<br></dd>
																		</dl>
																</div>

														</div><!-- #c322 -->
														
