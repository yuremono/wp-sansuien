<?php
/**
 * Static front page layout (ACF-driven).
 *
 * @package Theme
 */

declare(strict_types=1);

get_header();

$hero_kicker = theme_front_meta('hero_kicker', '箕面・大阪北部｜社寺・集合・福祉の建築設計');
$hero_title  = theme_front_meta('hero_title', '坂ノ上設計｜社寺・集合・福祉で「場」を編む');
$hero_lead   = theme_front_meta(
	'hero_lead',
	"箕面から大阪北部へ、プロセスデザインと構法設計を両輪に据えます。\n現調から監理まで伴走し、制度・構造・運用まで一枚岩でご提案します。"
);

$hero_img_field = theme_front_meta('hero_image', null);
$hero_src       = theme_image_url($hero_img_field, 'assets/hero.jpg');

$svc_heading = theme_front_meta('services_heading', '領域別サービス');

$svc_defs = array(
	array(
		'title_default' => '社寺・伝統的木造',
		'body_default'  => "本尊・札所動線・地域行事まで見据えた平面組み替え。\n耐震・メンテ計画までワンストップでご提案します。",
		'fallback_img'  => 'assets/studio.jpg',
		'title_key'     => 'service_1_title',
		'body_key'      => 'service_1_body',
		'image_key'     => 'service_1_image',
	),
	array(
		'title_default' => '集合・福祉・中小プロジェクト',
		'body_default'  => "長寿命仕様・運営動線・ユニバーサルデザインを前提にした計画。\n行政調整やJV連携にも対応します。",
		'fallback_img'  => 'assets/hero.jpg',
		'title_key'     => 'service_2_title',
		'body_key'      => 'service_2_body',
		'image_key'     => 'service_2_image',
	),
	array(
		'title_default' => 'リノベ・構造調査',
		'body_default'  => "耐震診断から狭小地の増築まで局所的な構法見直し。\n竣工後の保全サイクル設計まで支援します。",
		'fallback_img'  => 'assets/studio.jpg',
		'title_key'     => 'service_3_title',
		'body_key'      => 'service_3_body',
		'image_key'     => 'service_3_image',
	),
);

$highlight_show_raw = theme_front_meta( 'highlight_show', 1 );
$show_highlight     = ! empty( $highlight_show_raw );
$highlight_heading = theme_front_meta( 'highlight_heading', '設計へのスタンス' );
$highlight_body    = theme_front_meta(
	'highlight_body',
	"用途と現場条件を踏まえ、法規・構造・運用のバランスを見通してから図面化します。\nワークショップや合意形成の場にも同席し、一段深い提案ができるよう伴走します。"
);
$highlight_img_field = theme_front_meta( 'highlight_image', null );
$highlight_src       = theme_image_url( $highlight_img_field, 'assets/studio.jpg' );

$cta_strip_show_raw = theme_front_meta( 'cta_strip_show', 1 );
$show_cta_strip     = ! empty( $cta_strip_show_raw );
$cta_strip_heading  = theme_front_meta( 'cta_strip_heading', 'まずはお気軽にご相談ください' );
$cta_strip_body     = theme_front_meta(
	'cta_strip_body',
	'用途やスケジュールが固まっていなくても構いません。オンライン面談・現地確認の調整など、運用しやすい形でご案内します。'
);
$cta_strip_button_label = theme_front_meta( 'cta_strip_button_label', 'お問い合わせページへ' );
$cta_strip_button_url   = theme_front_meta( 'cta_strip_button_url', '' );

$stats_show_raw = theme_front_meta( 'stats_show', 1 );
$show_stats_row = ! empty( $stats_show_raw );
$stat_defs      = array(
	array(
		'label_key' => 'stat_1_label',
		'value_key' => 'stat_1_value',
		'label_def' => '設立',
		'value_def' => '2006年',
	),
	array(
		'label_key' => 'stat_2_label',
		'value_key' => 'stat_2_value',
		'label_def' => '設計監理実績（累計・例）',
		'value_def' => '120件超',
	),
	array(
		'label_key' => 'stat_3_label',
		'value_key' => 'stat_3_value',
		'label_def' => '対応エリア（例）',
		'value_def' => '大阪府北部・阪神間',
	),
);

