<?php
/**
 * Front news-link section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
        exit;
}
?>
<div class="clearfix f32 mt-bl div-fcc c506">
        <div><?php theme_text('front_section_heading', 'お知らせ'); ?><i class="triple f16"></i><a class="btn2"
                   href="<?php echo esc_url(theme_url('front_cta_url', home_url('/insta/'))); ?>"><?php theme_text('front_cta_label', '詳しく見る'); ?></a>
        </div>
</div>