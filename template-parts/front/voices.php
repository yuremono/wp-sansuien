<?php
/**
 * Front voices section（お客様の声、固定表示）.
 *
 * @package Theme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$voice_rows = theme_meta( 'front_voices', array() );

if ( is_array( $voice_rows ) && $voice_rows ) {
	$voices = array_map(
		static fn( array $row, int $index ): array => array(
			'stars'   => (int) ( $row['stars'] ?? 5 ),
			'comment' => (string) ( $row['comment'] ?? '' ),
			'who'     => (string) ( $row['who'] ?? '' ),
			'reveal'  => 0 === $index % 2 ? 'reveal-r' : 'reveal',
		),
		$voice_rows,
		array_keys( $voice_rows )
	);
} else {
	// 管理画面で未設定（導入直後）の場合のみ、テーマ内蔵のデモの声を表示する。
	$voices = array(
		array(
			'stars'   => 5,
			'comment' => '露天風呂からの眺めが忘れられません。夕食の炊き合わせも丁寧な味でした。',
			'who'     => '50代・ご夫婦での利用',
			'reveal'  => 'reveal-r',
		),
		array(
			'stars'   => 5,
			'comment' => '仲居さんの心配りが行き届いていて、両親も大変喜んでおりました。',
			'who'     => '30代・三世代旅行',
			'reveal'  => 'reveal',
		),
		array(
			'stars'   => 4,
			'comment' => '湖側の客室は静かでゆっくりできました。朝食のお粥が美味しかったです。',
			'who'     => '40代・おひとり様',
			'reveal'  => 'reveal',
		),
	);
}
?>
<section class="voices">
	<div class="wrap">
		<div class="voice_grid">
			<div class="sec_head sm reveal-l">
				<span class="en">Voices</span>
				<svg class="sym"><use href="#sym-tri"></use></svg>
				<span class="jp">お客様の声</span>
			</div>
			<?php foreach ( $voices as $voice ) : ?>
				<article class="<?php echo esc_attr( $voice['reveal'] ); ?>">
					<div class="stars" aria-label="星<?php echo (int) $voice['stars']; ?>つ"><?php echo str_repeat( '★', (int) $voice['stars'] ) . str_repeat( '☆', 5 - (int) $voice['stars'] ); ?></div>
					<p><?php echo esc_html( $voice['comment'] ); ?></p>
					<span class="who"><?php echo esc_html( $voice['who'] ); ?></span>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
