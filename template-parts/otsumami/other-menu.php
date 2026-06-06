<?php
/**
 * Otsumami other-menu section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foods = theme_get_section_posts( 'food', 'food_category', 'other' );
if ( $foods ) {
	?>
	<div class="clearfix title_bb2mc h-icon c295">
		<article>
			<h2><?php theme_text( 'otsumami_section_heading', 'その他' ); ?></h2>
			<div></div>
		</article>
	</div><!-- #c295 -->
	<div class="fl50 mt20 gap3mi c267">
		<div class="form_wrap dl_menu c268">
			<?php theme_render_menu_posts( $foods, 'food_price' ); ?>
		</div>
	</div><!-- #c270 -->
	<?php
	return;
}
?>
<div class="clearfix title_bb2mc h-icon c295">
																<article>
																		<h2>その他</h2>
																		<div></div>
																</article>
														</div><!-- #c295 -->
														<div class="fl50 mt20 gap3mi c267">
																<!-- #c267 -->
																<div class="form_wrap dl_menu c268">
																		<dl>
																				<dt>850円</dt>
																				<dd>鶏ユッケ<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>塩辛<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>たこ七味ゆず<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>クリームチーズの味噌漬け<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>クリームチーズのわさび醬油漬け<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>うずら卵のピクルス<br></dd>
																		</dl>
																</div>
																<div class="form_wrap dl_menu c269">
																		<dl>
																				<dt>530円</dt>
																				<dd>酢もつ(夏季限定）<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>豚みそ<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>鶏レバーのウスターソース漬け<br></dd>
																		</dl>
																		<dl>
																				<dt>450円</dt>
																				<dd>お漬物盛り<br></dd>
																		</dl>
																		<dl>
																				<dt>530円</dt>
																				<dd>高菜明太マヨご飯<br></dd>
																		</dl>
																		<dl>
																				<dt>530円</dt>
																				<dd>野菜スティック<br></dd>
																		</dl>
																</div>

														</div><!-- #c270 -->
														
