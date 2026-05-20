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
				array( 'Tailwind CSS', '6 Month,AI 1 Year' ),
				array( 'canvas API', 'AI 1 Year' ),
				array( 'Three.js', 'AI 1 Year' ),
				array( 'D3.js', 'AI 6 Month' ),
				array( 'GSAP', '3.5 Year' ),
				array( 'VScode/Chrome Extentions', '1~2回作成' ),
				array( 'NanoBanana', 'スキルで頻繁に利用' ),
				array( 'Quiver.ai/arrow-1', 'BYOS demoのsvg生成で使用' ),
				array( 'Recraft', '高度な画像生成、SVG作成' ),
				array( 'LottieAnimation', 'webツール試用' ),
				array( 'memsearch', 'claude/codexで常用' ),
				array( 'superpowers/oh-my-claudecode', '試用' ),
				array( 'tweekpane', '`/Generator`で使用' ),
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
	array( 'Other Works', '', '', 'is-initial pointer-events-none mr-4 -mt-4 bg-transparent', '' ),
	array( 'Random Generator', home_url( '/rects' ), '', 'mt-4', 'コントローラー付きのランダム図形配置ジェネレーター' ),
	array( 'Agent Driven CMS', home_url( '/donut' ), '', '', 'Codex または Claude Code を Next.js Node runtimeで中継。ローカルブラウザでエージェントに直接ソースコードを編集させるCMS' ),
	array( 'Shuffle Divide', home_url( '/shuffleDivide' ), '', '', '制作サイトの部分再現です。' ),
	array( 'Glitch', home_url( '/glitch' ), '', '', '制作サイトの部分再現です。' ),
	array( 'Grid Carousel', home_url( '/grid-carousel' ), '', '', 'グリッドカルーセルです。' ),
	array( 'Bounding Box On Design', home_url( '/bbox' ), '', '-mb-4', 'AI生成のLPデザインにバウンディングボックスを配置し、画像+構造化データをエージェントに渡すツールです。' ),
	array( 'Activity', home_url( '/activity' ), '', '', '職務要約と活動記録を書いています。' ),
	array( 'Chat Canban', '', 'https://chat-kanban.vercel.app/', 'mb-4', 'ローカル環境の特定ブラウザに拡張機能をインストールし、ChatGPTやGeminiにチャット履歴を送信するためのUIを設置。' ),
	array( 'NextJs CMS', '', 'https://cms0505.vercel.app/editor', '', 'AI駆動開発最初の制作物。単一ページ専用CMSを作成。閲覧pass: view' ),
);
?>

