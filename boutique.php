
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>Boutique | La Forge des Joueurs</title>
<meta name="description" content="Précommandes textiles de La Forge des Joueurs : t-shirts, maillots et sweats de la collection Pingu, coton bio fabriqué en France." />
<?php require('importation-php/regles.php'); ?>
<link rel="stylesheet" href="./css/boutique.css">
</head>

<body class="lfdj-maincontainer">

<hr class="lfdj-midpage">

<?php require('importation-php/menu.php'); ?>

<?php

/**
 * Génère le code HTML pour un élément d'une collection (une miniature)
 * @param string $collection_root Répertoire racine où trouver la collection
 * @param array $element Liste de tableaux associatifs contenant les données de la collection (nom du fichier, code produit,
 * légende)
 * @param bool $is_active Si l'élément doit être actif ou non sur la page (classe `active`)
 */
function create_collection_element(string $collection_root, array $element, bool $is_active)
{
  echo ('<button type="button" class="lfdj-design-thumb ' . ($is_active ? "active" : "") . '" data-file="' . $element["data-file"] . '" data-code="' . $element["data-code"] . '" aria-label="' . $element["label"] . '">');
  if ($element["data-file"] == "") {
    echo ('<span class="lfdj-design-thumb-blank" aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>');
  } else {
    echo ('<img src="' . $collection_root . $element["data-file"] . '" alt="' . $element["label"] . '" loading="lazy">');
  }
  echo ('</button>');
}

/**
 * Génère le code HTML pour une collection (galerie de miniatures)
 * @param string $collection_root Répertoire racine où trouver la collection
 * @param array $collection Liste de tableaux associatifs contenant les données de la collection (nom du fichier, code produit,
 * légende)
 */
function create_collection(string $collection_root, array $collection)
{
  if (sizeof($collection) == 0) return;

  if (!str_ends_with($collection_root, "/")) {
    $collection_root = $collection_root . "/";
  }

  // Création du HTML correpondant

  // Le premier élément de la collection est défini comme actif par défaut
  create_collection_element($collection_root, $collection[0], true);

  foreach (array_slice($collection, 1) as $element) {
    // Les autres sont inactifs.
    create_collection_element($collection_root, $element, false);
  }
}

/**
 * Génère le code HTML pour un swatch de couleur
 * @param array $swatch Données du swatch : "code" (couleur CSS), "data-code" (code référence), "label",
 * et soit "data-file" (nom de fichier image), soit "data-color" (code court utilisé par le script de rendu)
 * @param bool $is_active Si le swatch doit être actif ou non sur la page (classe `active`)
 */
function create_color_swatch(array $swatch, bool $is_active)
{
  $data_attr = isset($swatch["data-file"])
    ? ' data-file="' . $swatch["data-file"] . '"'
    : ' data-color="' . $swatch["data-color"] . '"';

  echo ('<button type="button" class="lfdj-color-swatch ' . ($is_active ? "active" : "") . '"' . $data_attr
    . ' data-code="' . $swatch["data-code"] . '" style="background-color:' . $swatch["color"] . '"'
    . ' aria-label="' . $swatch["label"] . '" title="' . $swatch["label"] . '"></button>');
}

/**
 * Génère le code HTML pour une ligne de swatches de couleur
 * @param array $swatches Liste de tableaux associatifs contenant les données de chaque swatch
 */
function create_color_swatches(array $swatches)
{
  if (sizeof($swatches) == 0) return;

  // Le premier swatch est défini comme actif par défaut
  create_color_swatch($swatches[0], true);

  foreach (array_slice($swatches, 1) as $swatch) {
    // Les autres sont inactifs.
    create_color_swatch($swatch, false);
  }
}

?>

