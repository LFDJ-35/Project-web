<?php
$lfdj_current = basename($_SERVER['SCRIPT_NAME']);

$lfdj_nav_links = [
  ['href' => '/jdf.php', 'label' => 'Figurines'],
  ['href' => '/jdr.php', 'label' => 'Jeu de Rôle'],
  ['href' => '/jdp.php', 'label' => 'Sur Plateau'],
  ['href' => '/jdc.php', 'label' => 'Carte à collectionner'],
];
$lfdj_nav_links_activite = [
  ['href' => '/peinture.php', 'label' => 'Peinture'],
  ['href' => '/atelier.php', 'label' => 'Atelier'],
];

/**
 * Affiche une liste de liens de navigation à plat (desktop et mobile), avec état actif.
 * @param array $links Liste de tableaux associatifs "href", "label"
 * @param string $current Nom du fichier de la page courante (basename)
 */
function lfdj_flat_nav_links(array $links, string $current)
{
  foreach ($links as $link) {
    $is_active = basename($link['href']) === $current;
    echo '<a href="' . $link['href'] . '" class="' . ($is_active ? 'active' : '') . '">' . $link['label'] . '</a>';
  }
}
?>
<link rel="stylesheet" href="/css/header.css">
<header id="lfdj-sticky-header" class="lfdj-header lfdj-bg">

  <!-- PC -->
  <div class="lfdj-nav-container lfdj-nav-pc">
    <nav class="lfdj-nav-grid" aria-label="Navigation principale">
      <a class="lfdj-nav-cluster__home" href="/index.php" aria-label="Accueil, La Forge des Joueurs">
        <img src="/images/Typographie-Blanc.png" alt="La Forge des Joueurs">
      </a>
      <div class="lfdj-nav-cluster__main">
        <?php lfdj_flat_nav_links($lfdj_nav_links, $lfdj_current); ?>
        <span class="lfdj-nav-divider" aria-hidden="true"></span>
        <?php lfdj_flat_nav_links($lfdj_nav_links_activite, $lfdj_current); ?>
      </div>

      <div class="lfdj-header-tools">
        <a class="lfdj-cta-discord" href="/discord">
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
    <a class="lfdj-mobile-home" href="/index.php" aria-label="Association">
      <img src="/images/Favicon-Main2.png" alt="La Forge des Joueurs">
    </a>

    <div class="lfdj-dropdown">
      <a class="lfdj-mobile-discord-btn" href="/discord" aria-label="Rejoignez le Discord">
        <i class="fa-brands fa-discord" aria-hidden="true"></i>
      </a>
      <button class="lfdj-burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>

      <div class="lfdj-dropdown-content" aria-label="Navigation mobile">
        <a href="/index.php" aria-label="Association">
          <i class="fa-solid fa-house" aria-hidden="true"></i>
        </a>

        <?php lfdj_flat_nav_links($lfdj_nav_links, $lfdj_current); ?>
        <span class="lfdj-nav-divider lfdj-nav-divider--mobile" aria-hidden="true"></span>
        <?php lfdj_flat_nav_links($lfdj_nav_links_activite, $lfdj_current); ?>
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

<script src="/importation-js/menu.js"></script>

<hr class="lfdj-hautdepage">
