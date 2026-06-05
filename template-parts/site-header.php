<?php
/**
 * Quests page header.
 *
 * @package Theme
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_url = theme_quests_url( 'quests_contact_url', home_url( '/service/' ) );
$line_url    = theme_quests_url( 'quests_line_url', $contact_url );
$logo_id     = (int) get_theme_mod( 'custom_logo' );
?>
<header id="global_header">
<div id="header" class="h">
		<div class="h_inner">
			<a class="h_logo h_logotext sawa" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: var(--tx);background-color: var(--un);">
				<?php if ( $logo_id ) : ?>
					<?php echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'h_logoimg' ) ); ?>
				<?php else : ?>
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				<?php endif; ?>
			</a>
			<button class="h_menu menu_toggle dots" aria-expanded="false" aria-controls="nav">
				<span class="bar2"></span><span class="bar2 tate"></span><span class="dot1"></span><span class="dot2"></span><span class="dot3"></span>
			</button>
			<div class="h_items ">
				<a class="btn LINE" style="background: #05c554;border-radius: 1vmin" href="<?php echo esc_url( $line_url ); ?>"><img class="h_logoimg" src="<?php echo esc_url( theme_quests_source_uri( 'images/home/line-logo.png' ) ); ?>" alt="LINE">CONTACT</a>
			</div>
			<nav class="h_nav " id="nav">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'fallback_cb'    => 'theme_quests_primary_menu_fallback',
						'items_wrap'     => '<ul>%3$s</ul>',
					)
				);
				?>
				<div class="focus_trap menu_toggle" tabindex="0"></div>
			</nav>
		</div>
	</div>
	<!-- #global_header --></header>
