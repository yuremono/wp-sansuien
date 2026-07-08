<?php
/**
 * Front about section（山翠苑について）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="about">
	<img class="about_bg" src="<?php echo esc_url( theme_source_uri( 'images/bg_beige.jpg' ) ); ?>" alt="">
	<div class="about_grid">
		<div class="about_pic"><?php theme_image( 'front_about_image', 'images/irori.jpg', '囲炉裏のある伝統的な空間' ); ?></div>
		<div class="about_side reveal-r">
			<span class="en_label">About<svg class="sym sym-sm"><use href="#sym-tri"></use></svg><span class="jp_s">山翠苑について</span></span>
			<h3><?php theme_lines( 'front_about_heading', "創業から半世紀、\n湖畔とともに。" ); ?></h3>
			<p><?php theme_text( 'front_about_body', '創業から半世紀、湖畔の自然と地元の恵みを活かしたおもてなしを大切にしてまいりました。派手さはございませんが、また帰ってきたくなる——そんな宿でありたいと願っております。' ); ?></p>
			<div class="about_staff">
				<figure>
					<?php theme_image( 'front_about_okami_image', 'images/okami.jpg', '女将' ); ?>
					<figcaption><div class="nm"><?php theme_text( 'front_about_okami_name', '川井 美和子' ); ?></div><div class="rl"><?php theme_text( 'front_about_okami_role', 'OKAMI 女将' ); ?></div></figcaption>
				</figure>
				<figure>
					<?php theme_image( 'front_about_chef_image', 'images/chef.jpg', '板長' ); ?>
					<figcaption><div class="nm"><?php theme_text( 'front_about_chef_name', '佐伯 隆' ); ?></div><div class="rl"><?php theme_text( 'front_about_chef_role', 'ITACHO 板長' ); ?></div></figcaption>
				</figure>
			</div>
		</div>
	</div>
</section>
