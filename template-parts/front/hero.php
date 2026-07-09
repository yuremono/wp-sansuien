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
		<p class="en"><?php theme_text( 'front_hero_eyebrow', theme_demo_content( 'front_hero_eyebrow' ) ); ?></p>
		<h1><?php theme_lines( 'front_hero_heading', theme_demo_content( 'front_hero_heading' ) ); ?></h1>
		<p class="lead"><?php theme_lines( 'front_hero_lead', theme_demo_content( 'front_hero_lead' ) ); ?></p>
	</div>
	<?php if ( $news_post ) : ?>
		<?php
		$news_url    = (string) theme_content_meta( $news_post->ID, 'news_external_url', get_permalink( $news_post ) );
		$news_target = '' !== (string) theme_content_meta( $news_post->ID, 'news_external_url', '' ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		?>
		<div class="hero_news">
			<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d', $news_post ) ); ?></span>
			<a href="<?php echo esc_url( $news_url ); ?>"<?php echo $news_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( get_the_title( $news_post ) ); ?></a>
		</div>
	<?php endif; ?>
</section>
