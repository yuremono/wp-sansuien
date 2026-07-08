<?php
/**
 * Front feature section（ROOMS / ONSEN / CUISINE）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$room_archive_url = home_url( '/room/' );
$reserve_url       = home_url( '/#reserve' );

$blocks = array(
	array(
		'slug'     => 'rooms',
		'label'    => 'ROOMS',
		'heading'  => "湖に向かって開かれた、\n全十二室のしつらえ。",
		'body'     => '露天風呂付き特別室「蒼」をはじめ、湖viewの和洋室、庭園沿いの和室まで。どの部屋も窓の外の景色を主役に、余計なものを置かないしつらえです。',
		'url'      => $room_archive_url,
		'fallback' => 'images/room1.jpg',
		'alt'      => '客室の座卓と床の間',
	),
	array(
		'slug'     => 'onsen',
		'label'    => 'ONSEN',
		'heading'  => "湯けむりの向こうに、\n湖と山のいとなみ。",
		'body'     => '大浴場と展望風呂のほか、貸切の露天風呂をご用意。朝は湖面の霧、夜は星空。季節と時間で表情を変える湯浴みをお楽しみください。',
		'url'      => $reserve_url,
		'fallback' => 'images/bath.jpg',
		'alt'      => '露天風呂',
	),
	array(
		'slug'     => 'cuisine',
		'label'    => 'CUISINE',
		'heading'  => "土地の恵みを、\n囲炉裏の火とともに。",
		'body'     => '信州の山菜や湖の幸を中心にした季節の会席。夕食後は炭火の灯る囲炉裏ラウンジで、地酒とともにゆっくりとお過ごしください。',
		'url'      => $reserve_url,
		'fallback' => 'images/kaiseki.jpg',
		'alt'      => '季節の会席料理',
	),
);
?>
<section class="feature" id="feature">
	<div class="bg_wrap"><div class="bg_sticky"><img src="<?php echo esc_url( theme_source_uri( 'images/bg_teal.jpg' ) ); ?>" alt=""></div></div>
	<div class="wrap">
		<div class="sec_head reveal">
			<span class="en">Feature</span><svg class="sym"><use href="#sym-tri"></use></svg><span class="jp">山翠苑の過ごし方</span>
		</div>
	</div>
	<div class="wrap">
		<div class="f_wrap">
			<div class="f_texts">
				<?php foreach ( $blocks as $block ) : ?>
					<div class="f_txt reveal-l">
						<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg><?php echo esc_html( $block['label'] ); ?></span>
						<h3><?php echo nl2br( esc_html( (string) theme_meta( "front_{$block['slug']}_heading", $block['heading'] ) ) ); ?></h3>
						<p><?php echo esc_html( (string) theme_meta( "front_{$block['slug']}_body", $block['body'] ) ); ?></p>
						<a class="view_more" href="<?php echo esc_url( theme_url( "front_{$block['slug']}_cta_url", $block['url'] ) ); ?>">View More<span class="arrow"><span class="bar"></span><svg class="sym"><use href="#sym-tri"></use></svg></span></a>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="f_pics">
				<?php foreach ( $blocks as $block ) : ?>
					<div class="f_pic"><div class="ph"><?php theme_image( "front_{$block['slug']}_image", $block['fallback'], $block['alt'] ); ?></div></div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
