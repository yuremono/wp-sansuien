<?php
/**
 * Front shochu-features section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
        exit;
}
?>
<div class="fl50wide mt0 c414">
        <div class="clearfix c502">
                <article>
                        <h2><?php theme_text('front_section_heading', '焼酎の原酒'); ?></h2>
                        <div><?php theme_rich('front_section_body', '皆さんがよく見かける焼酎は<br>25度や20度のものが多いと思いますが、<br>それらの焼酎は原酒に水を加えることによって<br>度数を調整しています。<br>水や添加物を一切加えない状態のお酒のことを<br>原酒と呼びます。<br>'); ?>
                                
                                <a class="btn"
                                   href="<?php echo esc_url(theme_url('front_cta_url', home_url('/genshu/'))); ?>"><?php theme_text('front_cta_label', '詳しく見る'); ?></a>
                        </div>
                </article>
        </div>
        <div class="twopicR wrapGrid c475">
                <div class="box">
                        <?php theme_image('front_image_1', 'images/shoutyuu/Image_20230915_180414_591.jpeg'); ?>
                        <div></div>
                </div>
                <div class="box">
                        <?php theme_image('front_image_2', 'images/shoutyuu/IMG_404334.jpg'); ?>
                        <div></div>
                </div>
        </div>
        <div class="twopicL wrapGrid c477">
                <div class="box">
                        <img src="<?php echo esc_url(theme_source_uri('images/home/s01.jpg')); ?>" alt="">
                        <div></div>
                </div>
                <div class="box">
                        <img src="<?php echo esc_url(theme_source_uri('images/shoutyuu/IMG_4057.jpg')); ?>" alt="">
                        <div></div>
                </div>
        </div>
        <div class="clearfix c503">
                <article>
                        <h2>本格焼酎</h2>
                        <div>当店で扱っている焼酎は本格焼酎と言われるものです。<br />
                                連続式蒸留機を使用して純粋なアルコール分を取り出したものではなく、単式蒸留機を使用してじっくりと蒸留していくことで出来る焼酎で<br />
                                本格焼酎には原料の芋、米、麦などの風味が豊かで、深い味わいが楽しめます。<br />
                                <a class="btn" href="<?php echo esc_url(home_url('/shochu/')); ?>">詳しく見る</a>
                        </div>
                </article>
        </div>

</div>