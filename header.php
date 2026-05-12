<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$strip_default = '設計提案│箕面・大阪北部│用途別ワークショップ同行';
$tagline       = theme_front_meta('tagline', $strip_default);
?>
<div class="tagline">
	<?php echo esc_html((string) $tagline); ?>
</div>

<header class="masthead">
	<div class="wrap brand">
		<p class="brand_title">
			<a class="brand_link" href="<?php echo esc_url(home_url('/')); ?>">
				<?php echo esc_html(theme_brand()); ?>
			</a>
		</p>
		<nav class="primary_nav" aria-label="<?php esc_attr_e('メインメニュー', THEME_GETTEXT_DOMAIN); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'primary_nav_list',
					'fallback_cb'    => 'theme_fallback_menu',
				)
			);
			?>
		</nav>
	</div>
</header>

<main id="primary" class="site-main">
