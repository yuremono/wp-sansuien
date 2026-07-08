<?php
/**
 * 客室一覧ページ（CPT: room のアーカイブ）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/site-header' );
get_template_part( 'template-parts/reserve-tab' );

$rooms = theme_get_content_posts( 'room' );
?>

<section class="page_hero">
	<img src="<?php echo esc_url( theme_source_uri( 'images/room2.jpg' ) ); ?>" alt="山翠苑の客室">
	<div class="shade"></div>
	<div class="hd">
		<span class="en_label"><svg class="sym sym-sm"><use href="#sym-tri"></use></svg>Rooms</span>
		<h2>客室のご案内</h2>
	</div>
</section>

<nav class="crumbs" aria-label="パンくずリスト">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップ</a><span>›</span><span>客室のご案内</span>
</nav>

<section class="other_rooms">
	<div class="wrap">
		<?php if ( $rooms ) : ?>
			<div class="or_cards">
				<?php foreach ( $rooms as $room ) : ?>
					<?php
					$image = theme_content_image_data( $room->ID, 'images/room1.jpg' );
					$rate  = (string) theme_content_meta( $room->ID, 'room_rate_weekday', '' );
					?>
					<a href="<?php echo esc_url( get_permalink( $room ) ); ?>">
						<div class="ph"><img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"></div>
						<div class="bd">
							<svg class="sym sym-sm csym"><use href="#sym-tri"></use></svg>
							<div class="nm"><?php echo esc_html( get_the_title( $room ) ); ?></div>
							<?php if ( '' !== $rate ) : ?><div class="pr"><?php echo esc_html( $rate ); ?> / 1泊2食付</div><?php endif; ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="archive_empty">現在ご案内できる客室情報はございません。</p>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/front/closing' );
get_template_part( 'template-parts/site-footer' );
get_footer();
