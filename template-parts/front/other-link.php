<?php
/**
 * Front other-link section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
        exit;
}
$other_url = theme_url('front_other_url', home_url('/other/'));
?>
<div class="linkouter_top mt-bl05 c478">
        
        <div class="clearfix twopicBf c505">
                <div><a class="btn" href="<?php echo esc_url($other_url); ?>"><br />
                                <span><?php theme_text('front_other_eyebrow', 'Other'); ?></span><br />
                                <span><?php theme_text('front_other_heading', 'その他のお酒'); ?></span><br />
                        </a></div>
        </div>
        <div class="twopicBtn c504">
                <div class="box">
                        <a href="<?php echo esc_url($other_url); ?>" title=""
                           target="_self"><?php theme_image('front_other_image_1', 'images/home/sonota01.jpg'); ?></a>
                        <div></div>
                </div>
                <div class="box">
                        <a href="<?php echo esc_url($other_url); ?>" title=""
                           target="_self"><?php theme_image('front_other_image_2', 'images/home/IMG_4031.jpg'); ?></a>
                        <div>その他のお酒<br></div>
                </div>
        </div>

</div>