<div class="PageRoot [--innerPX:--PX] [--Eng:--Jost] [--San:--Zen] [--h3FZ:1.5em] [--dropBG:--WH] [--dropC:--TC] [--WTS:var(--tsw)_var(--TC30)]" data-portfolio-page>
	<header id="Header" class="Header HeaderCylinder" data-nav-open="false">
		<div class="HeaderInner ">
			<button type="button" class="HeaderLogo HeaderCylinderLogo" aria-expanded="false" aria-controls="HeaderNav" aria-label="Open menu" data-menu-toggle>
				<span class="LogoLoading" aria-hidden="true"></span>
				<span class="HeaderAnotation WTS text-[--BC] ">
					<span>Tap or Click</span>
					<span>Open Menu</span>
				</span>
			</button>
			<nav class="HeaderNav" id="HeaderNav" role="navigation" aria-label="main navigation" aria-hidden="true" inert>
				<ul class="NavUl">
					<li class="NavLi"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a></li>
					<li class="NavLi [font-family:--Ship]"><a href="<?php echo esc_url( home_url( '/bunmyaku' ) ); ?>">文脈</a></li>
					<li class="NavLi NavDrop">
						<button type="button" class="DropA DropToggle">Repositories<span class="DropIcon">⌄</span></button>
						<ul class="DropUl" aria-label="Repositories">
							<li class="DropLi"><a href="https://github.com/yuremono/portfolio" target="_blank" rel="noopener noreferrer">Portfolio ↗</a></li>
							<li class="DropLi"><a href="https://github.com/yuremono/wp-local-demo" target="_blank" rel="noopener noreferrer">wp-local-demo ↗</a></li>
							<li class="DropLi"><a href="https://github.com/yuremono/BurnYourOwnStyle/tree/react" target="_blank" rel="noopener noreferrer">BurnYourOwnStyle ↗</a></li>
						</ul>
					</li>
					<li class="NavLi"><a href="<?php echo esc_url( home_url( '/preview' ) ); ?>">BYOS</a></li>
				</ul>
				<div class="FocusTrap MenuToggle" tabindex="0"></div>
			</nav>
		</div>
	</header>

	<div class="HeaderPagetop mix-blend-difference text-WH">
		<a href="#">⌃</a>
	</div>
	<button type="button" class="ThemeToggle mix-blend-difference text-WH" aria-label="Toggle dark mode" data-theme-toggle>☾</button>

	<main class="min-h-screen">
		<section class="out mindMap text-center font-thin">
			<p class="mmPin about_p lg:w-[calc(var(--wid)/2)] text-[--GR] font-light text-center p-4 px-6 right-1/2 top-1/2 lg:translateYH static lg:absolute" style="font-size: 3em;">
				yuremono<br>works
			</p>
			<h1 class="JsLetter text-lg font-normal budoux mmPin about_tx static lg:absolute lg:translateYH leading-[2em] left-1/2 top-1/2 z-10 text-left p-4 bg-background/80">
				2025/05からAI駆動開発を開始<br>
				ヴィジュアル表現をAIでブーストし<br>
				コンテキストエンジニアリングに注力しています
			</h1>
			<p class="mm2-2" style="font-size: 4em;">Context</p>
			<p class="mm9-6" style="font-size: 4em;">Development</p>
			<p class="hidden lg:inline-block mm3-9" style="font-size: 5em;">Web</p>
		</section>

		<section class="ScrollX relative mt-0" data-scroll-x>
			<div class="ScrollTrack">
				<div class="DialogWrapper">
					<div class="mindMap text-center experience font-thin">
						<h2 class="mm1-3 text-[--GR] font-light text-left tracking-[-0.025em]" style="font-size: 3em;">
							Experience and<br>Dependencies
						</h2>
						<div class="text-base mmPin mmStatic max-w-[calc(var(--wid)/2)] experience_tx text-left San font-light leading-[2em] static lg:absolute left-1/2 top-[--MY] z-10 p-4 bg-background/80">
							<h3 class="text-GR text-[1.25em] inline-block mr-4">経験と依存性</h3>
							<button type="button" class="textlink mt-6" aria-haspopup="dialog" aria-controls="experience-dialog" data-dialog-open="experience-dialog">
								Details<span class="[--btnIFZ:1.5em] align-text-bottom">＋</span>
							</button>
							<br>
							<div class="text-left">
								<h3 class="text-GR mt-10 mb-2">About This Site</h3>
								<span class="budoux">
									個人制作ページ、ツールをまとめています。<br>
									これまではNextJS CMS、AIチャット共有拡張機能、<br>
									AI前提のweb開発を行なってきました。
								</span>
							</div>
						</div>
						<p class="hidden lg:inline-block" style="font-size: 2.5em;">Cursor</p>
						<p class="hidden lg:inline-block" style="font-size: 2em;">Claude Code</p>
						<p class="hidden lg:inline-block" style="font-size: 2.5em;">TailwindCSS</p>
						<p class="hidden lg:inline-block" style="font-size: 2em;">WebGL</p>
						<p class="hidden lg:inline-block" style="font-size: 2.5em;">Codex</p>
						<p class="hidden lg:inline-block" style="font-size: 2em;">Pencil.dev</p>
						<p class="mmPin bg-GR/70 text-xs md:text-xl absolute z-10 text-[--WH] min-h-[2.5rem] content-center left-0 bottom-0 w-full text-align-last-justify px-2 md:px-16">
							Typescript PhotoShop Figma Three.js Supabase GSAP
						</p>
					</div>
					<dialog id="experience-dialog" aria-label="Experience and Dependencies" aria-modal="true" class="min-h-lvh w-screen max-w-none overflow-y-auto overscroll-none bg-BC/90 outline-none">
						<article class="py-[--PX] into">
							<button type="button" class="textlink DS shrink-0 text-AC fixed top-[--PX] right-[--into] p-2" data-dialog-close>Close ×</button>
							<header class="flex items-start justify-between gap BorderB pb-4">
								<div>
									<p class="text-sm font-bold text-AC">Details</p>
									<h2 class="font-medium text-GR">Experience and Dependencies</h2>
									<p class="mt-2 leading-[--LH]">経験とAI依存の詳細。</p>
								</div>
							</header>
							<section class="mt-8" aria-label="Experience and Dependencies">
								<div class="Cards col3 [--gap:1rem]">
									<?php foreach ( $experience_groups as $group ) : ?>
										<div class="item space-y-4">
											<?php foreach ( $group as $card ) : ?>
												<article class="BorderXY px-4 py-5 text-xs bg-WH/70">
													<h3 class="text-[1rem] BorderB pb-4 flex items-baseline justify-between gap-4">
														<?php echo esc_html( $card['title'] ); ?>
														<span class="text-GR tracking-[0.1em]"><?php echo esc_html( (string) count( $card['rows'] ) ); ?> lists</span>
													</h3>
													<div class="DescList [--dtW:50%] [--PY:0.25em] [--PX:0.25em] mt-4 IsDdright">
														<dl class="items-center">
															<?php foreach ( $card['rows'] as $row ) : ?>
																<dt><?php echo esc_html( $row[0] ); ?></dt>
																<dd><span class="px-2 bg-AC/30 font-medium"><?php echo esc_html( $row[1] ); ?></span></dd>
															<?php endforeach; ?>
														</dl>
													</div>
												</article>
											<?php endforeach; ?>
										</div>
									<?php endforeach; ?>
									<div class="item"></div>
								</div>
							</section>
						</article>
					</dialog>
				</div>

				<section class="Cards col2 relative items-center into [--gap:0px]">
					<div class="item PX">
						<div class="text-center">
							<h2 class="font-thin grid content-center md:h-[100lvh]">
								<span class="mindWobble text-left leading-[0.7em] tracking-[-0.0em]" style="font-size: 2.5em;">Vibe<br>&nbsp;&nbsp;Design</span>
								<span class="mindWobble text-center leading-[1em] mt-[-0.25em] tracking-[-0.0em] font-normal text-GR/10" style="font-size: 6em;">or</span>
								<span class="mindWobble text-right leading-[0.57em] tracking-[0.08em]" style="font-size: 2.5em;">Vault&nbsp;<br>Driven</span>
							</h2>
						</div>
					</div>
					<div class="item content-center bg-background/80 p-4">
						<div class="leading-[2]">
							<h3 class="text-GR mb-2">AI Ready</h3>
							<b>DESIGN.md</b> , <b>画像生成デザイン</b>を基点としたゼロからのページ作成の検証と、<b>自然言語でUIパーツを再利用</b>する為の環境構築を行っています。
							<h3 class="text-GR mt-10">Burn Your Own Style</h3>
							<details class="Toggle IsSmall font-normal mt-2">
								<summary class="Eng">Thinking...</summary>
								<div>
									- モデルの学習データに基づくwebデザイン・コーディングは平均的で、振れ幅が大きく、個人の理想とするマークアップ、スタイリングとかけ離れたものになる。<br>
									- 構造=既存クラス、装飾=Tailwindで手直ししやすい状態になるが、無駄な記述が多い。<br>
									考察：モデルのファインチューニングが民主化するまでは「完成品の再利用」を効率化する方が良い
								</div>
							</details>
							<div class="flex flex-wrap mt-4">
								<a class="btn mt-[-1px] [--btnW:50%]" href="https://github.com/yuremono/BurnYourOwnStyle/tree/react" target="_blank" rel="noopener noreferrer">Repository&nbsp;↗</a>
								<a class="btn mt-[-1px] ml-[-1px] [--btnW:50%]" href="<?php echo esc_url( home_url( '/preview' ) ); ?>">Preview</a>
							</div>
						</div>
					</div>
					<p class="bg-GR/70 text-xs md:text-xl absolute z-10 font-thin Eng text-[--WH] min-h-[2.5rem] content-center left-0 bottom-0 w-full text-align-last-justify px-2 md:px-16">
						Typescript PhotoShop Figma Three.js Supabase GSAP
					</p>
				</section>
			</div>
			<div class="ScrollSpacer" aria-hidden="true"></div>
		</section>

		<section class="out relative mt-0 grid BunmyakuTeaserSection">
			<div class="BunmyakuTeaserCanvasPlaceholder" aria-hidden="true">文</div>
		</section>

		<div class="repulsion-lists-module mt-[-25lvh] z-10">
			<section class="out px-[calc(var(--into)/3*2)] MY Eng font-light">
				<div id="repulsion-lists-horizontal-scroll-container" class="repulsion-lists-viewport">
					<div id="repulsion-lists-card-container">
						<svg class="repulsion-lists-lines" viewBox="0 0 0 0" preserveAspectRatio="none" data-connection-lines="true" aria-hidden="true"></svg>
						<ul class="repulsion-lists-list" aria-label="Repulsion list">
							<?php foreach ( $repulsion_items as $index => $item ) : ?>
								<?php
								$title = $item[0];
								$to    = $item[1];
								$href  = $item[2];
								$class = $item[3];
								$body  = $item[4];
								?>
								<li data-repulsion-list-chip="true" data-repulsion-list-item-id="repulsion-list-item-<?php echo esc_attr( (string) $index ); ?>" data-state="idle" class="repulsion-list-chip relative list-none bg-WH <?php echo esc_attr( $class ); ?>">
									<div class="repulsion-list-chip-control">
										<?php if ( '' !== $to || '' !== $href ) : ?>
											<a href="<?php echo esc_url( '' !== $to ? $to : $href ); ?>"<?php echo '' !== $href ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
												<div class="repulsion-list-chip-content [font-size:clamp(2rem,_5vw,_5rem)] font-light">
													<span class="repulsion-list-chip-label block mx-auto p-4 whitespace-nowrap text-center bg-[repultion-list-light]"><?php echo esc_html( $title ); ?></span>
												</div>
											</a>
										<?php else : ?>
											<span class="font-thin z-10 leading-[1.25em] [font-size:calc(var(--mmFZ)*4.5)]"><?php echo esc_html( $title ); ?></span>
										<?php endif; ?>
										<div class="repulsion-list-chip-popup">
											<?php if ( '' !== $body ) : ?>
												<p><?php echo esc_html( $body ); ?></p>
											<?php endif; ?>
										</div>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</section>
		</div>
	</main>

	<footer class="Eng Wrap into bg-[--foreground] text-[--background] bg-no-repeat bg-contain bg-left-bottom Footer">
		<div class="DescList IsCenter">
			<div>
				<dl>
					<dt>Name</dt>
					<dd>Yano Seiji</dd>
					<dt>Hobby</dt>
					<dd>Manga I love<br>Anime I love<br>Light Novel I love<br>Music I love</dd>
					<dt>Specialty</dt>
					<dd>CSS Styling<br>Context Engineering</dd>
				</dl>
			</div>
		</div>
		<div class="text-center">
			<p class="mb-0 text-[length:var(--logoFZ)]">yuremono works</p>
			<ul class="flex flex-wrap gap md:justify-center mt-6">
				<li><a href="<?php echo esc_url( home_url( '/preview' ) ); ?>">BurnYourOwnStyle</a></li>
				<li class="[font-family:--Ship]"><a href="<?php echo esc_url( home_url( '/bunmyaku' ) ); ?>">文脈</a></li>
				<li><a href="<?php echo esc_url( home_url( '/donut' ) ); ?>">Donut<small>(ADCMS)</small></a></li>
				<li><a href="<?php echo esc_url( home_url( '/rects' ) ); ?>">RandomGenerator</a></li>
				<li><a href="<?php echo esc_url( home_url( '/shuffleDivide' ) ); ?>">ShuffleDivide</a></li>
				<li><a href="<?php echo esc_url( home_url( '/glitch' ) ); ?>">Glitch</a></li>
				<li><a href="<?php echo esc_url( home_url( '/grid-carousel' ) ); ?>">GridCarousel</a></li>
				<li><a href="<?php echo esc_url( home_url( '/bbox' ) ); ?>">BBox</a></li>
				<li><a href="<?php echo esc_url( home_url( '/activity' ) ); ?>">Activity</a></li>
				<li><a href="https://chat-kanban.vercel.app/" target="_blank" rel="noopener noreferrer">ChatCanban&nbsp;↗</a></li>
				<li><a href="https://cms0505.vercel.app/" target="_blank" rel="noopener noreferrer">NextJsCMS&nbsp;↗</a></li>
			</ul>
		</div>
	</footer>
</div>

<?php
get_footer();
