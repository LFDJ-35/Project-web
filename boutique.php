
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
    echo ("<span>Vierge</span>");
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
    <a href="https://www.instagram.com/estelle_arte/" target="_blank" rel="noopener"><strong>Estelle</strong></a>,
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

<div class="lfdj-notice-box">
  <p>
    <strong>Un article précommandé est un engagement&nbsp;:</strong> il devra être réglé
    dès que la commande groupée sera passée auprès du prestataire. C'est grâce à vos
    précommandes qu'on peut estimer nos tarifs dégressifs et en faire profiter tout le
    monde&nbsp;: une annulation est problématique pour l'ensemble du groupe.
    Soyons raisonnables, on compte sur vous&nbsp;!
  </p>
</div>

<div class="lfdj-divtitle">
  <h4>Composez votre style</h4>
  <h3>collection pingu</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-palette"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Le design choisi est imprimé <strong>au dos du t-shirt</strong>, comme sur l'aperçu ci-dessous.
    Designs imaginés par <strong>Estelle</strong> (pseudo <strong>Pingu</strong>&nbsp;🐧),
    illustratrice de l'association&nbsp;: en courtoisie pour son travail bénévole, un lien vers son
    <a href="https://www.instagram.com/estelle_arte/" target="_blank" rel="noopener">Instagram</a> est indiqué ici.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-boutique-preview-frame">
      <img id="lfdj-tshirt-base" src="./images/Textile/COLLECTION-PINGU/TSHIRT/TSHIRT-BLANC.webp" alt="T-shirt dos, coloris blanc" width="2050" height="2529">
      <img id="lfdj-tshirt-design" src="./images/Textile/COLLECTION-PINGU/TSHIRT/DESIGN-ALIEN.webp" alt="Design Alien" width="2050" height="2529">
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-ref-code">EST-ALI-BLA-M-Q1</code>
      <button type="button" id="lfdj-ref-copy" class="lfdj-ref-copy-btn-small">Copier</button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">

      <?php
        create_collection("/images/Textile/COLLECTION-PINGU/TSHIRT/", array(
          array("data-file" => "DESIGN-ALIEN.webp", "data-code" => "ALI", "label" => "Design Alien"),
          array("data-file" => "DESIGN-BLOODBOWL.webp", "data-code" => "BB", "label" => "Design Blood Bowl"),
          array("data-file" => "DESIGN-BLOODBOWLGOLD.webp", "data-code" => "BBG", "label" => "Design Blood Bowl Gold"),
          array("data-file" => "DESIGN-CYBERPUNKGOLD.webp", "data-code" => "CPG", "label" => "Design Cyberpunk Gold"),
          array("data-file" => "DESIGN-DRAGON.webp", "data-code" => "DRA", "label" => "Design Dragon"),
          array("data-file" => "DESIGN-DRAGONGOLD.webp", "data-code" => "DRG", "label" => "Design Dragon Gold"),
          array("data-file" => "DESIGN-SPACEMARINE.webp", "data-code" => "SM", "label" => "Design Space Marine"),
        ));
      ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-file" => "TSHIRT-BLANC.webp", "data-code" => "BLA", "color" => "#f4f3f0", "label" => "Blanc"),
          array("data-file" => "TSHIRT-BLEU.webp", "data-code" => "BLE", "color" => "#7189ab", "label" => "Bleu"),
          array("data-file" => "TSHIRT-JAUNE.webp", "data-code" => "JAU", "color" => "#c2a05a", "label" => "Jaune"),
          array("data-file" => "TSHIRT-NOIR.webp", "data-code" => "NOI", "color" => "#222222", "label" => "Noir"),
          array("data-file" => "TSHIRT-ROSE.webp", "data-code" => "ROS", "color" => "#c98f8a", "label" => "Rose"),
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
        <span class="lfdj-price-tag-inline">23&nbsp;€ la pièce</span>
        <p class="lfdj-price-caption">
          Coton bio, fabriqué en France (référence
          <a href="https://www.lesfilosophes.fr/products/descartes-t-shirt-en-coton-bio-fabrique-en-france" target="_blank" rel="noopener">Descartes, Les Philosophes</a>).
          Prix fixe, ne pourra que baisser.
        </p>
      </div>
    </div>

  </div>

