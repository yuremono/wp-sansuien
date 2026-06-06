<?php
/**
 * Site footer.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
        exit;
}
?>

<footer id="global_footer">
        <div id="footer" class="f">
                <div class="f_main"
                     style="background-image: url(<?php echo esc_url(theme_source_uri('images/home/mv02__pc.jpg')); ?>);background-color: var(--mc);">
                        <div class="f_info">
                                <h2 class="f_name">居酒屋</h2>
                                <div class="form_01">
                                        <dl>
                                                <dt>所在地</dt>
                                                <dd>〒000-0000<br>東京都何何区何々市何々町０−０−０</dd>
                                        </dl>
                                        <dl>
                                                <dt>TEL</dt>
                                                <dd>000-0000-0000</dd>
                                        </dl>
                                        <dl>
                                                <dt>営業時間</dt>
                                                <dd>火～土曜日17:00～2:00<br>日曜日15:00～0:00</dd>
                                        </dl>
                                        <dl>
                                                <dt>定休日</dt>
                                                <dd>月曜日</dd>
                                        </dl>
                                </div>
                        </div>
                        <div class="f_map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1662873.2451231668!2d139.7698121!3d35.50924045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2z5p2x5Lqs6YO9!5e0!3m2!1sja!2sjp!4v1780738443365!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                </div>
                <nav class="f_nav">
                        <ul>
                                <li><a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a></li>
                                <li><a href="<?php echo esc_url(home_url('/genshu/')); ?>">焼酎の原酒</a></li>
                                <li><a href="<?php echo esc_url(home_url('/shochu/')); ?>">本格焼酎</a></li>
                                <li><a href="<?php echo esc_url(home_url('/other/')); ?>">その他のお酒</a></li>
                                <li><a href="<?php echo esc_url(home_url('/otsumami/')); ?>">おつまみ</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insta/')); ?>">お知らせ</a></li>
                                <li><a href="<?php echo esc_url(home_url('/info/')); ?>">店舗案内</a></li>
                        </ul>
                </nav>
                <div class="f_copy ">2023-居酒屋</div>
        </div>
        <!-- #global_footer -->
</footer>