$greeting_show_raw = theme_front_meta( 'greeting_show', 1 );
$show_greeting     = ! empty( $greeting_show_raw );
$greeting_heading = theme_front_meta( 'greeting_heading', 'ごあいさつ' );
$greeting_body    = theme_front_meta(
	'greeting_body',
	"私ども坂ノ上設計は、社寺から集合・福祉施設まで、地域に根差した計画や耐震・長寿命の観点を大切にしています。\n現場での対話と図面上の論理、その両面からお役に立てるよう支援いたします。"
);
$greeting_img_field = theme_front_meta( 'greeting_image', null );
$greeting_has_image = false;
$greeting_src       = '';
if ( is_array( $greeting_img_field ) && ! empty( $greeting_img_field['url'] ) ) {
	$greeting_has_image = true;
	$greeting_src       = esc_url( (string) $greeting_img_field['url'] );
} elseif ( is_string( $greeting_img_field ) && '' !== trim( $greeting_img_field ) ) {
	$greeting_has_image = true;
	$greeting_src       = esc_url( $greeting_img_field );
}

$news_preview_show_raw = theme_front_meta( 'news_preview_show', 1 );
$show_news_preview     = ! empty( $news_preview_show_raw );
$news_preview_heading  = theme_front_meta( 'news_preview_heading', 'お知らせ' );
$news_posts_count      = (int) theme_front_meta( 'posts_count', 3 );
$news_posts_count      = max( 1, min( 10, $news_posts_count ) );

?>

<section class="hero wrap">
	<div class="hero_inner">
		<p class="kicker"><?php echo esc_html((string) $hero_kicker); ?></p>
		<h1 class="hero_title"><?php echo esc_html((string) $hero_title); ?></h1>
		<p class="lead"><?php echo nl2br(esc_html((string) $hero_lead), false); ?></p>
	</div>
	<div class="hero_visual">
		<img class="hero_img" src="<?php echo esc_url($hero_src); ?>" alt="" width="1100" height="760" loading="eager" decoding="async">
	</div>
</section>

<section class="services" aria-labelledby="services_heading">
	<div class="wrap">
		<h2 id="services_heading" class="services_heading"><?php echo esc_html((string) $svc_heading); ?></h2>
		<div class="card_grid">
			<?php foreach ($svc_defs as $svc) : ?>
				<?php
				$t = theme_front_meta($svc['title_key'], $svc['title_default']);
				$b = theme_front_meta($svc['body_key'], $svc['body_default']);
				$img_field = theme_front_meta($svc['image_key'], null);
				$img_src   = theme_image_url($img_field, $svc['fallback_img']);
				?>
				<article class="feature_card">
					<img class="feature_card_img" src="<?php echo esc_url($img_src); ?>" alt="" loading="lazy" decoding="async" width="640" height="480">
					<div class="feature_card_body">
						<h3 class="feature_card_title"><?php echo esc_html((string) $t); ?></h3>
						<p class="feature_card_text"><?php echo nl2br(esc_html((string) $b), false); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ( $show_highlight ) : ?>
