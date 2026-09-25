<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>Palmarès | La Forge des Joueurs</title>
<meta name="description" content="Palmarès de La Forge des Joueurs : le podium de tous les tournois et compétitions internes organisés par l'association." />
<?php require('importation-php/regles.php'); ?>
<link rel="stylesheet" href="./css/palmares.css">
</head>

<body class="lfdj-maincontainer">

<?php require('importation-php/menu.php'); ?>

<?php
// Palmarès : un événement = une entrée avec son jeu, sa date, son podium (et un
// lien vers sa page dédiée si elle existe). Nouvelle compétition => nouvelle entrée ici.
$lfdj_palmares_events = [
  [
    "title" => "Vitré Bowl Cup — Saison 1",
    "game" => "Blood Bowl",
    "icon" => "fa-solid fa-chess-knight",
    "date" => "Saison 2025-2026",
    "link" => null,
    "podium" => [
      ["place" => 1, "name" => "Seth29", "detail" => "Les jaguars insaisissables — Amazones"],
      ["place" => 2, "name" => "Kalimsshar57", "detail" => "Lorien Masters (of puppets) — Elfes sylvains"],
      ["place" => 3, "name" => "Sardaukar [rudy]", "detail" => "Les rats musqués — Skavens"],
    ],
  ],
  [
    "title" => "Tournoi Roots",
    "game" => "Roots",
    "icon" => "fa-solid fa-dove",
    "date" => "Mars 2026",
    "link" => null,
    "podium" => [
      ["place" => 1, "name" => "Estelle", "detail" => ""],
      ["place" => 2, "name" => "Spirito", "detail" => ""],
      ["place" => 3, "name" => "Guerric", "detail" => ""],
    ],
  ],
];

/**
 * Affiche le podium compact (1er/2e/3e) d'un événement du palmarès :
 * un petit en-tête, puis trois lignes or/argent/cuivre.
 */
function lfdj_palmares_event(array $event): void
{
  ?>
  <div class="lfdj-palmares-group">
    <h3 class="lfdj-palmares-group-title">
      <i class="<?= htmlspecialchars($event["icon"]) ?>" aria-hidden="true"></i>
      <?= htmlspecialchars($event["title"]) ?>
      <span class="lfdj-palmares-group-meta">
        <?= htmlspecialchars($event["game"]) ?><?= $event["date"] ? " · " . htmlspecialchars($event["date"]) : "" ?>
      </span>
    </h3>

    <?php foreach ($event["podium"] as $p): ?>
    <div class="lfdj-palmares-row lfdj-palmares-row--<?= (int) $p["place"] ?>">
      <span class="lfdj-palmares-row-place"><?= (int) $p["place"] ?></span>
      <span class="lfdj-palmares-row-name"><?= htmlspecialchars($p["name"]) ?></span>
      <?php if (!empty($p["detail"])): ?>
        <span class="lfdj-palmares-row-detail"><?= htmlspecialchars($p["detail"]) ?></span>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <?php if ($event["link"]): ?>
      <a class="lfdj-palmares-group-link" href="<?= htmlspecialchars($event["link"]["href"]) ?>"><?= htmlspecialchars($event["link"]["label"]) ?></a>
    <?php endif; ?>
  </div>
  <?php
}
?>

<div class="lfdj-divtitle">
  <h4>Ceux qui sont montés sur la boîte</h4>
  <h2>Palmarès</h2>
  <div class="lfdj-title-icon">
    <i class="fa-solid fa-medal"></i>
  </div>
</div>

<div class="lfdj-bloc-text">
  <p>
    Le podium de tous les tournois et compétitions internes organisés à
    La Forge des Joueurs, tous jeux confondus. Une nouvelle compétition,
    un nouveau podium : cette page s'agrandit au fil des événements.
  </p>
</div>

<div class="lfdj-palmares-hero">
  <img src="./images/Palmares/IMG-PALMARES-1.webp" alt="Trophées imprimés en 3D du tournoi 2026 de La Forge des Joueurs" width="1000" height="1000" loading="lazy">
</div>

<div class="lfdj-palmares-list">
  <?php foreach ($lfdj_palmares_events as $event): lfdj_palmares_event($event); endforeach; ?>
</div>

<hr class="lfdj-midpage">

<?php require('importation-php/footer.php'); ?>
</body>
</html>
