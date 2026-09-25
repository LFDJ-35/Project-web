<?php
$lfdj_current = basename($_SERVER['SCRIPT_NAME']);

$lfdj_jeux_links = [
  ['href' => '/jdf.php', 'icon' => 'fa-chess-knight', 'label' => '… de Figurines'],
  ['href' => '/jdr.php', 'icon' => 'fa-dice', 'label' => '… de Rôle'],
  ['href' => '/jdp.php', 'icon' => 'fa-chess-board', 'label' => '… de Plateau'],
  ['href' => '/jdc.php', 'icon' => 'fa-clone', 'label' => '… de Cartes'],
];
$lfdj_activite_links = [
  ['href' => '/bloodbowl.php', 'icon' => 'fa-chess-knight', 'label' => 'Ligue Bloodbowl S2'],
  ['href' => '/palmares.php', 'icon' => 'fa-medal', 'label' => 'Palmarès'],
];

$lfdj_jeux_pages = array_map('basename', array_column($lfdj_jeux_links, 'href'));
$lfdj_activite_pages = array_map('basename', array_column($lfdj_activite_links, 'href'));

/**
 * Affiche une liste de liens de sous-menu (desktop et mobile), avec icône et état actif.
 * @param array $links Liste de tableaux associatifs "href", "icon", "label"
 * @param string $current Nom du fichier de la page courante (basename)
 */
function lfdj_menu_links(array $links, string $current)
{
  foreach ($links as $link) {
    $is_active = basename($link['href']) === $current;
    echo '<a href="' . $link['href'] . '" class="' . ($is_active ? 'active' : '') . '">'
      . '<i class="fa-solid ' . $link['icon'] . '" aria-hidden="true"></i> ' . $link['label']
      . '</a>';
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
        <div class="lfdj-submenu">
          <button type="button" class="lfdj-submenu-btn <?= in_array($lfdj_current, $lfdj_jeux_pages) ? 'active' : '' ?>" aria-haspopup="true" aria-expanded="false">
            Jeux <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
          </button>
          <div class="lfdj-submenu-content">
            <?php lfdj_menu_links($lfdj_jeux_links, $lfdj_current); ?>
          </div>
        </div>
        <div class="lfdj-submenu">
          <button type="button" class="lfdj-submenu-btn <?= in_array($lfdj_current, $lfdj_activite_pages) ? 'active' : '' ?>" aria-haspopup="true" aria-expanded="false">
            Activité <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
          </button>
          <div class="lfdj-submenu-content">
            <?php lfdj_menu_links($lfdj_activite_links, $lfdj_current); ?>
          </div>
        </div>
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
        <button type="button" class="lfdj-mobile-subbtn <?= in_array($lfdj_current, $lfdj_jeux_pages) ? 'active' : '' ?>" aria-expanded="false">
          Jeux <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="lfdj-mobile-subcontent">
          <?php lfdj_menu_links($lfdj_jeux_links, $lfdj_current); ?>
        </div>

        <button type="button" class="lfdj-mobile-subbtn <?= in_array($lfdj_current, $lfdj_activite_pages) ? 'active' : '' ?>" aria-expanded="false">
          Activité <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div class="lfdj-mobile-subcontent">
          <?php lfdj_menu_links($lfdj_activite_links, $lfdj_current); ?>
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

<script src="/importation-js/menu.js"></script>

<hr class="lfdj-hautdepage">
