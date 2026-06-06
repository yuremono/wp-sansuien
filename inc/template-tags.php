<?php
/**
 * Reusable template helpers.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a URI below the theme assets directory.
 *
 * @param string $relative Relative asset path.
 * @return string
 */
function theme_source_uri( string $relative = '' ): string {
	return trailingslashit( get_theme_file_uri( 'assets' ) ) . ltrim( $relative, '/' );
}

/**
 * Return body classes for the custom page templates.
 *
 * @return array<int, string>
 */
function theme_body_classes(): array {
	$classes = array( 'IzakayaPage' );
	$pages   = array( 'genshu', 'shochu', 'other', 'otsumami', 'insta', 'info' );

	foreach ( $pages as $page ) {
		if ( is_page_template( "page-templates/{$page}.php" ) ) {
			$classes[] = 'IzakayaPage' . ucfirst( $page );
			return apply_filters( 'theme_body_classes', $classes );
		}
	}

	$classes[] = 'IzakayaPageTop';
	return apply_filters( 'theme_body_classes', $classes );
}

/**
 * Determine whether the current request uses a custom template.
 *
 * @return bool
 */
function theme_is_custom_view(): bool {
	return is_front_page() || is_page_template(
		array(
			'page-templates/top.php',
			'page-templates/genshu.php',
			'page-templates/shochu.php',
			'page-templates/other.php',
			'page-templates/otsumami.php',
			'page-templates/insta.php',
			'page-templates/info.php',
		)
	);
}

/**
 * Return an editable page value with an ACF-independent fallback.
 *
 * @param string $field_name Field name.
 * @param mixed  $fallback   Fallback value.
 * @return mixed
 */
function theme_meta( string $field_name, $fallback = '' ) {
	$post_id = (int) get_queried_object_id();
	if ( ! $post_id ) {
		$post_id = (int) get_the_ID();
	}
	if ( ! $post_id ) {
		return $fallback;
	}

	$value = function_exists( 'get_field' )
		? get_field( $field_name, $post_id )
		: get_post_meta( $post_id, $field_name, true );

	return theme_acf_value_absent( $value ) ? $fallback : $value;
}

/**
 * Return a URL field value.
 *
 * @param string $field_name Field name.
 * @param string $fallback Fallback URL.
 * @return string
 */
function theme_url( string $field_name, string $fallback = '' ): string {
	$url = (string) theme_meta( $field_name, $fallback );

	return '' !== $url ? $url : $fallback;
}

/**
 * Return a shared shop setting with an ACF-independent fallback.
 *
 * @param string $field_name Field name.
 * @param mixed  $fallback Fallback value.
 * @return mixed
 */
function theme_option( string $field_name, $fallback = '' ) {
	$value = function_exists( 'get_field' ) ? get_field( $field_name, 'option' ) : get_option( $field_name, '' );

	return theme_acf_value_absent( $value ) ? $fallback : $value;
}

/**
 * Return a shared shop URL.
 *
 * @param string $field_name Field name.
 * @param string $fallback Fallback URL.
 * @return string
 */
function theme_option_url( string $field_name, string $fallback = '' ): string {
	$value = (string) theme_option( $field_name, $fallback );

	return '' !== $value ? $value : $fallback;
}

/**
 * Normalize a phone number for a tel URI.
 *
 * @param string $phone Display phone number.
 * @return string
 */
function theme_phone_uri( string $phone ): string {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * Return ordered content posts.
 *
 * @param string $post_type Registered post type.
 * @param array  $args Query overrides.
 * @return array<int, WP_Post>
 */
function theme_get_content_posts( string $post_type, array $args = array() ): array {
	if ( ! in_array( $post_type, array( 'drink', 'food', 'news' ), true ) ) {
		return array();
	}

	$posts = get_posts(
		array_merge(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
			),
			$args
		)
	);

	return is_array( $posts ) ? $posts : array();
}

/**
 * Return post meta through ACF when available.
 *
 * @param int    $post_id Post ID.
 * @param string $field_name Field name.
 * @param mixed  $fallback Fallback value.
 * @return mixed
 */
function theme_content_meta( int $post_id, string $field_name, $fallback = '' ) {
	$value = function_exists( 'get_field' )
		? get_field( $field_name, $post_id )
		: get_post_meta( $post_id, $field_name, true );

	return theme_acf_value_absent( $value ) ? $fallback : $value;
}

/**
 * Return content posts assigned to a section taxonomy term.
 *
 * @param string $post_type Registered post type.
 * @param string $taxonomy Registered taxonomy.
 * @param string $term_slug Term slug.
 * @param array  $args Query overrides.
 * @return array<int, WP_Post>
 */
