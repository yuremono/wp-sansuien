<?php
/**
 * Front hero section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
        exit;
}
?>
<div class="mv bg100 c143">
        <!-- #c143 -->
        <div class="clearfix mv_slide c501">
                <ul>
                        <li>
                                <?php theme_image('front_hero_image', 'images/home/mv01__pc.jpg'); ?>
                        </li>
                        <li>
                                <?php theme_image('front_image_1', 'images/home/mv02__pc.jpg'); ?>
                        </li>
                </ul>
        </div><!-- #c501 -->
        <div class="clearfix mv_h js-hide c464">
                <img src="<?php echo esc_url(theme_source_uri('images/home/logo.png')); ?>" alt="" class="imgL">
        </div><!-- #c464 -->

</div><!-- #c391 -->