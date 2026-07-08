<?php
/**
 * Front hero section.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$latest_news = theme_get_content_posts( 'news', array( 'posts_per_page' => 1 ) );
$news_post   = $latest_news ? $latest_news[0] : null;
?>
<section class="hero">
	<?php theme_image( 'front_hero_image', 'images/hero.jpg', '青木湖と山並み' ); ?>
	<div class="shade"></div>
	<div class="hero_copy">
		<p class="en"><?php theme_text( 'front_hero_eyebrow', 'HAVE A QUIET TIME BY THE LAKE — EST. 1972' ); ?></p>
		<h1><?php theme_lines( 'front_hero_heading', "水と緑に抱かれて、\n心をほどく一夜を。" ); ?></h1>
		<p class="lead"><?php theme_lines( 'front_hero_lead', "湖畔にたたずむ全十二室の小さな宿。\n季節の湯と土地の恵みで、静かな時間をご用意しております。" ); ?></p>
	</div>
	<?php if ( $news_post ) : ?>
		<div class="hero_news">
			<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d', $news_post ) ); ?></span>
			<a href="<?php echo esc_url( home_url( '/#news' ) ); ?>"><?php echo esc_html( get_the_title( $news_post ) ); ?></a>
		</div>
	<?php endif; ?>
</section>
