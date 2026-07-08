<?php
/**
 * Front news-feed section（お知らせ一覧）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$news_posts = theme_get_content_posts( 'news', array( 'posts_per_page' => 3 ) );
$news_archive_url = home_url( '/#news' );
?>
<section class="news_sec" id="news">
	<svg class="news_bg path_draw" viewBox="15 97.8 166.4 40" preserveAspectRatio="xMidYMid meet" fill="none" aria-hidden="true">
		<path pathLength="1" d="m23.6 121.8c9.9-1.7 22.4-7.3 28.3-10.1 7.2-3.4 8.9-4.7 10.1-4.6 2 0.1 5.3 2.7 6.7 3.1 1.6 0.5 2.3-0.5 3.8 0.2s3.4 2.8 4.5 2.9c1 0.2 1.5-0.9 3.1-0.5 1.9 0.6 6.7 3.8 13.6 6 6.4 2.2 14.8 4.3 25.3 4.8"/>
		<path pathLength="1" d="m85.9 128.8c-15.6-3-22.1-4.9-45.9-0.4"/>
		<path pathLength="1" d="m26.1 127.2c18.4 0.8 27.3-3.7 37.7-6.5 11.1-2.9 15.2 0.2 25 3 12 3.6 21.4 5.2 32.4 4 7.1-0.7 14.3-3.4 18.7-4.7 11.1-3.7 14.6-6.6 26.5-5.6l8.2 1.6 0.4 0.1-0.4-0.1"/>
		<path pathLength="1" d="m111.7 126.7c10.7-0.4 16.9-2.7 27.7-6.1 8.6-2.8 13.1-4.3 20.8-3.9 4.1 0.4 9.3 1.5 21.1 1.8"/>
		<path pathLength="1" d="m96.5 116.3c7.9-1.1 13.2-5.3 15.9-6.5 1.5-0.6 2.1 0.2 3.8-0.5 1.8-0.7 6.2-3.6 7.5-4.4 2.3-1.2 2.9-0.6 4.7 0.5 3.3 2.1 2.9 2.3 5.2 1.8 1.5-0.1 1.9 0.2 3.3 1 3.3 2.1 6.5 4.4 8.4 5 2.2 0.9 2.6-0.4 3.9-0.3 1.3 0 1.9 1.1 3.7 1.2 2.1 0.1 3.8-1.3 6.2-1.4 3.5-0.1 9.8 3.6 22.2 5.7"/>
	</svg>
	<div class="wrap news_grid">
		<div>
			<div class="sec_head sm reveal-l">
				<span class="en">News</span><svg class="sym"><use href="#sym-tri"></use></svg><span class="jp">お知らせ</span>
			</div>
		</div>
		<div>
			<div class="news_list paper50">
				<?php if ( $news_posts ) : ?>
					<?php foreach ( $news_posts as $index => $news_post ) : ?>
						<?php
						$image     = theme_content_image_data( $news_post->ID, 'images/lake2.jpg' );
						$news_url  = (string) theme_content_meta( $news_post->ID, 'news_external_url', get_permalink( $news_post ) );
						$news_target = '' !== (string) theme_content_meta( $news_post->ID, 'news_external_url', '' ) ? ' target="_blank" rel="noopener noreferrer"' : '';
						?>
						<a href="<?php echo esc_url( $news_url ); ?>"<?php echo $news_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="<?php echo 0 === $index % 2 ? 'reveal-r' : 'reveal-l'; ?>">
							<div class="th"><img src="<?php echo esc_url( $image['url'] ); ?>" alt=""></div>
							<span class="date"><?php echo esc_html( get_the_date( 'Y.m.d', $news_post ) ); ?></span>
							<span class="tt"><?php echo esc_html( get_the_title( $news_post ) ); ?></span>
						</a>
					<?php endforeach; ?>
				<?php else : ?>
					<p class="news_empty">現在お知らせはございません。</p>
				<?php endif; ?>
			</div>
			<div class="view_more_row reveal-l"><a class="view_more" href="<?php echo esc_url( $news_archive_url ); ?>">View More<span class="arrow"><span class="bar"></span><svg class="sym"><use href="#sym-tri"></use></svg></span></a></div>
		</div>
	</div>
</section>
