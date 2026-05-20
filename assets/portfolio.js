(function () {
  const root = document.querySelector("[data-portfolio-page]");
  if (!root) return;

  const page = document.documentElement;
  const menuButton = root.querySelector(".portfolio_menu_button");
  const nav = root.querySelector("#portfolio_nav");
  const themeToggle = root.querySelector("[data-theme-toggle]");
  const dialogOpeners = root.querySelectorAll("[data-dialog-open]");
  let activeDialog = null;

  function setMenu(open) {
    if (!menuButton || !nav) return;
    menuButton.setAttribute("aria-expanded", open ? "true" : "false");
    nav.setAttribute("aria-hidden", open ? "false" : "true");
    root.dataset.navOpen = open ? "true" : "false";
  }

  function closeDialog() {
    if (!activeDialog) return;
    activeDialog.hidden = true;
    activeDialog = null;
    document.body.classList.remove("portfolio_dialog_is_open");
  }

  function openDialog(id) {
    const dialog = document.getElementById(id);
    if (!dialog) return;
    closeDialog();
    dialog.hidden = false;
    activeDialog = dialog;
    document.body.classList.add("portfolio_dialog_is_open");
    const panel = dialog.querySelector(".portfolio_dialog_panel");
    if (panel instanceof HTMLElement) {
      panel.focus();
    }
  }

  function updateScrollX(section) {
    const track = section.querySelector(".portfolio_scroll_track");
    const spacer = section.querySelector(".portfolio_scroll_spacer");
    if (!(track instanceof HTMLElement) || !(spacer instanceof HTMLElement)) {
      return;
    }

    const maxX = Math.max(0, track.scrollWidth - window.innerWidth);
    spacer.style.height = `${maxX}px`;
    const start = section.getBoundingClientRect().top + window.scrollY;
    const offset = Math.min(maxX, Math.max(0, window.scrollY - start));
    track.style.transform = `translate3d(${-offset}px,0,0)`;
  }

  function updateAllScrollX() {
    root.querySelectorAll("[data-scroll-x]").forEach(updateScrollX);
  }

  menuButton?.addEventListener("click", () => {
    setMenu(root.dataset.navOpen !== "true");
  });

  nav?.addEventListener("click", (event) => {
    if (event.target instanceof Element && event.target.closest("a")) {
      setMenu(false);
    }
  });

  themeToggle?.addEventListener("click", () => {
    const dark = page.classList.toggle("portfolio_dark");
    themeToggle.textContent = dark ? "☼" : "☾";
  });

  dialogOpeners.forEach((button) => {
    button.addEventListener("click", () => {
      openDialog(button.getAttribute("data-dialog-open") || "");
    });
  });

  root.addEventListener("click", (event) => {
    if (event.target instanceof Element && event.target.closest("[data-dialog-close]")) {
      closeDialog();
    }
  });

  document.addEventListener("keyup", (event) => {
    if (event.key === "Escape") {
      closeDialog();
      setMenu(false);
    }
  });

  window.addEventListener("scroll", updateAllScrollX, { passive: true });
  window.addEventListener("resize", updateAllScrollX, { passive: true });
  window.addEventListener("load", updateAllScrollX);
  updateAllScrollX();
})();
