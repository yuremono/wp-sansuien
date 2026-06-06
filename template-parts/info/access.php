<?php
/**
 * Info access section.
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
$shop_hours   = (string) theme_option( 'shop_hours', "火～土曜日17:00～2:00\n日曜日15:00～0:00" );
$shop_closed  = (string) theme_option( 'shop_closed', '月曜日' );
$map_url      = theme_option_url( 'shop_map_embed_url', 'about:blank' );
?>
<div class="mt0 info_main c306">
																<div class="f_info">
																		<h2 class="f_name"><?php echo esc_html( $shop_name ); ?></h2>
																		<div class="form_01">

																				<dl>
																						<dt>所在地</dt>
																						<dd><?php echo nl2br( esc_html( $shop_address ) ); ?>
																						</dd>
																				</dl>
																				<dl>
																						<dt>TEL</dt>
																						<dd><?php echo esc_html( $shop_phone ); ?></dd>
																				</dl>
																				<dl>
																						<dt>営業時間</dt>
																						<dd><?php echo nl2br( esc_html( $shop_hours ) ); ?>
																						</dd>
																				</dl>
																				<dl>
																						<dt>定休日</dt>
																						<dd><?php echo esc_html( $shop_closed ); ?></dd>
																				</dl>

																		</div>
																</div>
																<div class="f_map">
																		<iframe src="<?php echo esc_url( $map_url ); ?>"
																				width="100%" height="400"
																				style="border:0;" allowfullscreen=""
																				loading="lazy"
																				referrerpolicy="no-referrer-when-downgrade"></iframe>
																</div>
														</div><!-- #c306 -->
														<!-- #c308 -->
												