<section class="highlight" aria-labelledby="highlight_heading">
	<div class="wrap highlight_grid">
		<div>
			<h2 id="highlight_heading" class="highlight_heading"><?php echo esc_html( (string) $highlight_heading ); ?></h2>
			<p class="highlight_body"><?php echo nl2br( esc_html( (string) $highlight_body ), false ); ?></p>
		</div>
		<div class="highlight_visual">
			<img class="highlight_img" src="<?php echo esc_url( $highlight_src ); ?>" alt="" width="960" height="720" loading="lazy" decoding="async">
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $show_greeting ) : ?>
<section class="greeting_section" aria-labelledby="greeting_heading">
	<div class="wrap greeting_grid<?php echo $greeting_has_image ? '' : ' is_text_only'; ?>">
		<div>
			<h2 id="greeting_heading" class="greeting_heading"><?php echo esc_html( (string) $greeting_heading ); ?></h2>
			<p class="greeting_body"><?php echo nl2br( esc_html( (string) $greeting_body ), false ); ?></p>
		</div>
		<?php if ( $greeting_has_image ) : ?>
		<div class="greeting_visual">
			<img class="greeting_img" src="<?php echo esc_url( $greeting_src ); ?>" alt="" width="960" height="720" loading="lazy" decoding="async">
		</div>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( $show_cta_strip ) : ?>
<section class="cta_strip" aria-labelledby="cta_strip_heading">
	<div class="wrap cta_strip_inner">
		<div class="cta_strip_copy">
			<h2 id="cta_strip_heading" class="cta_strip_title"><?php echo esc_html( (string) $cta_strip_heading ); ?></h2>
			<p class="cta_strip_text"><?php echo nl2br( esc_html( (string) $cta_strip_body ), false ); ?></p>
		</div>
		<?php
		$btn_url_raw = trim( (string) $cta_strip_button_url );
		$btn_label   = trim( (string) $cta_strip_button_label );
		if ( '' !== $btn_url_raw && '' !== $btn_label ) :
			?>
		<p class="cta_strip_action">
			<a class="cta_strip_btn" href="<?php echo esc_url( $btn_url_raw ); ?>"><?php echo esc_html( $btn_label ); ?></a>
		</p>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( $show_stats_row ) : ?>
<section class="stats_row" aria-label="<?php echo esc_attr( __( '主な実績・概要', THEME_GETTEXT_DOMAIN ) ); ?>">
	<div class="wrap stats_row_inner">
		<?php foreach ( $stat_defs as $row ) : ?>
			<?php
			$lbl = theme_front_meta( $row['label_key'], $row['label_def'] );
			$val = theme_front_meta( $row['value_key'], $row['value_def'] );
			?>
			<div class="stat_cell">
				<p class="stat_label"><?php echo esc_html( (string) $lbl ); ?></p>
				<p class="stat_value"><?php echo esc_html( (string) $val ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( $show_news_preview ) : ?>
<section class="news_preview_section" aria-labelledby="news_preview_heading">
	<div class="wrap">
		<h2 id="news_preview_heading" class="news_preview_heading"><?php echo esc_html( (string) $news_preview_heading ); ?></h2>
		<?php
		$news_q = new WP_Query(
			array(
				'post_type'      => 'news',
				'post_status'    => 'publish',
				'posts_per_page' => $news_posts_count,
				'no_found_rows'  => true,
			)
		);
		?>
		<?php if ( $news_q->have_posts() ) : ?>
		<ul class="news_list news_list_preview">
			<?php
			while ( $news_q->have_posts() ) :
				$news_q->the_post();
				?>
			<li class="news_list_item">
				<a class="news_list_link" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
				<span class="news_list_meta_preview"><?php echo esc_html( get_the_date() ); ?></span>
			</li>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</ul>
		<?php else : ?>
			<p class="news_preview_empty"><?php esc_html_e( '掲載中のお知らせはありません。', THEME_GETTEXT_DOMAIN ); ?></p>
		<?php endif; ?>

		<?php
		$news_archive = get_post_type_archive_link( 'news' );
		if ( is_string( $news_archive ) && '' !== $news_archive ) :
			?>
		<p class="news_preview_footer">
			<a class="news_preview_more" href="<?php echo esc_url( $news_archive ); ?>"><?php esc_html_e( 'お知らせ一覧へ', THEME_GETTEXT_DOMAIN ); ?></a>
		</p>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php
get_footer();
