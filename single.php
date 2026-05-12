<?php
/**
 * Single post template (default `post`).
 *
 * @package Theme
 */

declare(strict_types=1);

get_header();
?>

<section class="singular wrap">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'singular_article' ); ?>>
			<p class="news_meta">
				<time class="news_meta_time" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</p>
			<h1 class="singular_title"><?php echo esc_html( get_the_title() ); ?></h1>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="single_featured_banner is_post">
					<?php
					echo get_the_post_thumbnail(
						null,
						'large',
						array(
							'class'    => 'single_featured_img',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				</figure>
			<?php endif; ?>
			<div class="entry-content entry">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</section>

<?php
get_footer();
