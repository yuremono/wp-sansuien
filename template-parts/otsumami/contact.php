<?php
/**
 * Otsumami contact section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$shop_phone = (string) theme_option( 'shop_phone', '000-0000-0000' );
?>
<div class="clearfix btns bg01 txwh c255">
																<article>
																		<h2><?php theme_text( 'otsumami_cta_label', 'お問い合わせ' ); ?></h2>
																		<div><a class="btn __wh"
																					href="<?php echo esc_url( theme_phone_uri( $shop_phone ) ); ?>"><?php echo esc_html( $shop_phone ); ?></a><br />
																				<a class="btn __wh" href="<?php echo esc_url( theme_url( 'otsumami_cta_url', theme_option_url( 'shop_contact_url', '#' ) ) ); ?>">CONTACT</a>
																		</div>
																</article>
														</div><!-- #c255 -->
														<!-- #c250 -->
														<!-- #c263 -->
														<!-- #c262 -->
														<!-- #c249 -->
														<!-- #c251 -->
														<!-- #c266 -->

														<!-- #c292 -->
														<!-- #c300 -->
												
