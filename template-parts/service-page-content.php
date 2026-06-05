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
        <div id="contents" class="clearfix ">
                <div id="main" class="clearfix">
                        <div id="col_main">
                                <section>
                                        <div  class="c324 clearfix bg_slide c324">
                                                <ul>
                                                        <li>
                                                                <?php theme_quests_image('quests_service_hero_image', 'images/home/mv02.jpg', 'サービス メインビジュアル'); ?>
                                                        </li>
                                                </ul>
                                        </div><!-- #c324 -->
                                        <div  class="c322 clearfix mv_it  js-hide mt0 c322">
                                                <div>
                                                        <h1 style="font-size:1em;">
                                                                <span><?php theme_quests_text('quests_service_hero_label', 'Service'); ?></span><small><?php theme_quests_text('quests_service_hero_small', '文字文字紹介'); ?></small>
                                                        </h1>
                                                </div>
                                        </div><!-- #c322 -->
                                        <div  class="pan1 __center c344">
                                                <pan></pan>
                                        </div><!-- #c344 -->
                                       
                                        
                                        <div  class="Education bg100 child1680 bg_fix c327">
                                                <div class="bg_half __left" style="background:var(--wh80)"></div>
                                                
                                        </div><!-- #c364 -->
                                        <div  class="LongText Quests wrapper100 in1680 c378">

                                                <div  class="c381 clearfix mtB15 Quests_h js-hide H-center c381">
                                                        <article>
                                                                <h2><u style="font-size:1em;"><?php theme_quests_lines('quests_service_long_u', "Samplex\nTextxx"); ?></u><?php theme_quests_text('quests_service_long_heading', 'アイウエオカキクケコとは？'); ?>
                                                                </h2>
                                                                <div>
                                                                        <div class="mgi-auto"
                                                                             style='width: 720px;font-weight: bold;'>
                                                                                <br />
                                                                                <span style='font-size:1.0em;'>
                                                                                        <?php theme_quests_lines('quests_service_long_body', "ここには日本語の仮文章を配置し、行の高さと余白を確認します。\n\n対象や内容を示す実文ではなく、文字量を保つための文章です。\n\n段落の見え方が大きく変わらないよう、同程度の長さで調整しています。\n\n（仮として）\n・日本語の仮文を通じて表示の密度を確認\n・見た目の分量を保つためのサンプルテキスト！\n・意味を持たない文章を並べて、折り返しを確認します！\n\nここに続く文章もダミーです。元の説明文が残らないようにしながら、表示のまとまりが崩れない程度の文字量で構成しています。\n最後の行も確認用の日本語テキストとして配置しています"); ?></span><br />
                                                                        </div>
                                                                </div>
                                                        </article>
                                                </div><!-- #c381 -->
                                                <div  class="__v1 fb_para box-parallax op7 c379">
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_service_point_image_1', 'images/home/servide01.jpg', 'サービス Point イメージ 1'); ?>
                                                                <div></div>
                                                        </div>
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_service_point_image_2', 'images/home/service02.jpg', 'サービス Point イメージ 2'); ?>
                                                                <div></div>
                                                        </div>
                                                </div><!-- #c379 -->
                                                <div  class="__v2 fb_para box-parallax op7 c380">
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_service_point_image_3', 'images/home/service03.jpg', 'サービス Point イメージ 3'); ?>
                                                                <div></div>
                                                        </div>
                                                        <div class="box">
                                                                <?php theme_quests_image('quests_service_point_image_4', 'images/home/service04.jpg', 'サービス Point イメージ 4'); ?>
                                                                <div></div>
                                                        </div>
                                                </div><!-- #c380 -->

                                        </div><!-- #c382 -->
                                        <div  class="clearfix difference ml0 c360">
                                                <article>
                                                        <h2><em><?php theme_quests_text('quests_service_plan_heading', 'PLAN'); ?></em>
                                                        </h2>
                                                        <div></div>
                                                </article>
                                        </div><!-- #c360 -->
                                        <div  class="clearfix c377">
                                                <div><?php theme_quests_text('quests_service_plan_time', '文字時間7：00～22：00'); ?>
                                                </div>
                                        </div><!-- #c377 -->
                                        <div  class="clearfix c372">
                                                <article>
                                                        <h3><?php theme_quests_text('quests_service_price_heading', '文字一覧'); ?>
                                                        </h3>
                                                        <div></div>
                                                </article>
                                        </div><!-- #c372 -->
                                        <div  class="tbl_normal  c370">
                                                <article>
                                                        <?php
                                                        theme_quests_rich(
                                                                'quests_service_price_table',
                                                                '<table>
                                                                <tr>
                                                                        <td id="c370_cell_1_1" class="">
                                                                                <div><span style="font-size:0.9em;">１チケット（7:00〜22:00）
                                                                                                / １文字</span></div>
                                                                        </td>
                                                                        <td id="c370_cell_2_1" class="">
                                                                                <div>0,000円</div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td id="c370_cell_1_2" class="">
                                                                                <div>１Txt（9文字）</div>
                                                                        </td>
                                                                        <td id="c370_cell_2_2" class="">
                                                                                <div><span
                                                                                              style="font-size:0.9em;">00,000円</span>
                                                                                </div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td id="c370_cell_1_3" class="">
                                                                                <div>文字同行（文字費・文字・文字費別）</div>
                                                                        </td>
                                                                        <td id="c370_cell_2_3" class="">
                                                                                <div>文字列</div>
                                                                        </td>
                                                                </tr>
                                                        </table>'
                                                        );
                                                        ?>
                                                </article>
                                        </div><!-- #c370 -->
                                        <div  class="clearfix  c375">
                                                <div><?php theme_quests_text('quests_service_price_note', '※表示文字は税込です'); ?>
                                                </div>
                                        </div><!-- #c375 -->
                                        <div  class="clearfix  c373">
                                                <article>
                                                        <h3><?php theme_quests_text('quests_service_area_heading', '対応文字列'); ?>
                                                        </h3>
                                                        <div></div>
                                                </article>
                                        </div><!-- #c373 -->
                                        <div  class="tbl_normal  c374">
                                                <article>
                                                        <?php
                                                        theme_quests_rich(
                                                                'quests_service_area_table',
                                                                '<table>
                                                                <tr>
                                                                        <td id="c374_cell_1_1" class="">
                                                                                <div>文字都</div>
                                                                        </td>
                                                                        <td id="c374_cell_2_1" class="">
                                                                                <div>文字</div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td id="c374_cell_1_2" class="">
                                                                                <div>文字文字</div>
                                                                        </td>
                                                                        <td id="c374_cell_2_2" class="">
                                                                                <div>文字</div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td id="c374_cell_1_3" class="">
                                                                                <div>文字県</div>
                                                                        </td>
                                                                        <td id="c374_cell_2_3" class="">
                                                                                <div>文字</div>
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                        <td id="c374_cell_1_4" class="">
                                                                                <div>文字県</div>
                                                                        </td>
                                                                        <td id="c374_cell_2_4" class="">
                                                                                <div>文字</div>
                                                                        </td>
                                                                </tr>
                                                        </table>'
                                                        );
                                                        ?>
                                                </article>
                                        </div><!-- #c374 -->
                                        <div  class="clearfix em-inline c349">
                                                <article>
                                                        <h2><em><?php theme_quests_text('quests_service_flow_kicker', 'Flow'); ?></em><?php theme_quests_text('quests_service_flow_heading', '文字までの流れ'); ?>
                                                        </h2>
                                                        <div></div>
                                                </article>
                                        </div><!-- #c349 -->
                                        <div  class="fb_flow01 c376">
                                                <div class="box">
                                                        <div>
                                                                <h3><?php theme_quests_text('quests_service_flow_1', '文字文字文字30分'); ?>
                                                                </h3>
                                                        </div>
                                                </div>
                                                <div class="box">
                                                        <div>
                                                                <h3><?php theme_quests_text('quests_service_flow_2', 'テキストのご購入'); ?>
                                                                </h3>
                                                        </div>
                                                </div>
                                                <div class="box">
                                                        <div>
                                                                <h3><?php theme_quests_text('quests_service_flow_3', '次回ご文字の日程を選択'); ?>
                                                                </h3>
                                                        </div>
                                                </div>
                                                <div class="box">
                                                        <div>
                                                                <h3><?php theme_quests_text('quests_service_flow_4_heading', 'テキストの選択'); ?>
                                                                </h3>
                                                                <?php theme_quests_lines('quests_service_flow_4_body', "テキスト何枚（何時間）、もしくは１TXT（９文字）かを選択\n※１日８文字までもしくは１Txtが選択できます"); ?><br>
                                                        </div>
                                                </div>
                                                <div class="box">
                                                        <div>
                                                                <h3><?php theme_quests_text('quests_service_flow_5', 'ご文字を希望のテキストを選択する'); ?>
                                                                </h3>
                                                        </div>
                                                </div>
                                                <div class="box">
                                                        <div>
                                                                <h3><?php theme_quests_text('quests_service_flow_6_heading', 'ご文字完了'); ?>
                                                                </h3>
                                                                <?php theme_quests_lines('quests_service_flow_6_body', '※文字・テキストは４８時間前まで'); ?><br>
                                                        </div>
                                                </div>
                                        </div><!-- #c376 -->
                                        <div  class="clearfix it_bnr c357 c357">
                                                <a class="itext imgC"
                                                   href="<?php echo esc_url(theme_quests_url('quests_contact_url', home_url('/service/'))); ?>"
                                                   title="<?php echo esc_attr(theme_quests_meta('quests_service_cta_label', 'Contact')); ?>">
                                                        <?php theme_quests_image('quests_service_cta_image', 'images/home/mv01.jpg', 'サービス CTA イメージ', 'imgC'); ?>
                                                </a>
                                                <div><span
                                                              style='font-size:2em;'><?php theme_quests_lines('quests_service_cta_heading', "Let's sample layout\ntogether!"); ?></span><br />
                                                        <p class="tar" style='font-size:;'><i
                                                                   class="las la-arrow-right"></i><?php theme_quests_text('quests_service_cta_label', 'Contact'); ?>
                                                        </p>
                                                </div>
                                        </div><!-- #c357 -->
                                </section>

                                <!-- #col_main -->
                        </div>
                        <aside id="col_side1">

                                <!-- #col_side1 -->
                        </aside>
                        <!-- #main -->
                </div>
                <div id="side">
                        <aside id="col_side2">

                                <!-- #col_side2 -->
                        </aside>
                        <!-- #side -->
                </div>
                <!-- #contents -->
        </div>
        <!-- #contents_wrap -->
</div>