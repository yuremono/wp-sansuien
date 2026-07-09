/**
 * 山翠苑テーマ フロントエンド演出。
 * 静的サイト（tmp/sansuien/preview/index.html, room.html）のインラインスクリプトを
 * ページ間で共通化し、要素が存在しないページでは何もしないように防御的に実装している。
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		initReveal();
		initHeaderScroll();
		initGalleryMarquee();
		initFeatureScrollScrub();
		initModals();
	});

	/** 出現時に reveal 系クラスを解除する（IntersectionObserver）. */
	function initReveal() {
		var targets = document.querySelectorAll('.reveal, .reveal-l, .reveal-r, .reveal-tr, .reveal-br, .path_draw');
		if (!targets.length) {
			return;
		}
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is_in');
					io.unobserve(entry.target);
				}
			});
		}, { threshold: 0.15 });
		targets.forEach(function (el) {
			io.observe(el);
		});
	}

	/** スクロール量に応じてヘッダーの背景を切り替える. */
	function initHeaderScroll() {
		var header = document.querySelector('.site_header');
		if (!header) {
			return;
		}
		addEventListener('scroll', function () {
			header.classList.toggle('is_scrolled', scrollY > 80);
		}, { passive: true });
	}

	/** ドラッグ可能かつ自動スクロールするギャラリーのマーキー演出（トップページのみ）. */
	function initGalleryMarquee() {
		var track = document.getElementById('gTrack');
		if (!track || !track.children.length) {
			return;
		}

		var setWidth = 0;
		var gx = 0;
		var dragging = false;
		var startX = 0;
		var startAt = 0;

		function measure() {
			setWidth = track.children[0].getBoundingClientRect().width;
		}
		measure();
		addEventListener('resize', measure);

		function loop() {
			if (!dragging) {
				gx -= 0.6;
			}
			if (gx <= -setWidth) {
				gx += setWidth;
			}
			if (gx > 0) {
				gx -= setWidth;
			}
			track.style.transform = 'translateX(' + gx + 'px)';
			requestAnimationFrame(loop);
		}
		requestAnimationFrame(loop);

		track.addEventListener('pointerdown', function (e) {
			dragging = true;
			startX = e.clientX;
			startAt = gx;
			track.setPointerCapture(e.pointerId);
			track.style.cursor = 'grabbing';
		});
		track.addEventListener('pointermove', function (e) {
			if (!dragging) {
				return;
			}
			gx = startAt + (e.clientX - startX);
		});
		function endDrag() {
			dragging = false;
			track.style.cursor = 'grab';
		}
		track.addEventListener('pointerup', endDrag);
		track.addEventListener('pointerleave', endDrag);
	}

	/**
	 * Feature セクション: スクロール量に連動した画像の重なり・フェード演出（トップページのみ）。
	 * IntersectionObserverのon/off方式ではなく、requestAnimationFrameで毎フレーム
	 * 進行度を再計算する。上スクロールで戻せば逆再生になる。
	 */
	function initFeatureScrollScrub() {
		var fPics = document.querySelectorAll('.f_pic .ph');
		var fTxts = document.querySelectorAll('.f_txt');
		if (!fPics.length || !fTxts.length) {
			return;
		}

		// 「開始位置は到着位置から画像自身の幅・高さの何%ずれているか」という比率指定。
		// pxではなく画像自身のwidth/heightに対する割合なので、レスポンシブでサイズが
		// 変わっても同じ見た目になる。
		//   xPct: 到着位置からのXオフセット(画像の幅に対する%。正=右からスタート)
		//   yPct: 到着位置からのYオフセット(画像の高さに対する%。正=下からスタート)
		var specs = [
			{ xPct: 0, yPct: 0, r0: 0, x1: 0, y1: 0, r1: 0 },
			{ xPct: 200, yPct: 100, r0: 6, x1: -4, y1: 14, r1: 1.5 },
			{ xPct: 200, yPct: 100, r0: 5.5, x1: 5, y1: 25, r1: -1.25 }
		];

		function loop() {
			var vh = innerHeight;
			fPics.forEach(function (ph, i) {
				var spec = specs[i];
				var txt = fTxts[i];
				if (!spec || !txt) {
					return;
				}
				var rect = txt.getBoundingClientRect();
				var p = (vh - rect.top) / vh;
				p = Math.max(0, Math.min(1, p));
				var x0 = ph.offsetWidth * (spec.xPct / 100);
				var y0 = ph.offsetHeight * (spec.yPct / 100);
				var x = x0 + (spec.x1 - x0) * p;
				var y = y0 + (spec.y1 - y0) * p;
				var r = spec.r0 + (spec.r1 - spec.r0) * p;
				ph.style.opacity = p;
				ph.style.transform = 'translate(' + x + 'px,' + y + 'px) rotate(' + r + 'deg)';
			});
			requestAnimationFrame(loop);
		}
		requestAnimationFrame(loop);
	}

	/**
	 * .Modal を開閉する。ブラウザ標準の <dialog>/top layerは使わず、
	 * opacity/visibility/pointer-events の切り替え（.is_open クラス）で実装している。
	 * href="#モーダルのid" を持つリンクをクリックすると、ページ内のどこからでも開ける。
	 */
	function initModals() {
		var modals = document.querySelectorAll('.Modal');
		if (!modals.length) {
			return;
		}

		var lastTrigger = null;

		function openModal(modal, trigger) {
			lastTrigger = trigger || null;
			modal.classList.add('is_open');
			modal.setAttribute('aria-hidden', 'false');
			document.body.classList.add('has_open_modal');
			var dialog = modal.querySelector('.Modal_dialog');
			if (dialog) {
				dialog.focus();
			}
		}

		function closeModal(modal) {
			modal.classList.remove('is_open');
			modal.setAttribute('aria-hidden', 'true');
			document.body.classList.remove('has_open_modal');
			if (lastTrigger) {
				lastTrigger.focus();
				lastTrigger = null;
			}
		}

		document.addEventListener('click', function (e) {
			var opener = e.target.closest('a[href^="#"]');
			if (opener) {
				var modal = document.querySelector(opener.getAttribute('href'));
				if (modal && modal.classList.contains('Modal')) {
					e.preventDefault();
					openModal(modal, opener);
					return;
				}
			}

			var closer = e.target.closest('[data-modal-close]');
			if (closer) {
				var openModalEl = closer.closest('.Modal');
				if (openModalEl) {
					closeModal(openModalEl);
				}
				return;
			}

			modals.forEach(function (modal) {
				if (e.target === modal) {
					closeModal(modal);
				}
			});
		});

		document.addEventListener('keydown', function (e) {
			if (e.key !== 'Escape') {
				return;
			}
			modals.forEach(function (modal) {
				if (modal.classList.contains('is_open')) {
					closeModal(modal);
				}
			});
		});
	}
})();
