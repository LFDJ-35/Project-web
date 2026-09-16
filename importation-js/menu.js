document.addEventListener("DOMContentLoaded", () => {
  // ====== Helpers ======
  const $ = (sel, root = document) => root.querySelector(sel);
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  // ====== MOBILE: burger dropdown ======
  const dd = $(".lfdj-dropdown");
  const burger = dd ? $(".lfdj-burger", dd) : null;
  const panel = dd ? $(".lfdj-dropdown-content", dd) : null;

  const closeMobileMenu = () => {
    if (!dd || !burger) return;
    dd.classList.remove("open");
    burger.setAttribute("aria-expanded", "false");
  };

  const toggleMobileMenu = (e) => {
    e.preventDefault();
    if (!dd || !burger) return;
    const isOpen = dd.classList.toggle("open");
    burger.setAttribute("aria-expanded", isOpen ? "true" : "false");
  };

  if (burger && panel) {
    burger.addEventListener("click", toggleMobileMenu);

    $$(".lfdj-dropdown-content a", dd).forEach(a =>
      a.addEventListener("click", closeMobileMenu)
    );
  }

  // ====== MOBILE: accordéons ======
  const mobileBtns = $$(".lfdj-mobile-subbtn");
  const mobileContents = () => $$(".lfdj-mobile-subcontent");

  const closeOtherMobileAccordions = (keepContent, keepBtn) => {
    mobileContents().forEach(sc => { if (sc !== keepContent) sc.classList.remove("open"); });
    mobileBtns.forEach(sb => { if (sb !== keepBtn) sb.setAttribute("aria-expanded", "false"); });
  };

  mobileBtns.forEach((btn) => {
    const content = btn.nextElementSibling;
    if (!content || !content.classList.contains("lfdj-mobile-subcontent")) return;

    btn.addEventListener("click", () => {
      const isOpen = content.classList.contains("open");

      closeOtherMobileAccordions(content, btn);

      content.classList.toggle("open", !isOpen);
      btn.setAttribute("aria-expanded", isOpen ? "false" : "true");
    });
  });

  // ====== PC: sous-menus au survol (CSS :hover / :focus-within) — pas de clic obligatoire ======

  // ====== Global: click outside & escape ======
  document.addEventListener("click", (e) => {
    if (dd && !dd.contains(e.target)) closeMobileMenu();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    closeMobileMenu();
  });

  // ====== DARK MODE: persistant + sync PC / mobile ======
  const toggles = [
    document.getElementById("dark-mode-toggle-pc"),
    document.getElementById("dark-mode-toggle-mobile"),
  ].filter(Boolean);

  const toggleLabels = [
    document.querySelector('label[for="dark-mode-toggle-pc"]'),
    document.querySelector('label[for="dark-mode-toggle-mobile"]'),
  ].filter(Boolean);

  const KEY = "lfdj_theme";

  const applyTheme = (theme) => {
    const isDark = theme === "dark";
    toggles.forEach(t => (t.checked = isDark));
    const aria = isDark ? "Passer au mode jour" : "Passer au mode nuit";
    toggleLabels.forEach((l) => l.setAttribute("aria-label", aria));
  };

  const saved = localStorage.getItem(KEY);
  const prefersDark = window.matchMedia?.("(prefers-color-scheme: dark)")?.matches;
  applyTheme(saved ?? (prefersDark ? "dark" : "light"));

  toggles.forEach(t => {
    t.addEventListener("change", () => {
      const theme = t.checked ? "dark" : "light";
      localStorage.setItem(KEY, theme);
      applyTheme(theme);
    });
  });
});
