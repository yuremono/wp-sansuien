<?php
/**
 * Front otsumami-link section.
 *
 * @package Izakaya
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$otsumami_url = theme_url( 'front_otsumami_url', home_url( '/otsumami/' ) );
?>
<div class="linkouter_bottom c509">
								<!-- #c509 -->
								<div class="clearfix twopicBf c510">
										<div><a class="btn"
													href="<?php echo esc_url( $otsumami_url ); ?>"><br />
														<span><?php theme_text( 'front_otsumami_eyebrow', 'Otsumami' ); ?></span><br />
														<span><?php theme_text( 'front_otsumami_heading', 'おつまみ' ); ?></span><br />
												</a></div>
								</div><!-- #c510 -->
								<div class="twopicBtn c511">
										<div class="box">
												<a href="<?php echo esc_url( $otsumami_url ); ?>" title=""
													target="_self"><?php theme_image( 'front_otsumami_image_1', 'images/home/IMG_3974.jpg' ); ?></a>
												<div>おつまみ<br></div>
										</div>
										<div class="box">
												<a href="<?php echo esc_url( $otsumami_url ); ?>" title=""
													target="_self"><?php theme_image( 'front_otsumami_image_2', 'images/home/IMG_4007.jpg' ); ?></a>
												<div></div>
										</div>
								</div><!-- #c511 -->

						</div><!-- #c512 -->
						