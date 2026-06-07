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

$shop_name = (string) theme_option('shop_name', THEME_BRAND_DEFAULT);
$shop_phone = (string) theme_option('shop_phone', '000-0000-0000');
$shop_postcode = (string) theme_option('shop_postcode', '〒000-0000');
$shop_address = (string) theme_option('shop_address', '東京都何何区何々市何々町０−０−０');
$shop_hours = (string) theme_option('shop_hours', "火～土曜日17:00～2:00\n日曜日15:00～0:00");
$shop_closed = (string) theme_option('shop_closed', '月曜日');
$map_url = theme_option_url('shop_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1662873.2451231668!2d139.7698121!3d35.50924045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2z5p2x5Lqs6YO9!5e0!3m2!1sja!2sjp!4v1780738443365!5m2!1sja!2sjp');
?>

<footer id="global_footer">
        <div id="footer" class="f">
                <div class="f_main"
                     style="background-image: url(<?php echo esc_url(theme_source_uri('images/home/mv02__pc.jpg')); ?>);background-color: var(--mc);">
                        <div class="f_info">
                                <h2 class="f_name"><?php echo esc_html($shop_name); ?></h2>
                                <div class="form_01">
                                        <dl>
                                                <dt>所在地</dt>
                                                <dd><?php echo esc_html($shop_postcode); ?><br><?php echo esc_html($shop_address); ?>
                                                </dd>
                                        </dl>
                                        <dl>
                                                <dt>TEL</dt>
                                                <dd><a href="<?php echo esc_url(theme_phone_uri($shop_phone)); ?>"><?php echo esc_html($shop_phone); ?></a>
                                                </dd>
                                        </dl>
                                        <dl>
                                                <dt>営業時間</dt>
                                                <dd><?php echo nl2br(esc_html($shop_hours)); ?></dd>
                                        </dl>
                                        <dl>
                                                <dt>定休日</dt>
                                                <dd><?php echo esc_html($shop_closed); ?></dd>
                                        </dl>
                                </div>
                        </div>
                        <div class="f_map"><iframe src="<?php echo esc_url($map_url); ?>" width="600" height="450"
                                        style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        title="<?php echo esc_attr($shop_name . ' 地図'); ?>"></iframe></div>
                </div>
                <nav class="f_nav">
                        <?php
                        wp_nav_menu(
                                array(
                                        'theme_location' => 'footer',
                                        'container' => false,
                                        'menu_class' => 'f_nav_list',
                                        'fallback_cb' => 'theme_menu_fallback',
                                        'depth' => 1,
                                )
                        );
                        ?>
                </nav>
                <div class="f_copy "><?php echo esc_html(gmdate('Y') . '-' . $shop_name); ?></div>
        </div>
</footer>