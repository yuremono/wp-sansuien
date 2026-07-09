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
		'heading'  => theme_demo_content( 'front_rooms_heading' ),
		'body'     => theme_demo_content( 'front_rooms_body' ),
		'url'      => $room_archive_url,
		'fallback' => 'images/room1.jpg',
		'alt'      => '客室の座卓と床の間',
	),
	array(
		'slug'     => 'onsen',
		'label'    => 'ONSEN',
		'heading'  => theme_demo_content( 'front_onsen_heading' ),
		'body'     => theme_demo_content( 'front_onsen_body' ),
		'url'      => $reserve_url,
		'fallback' => 'images/bath.jpg',
		'alt'      => '露天風呂',
	),
	array(
		'slug'     => 'cuisine',
		'label'    => 'CUISINE',
		'heading'  => theme_demo_content( 'front_cuisine_heading' ),
		'body'     => theme_demo_content( 'front_cuisine_body' ),
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
