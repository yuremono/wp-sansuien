(function () {
  const root = document.querySelector("[data-portfolio-page]");
  if (!root) return;

  const header = root.querySelector(".HeaderCylinder");
  const menuButton = root.querySelector("[data-menu-toggle]");
  const nav = root.querySelector("#HeaderNav");
  const themeToggle = root.querySelector("[data-theme-toggle]");
  const scrollXSections = root.querySelectorAll(".ScrollX");
  const mindMaps = root.querySelectorAll(".mindMap");
  const mindWobbles = root.querySelectorAll(".mindWobble");

  function setMenu(open) {
    if (!header || !menuButton || !nav) return;
    header.setAttribute("data-nav-open", open ? "true" : "false");
    menuButton.setAttribute("aria-expanded", open ? "true" : "false");
    menuButton.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    nav.setAttribute("aria-hidden", open ? "false" : "true");
    if (open) {
      nav.removeAttribute("inert");
      return;
    }
    nav.setAttribute("inert", "");
  }

  function updateScrollX(section) {
    const track = section.querySelector(".ScrollTrack");
    const spacer = section.querySelector(".ScrollSpacer");
    if (!(track instanceof HTMLElement) || !(spacer instanceof HTMLElement)) return;
    const maxX = Math.max(0, track.scrollWidth - window.innerWidth);
    spacer.style.height = `${maxX}px`;
    const start = section.getBoundingClientRect().top + window.scrollY;
    const offset = Math.min(maxX, Math.max(0, window.scrollY - start));
    track.style.transform = `translate3d(${-offset}px,0,0)`;
  }

  function updateAllScrollX() {
    scrollXSections.forEach(updateScrollX);
  }

  menuButton?.addEventListener("click", () => {
    setMenu(header?.getAttribute("data-nav-open") !== "true");
  });

  nav?.addEventListener("click", (event) => {
    if (event.target instanceof Element && event.target.closest("a")) {
      setMenu(false);
    }
  });

  root.querySelectorAll(".NavDrop").forEach((drop) => {
    const popover = drop.querySelector(".DropUl");
    if (!(popover instanceof HTMLElement)) return;
    const show = () => {
      if ("showPopover" in popover && !popover.matches(":popover-open")) {
        popover.showPopover();
      }
    };
    const hide = () => {
      if ("hidePopover" in popover && popover.matches(":popover-open")) {
        popover.hidePopover();
      }
    };
    drop.addEventListener("pointerenter", show);
    drop.addEventListener("pointerleave", (event) => {
      if (event.relatedTarget instanceof Node && drop.contains(event.relatedTarget)) return;
      hide();
    });
    popover.addEventListener("click", (event) => {
      if (event.target instanceof Element && event.target.closest("a")) {
        hide();
      }
    });
  });

  themeToggle?.addEventListener("click", () => {
    const dark = document.documentElement.classList.toggle("dark");
    root.classList.toggle("HasTheme", dark);
    themeToggle.textContent = dark ? "☼" : "☾";
  });

  root.querySelectorAll("[data-dialog-open]").forEach((button) => {
    button.addEventListener("click", () => {
      const id = button.getAttribute("data-dialog-open");
      const dialog = id ? document.getElementById(id) : null;
      if (dialog instanceof HTMLDialogElement) {
        dialog.showModal();
      }
    });
  });

  root.querySelectorAll("[data-dialog-close]").forEach((button) => {
    button.addEventListener("click", () => {
      button.closest("dialog")?.close();
    });
  });

  root.querySelectorAll(".repulsion-list-chip").forEach((chip) => {
    const popup = chip.querySelector(".repulsion-list-chip-popup");
    const open = () => {
      chip.setAttribute("data-state", "active");
      if (popup instanceof HTMLElement) {
        popup.style.setProperty("--repulsion-list-chip-grid-rows", "1fr");
      }
    };
    const close = () => {
      chip.setAttribute("data-state", "idle");
      if (popup instanceof HTMLElement) {
        popup.style.removeProperty("--repulsion-list-chip-grid-rows");
      }
    };
    chip.addEventListener("mouseenter", open);
    chip.addEventListener("mouseleave", close);
    chip.addEventListener("focusin", open);
    chip.addEventListener("focusout", close);
  });

  function initMindMap() {
    mindMaps.forEach((container) => {
      if (!(container instanceof HTMLElement)) return;
      const rect = container.getBoundingClientRect();
      const width = Math.max(rect.width, window.innerWidth, 320);
      const height = Math.max(rect.height, window.innerHeight, 320);
      const nodes = Array.from(container.children).filter((el) => el instanceof HTMLElement);
      nodes.forEach((node, index) => {
        if (!(node instanceof HTMLElement)) return;
        node.classList.add("mindMapNode");
        if (node.classList.contains("mmPin") || node.classList.contains("mmStatic")) {
          return;
        }
        if (node.classList.contains("mm1-3") || node.classList.contains("mm2-2") || node.classList.contains("mm3-9") || node.classList.contains("mm9-6")) {
          return;
        }
        const x = 8 + ((index * 23) % 76);
        const y = 12 + ((index * 37) % 70);
        node.style.position = "absolute";
        node.style.left = `${Math.min(86, x)}%`;
        node.style.top = `${Math.min(82, y)}%`;
      });
    });
  }

  let wobbleFrame = 0;
  function animateMindWobble(now) {
    mindWobbles.forEach((el, index) => {
      if (!(el instanceof HTMLElement)) return;
      const amp = Number.parseFloat(getComputedStyle(el).getPropertyValue("--mmWobbleAmp")) || 15;
      const x = Math.sin(now * 0.0005 + index) * amp;
      const y = Math.cos(now * 0.00035 + index * 1.7) * amp * 0.6;
      el.style.transform = `translate3d(${x.toFixed(2)}px, ${y.toFixed(2)}px, 0)`;
    });
    wobbleFrame = window.requestAnimationFrame(animateMindWobble);
  }

  document.addEventListener("keyup", (event) => {
    if (event.key === "Escape") {
      setMenu(false);
    }
  });

  window.addEventListener("scroll", updateAllScrollX, { passive: true });
  window.addEventListener("resize", () => {
    updateAllScrollX();
    initMindMap();
  }, { passive: true });
  window.addEventListener("load", () => {
    updateAllScrollX();
    initMindMap();
  });
  initMindMap();
  wobbleFrame = window.requestAnimationFrame(animateMindWobble);
  updateAllScrollX();
})();
