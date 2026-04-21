<?php
require_once __DIR__ . '/profile-storage.php';
$lfdjLogged = isset($_SESSION['discord_user']) && is_array($_SESSION['discord_user']);
$lfdjHeaderName = $lfdjLogged ? lfdj_header_display_name() : '';
$lfdjReqPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (!is_string($lfdjReqPath) || $lfdjReqPath === '') {
    $lfdjReqPath = '/';
}
$lfdjLogoutUrl = './auth-logout.php?next=' . rawurlencode($lfdjReqPath);
?>
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
        <a href="./membres.php">Membres</a>
      </div>

      <div class="lfdj-header-tools">
        <div class="lfdj-header-account" aria-label="Compte membre">
          <?php if ($lfdjLogged): ?>
            <a class="lfdj-header-account__name" href="./mon-compte.php" title="Mon compte"><?php echo htmlspecialchars($lfdjHeaderName, ENT_QUOTES, 'UTF-8'); ?></a>
            <a class="lfdj-header-account__off" href="<?php echo htmlspecialchars($lfdjLogoutUrl, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Déconnexion" title="Déconnexion">Off</a>
          <?php else: ?>
            <a class="lfdj-header-account__login" href="./auth-discord.php">Se connecter</a>
          <?php endif; ?>
        </div>
        <input class="hidden" type="checkbox" id="dark-mode-toggle-pc" />
        <label for="dark-mode-toggle-pc" class="lfdj-theme-toggle" aria-label="Passer au mode nuit">
          <i class="fa-solid fa-sun lfdj-theme-toggle__sun" aria-hidden="true"></i>
          <i class="fa-solid fa-moon lfdj-theme-toggle__moon" aria-hidden="true"></i>
        </label>
      </div>
    </nav>
  </div>

  <!-- MOBILE : gauche accueil + compte (icône user), droite menu + thème (même taille que le burger) -->
  <div class="lfdj-nav-container lfdj-nav-mobile">
    <div class="lfdj-mobile-bar-left">
      <a class="lfdj-mobile-home" href="./index.php" aria-label="Association">
        <i class="fa-solid fa-house" aria-hidden="true"></i>
      </a>
      <div class="lfdj-mobile-account-slot" aria-label="Compte membre">
        <?php if ($lfdjLogged): ?>
          <a class="lfdj-mobile-user-icon" href="./mon-compte.php" title="Mon compte" aria-label="Mon compte">
            <i class="fa-solid fa-user" aria-hidden="true"></i>
          </a>
          <a class="lfdj-header-account__off lfdj-mobile-account-off" href="<?php echo htmlspecialchars($lfdjLogoutUrl, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Déconnexion" title="Déconnexion">Off</a>
        <?php else: ?>
          <a class="lfdj-mobile-user-icon" href="./auth-discord.php" aria-label="Se connecter" title="Se connecter">
            <i class="fa-solid fa-user" aria-hidden="true"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="lfdj-mobile-bar-right">
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

          <a href="./membres.php">Membres</a>
        </div>
      </div>
      <input class="hidden" type="checkbox" id="dark-mode-toggle-mobile" />
      <label for="dark-mode-toggle-mobile" class="lfdj-theme-toggle lfdj-theme-toggle--mobile-header" aria-label="Passer au mode nuit">
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
