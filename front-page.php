<?php
/**
 * Portfolio front page.
 *
 * @package Theme
 */

declare(strict_types=1);

get_header();

$experience_groups = array(
	array(
		array(
			'title' => '職種・スキル概要',
			'rows'  => array(
				array( 'Web デザイナー', '3.5 Year' ),
				array( 'Web コーダー', '3.5 Year' ),
				array( 'フロントエンドエンジニア', '実務未経験' ),
				array( 'AI駆動開発', '1 Year' ),
			),
		),
		array(
			'title' => 'エージェント / web',
			'rows'  => array(
				array( 'Cursor', '1 Year' ),
				array( 'Claude Code (GLM, OpenRouter)', '4 Month' ),
				array( 'Codex / web', '1 Month / 1 Year' ),
				array( 'Gemini / NanoBanana', '1 Year / 6 Month' ),
			),
		),
		array(
			'title' => '言語 + ライブラリ',
			'rows'  => array(
				array( 'WEB SCSS+JavaScript+HTML', '4 Years' ),
				array( 'TypeScript', 'AI 1 Year' ),
				array( 'Python', 'AI 6 Month' ),
				array( 'React/Next.Js/Vite', 'AI 1 Year' ),
				array( 'vue/astro/svelte', 'AI 4 Month' ),
				array( 'WordPress', 'Localで学習中' ),
			),
		),
	),
	array(
		array(
			'title' => 'デザインツール',
			'rows'  => array(
				array( 'PhotoShop', '4 Year' ),
				array( 'Illustrator', '4 Year' ),
				array( 'Figma', 'HtmlToFigmaなど補助利用' ),
				array( 'Pencil.dev', '数回' ),
				array( 'Stitch', '数回' ),
				array( 'GPT Image-2.0', 'LPデザイン・アセット作成の実運用を研究' ),
				array( 'Claude Design', '情報収集' ),
			),
		),
		array(
			'title' => '環境',
			'rows'  => array(
				array( 'MacOS', '4 年' ),
				array( 'Windows', '社内利用 3.5 年' ),
				array( '情報収集', '主にX,Zenn,+webAI ディスカバー' ),
				array( '制作環境', '自作のtask系,memory系,実装系スキルを使用' ),
			),
		),
		array(
			'title' => 'インフラ / データベース',
			'rows'  => array(
				array( 'Vercel', 'AI 1 Year' ),
				array( 'Supabase', 'AI 1 Year' ),
				array( 'Github', 'AI 1 Year' ),
				array( 'Xserver+MySQL', '実務 4 Year' ),
			),
		),
	),
	array(
		array(
			'title' => 'その他利用履歴',
			'rows'  => array(
				array( 'Tailwind CSS', '6 Month, AI 1 Year' ),
				array( 'canvas API', 'AI 1 Year' ),
				array( 'Three.js', 'AI 1 Year' ),
				array( 'D3.js', 'AI 6 Month' ),
				array( 'GSAP', '3.5 Year' ),
				array( 'VScode/Chrome Extentions', '1〜2回作成' ),
				array( 'NanoBanana', 'スキルで頻繁に利用' ),
				array( 'Quiver.ai/arrow-1', 'BYOS demoのsvg生成で使用' ),
				array( 'Recraft', '高度な画像生成、SVG作成' ),
				array( 'LottieAnimation', 'webツール試用' ),
				array( 'memsearch', 'claude/codexで常用' ),
				array( 'superpowers/oh-my-claudecode', '試用' ),
				array( 'tweakpane', '/Generatorで使用' ),
				array( 'Z.ai Coding Plan', 'Claude Codeで使用' ),
				array( 'Open Router', 'モデル比較' ),
				array( 'Fal AI', '動画生成で使用' ),
				array( 'OpenClaw', '試用' ),
				array( 'tailscale', 'スマホターミナル操作試用' ),
			),
		),
	),
);

