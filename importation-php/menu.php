<?php $lfdj_current = basename($_SERVER['SCRIPT_NAME']); ?>
<header id="lfdj-sticky-header" class="lfdj-header lfdj-bg">

  <!-- PC -->
  <div class="lfdj-nav-container lfdj-nav-pc">
    <nav class="lfdj-nav-grid" aria-label="Navigation principale">
      <a class="lfdj-nav-cluster__home" href="./index.php" aria-label="Association">
        <img src="./images/Favicon-Main2.png" alt="La Forge des Joueurs">
      </a>
      <div class="lfdj-nav-cluster__main">
        <a href="./jdf.php" class="<?= $lfdj_current === 'jdf.php' ? 'active' : '' ?>">Figurines</a>
        <a href="./jdr.php" class="<?= $lfdj_current === 'jdr.php' ? 'active' : '' ?>">Jeu de Rôle</a>
        <a href="./jdp.php" class="<?= $lfdj_current === 'jdp.php' ? 'active' : '' ?>">Sur Plateau</a>
        <a href="./jdc.php" class="<?= $lfdj_current === 'jdc.php' ? 'active' : '' ?>">Carte à collectionner</a>
      </div>

      <div class="lfdj-header-tools">
        <a class="lfdj-cta-discord" href="./discord">
          <i class="fa-brands fa-discord" aria-hidden="true"></i>
          Rejoignez le Discord
          <i class="fa-solid fa-arrow-up-right lfdj-cta-discord__arrow" aria-hidden="true"></i>
        </a>
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
      <img src="./images/Favicon-Main2.png" alt="La Forge des Joueurs">
    </a>

    <div class="lfdj-dropdown">
      <button class="lfdj-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>

      <div class="lfdj-dropdown-content" aria-label="Navigation mobile">
        <a href="./index.php" aria-label="Association">
          <i class="fa-solid fa-house" aria-hidden="true"></i>
        </a>

        <a href="./jdf.php" class="<?= $lfdj_current === 'jdf.php' ? 'active' : '' ?>">Figurines</a>
        <a href="./jdr.php" class="<?= $lfdj_current === 'jdr.php' ? 'active' : '' ?>">Jeu de Rôle</a>
        <a href="./jdp.php" class="<?= $lfdj_current === 'jdp.php' ? 'active' : '' ?>">Sur Plateau</a>
        <a href="./jdc.php" class="<?= $lfdj_current === 'jdc.php' ? 'active' : '' ?>">Carte à collectionner</a>

        <a class="lfdj-cta-discord lfdj-cta-discord--mobile" href="./discord">
          <i class="fa-brands fa-discord" aria-hidden="true"></i>
          Rejoignez le Discord
          <i class="fa-solid fa-arrow-up-right lfdj-cta-discord__arrow" aria-hidden="true"></i>
        </a>
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

<script src="./importation-js/menu.js"></script>

<hr class="lfdj-hautdepage">