function theme_get_section_posts( string $post_type, string $taxonomy, string $term_slug, array $args = array() ): array {
	return theme_get_content_posts(
		$post_type,
		array_merge(
			array(
				// Taxonomy assignment is the canonical section selector for these small menu datasets.
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $term_slug,
					),
				),
			),
			$args
		)
	);
}

/**
 * Return a content post image.
 *
 * @param int    $post_id Post ID.
 * @param string $fallback_relative Relative fallback asset path.
 * @param string $size Image size.
 * @return array{url:string,alt:string}
 */
function theme_content_image_data( int $post_id, string $fallback_relative = '', string $size = 'large' ): array {
	$url = (string) get_the_post_thumbnail_url( $post_id, $size );
	$alt = (string) get_post_meta( get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true );

	if ( '' === $url && '' !== $fallback_relative ) {
		$url = theme_source_uri( $fallback_relative );
	}

	return array(
		'url' => $url,
		'alt' => '' !== $alt ? $alt : (string) get_the_title( $post_id ),
	);
}

/**
 * Print CPT items using the existing price/name list structure.
 *
 * @param array<int, WP_Post> $posts Content posts.
 * @param string              $price_field Price field name.
 */
function theme_render_menu_posts( array $posts, string $price_field ): void {
	foreach ( $posts as $post ) {
		?>
		<dl>
			<dt><?php echo esc_html( (string) theme_content_meta( $post->ID, $price_field ) ); ?></dt>
			<dd><?php echo esc_html( get_the_title( $post ) ); ?><br></dd>
		</dl>
		<?php
	}
}

/**
 * Print CPT items using the existing feature-card structure.
 *
 * @param array<int, WP_Post> $posts Content posts.
 * @param string              $price_field Price field name.
 */
function theme_render_feature_posts( array $posts, string $price_field ): void {
	foreach ( $posts as $post ) {
		$image = theme_content_image_data( $post->ID );
		?>
		<div class="box">
			<article>
				<?php if ( '' !== $image['url'] ) : ?>
					<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
				<?php endif; ?>
				<h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
				<div>
					<?php echo wp_kses_post( apply_filters( 'the_content', $post->post_content ) ); ?>
					<p><?php echo esc_html( (string) theme_content_meta( $post->ID, $price_field ) ); ?></p>
				</div>
			</article>
		</div>
		<?php
	}
}

/**
 * Print news posts using the existing SNS item structure.
 *
 * @param array<int, WP_Post> $posts News posts.
 */
function theme_render_news_posts( array $posts ): void {
	foreach ( $posts as $post ) {
		$image = theme_content_image_data( $post->ID );
		$url   = (string) theme_content_meta( $post->ID, 'news_external_url', get_permalink( $post ) );
		?>
		<div>
			<div class="sns_photo">
				<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
					<?php if ( '' !== $image['url'] ) : ?>
						<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
					<?php endif; ?>
				</a>
			</div>
			<div class="sns_text">
				<div class="sns_date"><?php echo esc_html( get_the_date( 'Y.m.d', $post ) ); ?></div>
				<div class="caption"><?php echo wp_kses_post( apply_filters( 'the_content', $post->post_content ) ); ?></div>
			</div>
		</div>
		<?php
	}
}

/**
 * Print a dynamic shochu category while preserving the established section classes.
 *
 * @param string $term_slug Category term slug.
 * @param string $section_class Main section class.
 * @param string $menu_class Menu section class.
 * @param string $fallback_heading Fallback heading.
 * @param string $fallback_body Fallback body HTML.
 * @param string $fallback_image_1 First fallback image.
 * @param string $fallback_image_2 Second fallback image.
 * @return bool Whether dynamic posts were rendered.
 */
function theme_render_shochu_section( string $term_slug, string $section_class, string $menu_class, string $fallback_heading, string $fallback_body, string $fallback_image_1, string $fallback_image_2 ): bool {
	$posts = theme_get_section_posts( 'drink', 'drink_category', $term_slug );
	if ( ! $posts ) {
		return false;
	}
	?>
	<div class="fl50wide <?php echo esc_attr( $section_class ); ?>">
		<div class="clearfix">
			<article>
				<h2><?php theme_text( "shochu_{$term_slug}_heading", $fallback_heading ); ?></h2>
				<div><?php theme_rich( "shochu_{$term_slug}_body", $fallback_body ); ?></div>
			</article>
		</div>
		<div class="twopicR wrapGrid">
			<div class="box"><?php theme_image( "shochu_{$term_slug}_image_1", $fallback_image_1 ); ?><div></div></div>
			<div class="box"><?php theme_image( "shochu_{$term_slug}_image_2", $fallback_image_2 ); ?><div></div></div>
		</div>
	</div>
	<div class="fl50 mt20 gap3mi <?php echo esc_attr( $menu_class ); ?>">
		<div class="form_wrap dl_menu">
			<?php theme_render_menu_posts( $posts, 'drink_price' ); ?>
		</div>
	</div>
	<?php
	return true;
}