$repulsion_items = array(
	'Context Engineering',
	'Design.md',
	'WordPress',
	'React',
	'TypeScript',
	'Three.js',
	'Pencil.dev',
	'Codex',
	'Claude Code',
	'Cursor',
	'Supabase',
	'GSAP',
);
?>

<div class="portfolio_page" data-portfolio-page>
	<header class="portfolio_header" aria-label="<?php esc_attr_e( 'サイトナビゲーション', THEME_GETTEXT_DOMAIN ); ?>">
		<button class="portfolio_menu_button" type="button" aria-expanded="false" aria-controls="portfolio_nav">
			<span class="portfolio_logo_orbit" aria-hidden="true"></span>
			<span class="portfolio_menu_hint">
				<span>Tap or Click</span>
				<span>Open Menu</span>
			</span>
		</button>
		<nav id="portfolio_nav" class="portfolio_nav" aria-hidden="true">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a>
			<a href="#bunmyaku">文脈</a>
			<a href="https://github.com/yuremono/portfolio" target="_blank" rel="noopener noreferrer">Portfolio ↗</a>
			<a href="https://github.com/yuremono/BurnYourOwnStyle/tree/react" target="_blank" rel="noopener noreferrer">BurnYourOwnStyle ↗</a>
			<a href="https://github.com/yuremono/wp-local-demo" target="_blank" rel="noopener noreferrer">wp-local-demo ↗</a>
		</nav>
	</header>

	<a class="portfolio_pagetop" href="#primary" aria-label="<?php esc_attr_e( 'ページ上部へ戻る', THEME_GETTEXT_DOMAIN ); ?>">↑</a>
	<button class="portfolio_theme_toggle" type="button" aria-label="<?php esc_attr_e( 'ダークモードを切り替える', THEME_GETTEXT_DOMAIN ); ?>" data-theme-toggle>☾</button>

	<section class="portfolio_hero mind_map" aria-labelledby="portfolio_hero_title">
		<p class="mind_pin portfolio_hero_logo">yuremono<br>works</p>
		<h1 id="portfolio_hero_title" class="mind_pin portfolio_hero_title">
			2025/05からAI駆動開発を開始<br>
			ヴィジュアル表現をAIでブーストし<br>
			コンテキストエンジニアリングに注力しています
		</h1>
		<p class="mind_word mind_word_context">Context</p>
		<p class="mind_word mind_word_development">Development</p>
		<p class="mind_word mind_word_web">Web</p>
	</section>

	<section class="portfolio_scroll_x" data-scroll-x aria-label="<?php esc_attr_e( 'Experience and project summary', THEME_GETTEXT_DOMAIN ); ?>">
		<div class="portfolio_scroll_track">
			<div class="portfolio_panel portfolio_experience mind_map">
				<h2 class="portfolio_experience_title">Experience and<br>Dependencies</h2>
				<div class="portfolio_experience_copy">
					<h3>経験と依存性</h3>
					<button class="portfolio_textlink" type="button" data-dialog-open="experience_dialog" aria-haspopup="dialog">
						Details +
					</button>
					<h3>About This Site</h3>
					<p>
						個人制作ページ、ツールをまとめています。<br>
						これまではNextJS CMS、AIチャット共有拡張機能、<br>
						AI前提のweb開発を行なってきました。
					</p>
				</div>
				<p class="experience_word experience_word_1">Cursor</p>
				<p class="experience_word experience_word_2">Claude Code</p>
				<p class="experience_word experience_word_3">TailwindCSS</p>
				<p class="experience_word experience_word_4">WebGL</p>
				<p class="experience_word experience_word_5">Codex</p>
				<p class="experience_word experience_word_6">Pencil.dev</p>
				<p class="portfolio_skill_strip">Typescript PhotoShop Figma Three.js Supabase GSAP</p>
			</div>

			<section class="portfolio_panel portfolio_vibe" aria-labelledby="portfolio_vibe_title">
				<div class="portfolio_vibe_heading">
					<h2 id="portfolio_vibe_title">
						<span>Vibe<br>&nbsp;&nbsp;Design</span>
						<span>or</span>
						<span>Vault&nbsp;<br>Driven</span>
					</h2>
				</div>
				<div class="portfolio_vibe_copy">
					<h3>AI Ready</h3>
					<p><strong>DESIGN.md</strong>、<strong>画像生成デザイン</strong>を基点としたゼロからのページ作成の検証と、<strong>自然言語でUIパーツを再利用</strong>する為の環境構築を行っています。</p>
					<h3>Burn Your Own Style</h3>
					<details class="portfolio_details">
						<summary>Thinking...</summary>
						<p>モデルの学習データに基づくwebデザイン・コーディングは平均的で振れ幅が大きい。完成品の再利用を効率化する方が良い、という仮説で検証しています。</p>
					</details>
					<p class="portfolio_actions">
						<a class="portfolio_button" href="https://github.com/yuremono/BurnYourOwnStyle/tree/react" target="_blank" rel="noopener noreferrer">Repository ↗</a>
						<a class="portfolio_button" href="<?php echo esc_url( home_url( '/preview' ) ); ?>">Preview</a>
					</p>
				</div>
				<p class="portfolio_skill_strip">Typescript PhotoShop Figma Three.js Supabase GSAP</p>
			</section>
		</div>
		<div class="portfolio_scroll_spacer" aria-hidden="true"></div>
	</section>

	<section id="bunmyaku" class="portfolio_bunmyaku" aria-labelledby="portfolio_bunmyaku_title">
		<div class="portfolio_bunmyaku_glyph" aria-hidden="true">文</div>
		<div class="portfolio_bunmyaku_copy">
			<p class="portfolio_kicker">Bunmyaku</p>
			<h2 id="portfolio_bunmyaku_title">文脈を残し、次の制作判断に接続する。</h2>
			<p>制作物、プロンプト、設計判断、失敗した検証を捨てずに扱うためのポートフォリオです。見た目だけではなく、作る過程の依存関係を公開できる形に整えています。</p>
		</div>
	</section>

	<section class="portfolio_repulsion" aria-labelledby="portfolio_repulsion_title">
		<h2 id="portfolio_repulsion_title">Working Stack</h2>
		<ul class="portfolio_repulsion_list">
			<?php foreach ( $repulsion_items as $item ) : ?>
				<li><?php echo esc_html( $item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</section>

	<footer class="portfolio_footer">
		<p>yuremono works</p>
		<a href="https://github.com/yuremono/portfolio" target="_blank" rel="noopener noreferrer">Repository ↗</a>
	</footer>

	<div id="experience_dialog" class="portfolio_dialog" role="dialog" aria-modal="true" aria-labelledby="experience_dialog_title" hidden>
		<div class="portfolio_dialog_backdrop" data-dialog-close></div>
		<div class="portfolio_dialog_panel" tabindex="-1">
			<header class="portfolio_dialog_header">
				<div>
					<p>Details</p>
					<h2 id="experience_dialog_title">Experience and Dependencies</h2>
					<p>経験とAI依存の詳細。</p>
				</div>
				<button type="button" class="portfolio_dialog_close" data-dialog-close aria-label="<?php esc_attr_e( '閉じる', THEME_GETTEXT_DOMAIN ); ?>">×</button>
			</header>
			<div class="portfolio_experience_grid">
				<?php foreach ( $experience_groups as $group ) : ?>
					<div class="portfolio_experience_column">
						<?php foreach ( $group as $card ) : ?>
							<article class="portfolio_experience_card">
								<h3>
									<?php echo esc_html( $card['title'] ); ?>
									<span><?php echo esc_html( (string) count( $card['rows'] ) ); ?> lists</span>
								</h3>
								<dl>
									<?php foreach ( $card['rows'] as $row ) : ?>
										<dt><?php echo esc_html( $row[0] ); ?></dt>
										<dd><?php echo esc_html( $row[1] ); ?></dd>
									<?php endforeach; ?>
								</dl>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