<div class="lfdj-divtitle">
  <h4>La boutique de la forge s'installe</h4>
  <h2>Boutique</h2>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-shirt"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Après plusieurs semaines à comparer les prestataires et à valider les designs avec
    <a href="https://www.instagram.com/estelle_arttt/" target="_blank" rel="noopener"><strong>Estelle</strong></a>,
    illustratrice de l'association, la Forge des Joueurs lance ses
    <strong>précommandes de goodies textiles</strong>&nbsp;: t-shirts, maillots et sweats.
  </p>
  <p>
    Cette page <strong>n'est pas une boutique en ligne classique</strong>&nbsp;: elle sert à
    <strong>composer et visualiser</strong> votre article, puis à générer sa référence.
    Les tarifs affichés sont ceux d'un premier devis fournisseur, pris comme base&nbsp;;
    ils ne pourront évoluer qu'à la <strong>baisse</strong> une fois les quantités réelles connues.
  </p>
  <p>
    Pour précommander&nbsp;: composez votre article ci-dessous, copiez la référence générée,
    puis notez-la (avec la quantité souhaitée) dans le
    <a href="https://docs.google.com/spreadsheets/d/1N33kyrAUG4bHaU7Hm_OirJmB8C72Rlye8F2bkU2DdT8/edit?usp=sharing" target="_blank" rel="noopener">tableau de précommande partagé</a>.
    Aucun paiement n'est demandé à ce stade&nbsp;: il sera organisé une fois les commandes
    groupées et les tarifs définitifs validés.
  </p>
</div>

<div class="lfdj-notice-box lfdj-notice-box--engagement">
  <p>
    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
    <strong>Un article précommandé est un engagement&nbsp;:</strong> il devra être réglé
    dès que la commande groupée sera passée auprès du prestataire. C'est grâce à vos
    précommandes qu'on peut estimer nos tarifs dégressifs et en faire profiter tout le
    monde&nbsp;: une annulation est problématique pour l'ensemble du groupe.
    Soyons raisonnables, on compte sur vous&nbsp;!
  </p>
</div>

<div class="lfdj-notice-box lfdj-notice-box--warning">
  <p>
    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
    <strong>Attention&nbsp;:</strong> les mockups utilisés ci-dessous ne sont pas les
    produits officiels finaux, mais des visuels permettant de se projeter sur le rendu.
    De même, les images affichées sont volontairement en qualité réduite, pour un
    chargement de page optimal&nbsp;: ce sont bien les fichiers finaux, la définition
    sera simplement restaurée en haute qualité au moment de la commande.
  </p>
</div>

<section aria-label="Collection Pingu">