/**
 * Print the default site navigation.
 *
 * @param array<string, mixed> $args WordPress fallback callback arguments.
 */
function theme_menu_fallback( array $args = array() ): void {
	$items = array(
		'ホーム'    => '/',
		'焼酎の原酒'  => '/genshu/',
		'本格焼酎'   => '/shochu/',
		'その他のお酒' => '/other/',
		'おつまみ'   => '/otsumami/',
		'お知らせ'   => '/insta/',
		'店舗案内'   => '/info/',
	);
	$class = isset( $args['menu_class'] ) ? (string) $args['menu_class'] : 'menu';
	?>
	<ul class="<?php echo esc_attr( $class ); ?>">
		<?php foreach ( $items as $label => $path ) : ?>
			<li><a href="<?php echo esc_url( home_url( $path ) ); ?>"><?php echo esc_html( $label ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * Normalize an editable image field.
 *
 * @param string $field_name Field name.
 * @param string $fallback_relative Relative fallback asset path.
 * @param string $fallback_alt Fallback alternative text.
 * @param string $size WordPress image size.
 * @return array{url:string,alt:string}
 */
function theme_image_data( string $field_name, string $fallback_relative = '', string $fallback_alt = '', string $size = 'full' ): array {
	$image = theme_meta( $field_name );
	$url   = '';
	$alt   = '';

	if ( is_array( $image ) ) {
		$attachment_id = ! empty( $image['ID'] ) ? (int) $image['ID'] : 0;
		$url           = $attachment_id ? (string) wp_get_attachment_image_url( $attachment_id, $size ) : (string) ( $image['url'] ?? '' );
		$alt           = (string) ( $image['alt'] ?? '' );
	} elseif ( is_numeric( $image ) ) {
		$attachment_id = (int) $image;
		$url           = (string) wp_get_attachment_image_url( $attachment_id, $size );
		$alt           = (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
	} elseif ( is_string( $image ) ) {
		$url = $image;
	}

	if ( '' === $url && '' !== $fallback_relative ) {
		$url = theme_source_uri( $fallback_relative );
	}

	return array(
		'url' => $url,
		'alt' => '' !== $alt ? $alt : $fallback_alt,
	);
}

/**
 * Print an editable image.
 *
 * @param string $field_name Field name.
 * @param string $fallback_relative Relative fallback asset path.
 * @param string $fallback_alt Fallback alternative text.
 * @param string $css_class Optional CSS class.
 */
function theme_image( string $field_name, string $fallback_relative = '', string $fallback_alt = '', string $css_class = '' ): void {
	$image = theme_image_data( $field_name, $fallback_relative, $fallback_alt );
	if ( '' === $image['url'] ) {
		return;
	}
	?>
	<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"<?php echo '' !== $css_class ? ' class="' . esc_attr( $css_class ) . '"' : ''; ?>>
	<?php
}

/**
 * Print escaped text.
 *
 * @param string $field_name Field name.
 * @param string $fallback Fallback text.
 */
function theme_text( string $field_name, string $fallback = '' ): void {
	echo esc_html( (string) theme_meta( $field_name, $fallback ) );
}

/**
 * Print escaped multiline text.
 *
 * @param string $field_name Field name.
 * @param string $fallback Fallback text.
 */
function theme_lines( string $field_name, string $fallback = '' ): void {
	echo nl2br( esc_html( (string) theme_meta( $field_name, $fallback ) ) );
}

/**
 * Return HTML allowed in editable rich text.
 *
 * @return array<string, mixed>
 */
function theme_allowed_html(): array {
	return wp_kses_allowed_html( 'post' );
}

/**
 * Print sanitized rich text.
 *
 * @param string $field_name Field name.
 * @param string $fallback Fallback HTML.
 */
function theme_rich( string $field_name, string $fallback = '' ): void {
	echo wp_kses( (string) theme_meta( $field_name, $fallback ), theme_allowed_html() );
}
