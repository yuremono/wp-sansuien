<?php
/**
 * Quests page footer.
 *
 * @package Theme
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$line_url      = theme_quests_url( 'quests_line_url', '#' );
$instagram_url = theme_quests_url( 'quests_instagram_url', '#' );
$site_name     = get_bloginfo( 'name' );
$copyright     = sprintf(
	/* translators: 1: year, 2: site name. */
	__( '© %1$s %2$s All Rights Reserved', THEME_GETTEXT_DOMAIN ),
	gmdate( 'Y' ),
	$site_name
);
?>
<footer id="global_footer">
<div id="footer" class="f" style="background: unset;">
		<!--<div class="f_map"></div>-->
		<div class="f_main incont  txwh" style="background: unset;background-color:var(--un);">
			<div class="f_info">
				<a class="f_logo f_logotext sawa " href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html( $site_name ); ?>
				</a>
				<ul class="f_social">
					<li><a href="<?php echo esc_url( $line_url ); ?>">LINE</a></li>
					<li><a href="<?php echo esc_url( $instagram_url ); ?>">Instagram</a></li>
				</ul>
			</div>
			<div class="f_nav fw700 lato" style="background: unset;">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => has_nav_menu( 'footer' ) ? 'footer' : 'primary',
						'container'      => false,
						'fallback_cb'    => 'theme_quests_primary_menu_fallback',
						'items_wrap'     => '<ul>%3$s</ul>',
					)
				);
				?>
				<div class="f_copy f14 __right" style="background:var(--un)"><?php echo esc_html( $copyright ); ?></div>
			</div>
		</div>
	</div>
	<!-- #global_footer --></footer>
