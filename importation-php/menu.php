<?php require_once __DIR__ . '/auth-session.php'; ?>
<?php
$lfdj_discord_user = $_SESSION['discord_user'] ?? null;
$lfdj_nav_account_href = is_array($lfdj_discord_user) ? './mon-compte.php' : './auth-discord.php';
if (is_array($lfdj_discord_user)) {
    $lfdj_nav_account_label = (string) (
        $lfdj_discord_user['display']
        ?? $lfdj_discord_user['global_name']
        ?? $lfdj_discord_user['username']
        ?? 'Membre'
    );
} else {
    $lfdj_nav_account_label = 'Connexion';
}
$lfdj_nav_account_aria = is_array($lfdj_discord_user)
    ? 'Mon compte — ' . $lfdj_nav_account_label
    : 'Connexion avec Discord';
?>
<header id="lfdj-sticky-header" class="lfdj-header lfdj-bg">

  <!-- PC -->
  <div class="lfdj-nav-container lfdj-nav-pc">
    <div class="lfdj-nav-pc-inner">
    <nav class="lfdj-nav-grid" aria-label="Navigation principale">
      <a href="./index.php" aria-label="Association">
        <i class="fa-solid fa-house" aria-hidden="true"></i>
      </a>
      <a href="./jdf.php">JdF</a>
      <a href="./jdr.php">JdR</a>
      <a href="./jdp.php">JdP</a>
      <a href="./jdc.php">JdC</a>

      <div class="lfdj-submenu" data-submenu="tournois">
        <button type="button" class="lfdj-submenu-btn" aria-haspopup="true" aria-expanded="false">
          Tournois
        </button>
        <div class="lfdj-submenu-content" aria-label="Sous-menu Tournois">
          <a href="./roots.php">Roots</a>
          <a href="./bloodbowl.php">Blood Bowl</a>
        </div>
      </div>

      <a class="lfdj-main-shortcut" href="./discord.php">Discord</a>

      <div class="lfdj-submenu" data-submenu="autres">
        <button type="button" class="lfdj-submenu-btn" aria-haspopup="true" aria-expanded="false">
          Autres
        </button>
        <div class="lfdj-submenu-content" aria-label="Sous-menu Autres">
          <a href="./mentions-legales.php">Mentions légales</a>
          <a href="./confidentialite-compte.php">Confidentialité (compte)</a>
          <a href="./partenaires.php">Partenaires</a>
          <a href="./reseaux-sociaux.php">Réseaux sociaux</a>
        </div>
      </div>

   <input class="hidden" type="checkbox" id="dark-mode-toggle-pc" />
<label for="dark-mode-toggle-pc" class="toggle" aria-label="Activer le mode sombre"></label>
    </nav>
    <a class="lfdj-nav-account" href="<?php echo htmlspecialchars($lfdj_nav_account_href, ENT_QUOTES, 'UTF-8'); ?>" aria-label="<?php echo htmlspecialchars($lfdj_nav_account_aria, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($lfdj_nav_account_label, ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
  </div>

  <!-- MOBILE -->
  <div class="lfdj-nav-container lfdj-nav-mobile">
    <a class="lfdj-mobile-home" href="./index.php" aria-label="Association">
      <i class="fa-solid fa-house" aria-hidden="true"></i>
    </a>

    <a class="lfdj-nav-account lfdj-nav-account--mobile" href="<?php echo htmlspecialchars($lfdj_nav_account_href, ENT_QUOTES, 'UTF-8'); ?>" aria-label="<?php echo htmlspecialchars($lfdj_nav_account_aria, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($lfdj_nav_account_label, ENT_QUOTES, 'UTF-8'); ?></a>

    <div class="lfdj-dropdown">
      <button class="lfdj-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>

      <div class="lfdj-dropdown-content" aria-label="Navigation mobile">
        <a href="./index.php" aria-label="Association">
          <i class="fa-solid fa-house" aria-hidden="true"></i>
        </a>

        <a href="./jdf.php">JdF</a>
        <a href="./jdr.php">JdR</a>
        <a href="./jdp.php">JdP</a>
        <a href="./jdc.php">JdC</a>

        <button class="lfdj-mobile-subbtn" type="button" aria-expanded="false">Tournois</button>
        <div class="lfdj-mobile-subcontent" aria-label="Sous-menu Tournois">
          <a href="./roots.php">Roots</a>
          <a href="./bloodbowl.php">Blood Bowl</a>
        </div>

        <a href="./discord.php">Discord</a>

        <button class="lfdj-mobile-subbtn" type="button" aria-expanded="false">Autres</button>
        <div class="lfdj-mobile-subcontent" aria-label="Sous-menu Autres">
          <a href="./mentions-legales.php">Mentions légales</a>
          <a href="./confidentialite-compte.php">Confidentialité (compte)</a>
          <a href="./partenaires.php">Partenaires</a>
          <a href="./reseaux-sociaux.php">Réseaux sociaux</a>
        </div>
      </div>
    </div>

<input class="hidden" type="checkbox" id="dark-mode-toggle-mobile" />
<label for="dark-mode-toggle-mobile" class="toggle" aria-label="Activer le mode sombre"></label>
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

  // ====== PC: submenus ======
  const submenus = $$(".lfdj-submenu");

  const closeAllPCSubmenus = () => {
    submenus.forEach(sm => {
      const b = $(".lfdj-submenu-btn", sm);
      const p = $(".lfdj-submenu-content", sm);
      if (b) b.setAttribute("aria-expanded", "false");
      if (p) p.classList.remove("open");
    });
  };

  const positionPCSubmenu = (btn, panel) => {
    const r = btn.getBoundingClientRect();
    panel.style.left = Math.max(12, Math.round(r.left)) + "px";
  };

  const getOpenPC = () => {
    for (const sm of submenus) {
      const b = $(".lfdj-submenu-btn", sm);
      const p = $(".lfdj-submenu-content", sm);
      if (b && p && p.classList.contains("open")) return { b, p, sm };
    }
    return null;
  };

  submenus.forEach((sm) => {
    const b = $(".lfdj-submenu-btn", sm);
    const p = $(".lfdj-submenu-content", sm);
    if (!b || !p) return;

    b.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      const isOpen = p.classList.contains("open");
      closeAllPCSubmenus();

      if (!isOpen) {
        positionPCSubmenu(b, p);
        p.classList.add("open");
        b.setAttribute("aria-expanded", "true");
      }
    });

    p.addEventListener("click", (e) => e.stopPropagation());
  });

  // ====== Global: click outside & escape ======
  document.addEventListener("click", (e) => {
    if (dd && !dd.contains(e.target)) closeMobileMenu();

    // option conseillé pour éviter fermeture quand clic dans submenu
    if (!e.target.closest(".lfdj-submenu")) closeAllPCSubmenus();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    closeMobileMenu();
    closeAllPCSubmenus();
  });

  window.addEventListener("resize", () => {
    const open = getOpenPC();
    if (open) positionPCSubmenu(open.b, open.p);
  });

  // ====== DARK MODE: persistant + sync PC / mobile ======
  const toggles = [
    document.getElementById("dark-mode-toggle-pc"),
    document.getElementById("dark-mode-toggle-mobile"),
  ].filter(Boolean);

  const root = document.documentElement; // <html>
  const KEY = "lfdj_theme";

  const applyTheme = (theme) => {
    const isDark = theme === "dark";
    root.dataset.theme = isDark ? "dark" : "light";
    toggles.forEach(t => (t.checked = isDark));
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