</div>

<div class="lfdj-divtitle">
  <h4>Un peu plus perso</h4>
  <h3>collection pipito</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-wand-magic-sparkles"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Une petite collection plus personnelle, imaginée par <strong>Spirito</strong> (Johan B.),
    membre de l'association&nbsp;: en courtoisie pour son travail bénévole, un lien vers son
    site <a href="https://www.spirito.fr" target="_blank" rel="noopener">www.spirito.fr</a> est indiqué ici.
    Par souci de transparence, <strong>sachez que ces designs ont été réalisés en partie
    à l'aide de l'intelligence artificielle</strong>.
  </p>
  <p>
    Le design choisi est imprimé <strong>devant</strong> le t-shirt, comme sur l'aperçu ci-dessous.
    Disponible uniquement en <strong>noir</strong>, même tarif que la collection Pingu.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-boutique-preview-frame">
      <img id="lfdj-pipito-base" src="./images/Textile/COLLECTION-PIPITO/TSHIRT_B-BEER.webp" alt="T-shirt La Forge des Joueurs, design Actuellement en repos long" width="2050" height="2529">
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-pipito-ref-code">PIP-BEE-NOI-M-Q1</code>
      <button type="button" id="lfdj-pipito-ref-copy" class="lfdj-ref-copy-btn-small">Copier</button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">

        <?php
        create_collection("/images/Textile/COLLECTION-PIPITO/", array(
          array("data-file" => "TSHIRT_B-BEER.webp", "data-code" => "BEE", "label" => "Actuellement en repos long"),
          array("data-file" => "TSHIRT_B-COFFRE.webp", "data-code" => "COF", "label" => "Coffret vraiment gourmand"),
          array("data-file" => "TSHIRT_B-MENHIR.webp", "data-code" => "MEN", "label" => "Solide comme un menhir"),
          array("data-file" => "TSHIRT_B-PIOU.webp", "data-code" => "PIO", "label" => "Grand destin, petit héro"),
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
        <span class="lfdj-price-tag-inline">23&nbsp;€ la pièce</span>
        <p class="lfdj-price-caption">
          Coton bio, fabriqué en France (référence
          <a href="https://www.lesfilosophes.fr/products/descartes-t-shirt-en-coton-bio-fabrique-en-france" target="_blank" rel="noopener">Descartes, Les Philosophes</a>).
          Prix fixe, ne pourra que baisser.
        </p>
      </div>
    </div>

  </div>

</div>

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
    autres collections de t-shirts.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-boutique-preview-frame lfdj-generique-preview-frame">
      <img id="lfdj-generique-base" src="./images/Textile/COLLECTION-GENERIQUE/TSHIRT_W-GENERIQUE.webp" alt="T-shirt générique, coloris blanc, face et dos" width="4864" height="3242">
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-generique-ref-code">GEN-XX-BLA-M-Q1</code>
      <button type="button" id="lfdj-generique-ref-copy" class="lfdj-ref-copy-btn-small">Copier</button>
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" role="group" aria-label="Choix du coloris">
        <?php
        create_color_swatches(array(
          array("data-file" => "TSHIRT_W-GENERIQUE.webp", "data-code" => "BLA", "color" => "#f4f3f0", "label" => "Blanc"),
          array("data-file" => "TSHIRT_Y-GENERIQUE.webp", "data-code" => "JAU", "color" => "#c2a05a", "label" => "Jaune"),
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
        <span class="lfdj-price-tag-inline">23&nbsp;€ la pièce</span>
        <p class="lfdj-price-caption">
          Coton bio, fabriqué en France (référence
          <a href="https://www.lesfilosophes.fr/products/descartes-t-shirt-en-coton-bio-fabrique-en-france" target="_blank" rel="noopener">Descartes, Les Philosophes</a>).
          Prix fixe, ne pourra que baisser.
        </p>
      </div>
    </div>

  </div>

</div>

<div class="lfdj-divtitle">
  <h4>La suite de la collection</h4>
  <h3>maillots</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-medal"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Second volet de la boutique&nbsp;: des <strong>maillots</strong> personnalisables,
    réalisés en collaboration entre <strong>Estelle</strong> et <strong>Johan</strong>,
    disponibles en <strong>noir</strong> ou en <strong>jaune</strong>, avec un design
    au choix pour le dos (ou aucun, en version <strong>vierge</strong>). La
    <strong>face avant n'est pas personnalisable</strong>&nbsp;: elle reste telle quelle,
    frappée du logo de l'association.
  </p>
  <p>
    Au dos, indiquez votre <strong>nom</strong> et votre <strong>numéro</strong>
    pour un aperçu fidèle au rendu final.
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
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-jersey-ref-code">MAI-BB-NOI-M-NOM-00-Q1</code>
      <button type="button" id="lfdj-jersey-ref-copy" class="lfdj-ref-copy-btn-small">Copier</button>
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
          Fabriqué en Aquitaine 🇫🇷 par
          <a href="https://printtex64.com/" target="_blank" rel="noopener">Printex64</a>.
        </p>
      </div>
    </div>

  </div>

</div>

<div class="lfdj-divtitle">
  <h4>Encore un peu de chaleur</h4>
  <h3>sweats</h3>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-vest"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Troisième volet de la boutique&nbsp;: deux modèles de <strong>sweats à capuche</strong>,
    <strong>Rousseau</strong> (classique) et <strong>Montaigne</strong> (zippé),
    personnalisables avec les designs de la collection Pingu imprimés au dos.
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-jersey-tabs" role="group" aria-label="Choix du modèle">
      <button type="button" class="lfdj-size-pill active" data-product="ROUSSEAU">Rousseau</button>
      <button type="button" class="lfdj-size-pill" data-product="MONTAIGNE">Montaigne</button>
    </div>
    <div class="lfdj-sweat-preview-frame">
      <img id="lfdj-sweat-base" src="./images/Textile/COLLECTION-PINGU/SWEAT/SWEAT-ROUSSEAU-BLEU.webp" alt="Sweat Rousseau, coloris bleu" width="2816" height="3457">
      <img id="lfdj-sweat-design" src="./images/Textile/COLLECTION-PINGU/SWEAT/DESIGN-ALIEN.webp" alt="Design Alien" width="2816" height="3457">
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-sweat-ref-code">SWE-ROUS-ALI-BLE-M-Q1</code>
      <button type="button" id="lfdj-sweat-ref-copy" class="lfdj-ref-copy-btn-small">Copier</button>
    </p>
    <p class="lfdj-sweat-disclaimer">
      Aperçu indicatif&nbsp;: le rendu réel du tissu et de la coupe est visible sur les fiches
      <a href="https://www.lesfilosophes.fr/products/rousseau-hoodie-coton-bio-unisexe-couleurs" target="_blank" rel="noopener">Rousseau</a>
      et
      <a href="https://www.lesfilosophes.fr/products/montaigne-hoodie-zippe-coton-bio-unisexe-classique" target="_blank" rel="noopener">Montaigne</a>.
    </p>
  </div>

  <div class="lfdj-boutique-controls">

    <div class="lfdj-boutique-group">
      <h5>Design (dos)</h5>
      <div class="lfdj-design-grid" role="group" aria-label="Choix du design">
        <?php

        create_collection("/images/Textile/COLLECTION-PINGU/SWEAT/", array(
          array("data-file" => "DESIGN-ALIEN.webp", "label" => "Design Alien", "data-code" => "ALI"),
          array("data-file" => "DESIGN-BLOODBOWL.webp", "label" => "Design Blood Bowl", "data-code" => "BB"),
          array("data-file" => "DESIGN-BLOODBOWLGOLD.webp", "label" => "Design Blood Bowl Gold", "data-code" => "BBG"),
          array("data-file" => "DESIGN-CYBERPUNKGOLD.webp", "label" => "Design Cyberpunk Gold", "data-code" => "CPG"),
          array("data-file" => "DESIGN-DRAGON.webp", "label" => "Design Dragon", "data-code" => "DRA"),
          array("data-file" => "DESIGN-DRAGONGOLD.webp", "label" => "Design Dragon Gold", "data-code" => "DRG"),
          array("data-file" => "DESIGN-SPACEMARINE.webp", "label" => "Design Space Marine", "data-code" => "SM"),
        ));

        ?>
      </div>
    </div>

    <div class="lfdj-boutique-group">
      <h5>Coloris</h5>
      <div class="lfdj-color-row" data-product-colors="ROUSSEAU" role="group" aria-label="Choix du coloris Rousseau">
        <?php
        create_color_swatches(array(
          array("data-file" => "BLEU", "data-code" => "BLE", "color" => "#2a3e62", "label" => "Bleu"),
          array("data-file" => "ROUGE", "data-code" => "RGE", "color" => "#833748", "label" => "Rouge"),
          array("data-file" => "VERT", "data-code" => "VER", "color" => "#396c69", "label" => "Vert"),
        ));
        ?>
      </div>
      <div class="lfdj-color-row lfdj-hidden" data-product-colors="MONTAIGNE" role="group" aria-label="Choix du coloris Montaigne">
        <?php
        create_color_swatches(array(
          array("data-file" => "BLANC", "data-code" => "BLA", "color" => "#f3f3f3", "label" => "Blanc"),
          array("data-file" => "GRIS", "data-code" => "GRI", "color" => "#b4b4b4", "label" => "Gris"),
          array("data-file" => "GRISFONCE", "data-code" => "GRF", "color" => "#696969", "label" => "Gris foncé"),
          array("data-file" => "NOIR", "data-code" => "NOI", "color" => "#151515", "label" => "Noir"),
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
          <input type="number" id="lfdj-input-sweat-qty" class="lfdj-qty-value" min="1" step="1" value="1" inputmode="numeric">
          <button type="button" class="lfdj-qty-btn" data-action="increment" aria-label="Augmenter la quantité">+</button>
        </div>
      </div>
      <div class="lfdj-price-inline">
        <span class="lfdj-price-tag-inline" id="lfdj-sweat-price">60&nbsp;€ la pièce</span>
        <p class="lfdj-price-caption">
          Coton bio (référence
          <a href="https://www.lesfilosophes.fr/products/rousseau-hoodie-coton-bio-unisexe-couleurs" target="_blank" rel="noopener">Rousseau</a>
          et
          <a href="https://www.lesfilosophes.fr/products/montaigne-hoodie-zippe-coton-bio-unisexe-classique" target="_blank" rel="noopener">Montaigne</a>,
          Les Philosophes). Confection 🇫🇷, tissu &amp; teinture 🇵🇹, coton 🇹🇷. Tarif indicatif.
        </p>
      </div>
    </div>

  </div>

</div>

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
    label <strong>Origine France Garantie</strong>&nbsp;🇫🇷 (référence
    <a href="https://www.europeancatalog.com/fr/ki3205-sac-de-shopping-tricolore-origine-france-garantie.html" target="_blank" rel="noopener">KI3205, European Catalog</a>).
  </p>
</div>

<div class="lfdj-boutique-wrap">

  <div class="lfdj-boutique-preview">
    <div class="lfdj-boutique-preview-frame lfdj-totbag-preview-frame">
      <img id="lfdj-totbag-base" src="./images/Textile/TOT-BAG/PS_KI3205_NATURAL.webp" alt="Tote bag La Forge des Joueurs, coloris naturel" width="660" height="616">
    </div>
    <p class="lfdj-ref-inline">
      Réf.&nbsp;: <code id="lfdj-totbag-ref-code">TOT-NAT-Q1</code>
      <button type="button" id="lfdj-totbag-ref-copy" class="lfdj-ref-copy-btn-small">Copier</button>
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
