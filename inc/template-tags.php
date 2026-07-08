<?php
/**
 * テンプレートで再利用する補助関数群。
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * テーマの assets ディレクトリ配下の URI を返す。
 *
 * @param string $relative 相対資産パス。
 * @return string
 */
function theme_source_uri( string $relative = '' ): string {
	return trailingslashit( get_theme_file_uri( 'assets' ) ) . ltrim( $relative, '/' );
}

/**
 * body class を返す。
 *
 * @return array<int, string>
 */
function theme_body_classes(): array {
	$classes = array( 'SansuienPage' );

	if ( is_front_page() ) {
		$classes[] = 'SansuienPageTop';
	} elseif ( is_singular( 'post' ) && in_category( 'room' ) ) {
		$classes[] = 'SansuienPageRoom';
	} elseif ( is_category( 'room' ) ) {
		$classes[] = 'SansuienPageRoomArchive';
	}

	return apply_filters( 'theme_body_classes', $classes );
}

/**
 * ACF の有無に依存せず、ページの編集値を返す。
 *
 * @param string $field_name フィールド名。
 * @param mixed  $fallback   フォールバック値。
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
 * URL フィールド値を返す。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback フォールバック URL。
 * @return string
 */
function theme_url( string $field_name, string $fallback = '' ): string {
	$url = (string) theme_meta( $field_name, $fallback );

	return '' !== $url ? $url : $fallback;
}

/**
 * ACF の有無に依存せず、共通宿泊施設設定を返す。
 *
 * @param string $field_name フィールド名。
 * @param mixed  $fallback フォールバック値。
 * @return mixed
 */
function theme_option( string $field_name, $fallback = '' ) {
	$value = function_exists( 'get_field' ) ? get_field( $field_name, 'option' ) : get_option( $field_name, '' );

	return theme_acf_value_absent( $value ) ? $fallback : $value;
}

/**
 * 共通宿泊施設 URL を返す。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback フォールバック URL。
 * @return string
 */
function theme_option_url( string $field_name, string $fallback = '' ): string {
	$value = (string) theme_option( $field_name, $fallback );

	return '' !== $value ? $value : $fallback;
}

/**
 * tel URI 用に電話番号を正規化する。
 *
 * @param string $phone 表示用電話番号。
 * @return string
 */
function theme_phone_uri( string $phone ): string {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', $phone );
}

/**
 * 並び順を考慮したコンテンツ投稿（標準投稿 + カテゴリー）を返す。
 *
 * @param string $category_slug 「room」または「news」カテゴリーのスラッグ。
 * @param array  $args クエリ上書き。
 * @return array<int, WP_Post>
 */
function theme_get_content_posts( string $category_slug, array $args = array() ): array {
	if ( ! in_array( $category_slug, array( 'room', 'news' ), true ) ) {
		return array();
	}

	$posts = get_posts(
		array_merge(
			array(
				'post_type'      => 'post',
				'category_name'  => $category_slug,
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
 * カテゴリースラッグから一覧ページ URL を解決する。
 *
 * カテゴリーが未作成（テーマ有効化直後など）の場合はフォールバック URL を返す。
 *
 * @param string $slug カテゴリースラッグ。
 * @param string $fallback フォールバック URL。
 * @return string
 */
function theme_category_url( string $slug, string $fallback = '' ): string {
	$term = get_category_by_slug( $slug );
	if ( ! ( $term instanceof WP_Term ) ) {
		return $fallback;
	}

	$url = (string) get_category_link( $term );

	return '' !== $url ? $url : $fallback;
}

/**
 * ACF が使える場合は ACF 経由で投稿メタを返す。
 *
 * @param int    $post_id 投稿 ID。
 * @param string $field_name フィールド名。
 * @param mixed  $fallback フォールバック値。
 * @return mixed
 */
function theme_content_meta( int $post_id, string $field_name, $fallback = '' ) {
	$value = function_exists( 'get_field' )
		? get_field( $field_name, $post_id )
		: get_post_meta( $post_id, $field_name, true );

	return theme_acf_value_absent( $value ) ? $fallback : $value;
}

/**
 * コンテンツ投稿の画像情報を返す。
 *
 * @param int    $post_id 投稿 ID。
 * @param string $fallback_relative 相対フォールバック資産パス。
 * @param string $size 画像サイズ。
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
 * カンマ区切りのタグ文字列を配列へ整形する。
 *
 * @param string $value カンマ区切りの文字列。
 * @return array<int, string>
 */
function theme_split_tags( string $value ): array {
	if ( '' === trim( $value ) ) {
		return array();
	}

	return array_values(
		array_filter(
			array_map( 'trim', explode( ',', $value ) ),
			static fn( string $tag ): bool => '' !== $tag
		)
	);
}

/**
 * デフォルトのサイトナビゲーションを描画する。
 *
 * @param array<string, mixed> $args WordPress のフォールバックコールバック引数。
 */
function theme_menu_fallback( array $args = array() ): void {
	$room_archive = theme_category_url( 'room', home_url( '/room/' ) );
	$items        = array(
		'客室のご案内' => $room_archive,
		'館内施設'   => home_url( '/#feature' ),
		'アクセス'   => home_url( '/#access' ),
		'お知らせ'   => home_url( '/#news' ),
	);
	$class = isset( $args['menu_class'] ) ? (string) $args['menu_class'] : 'menu';
	?>
	<ul class="<?php echo esc_attr( $class ); ?>">
		<?php foreach ( $items as $label => $path ) : ?>
			<li><a href="<?php echo esc_url( $path ); ?>"><?php echo esc_html( $label ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * 編集可能な画像フィールドを正規化する。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback_relative 相対フォールバック資産パス。
 * @param string $fallback_alt フォールバック代替テキスト。
 * @param string $size WordPress 画像サイズ。
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
 * 編集可能な画像を出力する。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback_relative 相対フォールバック資産パス。
 * @param string $fallback_alt フォールバック代替テキスト。
 * @param string $css_class 任意の CSS class。
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
 * エスケープ済みテキストを出力する。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback フォールバック文字列。
 */
function theme_text( string $field_name, string $fallback = '' ): void {
	echo esc_html( (string) theme_meta( $field_name, $fallback ) );
}

/**
 * エスケープ済みの複数行テキストを出力する。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback フォールバック文字列。
 */
function theme_lines( string $field_name, string $fallback = '' ): void {
	echo nl2br( esc_html( (string) theme_meta( $field_name, $fallback ) ) );
}

/**
 * 編集可能なリッチテキストで許可する HTML を返す。
 *
 * @return array<string, mixed>
 */
function theme_allowed_html(): array {
	return wp_kses_allowed_html( 'post' );
}

/**
 * サニタイズしたリッチテキストを出力する。
 *
 * @param string $field_name フィールド名。
 * @param string $fallback フォールバック HTML。
 */
function theme_rich( string $field_name, string $fallback = '' ): void {
	echo wp_kses( (string) theme_meta( $field_name, $fallback ), theme_allowed_html() );
}
