<header id="lfdj-sticky-header" class="lfdj-header lfdj-bg">

  <!-- PC -->
  <div class="lfdj-nav-container lfdj-nav-pc">
    <nav class="lfdj-nav-grid" aria-label="Navigation principale">
      <a href="./laforgedesjoueurs.php" aria-label="Association">
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

      <a href="./discord.php">Discord</a>

      <div class="lfdj-submenu" data-submenu="autres">
        <button type="button" class="lfdj-submenu-btn" aria-haspopup="true" aria-expanded="false">
          Autres
        </button>
        <div class="lfdj-submenu-content" aria-label="Sous-menu Autres">
          <a href="./mentions-legales.php">Mentions légales</a>
          <a href="./partenaires.php">Partenaires</a>
          <a href="./reseaux-sociaux.php">Réseaux sociaux</a>
        </div>
      </div>

      <input type="checkbox" id="dark-mode-toggle" />
      <label for="dark-mode-toggle" class="toggle" aria-label="Activer le mode sombre"></label>
    </nav>
  </div>

  <!-- MOBILE -->
  <div class="lfdj-nav-container lfdj-nav-mobile">
    <a class="lfdj-mobile-home" href="./laforgedesjoueurs.php" aria-label="Association">
      <i class="fa-solid fa-house" aria-hidden="true"></i>
    </a>

    <div class="lfdj-dropdown">
      <button class="lfdj-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>

      <div class="lfdj-dropdown-content" aria-label="Navigation mobile">
        <a href="./laforgedesjoueurs.php" aria-label="Association">
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
          <a href="./partenaires.php">Partenaires</a>
          <a href="./reseaux-sociaux.php">Réseaux sociaux</a>
        </div>
      </div>
    </div>

    <input type="checkbox" id="dark-mode-toggle" />
    <label for="dark-mode-toggle" class="toggle" aria-label="Activer le mode sombre"></label>
  </div>

</header>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Burger mobile
  const dd = document.querySelector(".lfdj-dropdown");
  const burger = dd?.querySelector(".lfdj-burger");
  const panel = dd?.querySelector(".lfdj-dropdown-content");

  const closeMobileMenu = () => {
    if (!dd || !burger) return;
    dd.classList.remove("open");
    burger.setAttribute("aria-expanded", "false");
  };

  if (dd && burger && panel) {
    burger.addEventListener("click", (e) => {
      e.preventDefault();
      const isOpen = dd.classList.toggle("open");
      burger.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    document.addEventListener("click", (e) => {
      if (!dd.contains(e.target)) closeMobileMenu();
    });

    panel.querySelectorAll("a").forEach(a => a.addEventListener("click", closeMobileMenu));

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeMobileMenu();
    });
  }

  // Accordéons mobile (plusieurs)
  document.querySelectorAll(".lfdj-mobile-subbtn").forEach((btn) => {
    const content = btn.nextElementSibling;
    if (!content || !content.classList.contains("lfdj-mobile-subcontent")) return;

    btn.addEventListener("click", () => {
      // ferme les autres
      document.querySelectorAll(".lfdj-mobile-subcontent").forEach(sc => {
        if (sc !== content) sc.style.display = "none";
      });
      document.querySelectorAll(".lfdj-mobile-subbtn").forEach(sb => {
        if (sb !== btn) sb.setAttribute("aria-expanded", "false");
      });

      const open = content.style.display === "block";
      content.style.display = open ? "none" : "block";
      btn.setAttribute("aria-expanded", open ? "false" : "true");
    });
  });

  // Sous-menus PC (plusieurs) : toggle + placement fixed + fermeture dehors
  const submenus = document.querySelectorAll(".lfdj-submenu");

  const closeAllPCSubmenus = () => {
    submenus.forEach(sm => {
      const b = sm.querySelector(".lfdj-submenu-btn");
      const p = sm.querySelector(".lfdj-submenu-content");
      if (b) b.setAttribute("aria-expanded", "false");
      if (p) p.style.display = "none";
    });
  };

  submenus.forEach((sm) => {
    const b = sm.querySelector(".lfdj-submenu-btn");
    const p = sm.querySelector(".lfdj-submenu-content");
    if (!b || !p) return;

    const open = () => {
      const r = b.getBoundingClientRect();
      p.style.left = Math.max(12, Math.round(r.left)) + "px";
      p.style.display = "block";
      b.setAttribute("aria-expanded", "true");
    };

    const close = () => {
      p.style.display = "none";
      b.setAttribute("aria-expanded", "false");
    };

    b.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();

      const isOpen = p.style.display === "block";
      closeAllPCSubmenus();
      isOpen ? close() : open();
    });

    window.addEventListener("resize", () => {
      if (p.style.display === "block") open();
    });
  });

  document.addEventListener("click", closeAllPCSubmenus);
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeAllPCSubmenus();
  });
});
</script>

<hr class="lfdj-hautdepage">