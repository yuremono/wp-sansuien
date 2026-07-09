<?php
/**
 * お知らせ一覧ページ（カテゴリー: news のアーカイブ、`/news/` リライト先）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$news_posts = theme_get_content_posts( 'news' );
?>

<main id="primary" class="site-main">
	<section class="page_hero">
		<img src="<?php echo esc_url( theme_source_uri( 'images/lake2.jpg' ) ); ?>" alt="山翠苑のお知らせ">
		<div class="shade"></div>
		<div class="hd">
			<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>News</span>
			<h1>お知らせ</h1>
		</div>
	</section>

	<nav class="crumbs" aria-label="パンくずリスト">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a><span>›</span><span>お知らせ</span>
	</nav>

	<section class="news_sec">
		<div class="wrap">
			<div class="news_list paper50">
				<?php if ( $news_posts ) : ?>
					<?php foreach ( $news_posts as $news_post ) : ?>
						<?php
						$image       = theme_content_image_data( $news_post->ID, 'images/lake2.jpg' );
						$news_url    = (string) theme_content_meta( $news_post->ID, 'news_external_url', get_permalink( $news_post ) );
						$news_target = '' !== (string) theme_content_meta( $news_post->ID, 'news_external_url', '' ) ? ' target="_blank" rel="noopener noreferrer"' : '';
						?>
						<a href="<?php echo esc_url( $news_url ); ?>"<?php echo $news_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<div class="th"><img src="<?php echo esc_url( $image['url'] ); ?>" alt=""></div>
							<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d', $news_post ) ); ?></span>
							<span class="tt"><?php echo esc_html( get_the_title( $news_post ) ); ?></span>
						</a>
					<?php endforeach; ?>
				<?php else : ?>
					<p class="news_empty">現在お知らせはございません。</p>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
