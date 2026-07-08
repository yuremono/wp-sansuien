<?php
/**
 * 画面右下固定の予約導線タブ。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$reserve_url = is_front_page() ? '#reserve' : home_url( '/#reserve' );
?>
<a class="reserve_tab" href="<?php echo esc_url( $reserve_url ); ?>">
	<svg class="sym rsym"><use href="#sym-tri"></use></svg>
	<span class="en">Reserve</span><span class="jp">予約する</span>
</a>
