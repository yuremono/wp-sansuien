<?php
/**
 * Quests page content.
 *
 * @package Theme
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
        exit;
}
?>
<div id="contents_wrap">
        <div id="contents" class="clearfix">
                <div id="main" class="clearfix">
                        <div id="col_main">
                                <section>
                                        <div  class="clearfix bg_slide c324">
                                                <ul>
                                                        <li>
                                                                <?php theme_quests_image('quests_hero_image_1', 'images/home/mv02.jpg', 'Quests メインビジュアル 1'); ?>
                                                        </li>
                                                        <li>
                                                                <?php theme_quests_image('quests_hero_image_2', 'images/home/mv01.jpg', 'Quests メインビジュアル 2'); ?>
                                                        </li>
                                                        <li>
                                                                <?php theme_quests_image('quests_hero_image_3', 'images/home/mv04.jpg', 'Quests メインビジュアル 3'); ?>
                                                        </li>
                                                </ul>
                                        </div><!-- #c324 -->
                                        <div  class="clearfix mv_it  js-hide mt0 c322">
                                                <div>
                                                        <h1 style="font-size:1em;">
                                                                <?php theme_quests_lines('quests_hero_title', "Samplexx\nLayout Text Dummyxx"); ?>
                                                        </h1>
                                                </div>
                                        </div><!-- #c322 -->
                                        <div  class="About bg100 mt0 c270">
                                                <div class="dis">
                                                </div><!-- #c270 -->
                                                <div  class="clearfix mv_it02  js-hide c325">
                                                        <div><span
                                                                      style="font-size:1em;"><?php theme_quests_lines('quests_about_copy', "Samplexx\nLayout Textxxxx"); ?></span>
                                                        </div>
                                                </div><!-- #c325 -->
                                                <div  class="clearfix About_tx txwh PB15 c291">
                                                        <div>
                                                                <h2 class="h1FZ">
                                                                        <?php theme_quests_text('quests_about_heading', '文字と「暮らす」'); ?>
                                                                </h2><br />
                                                                <span
                                                                      style='margin-top:0em; line-height:3.5;'><?php theme_quests_lines('quests_about_body', "ここには日本語の仮文章を配置しています。\n文字量と改行の見え方を保つため、同じ程度の長さで構成したダミーテキストです。\n実際の説明内容ではなく、画面上の余白や行間を確認するために、\n日本語のまま置き換えています。\n本文の密度が大きく変わらないよう、文の長さと折り返しを調整しています。\n「仮の文字列をここに入れています」\n「表示確認のための文章です」\n「元の内容を残さず、見た目だけを合わせています」\nSample Textは説明本文ではありません。\nレイアウト確認用の仮文として、全体の分量を元の構成に近づけています。"); ?></span>
                                                        </div>
                                                </div><!-- #c291 -->
                                                <div  class="dis c290">
                                                </div>
                                        </div><!-- #c290 -->
                                        <div  class="Intro wrapper100 c337">
                                                <div class="dis">
                                                </div><!-- #c337 -->
                                                <div  class="__v3 fb_para  op7 c349">
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_intro_image', 'images/home/top01.jpg', 'Introduction イメージ'); ?>
                                                                <div></div>
                                                        </div>
                                                </div><!-- #c349 -->
                                                <div  class="clearfix Intro_h js-hide c340">
                                                        <article>
                                                                <h2><em><?php theme_quests_text('quests_intro_kicker', 'Introduction'); ?></em><?php theme_quests_text('quests_intro_heading', 'Hello! This is Sample Text.'); ?>
                                                                </h2>
                                                                <div>
                                                                        <div style='width: 720px;font-weight: bold;'>
                                                                                <?php theme_quests_lines('quests_intro_body', 'ここには、文字数の確認に使うための仮の文章を配置しています。意味を持たない説明文として、見た目の長さや行数が大きく変わらないように調整しています。読み物としての内容ではなく、余白や折り返し、段落の密度を確認するための日本語ダミーテキストです。表示位置や雰囲気を保つため、同じ程度の長さで構成しています。'); ?>
                                                                        </div>
                                                                </div>
                                                        </article>
                                                </div><!-- #c340 -->
                                                <div  class="clearfix mt0 difference Intro_h js-hide c348">
                                                        <div><a class="btn2 floatR" href="<?php echo esc_url( theme_quests_url( 'quests_contact_url', home_url( '/service/' ) ) ); ?>"><i
                                                                           class="las la-chevron-circle-right"></i></a>
                                                        </div>
                                                </div><!-- #c348 -->
                                                <div  class="dis c341">
                                                </div>
                                        </div><!-- #c341 -->
                                        <div  class="Quests wrapper100 in1680 c305">
                                                <div class="dis">
                                                </div><!-- #c305 -->
                                                <div  class="__v1 fb_para box-parallax op7 c334">
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_feature_image_1', 'images/home/top01.jpg', 'Quests イメージ 1'); ?>
                                                                <div></div>
                                                        </div>
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_feature_image_2', 'images/home/top02.jpg', 'Quests イメージ 2'); ?>
                                                                <div></div>
                                                        </div>
                                                </div><!-- #c334 -->
                                                <div  class="__v2 fb_para box-parallax op7 c336">
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_feature_image_3', 'images/home/top03.jpg', 'Quests イメージ 3'); ?>
                                                                <div></div>
                                                        </div>
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_feature_image_4', 'images/home/top04.jpg', 'Quests イメージ 4'); ?>
                                                                <div></div>
                                                        </div>
                                                </div><!-- #c336 -->
                                                <div  class="clearfix mtB15 Quests_h js-hide H-center c335">
                                                        <article>
                                                                <h2><u style="font-size:1em;"><?php theme_quests_lines('quests_feature_u', "Samplex\nTextxx"); ?></u><?php theme_quests_text('quests_feature_heading', 'Samplex-only'); ?>
                                                                </h2>
                                                                <div>
                                                                        <div class="mgi-auto"
                                                                             style='width: 720px;font-weight: bold;'>
                                                                                <?php theme_quests_lines('quests_feature_body', "「サンプル\nテキスト」は表示確認のために配置した仮の文章です。日本語の長さや改行の入り方を保ちながら、意味のあるサービス説明にならないよう調整しています。画面上の余白、文字量、読みやすさを確認するためのダミーテキストとして、同じ程度の密度で構成しています。"); ?>
                                                                        </div>
                                                                </div>
                                                        </article>
                                                </div><!-- #c335 -->
                                                <div  class="dis c308">
                                                </div>
                                        </div><!-- #c308 -->
                                        <div  class="Education bg100 child1680  mt0 bg_fix c266">
                                                <div class="bg_half __left" style="background:var(--wh80)"></div>
                                                <div class="dis">
                                                </div><!-- #c266 -->
                                                <div  class="clearfix difference ml0 c299">
                                                        <article>
                                                                <h2><em><?php theme_quests_text('quests_education_kicker', 'Surround yourself with English！'); ?></em><?php theme_quests_text('quests_education_heading', '日々の文字に文字を'); ?>
                                                                </h2>
                                                                <div></div>
                                                        </article>
                                                </div><!-- #c299 -->
                                                <div  class="clearfix txL c326">
                                                        <article>
                                                                <h3><em><?php theme_quests_text('quests_education_card_kicker', 'Education'); ?></em><?php theme_quests_text('quests_education_card_heading', '文字文字'); ?>
                                                                </h3>
                                                                <div><?php theme_quests_lines('quests_education_card_body', '仮の日本語テキストをここに配置しています。本文の量や折り返しを確認するための文章で、実際の説明として読ませる内容ではありません。表示の密度を保つため、同じくらいの長さで構成しています。'); ?>
                                                                </div>
                                                        </article>
                                                </div><!-- #c326 -->
                                                <div  class="dis c268">
                                                </div>
                                        </div><!-- #c268 -->
                                        <div  class="Education bg100 child1680  mt0 bg_fix c344">
                                                <div class="bg_half" style="background:var(--bk80)"></div>
                                                <div class="dis">
                                                </div><!-- #c344 -->
                                                <div  class="clearfix txR txwh c346">
                                                        <article>
                                                                <h3><em><?php theme_quests_text('quests_life_1_kicker', 'LIFE'); ?></em><?php theme_quests_text('quests_life_1_heading', '文字のある文字'); ?>
                                                                </h3>
                                                                <div><?php theme_quests_lines('quests_life_1_body', "Sample\ntext remains here for layout checking only. The sentence length is adjusted to keep the visual rhythm close to the original while avoiding real descriptive content. Japanese text is replaced separately so the mixed language balance stays similar."); ?>
                                                                </div>
                                                        </article>
                                                </div><!-- #c346 -->
                                                <div  class="dis c347">
                                                </div>
                                        </div><!-- #c347 -->
                                        <div  class="Education bg100 child1680  mt0 bg_fix c350">
                                                <div class="bg_half" style="background:var(--bk80)"></div>
                                                <div class="dis">
                                                </div><!-- #c350 -->
                                                <div  class="clearfix txR txwh c351">
                                                        <article>
                                                                <h3><em><?php theme_quests_text('quests_life_2_kicker', 'LIFE'); ?></em><?php theme_quests_text('quests_life_2_heading', '文字のある文字'); ?>
                                                                </h3>
                                                                <div><?php theme_quests_lines('quests_life_2_body', "Sample\ntext remains here for layout checking only. The sentence length is adjusted to keep the visual rhythm close to the original while avoiding real descriptive content. Japanese text is replaced separately so the mixed language balance stays similar."); ?>
                                                                </div>
                                                        </article>
                                                </div><!-- #c351 -->
                                                <div  class="dis c352">
                                                </div>
                                        </div><!-- #c352 -->
                                        <div  class="Education bg100 child1680 bg_fix c327">
                                                <div class="bg_half __left" style="background:var(--wh80)"></div>
                                                <div class="dis">
                                                </div><!-- #c327 -->
                                                <div class="clearfix txL mt0 Germany">
                                                        <article>
                                                                <h3><em><?php theme_quests_text('quests_enjoy_kicker', 'Enjoy'); ?></em><?php theme_quests_text('quests_enjoy_heading', '文字で遊ぶ'); ?>
                                                                </h3>
                                                                <div><?php theme_quests_lines('quests_enjoy_body', "Sample\ntext is placed here as a neutral placeholder. It keeps a similar amount of visible content while removing the original message. The wording is intentionally generic so only the layout and balance can be checked."); ?>
                                                                </div>
                                                        </article>
                                                </div><!-- #c329 -->
                                                <div  class="clearfix f40 PB1 pdi darken mt0 c331">
                                                        <div><span
                                                                      class='f140 lato lh13'><?php theme_quests_lines('quests_closing_big', "Sample text for layout\nbalance in this area\nthat keeps the original\nline volume"); ?></span><br />
                                                                <?php theme_quests_rich('quests_closing_small', 'ここにも仮の文字列を<span>同じ量だけ置きます。</span>'); ?>
                                                        </div>
                                                </div><!-- #c331 -->

                                        </div><!-- #c330 -->
                                        <div  class="wrapper100 c353">

                                                <div  class="clearfix js-hide H-center c342">
                                                        <article>
                                                                <h2><em class="txwh">Instagram</em></h2>
                                                        </article>
                                                </div><!-- #c342 -->
                                                <div  class="sns_slide noText c343">
                                                        <div class="sns_list">
                                                                <div>
                                                                        <div class="sns_photo">
                                                                                <a href="#">
                                                                                        <img
                                                                                             src="<?php echo esc_url(theme_quests_source_uri('images/placeholder/960x960.png')); ?>">
                                                                                </a>
                                                                        </div><!-- div.sns_list div.sns_photo -->
                                                                        <div class="sns_text">
                                                                                <div class="sns_date">2025.05.15</div>
                                                                                <div class="caption">
                                                                                        「遊びながら自然に英語が身につく、新しいカタチのシッターサービス」

                                                                                        忙しいママ・パパに代わって、お子さまのお世話をしながら、ネイティブレベルの英語に触れられる“英会話シッター”✨
                                                                                        ただの見守りではなく、遊びや日常の中で英語を楽しく学べる時間をご提供します🎨📚

                                                                                        **対象年齢：**3歳〜小学生 👶👧🧒
                                                                                        **エリア：**都内中心（応相談）🗼
                                                                                        **ご利用時間：**1日数時間からOK⌛

                                                                                        お子さまの未来に“本物の英語力”を✈️🌍

                                                                                        【ご予約・お問い合わせはDMまで】📩

                                                                                        #英語 #EnglishQuests #英会話 #都内シッター
                                                                                </div>
                                                                                <div id="TRANS_SNSCS30"></div>
                                                                                <ul class="clearfix">
                                                                                        <li><a href="#">#英語</a>
                                                                                        </li>
                                                                                        <li><a href="#">#EnglishQuests</a>
                                                                                        </li>
                                                                                        <li><a href="#">#英会話</a>
                                                                                        </li>
                                                                                        <li><a href="#">#都内シッター</a>
                                                                                        </li>
                                                                                </ul>
                                                                        </div><!-- div.sns_list div.sns_text -->
                                                                </div><!-- div.sns_list > div -->
                                                                <div>
                                                                        <div class="sns_photo">
                                                                                <a href="#">
                                                                                        <img
                                                                                             src="<?php echo esc_url(theme_quests_source_uri('images/placeholder/960x960.png')); ?>">
                                                                                </a>
                                                                        </div><!-- div.sns_list div.sns_photo -->
                                                                        <div class="sns_text">
                                                                                <div class="sns_date">2025.04.09</div>
                                                                                <div class="caption"></div>
                                                                                <div id="TRANS_SNSCS29"></div>
                                                                                <ul class="clearfix">
                                                                                </ul>
                                                                        </div><!-- div.sns_list div.sns_text -->
                                                                </div><!-- div.sns_list > div -->
                                                        </div><!-- div.sns_list -->
                                                </div><!-- #c343 -->

                                        </div><!-- #c354 -->
                                </section>

                                <!-- #col_main -->
                        </div>
                        <!-- #main -->
                </div>
                <!-- #contents -->
        </div>
        <!-- #contents_wrap -->
</div>
