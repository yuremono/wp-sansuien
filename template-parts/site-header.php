<?php
/**
 * Site header.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_phone  = (string) theme_option( 'shop_phone', '000-0000-0000' );
$contact_url = theme_option_url( 'shop_contact_url', '#' );
?>
<header id="global_header">
						<div id="header" class="h ">
								<div class="h_inner ">
										<div class="h_logo ">
												<a class="h_logolink" href="<?php echo esc_url( home_url( '/' ) ); ?>">
														<img class="h_logoimg" src="<?php echo esc_url( theme_source_uri( 'images/home/logo.png' ) ); ?>"
															srcset="<?php echo esc_url( theme_source_uri( 'images/home/logo.png' ) ); ?> 1x, <?php echo esc_url( theme_source_uri( 'images/home/logo2x.png' ) ); ?> 2x"
															alt="ロゴ">
												</a>
										</div>
										<button class="h_menu menu_toggle" aria-expanded="false" aria-controls="nav">
												<!--<span class="bar1"></span>-->
												<span class="bar2"></span>
												<!--<span class="bar3"></span>-->
												<span class="bar2 tate"></span>
												<span class="dot1"></span>
												<span class="dot2"></span>
												<span class="dot3"></span>
										</button>
										<div class="h_items ">
												<a class="h_btn h_tel" href="<?php echo esc_url( theme_phone_uri( $shop_phone ) ); ?>"><i
															class="fa-solid fa-phone"></i><?php echo esc_html( $shop_phone ); ?></a>
												<a class="h_btn h_contact" href="<?php echo esc_url( $contact_url ); ?>"><i
															class="fa-solid fa-envelope"></i>お問い合わせ</a>
										</div>
										<nav class="h_nav " id="nav">
												<?php
												wp_nav_menu(
													array(
														'theme_location' => 'primary',
														'container'      => false,
														'menu_class'     => 'h_nav_list',
														'fallback_cb'    => 'theme_menu_fallback',
														'depth'          => 1,
													)
												);
												?>
												<div class="focus_trap menu_toggle" tabindex="0"></div>
										</nav>
								</div>
						</div>
						<!-- #global_header -->
				</header>
