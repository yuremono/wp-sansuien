<?php
/**
 * Genshu featured-products section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$featured_drinks = array_values(
	array_filter(
		theme_get_section_posts( 'drink', 'drink_category', 'genshu' ),
		static function ( WP_Post $post ): bool {
			return (bool) theme_content_meta( $post->ID, 'drink_featured', false );
		}
	)
);
if ( $featured_drinks ) {
	?>
	<div class="__bg card js-chB i-art c251">
		<?php theme_render_feature_posts( $featured_drinks, 'drink_price' ); ?>
	</div><!-- #c251 -->
	<?php
	return;
}
?>
<div class="__bg card js-chB i-art c251">
								<div class="box">
										<article>
												<img src="<?php echo esc_url( theme_source_uri( 'images/shoutyuu/IMG_4042.jpg' ) ); ?>"
													alt="居酒屋">
												<h3>居酒屋</h3>
												<div>酒蔵：居酒屋(居酒屋)<br>原料：芋<br>麹：米・黒麹<br>アルコール度数：42度<br><br>年に一度の限定酒。<br>一蔵一銘柄で一つの銘柄に全てを賭ける居酒屋さんが造る魂の焼酎『居酒屋』の原酒です。<br>芳醇な甘い香り、濃厚な芋の風味があり、他に類を見ない非常に芋臭い芋焼酎です。<br>ストレートでダイレクトに味わうのもオススメです。<br><br>
														<p>1330円</p>
												</div>
										</article>
								</div>
								<div class="box">
										<article>
												<img src="<?php echo esc_url( theme_source_uri( 'images/shoutyuu/Image_20230915_180414_591.jpeg' ) ); ?>"
													alt="居酒屋">
												<h3>居酒屋</h3>
												<div>酒蔵：居酒屋<br>原料：芋<br>麹：米、白麹<br>アルコール度数：37度<br><br>居酒屋の人気商品『居酒屋』の原酒です。<br>角が取れ、丸みを帯びた味わいは、アルコール度数の高さを感じさせません。<br>トロっとした甘さに蒸した芋の香ばしさ、スッキッリとした後味、他にはない<br>味わいが楽しめます。<br><br>
														<p>1120円</p>
												</div>
										</article>
								</div>
								<div class="box">
										<article>
												<img src="<?php echo esc_url( theme_source_uri( 'images/shoutyuu/Image_20230915_180412_925.jpeg' ) ); ?>"
													alt="居酒屋">
												<h3>居酒屋</h3>
												<div>酒蔵：居酒屋<br>原料：芋(居酒屋契約農家栽培)<br>麹：米、白麹<br>アルコール度数：36度<br><br>一年に一度きりの仕込み、昨年以前の原酒とは一切ブレンドを行はない、<br>居酒屋の契約農家で完熟堆肥栽培という自然の力を最大限に利用した特殊農法の芋を<br>使用すると言う三つのこだわりから誕生した芋焼酎です。<br>コクがあり、甘口で芳醇な香りがあります。<br><br>
														<p>1120円</p>
												</div>
										</article>
								</div>
						</div><!-- #c251 -->
						
