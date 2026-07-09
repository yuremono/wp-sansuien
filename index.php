<?php
/**
 * Fallback template.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main">
	<section class="archive wrap">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<div class="entry-content entry"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<h1 class="archive_title"><?php echo esc_html( THEME_BRAND_DEFAULT ); ?></h1>
			<p class="archive_empty"><?php echo esc_html( 'ページが見つかりませんでした。メニューからお進みください。' ); ?></p>
		<?php endif; ?>
	</section>
</main>

<?php
get_footer();
