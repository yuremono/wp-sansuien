<?php
/**
 * Theme document head.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( theme_body_classes() ); ?>>
<?php wp_body_open(); ?>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
	<symbol id="sym-tri" viewBox="0 0 10 10">
		<path d="M5 0 L0 10 H5 Z" fill="currentColor"/>
		<path d="M5 0 L10 10 H5 Z" style="fill:var(--sym-r, var(--bronze))"/>
	</symbol>
</svg>
