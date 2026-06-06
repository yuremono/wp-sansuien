<?php
/**
 * Otsumami featured-dishes section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$foods = theme_get_section_posts( 'food', 'food_category', 'featured' );
if ( $foods ) {
	?>
	<div class="fb_menu04 i-art bg100in pdb-bl05 c265">
		<?php theme_render_feature_posts( $foods, 'food_price' ); ?>
	</div><!-- #c265 -->
	<?php
	return;
}
?>
<div class="fb_menu04 i-art bg100in pdb-bl05 c265">
																<div class="box">
																		<article>
																				<img src="<?php echo esc_url( theme_source_uri( 'images/otsumami/IMG_3984.jpg' ) ); ?>"
																					alt="居酒屋の味　とんこつ">
																				<h3>居酒屋の味　とんこつ</h3>
																				<div>ぶつ切りにした豚の骨付きあばら肉を、大根やこんにゃくと一緒に柔らかく煮た居酒屋の郷土料理です。（冬季限定）<br>
																						<p> 960円</p>
																				</div>
																		</article>
																</div>
																<div class="box">
																		<article>
																				<img src="<?php echo esc_url( theme_source_uri( 'images/otsumami/IMG_3990.jpg' ) ); ?>"
																					alt="鶏たたき刺し">
																				<h3>鶏たたき刺し</h3>
																				<div>鶏肉の表面を炙りお刺身にしたものです。甘口の薩摩醤油で食べるのが本場の味です。<br>
																						<p> 850円</p>
																				</div>
																		</article>
																</div>
														</div><!-- #c265 -->
														