<div class="lfdj-divtitle">
  <h4>Composez votre style</h4>
  <h3>collection pingu</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-palette"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Design imaginé par <strong>Estelle 🐧</strong> illustratrice en courtoisie pour son travail bénévole, un lien vers son
    <a href="https://www.instagram.com/estelle_arttt/" target="_blank" rel="noopener">Instagram</a>.
    Le t-shirt utilisé est le
    <a href="https://www.lesfilosophes.fr/products/descartes-t-shirt-en-coton-bio-fabrique-en-france" target="_blank" rel="noopener">Descartes</a>,
    en coton bio fabriqué en France par Les Philosophes.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs" role="group" aria-label="Vue du t-shirt">
      <button type="button" class="lfdj-size-pill" data-view="FACE">Face</button>
      <button type="button" class="lfdj-size-pill active" data-view="DOS">Dos</button>
    </div>
    <div class="lfdj-boutique-preview-frame">
      <img id="lfdj-tshirt-base" src="./images/Textile/DESCARTES/TSHIRT-DOS-BLANC.webp" alt="T-shirt dos, coloris blanc" width="2050" height="2529">
      <img id="lfdj-tshirt-design" src="./images/Textile/COLLECTION-PINGU/TSHIRT/DESIGN-PINGU-ALIEN.webp" alt="Design Alien" width="2050" height="2529">
      <img id="lfdj-tshirt-logo" src="./images/Textile/COLLECTION-PINGU/TSHIRT/LOGO-PINGU-FACE-BLANC.webp" alt="Logo, face" width="2113" height="2351">
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-ref-code">EST-ALI-BLA-M-Q1</code>
      <button type="button" id="lfdj-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">

      <?php
        create_collection("/images/Textile/COLLECTION-PINGU/TSHIRT/", array(
          array("data-file" => "DESIGN-PINGU-ALIEN.webp", "data-code" => "ALI", "label" => "Design Alien"),
          array("data-file" => "DESIGN-PINGU-BLOODBOWL.webp", "data-code" => "BB", "label" => "Design Blood Bowl"),
          array("data-file" => "DESIGN-PINGU-CYBERPUNK.webp", "data-code" => "CPK", "label" => "Design Cyberpunk"),
          array("data-file" => "DESIGN-PINGU-DRAGON.webp", "data-code" => "DRA", "label" => "Design Dragon"),
          array("data-file" => "DESIGN-PINGU-SPACEMARINE.webp", "data-code" => "SM", "label" => "Design Space Marine"),
          array("data-file" => "DESIGN-PINGU-TRIO-JDF-SPACEMARINE.webp", "data-code" => "TRISM", "label" => "Design Trio, Space Marine en avant"),
          array("data-file" => "DESIGN-PINGU-TRIO-JDR-DRAGON.webp", "data-code" => "TRIDRA", "label" => "Design Trio, Dragon en avant"),
          array("data-file" => "DESIGN-PINGU-QUINTET-DRAGON.webp", "data-code" => "QUIDRA", "label" => "Design Quintet, Dragon en avant"),
        ));
      ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-color" => "BLANC", "data-code" => "BLA", "color" => "#f4f3f0", "label" => "Blanc"),
          array("data-color" => "BORDEAUX", "data-code" => "BOR", "color" => "#661f24", "label" => "Bordeaux"),
          array("data-color" => "CIEL", "data-code" => "CIE", "color" => "#b5d9f3", "label" => "Ciel"),
          array("data-color" => "MARINE", "data-code" => "MAR", "color" => "#1d253a", "label" => "Marine"),
          array("data-color" => "NOIR", "data-code" => "NOI", "color" => "#333332", "label" => "Noir"),
          array("data-color" => "ROSEFUCHSIA", "data-code" => "RFU", "color" => "#f34b8d", "label" => "Rose fuchsia"),
          array("data-color" => "ROSEPALE", "data-code" => "RPA", "color" => "#ecdade", "label" => "Rose pâle"),
          array("data-color" => "ROUGE", "data-code" => "RGE", "color" => "#e0222b", "label" => "Rouge"),
          array("data-color" => "ROYAL", "data-code" => "ROY", "color" => "#054bac", "label" => "Royal"),
          array("data-color" => "VERT", "data-code" => "VER", "color" => "#345c4a", "label" => "Vert"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Taille</h5>
      <div class="lfdj-size-row" role="group" aria-label="Choix de la taille">
        <button type="button" class="lfdj-size-pill" data-code="XS">XS</button>
        <button type="button" class="lfdj-size-pill" data-code="S">S</button>
        <button type="button" class="lfdj-size-pill active" data-code="M">M</button>
        <button type="button" class="lfdj-size-pill" data-code="L">L</button>
        <button type="button" class="lfdj-size-pill" data-code="XL">XL</button>
        <button type="button" class="lfdj-size-pill" data-code="2XL">2XL</button>
        <button type="button" class="lfdj-size-pill" data-code="3XL">3XL</button>
      </div>
    </div>

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-tshirt-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">25&nbsp;€ la pièce</span>
      </div>
    </div>

  </div>

</div>

</section>

<section aria-label="Collection Pipito">

<div class="lfdj-divtitle">
  <h4>Un peu plus perso</h4>
  <h3>collection pipito</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-wand-magic-sparkles"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Une collection imaginée par <strong>Spirito</strong>, en courtoisie pour son travail bénévole,
    un lien vers son site <a href="https://www.spirito.fr" target="_blank" rel="noopener">www.spirito.fr</a>
    est indiqué ici. Par souci de transparence, sachez que ces designs ont en partie été réalisés
    à l'aide de l'intelligence artificielle, bien qu'entièrement retouchés à la main. Le t-shirt
    utilisé est le
    <a href="https://www.lesfilosophes.fr/products/descartes-t-shirt-en-coton-bio-fabrique-en-france" target="_blank" rel="noopener">Descartes</a>,
    en coton bio fabriqué en France par Les Philosophes.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs" role="group" aria-label="Vue du t-shirt">
      <button type="button" class="lfdj-size-pill active" data-view="FACE">Face</button>
      <button type="button" class="lfdj-size-pill" data-view="DOS">Dos</button>
    </div>
    <div class="lfdj-boutique-preview-frame">
      <img id="lfdj-pipito-base" src="./images/Textile/DESCARTES/TSHIRT-FACE-NOIR.webp" alt="T-shirt, coloris noir, face" width="1129" height="1393">
      <img id="lfdj-pipito-design" src="./images/Textile/COLLECTION-PIPITO/DESIGN-PIPITO-BEER.webp" alt="Design Actuellement en repos long" width="2500" height="2500">
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-pipito-ref-code">PIP-BEE-NOI-M-Q1</code>
      <button type="button" id="lfdj-pipito-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design (face)</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">

        <?php
        create_collection("/images/Textile/COLLECTION-PIPITO/", array(
          array("data-file" => "DESIGN-PIPITO-BEER.webp", "data-code" => "BEE", "label" => "Actuellement en repos long"),
          array("data-file" => "DESIGN-PIPITO-COFFRE.webp", "data-code" => "COF", "label" => "Coffret vraiment gourmand"),
          array("data-file" => "DESIGN-PIPITO-MENHIR.webp", "data-code" => "MEN", "label" => "Solide comme un menhir"),
          array("data-file" => "DESIGN-PIPITO-PIOU.webp", "data-code" => "PIO", "label" => "Grand destin, petit héro"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-color" => "NOIR", "data-code" => "NOI", "color" => "#333332", "label" => "Noir"),
          array("data-color" => "BORDEAUX", "data-code" => "BOR", "color" => "#661f24", "label" => "Bordeaux"),
          array("data-color" => "MARINE", "data-code" => "MAR", "color" => "#1d253a", "label" => "Marine"),
          array("data-color" => "ROUGE", "data-code" => "RGE", "color" => "#e0222b", "label" => "Rouge"),
          array("data-color" => "ROYAL", "data-code" => "ROY", "color" => "#054bac", "label" => "Royal"),
          array("data-color" => "VERT", "data-code" => "VER", "color" => "#345c4a", "label" => "Vert"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Taille</h5>
      <div class="lfdj-size-row" role="group" aria-label="Choix de la taille">
        <button type="button" class="lfdj-size-pill" data-code="XS">XS</button>
        <button type="button" class="lfdj-size-pill" data-code="S">S</button>
        <button type="button" class="lfdj-size-pill active" data-code="M">M</button>
        <button type="button" class="lfdj-size-pill" data-code="L">L</button>
        <button type="button" class="lfdj-size-pill" data-code="XL">XL</button>
        <button type="button" class="lfdj-size-pill" data-code="2XL">2XL</button>
        <button type="button" class="lfdj-size-pill" data-code="3XL">3XL</button>
      </div>
    </div>

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-pipito-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">25&nbsp;€ la pièce</span>
      </div>
    </div>

  </div>

</div>

</section>

<section aria-label="Collection Générique">

<div class="lfdj-divtitle">
  <h4>Le basique de l'asso</h4>
  <h3>collection générique</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-people-group"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Le t-shirt simple de l'association, floqué du logo, à offrir ou à porter lors des
    portes ouvertes et conventions. Disponible en deux coloris, même tarif que les
    autres collections de t-shirts. Le t-shirt utilisé est le
    <a href="https://www.lesfilosophes.fr/products/descartes-t-shirt-en-coton-bio-fabrique-en-france" target="_blank" rel="noopener">Descartes</a>,
    en coton bio fabriqué en France par Les Philosophes.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs" role="group" aria-label="Vue du t-shirt">
      <button type="button" class="lfdj-size-pill active" data-view="FACE">Face</button>
      <button type="button" class="lfdj-size-pill" data-view="DOS">Dos</button>
    </div>
    <div class="lfdj-boutique-preview-frame lfdj-generique-preview-frame">
      <img id="lfdj-generique-base" src="./images/Textile/DESCARTES/TSHIRT-FACE-BLANC.webp" alt="T-shirt générique, coloris blanc, face" width="1297" height="1600">
      <img id="lfdj-generique-logo" src="./images/Textile/COLLECTION-GENERIQUE/LOGO-GENERIQUE-FACE-BLANC.webp" alt="Logo, face" width="1297" height="1600">
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-generique-ref-code">GEN-XX-BLA-M-Q1</code>
      <button type="button" id="lfdj-generique-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-color" => "BLANC", "data-code" => "BLA", "color" => "#f4f3f0", "label" => "Blanc"),
          array("data-color" => "NOIR", "data-code" => "NOI", "color" => "#1a1a1a", "label" => "Noir"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Taille</h5>
      <div class="lfdj-size-row" role="group" aria-label="Choix de la taille">
        <button type="button" class="lfdj-size-pill" data-code="XS">XS</button>
        <button type="button" class="lfdj-size-pill" data-code="S">S</button>
        <button type="button" class="lfdj-size-pill active" data-code="M">M</button>
        <button type="button" class="lfdj-size-pill" data-code="L">L</button>
        <button type="button" class="lfdj-size-pill" data-code="XL">XL</button>
        <button type="button" class="lfdj-size-pill" data-code="2XL">2XL</button>
        <button type="button" class="lfdj-size-pill" data-code="3XL">3XL</button>
      </div>
    </div>

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-generique-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">25&nbsp;€ la pièce</span>
      </div>
    </div>

  </div>

</div>

</section>

<section aria-label="Maillots">

<div class="lfdj-divtitle">
  <h4>La suite de la collection</h4>
  <h3>maillots</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-medal"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Des <strong>maillots</strong> personnalisables type sport, issus d'une collaboration entre
    <strong>Estelle</strong> et <strong>Johan</strong>. N'oubliez pas d'indiquer votre nom et le
    numéro que vous préférez, pour un aperçu fidèle au rendu final.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs" role="group" aria-label="Vue du maillot">
      <button type="button" class="lfdj-size-pill active" data-view="BACK">Dos</button>
      <button type="button" class="lfdj-size-pill" data-view="FRONT">Face</button>
    </div>
    <div class="lfdj-jersey-preview-frame">
      <img id="lfdj-jersey-base" src="./images/Textile/MAILLOTS-LFDJ/MAILLOT_BACK_B.webp" alt="Maillot dos, coloris noir" width="7000" height="7000">
      <img id="lfdj-jersey-design" src="./images/Textile/MAILLOTS-LFDJ/DESIGN-BLOODBOWL.webp" alt="Design Blood Bowl" width="7000" height="7000">
      <div id="lfdj-jersey-name" class="lfdj-jersey-text lfdj-jersey-name">VOTRE NOM</div>
      <div id="lfdj-jersey-number" class="lfdj-jersey-text lfdj-jersey-number">00</div>
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-jersey-ref-code">MAI-BB-NOI-M-NOM-00-Q1</code>
      <button type="button" id="lfdj-jersey-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design (dos)</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">

      <?php
        create_collection("/images/Textile/MAILLOTS-LFDJ/", array(
          array("data-file" => "DESIGN-BLOODBOWL.webp", "data-code" => "BB", "label" => "Design Blood Bowl"),
          array("data-file" => "DESIGN-CYBERPUNK.webp", "data-code" => "CPK", "label" => "Design Cyberpunk"),
          array("data-file" => "DESIGN-DRAGON.webp", "data-code" => "DRA", "label" => "Design Dragon"),
          array("data-file" => "DESIGN-TRIO-BLOODBOWL.webp", "data-code" => "TRIBB", "label" => "Design Trio, Blood Bowl en avant"),
          array("data-file" => "DESIGN-TRIO-CYBERPUNK.webp", "data-code" => "TRICPK", "label" => "Design Trio, Cyberpunk en avant"),
          array("data-file" => "DESIGN-TRIO-DRAGON.webp", "data-code" => "TRIDRA", "label" => "Design Trio, Dragon en avant"),
          array("data-file" => "", "data-code" => "VIE", "label" => "Vierge, sans design"),
        ));
      ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-color" => "B", "data-code" => "NOI", "color" => "#171717", "label" => "Noir"),
          array("data-color" => "Y", "data-code" => "JAU", "color" => "#b08a2e", "label" => "Jaune"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Taille</h5>
      <div class="lfdj-size-row" role="group" aria-label="Choix de la taille">
        <button type="button" class="lfdj-size-pill" data-code="XS">XS</button>
        <button type="button" class="lfdj-size-pill" data-code="S">S</button>
        <button type="button" class="lfdj-size-pill active" data-code="M">M</button>
        <button type="button" class="lfdj-size-pill" data-code="L">L</button>
        <button type="button" class="lfdj-size-pill" data-code="XL">XL</button>
        <button type="button" class="lfdj-size-pill" data-code="2XL">2XL</button>
        <button type="button" class="lfdj-size-pill" data-code="3XL">3XL</button>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Personnalisation (dos)</h5>
      <div class="lfdj-jersey-inputs">
        <div class="lfdj-jersey-inputs-row">
          <div>
            <label class="lfdj-jersey-label" for="lfdj-input-name">Nom</label>
            <input type="text" id="lfdj-input-name" maxlength="14" placeholder="Ex. SPIRITO">
          </div>
          <div>
            <label class="lfdj-jersey-label" for="lfdj-input-number">Numéro</label>
            <input type="text" id="lfdj-input-number" class="lfdj-jersey-number-input" maxlength="4" placeholder="Ex. 35 ou XXIV">
          </div>
        </div>
      </div>
    </div>

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">35&nbsp;€ la pièce</span>
        <p class="lfdj-price-caption">
          Fabriqué en Aquitaine (France) par
          <a href="https://printtex64.com/" target="_blank" rel="noopener">Printex64</a>.
        </p>
      </div>
    </div>

  </div>

</div>

</section>

<section aria-label="Sweat Rousseau">

<div class="lfdj-divtitle">
  <h4>Encore un peu de chaleur</h4>
  <h3>sweat rousseau</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-vest"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Le sweat à capuche
    <a href="https://www.lesfilosophes.fr/products/rousseau-hoodie-coton-bio-unisexe-couleurs" target="_blank" rel="noopener">Rousseau</a>,
    personnalisable avec les designs de la collection Pingu imprimés au dos, en coton bio
    fabriqué par Les Philosophes&nbsp;: confection en France, tissu et teinture au Portugal,
    coton de Turquie.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs lfdj-sweat-view-tabs" role="group" aria-label="Vue du sweat">
      <button type="button" class="lfdj-size-pill" data-view="FACE">Face</button>
      <button type="button" class="lfdj-size-pill active" data-view="DOS">Dos</button>
    </div>
    <div class="lfdj-sweat-preview-frame">
      <img id="lfdj-sweat-rousseau-base" src="./images/Textile/ROUSSEAU/SWEAT-DOS-BORDEAUX.webp" alt="Sweat Rousseau, coloris bordeaux" width="2816" height="3457">
      <img id="lfdj-sweat-rousseau-design" src="./images/Textile/COLLECTION-PINGU/SWEAT/DESIGN-PINGU-ALIEN.webp" alt="Design Alien" width="2816" height="3457">
      <img id="lfdj-sweat-rousseau-logo" src="./images/Textile/COLLECTION-PINGU/SWEAT/LOGO-PINGU-FACE-NOIR.webp" alt="Logo, face" width="1297" height="1600" class="lfdj-hidden">
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-sweat-rousseau-ref-code">SWE-ROUS-ALI-BOR-M-Q1</code>
      <button type="button" id="lfdj-sweat-rousseau-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design (dos)</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">
        <?php
        create_collection("/images/Textile/COLLECTION-PINGU/SWEAT/", array(
          array("data-file" => "DESIGN-PINGU-ALIEN.webp", "label" => "Design Alien", "data-code" => "ALI"),
          array("data-file" => "DESIGN-PINGU-BLOODBOWL.webp", "label" => "Design Blood Bowl", "data-code" => "BB"),
          array("data-file" => "DESIGN-PINGU-CYBERPUNK.webp", "label" => "Design Cyberpunk", "data-code" => "CPK"),
          array("data-file" => "DESIGN-PINGU-DRAGON.webp", "label" => "Design Dragon", "data-code" => "DRA"),
          array("data-file" => "DESIGN-PINGU-SPACEMARINE.webp", "label" => "Design Space Marine", "data-code" => "SM"),
          array("data-file" => "DESIGN-PINGU-TRIO-JDF-SPACEMARINE.webp", "label" => "Design Trio, Space Marine en avant", "data-code" => "TRISM"),
          array("data-file" => "DESIGN-PINGU-TRIO-JDR-DRAGON.webp", "label" => "Design Trio, Dragon en avant", "data-code" => "TRIDRA"),
          array("data-file" => "DESIGN-PINGU-QUINTET-DRAGON.webp", "label" => "Design Quintet, Dragon en avant", "data-code" => "QUIDRA"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-color" => "BORDEAUX", "data-code" => "BOR", "color" => "#692329", "label" => "Bordeaux"),
          array("data-color" => "CIEL", "data-code" => "CIE", "color" => "#b9d5f0", "label" => "Ciel"),
          array("data-color" => "MARINE", "data-code" => "MAR", "color" => "#242b3f", "label" => "Marine"),
          array("data-color" => "ROUGE", "data-code" => "RGE", "color" => "#e11421", "label" => "Rouge"),
          array("data-color" => "ROYAL", "data-code" => "ROY", "color" => "#0266cd", "label" => "Royal"),
          array("data-color" => "VERT", "data-code" => "VER", "color" => "#335d50", "label" => "Vert"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Taille</h5>
      <div class="lfdj-size-row" role="group" aria-label="Choix de la taille">
        <button type="button" class="lfdj-size-pill" data-code="XS">XS</button>
        <button type="button" class="lfdj-size-pill" data-code="S">S</button>
        <button type="button" class="lfdj-size-pill active" data-code="M">M</button>
        <button type="button" class="lfdj-size-pill" data-code="L">L</button>
        <button type="button" class="lfdj-size-pill" data-code="XL">XL</button>
        <button type="button" class="lfdj-size-pill" data-code="2XL">2XL</button>
        <button type="button" class="lfdj-size-pill" data-code="3XL">3XL</button>
      </div>
    </div>

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-sweat-rousseau-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">62&nbsp;€ la pièce</span>
      </div>
    </div>

  </div>

</div>

</section>

<section aria-label="Sweat Montaigne">

<div class="lfdj-divtitle">
  <h4>Encore un peu de chaleur</h4>
  <h3>sweat montaigne</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-vest"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Le sweat à capuche
    <a href="https://www.lesfilosophes.fr/products/montaigne-hoodie-zippe-coton-bio-unisexe-classique" target="_blank" rel="noopener">Montaigne</a>,
    personnalisable avec les designs de la collection Pingu imprimés au dos, en coton bio
    fabriqué par Les Philosophes&nbsp;: confection en France, tissu et teinture au Portugal,
    coton de Turquie.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs lfdj-sweat-view-tabs" role="group" aria-label="Vue du sweat">
      <button type="button" class="lfdj-size-pill" data-view="FACE">Face</button>
      <button type="button" class="lfdj-size-pill active" data-view="DOS">Dos</button>
    </div>
    <div class="lfdj-sweat-preview-frame">
      <img id="lfdj-sweat-montaigne-base" src="./images/Textile/MONTAIGNE/SWEAT-DOS-BLANC.webp" alt="Sweat Montaigne, coloris blanc" width="2816" height="3457">
      <img id="lfdj-sweat-montaigne-design" src="./images/Textile/COLLECTION-PINGU/SWEAT/DESIGN-PINGU-ALIEN.webp" alt="Design Alien" width="2816" height="3457">
      <img id="lfdj-sweat-montaigne-logo" src="./images/Textile/COLLECTION-PINGU/SWEAT/LOGO-PINGU-FACE-BLANC.webp" alt="Logo, face" width="1297" height="1600" class="lfdj-hidden">
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-sweat-montaigne-ref-code">SWE-MONT-ALI-BLA-M-Q1</code>
      <button type="button" id="lfdj-sweat-montaigne-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design (dos)</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">
        <?php
        create_collection("/images/Textile/COLLECTION-PINGU/SWEAT/", array(
          array("data-file" => "DESIGN-PINGU-ALIEN.webp", "label" => "Design Alien", "data-code" => "ALI"),
          array("data-file" => "DESIGN-PINGU-BLOODBOWL.webp", "label" => "Design Blood Bowl", "data-code" => "BB"),
          array("data-file" => "DESIGN-PINGU-CYBERPUNK.webp", "label" => "Design Cyberpunk", "data-code" => "CPK"),
          array("data-file" => "DESIGN-PINGU-DRAGON.webp", "label" => "Design Dragon", "data-code" => "DRA"),
          array("data-file" => "DESIGN-PINGU-SPACEMARINE.webp", "label" => "Design Space Marine", "data-code" => "SM"),
          array("data-file" => "DESIGN-PINGU-TRIO-JDF-SPACEMARINE.webp", "label" => "Design Trio, Space Marine en avant", "data-code" => "TRISM"),
          array("data-file" => "DESIGN-PINGU-TRIO-JDR-DRAGON.webp", "label" => "Design Trio, Dragon en avant", "data-code" => "TRIDRA"),
          array("data-file" => "DESIGN-PINGU-QUINTET-DRAGON.webp", "label" => "Design Quintet, Dragon en avant", "data-code" => "QUIDRA"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-color" => "BLANC", "data-code" => "BLA", "color" => "#ffffff", "label" => "Blanc"),
          array("data-color" => "GRISCLAIR", "data-code" => "GRC", "color" => "#b1afb2", "label" => "Gris clair"),
          array("data-color" => "GRISFONCE", "data-code" => "GRF", "color" => "#4f5151", "label" => "Gris foncé"),
          array("data-color" => "NOIR", "data-code" => "NOI", "color" => "#1f1f1f", "label" => "Noir"),
        ));
        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Taille</h5>
      <div class="lfdj-size-row" role="group" aria-label="Choix de la taille">
        <button type="button" class="lfdj-size-pill" data-code="XS">XS</button>
        <button type="button" class="lfdj-size-pill" data-code="S">S</button>
        <button type="button" class="lfdj-size-pill active" data-code="M">M</button>
        <button type="button" class="lfdj-size-pill" data-code="L">L</button>
        <button type="button" class="lfdj-size-pill" data-code="XL">XL</button>
        <button type="button" class="lfdj-size-pill" data-code="2XL">2XL</button>
        <button type="button" class="lfdj-size-pill" data-code="3XL">3XL</button>
      </div>
    </div>

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-sweat-montaigne-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">76&nbsp;€ la pièce</span>
      </div>
    </div>

  </div>

</div>

</section>

<section aria-label="Tote bag">

<div class="lfdj-divtitle">
  <h4>Pour transporter vos dés</h4>
  <h3>tote bag</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-bag-shopping"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Un sac <strong>tote bag</strong> tricolore siglé du logo de l'association, avec le
    label <strong>Origine France Garantie</strong>. Le modèle utilisé est le
    <a href="https://www.europeancatalog.com/fr/ki3205-sac-de-shopping-tricolore-origine-france-garantie.html" target="_blank" rel="noopener">KI3205</a>,
    chez European Catalog.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-boutique-preview-frame lfdj-totbag-preview-frame">
      <img id="lfdj-totbag-base" src="./images/Textile/TOT-BAG/PS_KI3205_NATURAL.webp" alt="Tote bag La Forge des Joueurs, coloris naturel" width="660" height="616">
      <button type="button" class="lfdj-zoom-btn" aria-label="Agrandir l'image">+</button>
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-totbag-ref-code">TOT-NAT-Q1</code>
      <button type="button" id="lfdj-totbag-ref-copy" class="lfdj-ref-copy-btn-small" aria-label="Copier la référence"><i class="fa-regular fa-copy" aria-hidden="true"></i></button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group lfdj-qty-price-row">
      <div>
        <h5>Quantité</h5>
        <div class="lfdj-qty-stepper">
          <button type="button" class="lfdj-qty-btn" data-action="decrement" aria-label="Diminuer la quantité">&minus;</button>
          <input type="number" id="lfdj-input-totbag-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline">18&nbsp;€ la pièce</span>
        <p class="lfdj-price-caption">
          Coloris naturel uniquement. Tarif de départ, pourra être ajusté selon les
          quantités commandées.
        </p>
      </div>
    </div>

  </div>

</div>

</section>

<hr class="lfdj-midpage">

<script src="./importation-js/boutique-common.js"></script>
<script src="./importation-js/boutique.js"></script>
<script src="./importation-js/pipito.js"></script>
<script src="./importation-js/generique.js"></script>
<script src="./importation-js/totbag.js"></script>
<script src="./importation-js/maillots.js"></script>
<script src="./importation-js/sweats.js"></script>

<?php require('importation-php/footer.php'); ?>
</body>
</html>
