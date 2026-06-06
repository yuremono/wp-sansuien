<?php
/**
 * Info overview section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$shop_name    = (string) theme_option( 'shop_name', THEME_BRAND_DEFAULT );
$shop_address = (string) theme_option( 'shop_address', '居酒屋' );
$shop_phone   = (string) theme_option( 'shop_phone', '000-0000-0000' );
$shop_hours   = (string) theme_option( 'shop_hours', "火～土曜日:17:00～2:00\n日曜日:15:00～0:00" );
$shop_closed  = (string) theme_option( 'shop_closed', '月曜日' );
?>
<div class="fl73 c301">
																<!-- #c301 -->
																<div class="form_wrap form_simple02 noscr c302">
																		<dl>
																				<dt>店名</dt>
																				<dd><?php echo esc_html( $shop_name ); ?><br></dd>
																		</dl>
																		<dl>
																				<dt>住所</dt>
																				<dd><?php echo nl2br( esc_html( $shop_address ) ); ?><br>
																				</dd>
																		</dl>
																		<dl>
																				<dt>TEL</dt>
																				<dd><?php echo esc_html( $shop_phone ); ?><br></dd>
																		</dl>
																		<dl>
																				<dt>営業時間</dt>
																				<dd><?php echo nl2br( esc_html( $shop_hours ) ); ?><br>
																				</dd>
																		</dl>
																		<dl>
																				<dt>定休日</dt>
																				<dd><?php echo esc_html( $shop_closed ); ?><br></dd>
																		</dl>
																</div>
																<div class="clearfix js-hide c303">
																		<?php theme_image( 'info_image_1', 'images/placeholder/960x960.png', '', 'imgL' ); ?>
																</div><!-- #c303 -->

														</div><!-- #c304 -->
														
