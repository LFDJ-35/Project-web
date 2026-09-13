<header id="lfdj-sticky-header" class="lfdj-header lfdj-bg">

  <!-- PC -->
  <div class="lfdj-nav-container lfdj-nav-pc">
    <nav class="lfdj-nav-grid" aria-label="Navigation principale">
      <a class="lfdj-nav-cluster__home" href="./index.php" aria-label="Association">
        <i class="fa-solid fa-house" aria-hidden="true"></i>
      </a>
      <div class="lfdj-nav-cluster__main">
        <a href="./jdf.php">Figurines</a>
        <a href="./jdr.php">Jeu de Rôle</a>
        <a href="./jdp.php">Sur Plateau</a>
        <a href="./jdc.php">Carte à collectionner</a>

        <div class="lfdj-submenu" data-submenu="tournois">
          <button type="button" class="lfdj-submenu-btn" aria-haspopup="true" aria-expanded="false">
            Tournois
          </button>
          <div class="lfdj-submenu-content" aria-label="Sous-menu Tournois">
            <a href="./roots.php">Roots</a>
            <a href="./bloodbowl.php">Blood Bowl</a>
          </div>
        </div>
      </div>

      <div class="lfdj-header-tools">
        <input class="hidden" type="checkbox" id="dark-mode-toggle-pc" />
        <label for="dark-mode-toggle-pc" class="lfdj-theme-toggle" aria-label="Passer au mode nuit">
          <i class="fa-solid fa-sun lfdj-theme-toggle__sun" aria-hidden="true"></i>
          <i class="fa-solid fa-moon lfdj-theme-toggle__moon" aria-hidden="true"></i>
        </label>
      </div>
    </nav>
  </div>

  <!-- MOBILE -->
  <div class="lfdj-nav-container lfdj-nav-mobile">
    <a class="lfdj-mobile-home" href="./index.php" aria-label="Association">
      <i class="fa-solid fa-house" aria-hidden="true"></i>
    </a>

    <div class="lfdj-dropdown">
      <button class="lfdj-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>

      <div class="lfdj-dropdown-content" aria-label="Navigation mobile">
        <a href="./index.php" aria-label="Association">
          <i class="fa-solid fa-house" aria-hidden="true"></i>
        </a>

        <a href="./jdf.php">Figurines</a>
        <a href="./jdr.php">Jeu de Rôle</a>
        <a href="./jdp.php">Sur Plateau</a>
        <a href="./jdc.php">Carte à collectionner</a>

        <button class="lfdj-mobile-subbtn" type="button" aria-expanded="false">Tournois</button>
        <div class="lfdj-mobile-subcontent" aria-label="Sous-menu Tournois">
          <a href="./roots.php">Roots</a>
          <a href="./bloodbowl.php">Blood Bowl</a>
        </div>
      </div>
    </div>

    <div class="lfdj-header-tools lfdj-header-tools--mobile">
      <input class="hidden" type="checkbox" id="dark-mode-toggle-mobile" />
      <label for="dark-mode-toggle-mobile" class="lfdj-theme-toggle" aria-label="Passer au mode nuit">
        <i class="fa-solid fa-sun lfdj-theme-toggle__sun" aria-hidden="true"></i>
        <i class="fa-solid fa-moon lfdj-theme-toggle__moon" aria-hidden="true"></i>
      </label>
    </div>
  </div>

</header>

<script>
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

  const root = document.documentElement; // <html>
  const KEY = "lfdj_theme";

  const applyTheme = (theme) => {
    const isDark = theme === "dark";
    root.dataset.theme = isDark ? "dark" : "light";
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
</script>



<hr class="lfdj-hautdepage">
