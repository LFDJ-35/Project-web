<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>Blood Bowl — Vitré Bowl Cup | La Forge des Joueurs</title>
<meta name="description" content="Blood Bowl à la Forge des Joueurs : présentation, ligue interne Vitré Bowl Cup, Saison 2 en préparation et classement final de la Saison 1." />
<?php require('importation-php/regles.php'); ?>
<link rel="stylesheet" href="./css/bloodbowl.css">
</head>

<body class="lfdj-maincontainer">

<?php require('importation-php/menu.php'); ?>

<?php
// Emoji et couleur propres à chaque équipe, choisis sur son nom plutôt que sur sa race
// (deux équipes peuvent partager une race, jamais un nom). La couleur reprend la teinte
// dominante de l'emoji, pour que la bordure de la carte lui corresponde vraiment.
$lfdj_bb_s1_teams = [
  ["name" => "tout glisse sur ma peau !", "race" => "Hommes Lézard", "coach" => "droops", "emoji" => "💪🏻", "color" => "#c88a5a"],
  ["name" => "Les savonnettes", "race" => "Amazones", "coach" => "Hinoto", "emoji" => "🧼", "color" => "#e07aa8"],
  ["name" => "Bella Chaos", "race" => "Élus du Chaos", "coach" => "JokerParano", "emoji" => "😈", "color" => "#8e44ad"],
  ["name" => "Lorien Masters (of puppets)", "race" => "Elfes sylvains", "coach" => "Kalimsshar57", "emoji" => "🎭", "color" => "#7d5ba6"],
  ["name" => "Les Sang Peur", "race" => "Vampires", "coach" => "LaBarbe", "emoji" => "🩸", "color" => "#a5291e"],
  ["name" => "Bière brune et Salade de phalanges", "race" => "Nains", "coach" => "Lucachouca", "emoji" => "🍻", "color" => "#c9852f"],
  ["name" => "Les Korrigans Volants", "race" => "Gnomes", "coach" => "OggyOneKenobi", "emoji" => "⛏️", "color" => "#8b6b4a"],
  ["name" => "Les rats musqués", "race" => "Skavens", "coach" => "Sardaukar [rudy]", "emoji" => "🐀", "color" => "#7d7d78"],
  ["name" => "Les jaguars insaisissables", "race" => "Amazones", "coach" => "seth29", "emoji" => "🐆", "color" => "#d9642b"],
  ["name" => "Cuetzpallin Nomades", "race" => "Hommes Lézard", "coach" => "Topaz", "emoji" => "🦎", "color" => "#4f9153"],
];

$lfdj_bb_team_emoji = array_column($lfdj_bb_s1_teams, "emoji", "name");
$lfdj_bb_s1_team_count = count($lfdj_bb_s1_teams);

/**
 * Affiche la carte d'une équipe (emoji, nom, race, coach), utilisée pour la Saison 1
 * comme pour la Saison 2 afin d'éviter de dupliquer ce bloc de markup.
 */
function lfdj_bb_team_card(array $team): void
{
  $color = htmlspecialchars($team["color"] ?? "var(--primary-color)");
  ?>
  <article class="lfdj-bb-team-card" style="--lfdj-bb-team-color: <?= $color ?>;">
    <h4><span aria-hidden="true"><?= $team["emoji"] ?? "🎲" ?></span> <?= htmlspecialchars($team["name"]) ?></h4>
    <span class="lfdj-bb-team-race"><?= htmlspecialchars($team["race"]) ?></span>
    <span class="lfdj-bb-team-coach"><?= htmlspecialchars($team["coach"]) ?></span>
  </article>
  <?php
}

$lfdj_bb_s1_matches = [
  "J1" => [
    ["a" => "Les Korrigans Volants", "score" => "0 - 2", "b" => "tout glisse sur ma peau !"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "1 - 0", "b" => "Les Sang Peur"],
    ["a" => "Les savonnettes", "score" => "0 - 2", "b" => "Lorien Masters (of puppets)"],
    ["a" => "Les rats musqués", "score" => "1 - 0", "b" => "Cuetzpallin Nomades"],
    ["a" => "Bella Chaos", "score" => "0 - 2", "b" => "Les jaguars insaisissables"],
  ],
  "J2" => [
    ["a" => "Les Sang Peur", "score" => "0 - 3", "b" => "Les savonnettes"],
    ["a" => "Les jaguars insaisissables", "score" => "3 - 0", "b" => "Les Korrigans Volants"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "1 - 0", "b" => "Bella Chaos"],
    ["a" => "tout glisse sur ma peau !", "score" => "1 - 2", "b" => "Cuetzpallin Nomades"],
    ["a" => "Lorien Masters (of puppets)", "score" => "1 - 0", "b" => "Les rats musqués"],
  ],
  "J3" => [
    ["a" => "Les jaguars insaisissables", "score" => "1 - 0", "b" => "Cuetzpallin Nomades"],
    ["a" => "Lorien Masters (of puppets)", "score" => "3 - 3", "b" => "tout glisse sur ma peau !"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "1 - 0", "b" => "Les savonnettes"],
    ["a" => "Les Sang Peur", "score" => "0 - 3", "b" => "Les rats musqués"],
    ["a" => "Les Korrigans Volants", "score" => "3 - 1", "b" => "Bella Chaos"],
  ],
  "J4" => [
    ["a" => "Les jaguars insaisissables", "score" => "2 - 1", "b" => "Lorien Masters (of puppets)"],
    ["a" => "Les Sang Peur", "score" => "0 - 4", "b" => "tout glisse sur ma peau !"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "2 - 0", "b" => "Les rats musqués"],
    ["a" => "Les savonnettes", "score" => "2 - 0", "b" => "Bella Chaos"],
    ["a" => "Les Korrigans Volants", "score" => "2 - 2", "b" => "Cuetzpallin Nomades"],
  ],
  "J5" => [
    ["a" => "Lorien Masters (of puppets)", "score" => "3 - 0", "b" => "Les Korrigans Volants"],
    ["a" => "Les jaguars insaisissables", "score" => "2 - 1", "b" => "Les Sang Peur"],
    ["a" => "Cuetzpallin Nomades", "score" => "1 - 1", "b" => "Bella Chaos"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "1 - 1", "b" => "tout glisse sur ma peau !"],
    ["a" => "Les rats musqués", "score" => "2 - 1", "b" => "Les savonnettes"],
  ],
  "J6" => [
    ["a" => "Cuetzpallin Nomades", "score" => "1 - 1", "b" => "Lorien Masters (of puppets)"],
    ["a" => "Bella Chaos", "score" => "0 - 2", "b" => "Les rats musqués"],
    ["a" => "Les jaguars insaisissables", "score" => "1 - 0", "b" => "Bière brune et Salade de phalanges"],
    ["a" => "Les Sang Peur", "score" => "1 - 2", "b" => "Les Korrigans Volants"],
    ["a" => "Les savonnettes", "score" => "1 - 2", "b" => "tout glisse sur ma peau !"],
  ],
  "J7" => [
    ["a" => "Bella Chaos", "score" => "1 - 2", "b" => "Lorien Masters (of puppets)"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "1 - 3", "b" => "Les Korrigans Volants"],
    ["a" => "Les jaguars insaisissables", "score" => "1 - 0", "b" => "Les savonnettes"],
    ["a" => "Les rats musqués", "score" => "0 - 2", "b" => "tout glisse sur ma peau !"],
    ["a" => "Cuetzpallin Nomades", "score" => "1 - 1", "b" => "Les Sang Peur"],
  ],
  "J8" => [
    ["a" => "Les Sang Peur", "score" => "0 - 4", "b" => "Lorien Masters (of puppets)"],
    ["a" => "Les jaguars insaisissables", "score" => "1 - 2", "b" => "Les rats musqués"],
    ["a" => "Cuetzpallin Nomades", "score" => "1 - 2", "b" => "Bière brune et Salade de phalanges"],
    ["a" => "Bella Chaos", "score" => "2 - 1", "b" => "tout glisse sur ma peau !"],
    ["a" => "Les savonnettes", "score" => "1 - 1", "b" => "Les Korrigans Volants"],
  ],
  "J9" => [
    ["a" => "Bella Chaos", "score" => "3 - 1", "b" => "Les Sang Peur"],
    ["a" => "Les jaguars insaisissables", "score" => "2 - 1", "b" => "tout glisse sur ma peau !"],
    ["a" => "Bière brune et Salade de phalanges", "score" => "2 - 3", "b" => "Lorien Masters (of puppets)"],
    ["a" => "Cuetzpallin Nomades", "score" => "2 - 0", "b" => "Les savonnettes"],
    ["a" => "Les rats musqués", "score" => "2 - 0", "b" => "Les Korrigans Volants"],
  ],
];

$lfdj_bb_s1_journee_count = count($lfdj_bb_s1_matches);
$lfdj_bb_s1_match_count = array_sum(array_map("count", $lfdj_bb_s1_matches));

/**
 * Calcule le classement final à partir des résultats de tous les matchs.
 * 3 points par victoire, 1 point par match nul, 0 point par défaite.
 * Lève une erreur explicite si un match référence un nom d'équipe inconnu
 * (faute de frappe lors d'un ajout/édition), plutôt que de fausser le classement en silence.
 */
function lfdj_bb_compute_standings(array $teams, array $matchdays)
{
  $stats = [];
  foreach ($teams as $team) {
    // Fusionne les infos de l'équipe (name/race/coach) avec ses stats à zéro
    $stats[$team["name"]] = $team + ["played" => 0, "w" => 0, "d" => 0, "l" => 0, "for" => 0, "against" => 0, "pts" => 0];
  }

  foreach ($matchdays as $journee => $matches) {
    foreach ($matches as $match) {
      foreach (["a", "b"] as $side) {
        if (!isset($stats[$match[$side]])) {
          throw new \RuntimeException("Équipe inconnue \"{$match[$side]}\" dans un match de {$journee} : vérifie l'orthographe par rapport à \$lfdj_bb_s1_teams.");
        }
      }
      [$scoreA, $scoreB] = array_map("intval", explode(" - ", $match["score"]));
      $a = &$stats[$match["a"]];
      $b = &$stats[$match["b"]];

      $a["played"]++;
      $b["played"]++;
      $a["for"] += $scoreA;
      $a["against"] += $scoreB;
      $b["for"] += $scoreB;
      $b["against"] += $scoreA;

      if ($scoreA > $scoreB) {
        $a["w"]++;
        $a["pts"] += 3;
        $b["l"]++;
      } elseif ($scoreB > $scoreA) {
        $b["w"]++;
        $b["pts"] += 3;
        $a["l"]++;
      } else {
        $a["d"]++;
        $b["d"]++;
        $a["pts"]++;
        $b["pts"]++;
      }
      unset($a, $b);
    }
  }

  foreach ($stats as &$s) {
    $s["diff"] = $s["for"] - $s["against"];
  }
  unset($s);

  $standings = array_values($stats);
  usort($standings, fn($x, $y) => [$y["pts"], $y["diff"], $y["for"]] <=> [$x["pts"], $x["diff"], $x["for"]]);

  return $standings;
}

$lfdj_bb_s1_standings = lfdj_bb_compute_standings($lfdj_bb_s1_teams, $lfdj_bb_s1_matches);
$lfdj_bb_s1_champion = $lfdj_bb_s1_standings[0];

/**
 * Renvoie l'équipe du classement avec la valeur la plus haute (ou la plus basse) sur un champ donné.
 */
function lfdj_bb_best_by(array $standings, string $field, bool $lowest = false)
{
  $best = $standings[0];
  foreach ($standings as $s) {
    if ($lowest ? $s[$field] < $best[$field] : $s[$field] > $best[$field]) {
      $best = $s;
    }
  }
  return $best;
}

$lfdj_bb_s1_best_attack = lfdj_bb_best_by($lfdj_bb_s1_standings, "for");
$lfdj_bb_s1_best_defense = lfdj_bb_best_by($lfdj_bb_s1_standings, "against", true);

// Achievements de la saison : un seul lauréat par titre, jamais de 2e/3e ex-æquo choisi
// arbitrairement. Ceux avec "team" viennent des fiches d'équipe Mordorbihan (stats
// individuelles non recalculables depuis les seuls scores de matchs) ; les autres sont
// calculés depuis le classement déjà présent sur la page.
$lfdj_bb_s1_achievements = [
  ["title" => "Le Sprint d'Or", "icon" => "fa-solid fa-trophy", "name" => "La Flèche", "team" => "Bière brune et Salade de phalanges", "stat" => "9 Touchdown"],
  ["title" => "La Main d'Argent", "icon" => "fa-solid fa-hands", "name" => "Layniel", "team" => "Lorien Masters (of puppets)", "stat" => "16 passes réussies"],
  ["title" => "L'Âme de l'Équipe", "icon" => "fa-solid fa-star", "name" => "Layniel", "team" => "Lorien Masters (of puppets)", "stat" => "4x MVP"],
  ["title" => "La Légende", "icon" => "fa-solid fa-crown", "name" => "Glorfindel", "team" => "Lorien Masters (of puppets)", "stat" => "12 EXP"],
  ["title" => "Le Boucher", "icon" => "fa-solid fa-skull", "name" => "Homme-Arbre", "team" => "Les Korrigans Volants", "stat" => "8 sorties infligées"],
  ["title" => "Le Rouleau Compresseur", "icon" => "fa-solid fa-fire", "name" => $lfdj_bb_s1_best_attack["name"], "stat" => $lfdj_bb_s1_best_attack["for"] . " Touchdown"],
  ["title" => "Le Mur Infranchissable", "icon" => "fa-solid fa-shield-halved", "name" => $lfdj_bb_s1_best_defense["name"], "stat" => $lfdj_bb_s1_best_defense["against"] . " Touchdown"],
  ["title" => "Les Rois du Sale Coup", "icon" => "fa-solid fa-hand-fist", "name" => "tout glisse sur ma peau !", "stat" => "19 sorties infligées"],
];

// Saison 2 : les 10 équipes confirmées sur Mordorbihan, réparties dans les 2 poules
// officielles de la compétition. Aucun résultat n'est encore tombé au moment de la
// rédaction de cette page.
$lfdj_bb_s2_pools = [
  "Poule 1" => [
    ["name" => "Fungus Flingerz", "race" => "Snotlings", "coach" => "Kalimsshar57", "emoji" => "🍄", "color" => "#c0533b"],
    ["name" => "Saumons Enragés United", "race" => "Nordiques", "coach" => "Sardaukar [rudy]", "emoji" => "🐟", "color" => "#e8825a"],
    ["name" => "toc toc, ca va couper", "race" => "Gobelins", "coach" => "droops", "emoji" => "🔪", "color" => "#8c96a0"],
    ["name" => "Etoiles rouges de Fondcombe", "race" => "Union elfique", "coach" => "TKPcerbros", "emoji" => "🌟", "color" => "#d4af37"],
    ["name" => "Camillionaires", "race" => "Hommes Lézard", "coach" => "Nexus Nihil", "emoji" => "🦎", "color" => "#4f9153"],
  ],
  "Poule 2" => [
    ["name" => "Caresses et douceurs", "race" => "Élus du Chaos", "coach" => "seth29", "emoji" => "🍬", "color" => "#e07aa8"],
    ["name" => "Les Panthères de Khemet", "race" => "Amazones", "coach" => "Spirito", "emoji" => "🐈‍⬛", "color" => "#4a4a52"],
    ["name" => "Les sablés de la fosse", "race" => "Rois des tombes", "coach" => "JokerParano", "emoji" => "🍪", "color" => "#c9a063"],
    ["name" => "Les Chevaliers de la Table Basse", "race" => "Bretonniens", "coach" => "OggyOneKenobi", "emoji" => "⚔️", "color" => "#3b5b8c"],
    ["name" => "Rotten Queen Club", "race" => "Horreurs nécromantiques", "coach" => "Niktazheur", "emoji" => "💀", "color" => "#5a7a4a"],
  ],
];

$lfdj_bb_s2_team_count = array_sum(array_map("count", $lfdj_bb_s2_pools));
?>

<div class="lfdj-bb-season-tabs">
  <nav class="lfdj-bb-season-tabs-nav" aria-label="Saisons de la Vitré Bowl Cup">
    <button type="button" class="lfdj-bb-season-tab-btn is-active" data-tab="presentation"><i class="fa-solid fa-chess-knight" aria-hidden="true"></i> Présentation</button>
    <button type="button" class="lfdj-bb-season-tab-btn" data-tab="s2"><i class="fa-solid fa-seedling" aria-hidden="true"></i> Saison 2 — ça démarre !</button>
    <button type="button" class="lfdj-bb-season-tab-btn" data-tab="s1"><i class="fa-solid fa-box-archive" aria-hidden="true"></i> Saison 1 — Archives</button>
  </nav>

  <section class="lfdj-bb-season-panel lfdj-bb-season-panel--presentation" data-panel="presentation">

    <div class="lfdj-divtitle">
      <h4>Assembler, peindre… puis jouer</h4>
      <h2>Blood Bowl à la Forge des Joueurs</h2>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-chess-knight"></i>
      </div>
    </div>

    <div class="lfdj-bloc-text">
      <p>
        Blood Bowl est un jeu de figurines qui mêle stratégie, tactique et créativité sur un terrain
        de football fantastique. Les déplacements précis et les choix stratégiques comptent autant
        que le hasard des dés. La Forge des Joueurs y organise une <strong>ligue interne</strong>
        régulière, ouverte aux débutants comme aux coachs confirmés.
      </p>
      <p>
        Blood Bowl est l'un des jeux les plus pratiqués au sein de la Forge des Joueurs. Des matchs
        sont régulièrement organisés lors des rencontres de l'association, aussi bien pour découvrir
        le jeu que pour approfondir des stratégies plus avancées.
      </p>
    </div>

    <div class="lfdj-hero">
      <img
        src="https://www.hobby2000.be/web/image/161737-c684f996/image_2024-08-20_104017463.webp?access_token=c1d386a3-cdd5-4733-9cbf-2ade90b618eb"
        alt="Blood Bowl - Match à la Forge des Joueurs"
        loading="lazy">
    </div>

    <div class="lfdj-bloc-text">
      <p>
        La ligue Blood Bowl de la Forge des Joueurs se veut avant tout conviviale. Les rivalités
        restent amicales, l'humour est omniprésent et chaque match est l'occasion d'échanger,
        d'apprendre et de partager un bon moment autour de la table.
      </p>
      <p>
        Que vous soyez attiré par la compétition, la narration d'une équipe qui progresse, ou
        simplement l'envie de lancer des dés en bonne compagnie, Blood Bowl trouve naturellement
        sa place au sein de l'association.
      </p>
    </div>

    <div class="lfdj-divtitle">
      <h4>Envie de te lancer ?</h4>
      <h3>Nouvelle franchise</h3>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-paintbrush"></i>
      </div>
    </div>

    <div class="lfdj-bloc-text">
      <p>
        Monter une nouvelle équipe de Blood Bowl est accessible à tous, même sans expérience
        préalable dans le jeu de figurines. Une équipe standard se compose généralement de
        <strong>12 à 16 figurines</strong>, représentant les joueurs, remplaçants et parfois
        quelques postes spécifiques selon la race choisie.
      </p>
      <p>
        Le prix moyen d'une équipe complète se situe entre <strong>35 € et 50 €</strong>, neuve,
        d'occasion ou via des marques alternatives — inutile qu'elle soit peinte pour commencer à jouer !
      </p>
      <p>
        Les membres de l'association partagent volontiers conseils, retours d'expérience et bonnes
        adresses pour l'achat de figurines, le choix d'une équipe ou la gestion de son effectif au
        fil de la ligue.
      </p>
      <p>
        Pour toute question ou pour suivre l'avancée de la ligue, les échanges se font principalement
        via le <a href="./discord" class="discord">Discord</a> de l'association.
      </p>
    </div>

  </section>

  <section class="lfdj-bb-season-panel lfdj-bb-season-panel--s2" data-panel="s2" hidden>

    <div class="lfdj-divtitle">
      <h4>Ligue interne Blood Bowl</h4>
      <h2>Vitré Bowl Cup — Saison 2</h2>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-seedling"></i>
      </div>
    </div>

    <div class="lfdj-bloc-text">
      <p>
        La <strong>Saison 2</strong> de la Vitré Bowl Cup arrive : <strong><?= $lfdj_bb_s2_team_count ?> équipes</strong> de la Forge des Joueurs
        sont engagées, aux côtés de deux équipes invitées d'autres clubs. Le calendrier vient d'être publié sur
        <a href="https://mordorbihan.fr/fr/bloodbowl/competition/521" target="_blank" rel="noopener">Mordorbihan</a>
        et les premiers matchs n'ont pas encore été joués — tout reste à faire !
      </p>
    </div>

    <div class="lfdj-divtitle">
      <h4>Elles prennent le relais</h4>
      <h3>Équipes engagées</h3>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-shield-halved"></i>
      </div>
    </div>

    <div class="lfdj-bb-pools-grid">
      <?php foreach ($lfdj_bb_s2_pools as $poolName => $poolTeams): ?>
      <section class="lfdj-bb-pool" aria-label="<?= htmlspecialchars($poolName) ?>">
        <h4 class="lfdj-bb-pool-title"><?= htmlspecialchars($poolName) ?></h4>
        <div class="lfdj-bb-pool-teams">
          <?php foreach ($poolTeams as $team): lfdj_bb_team_card($team); endforeach; ?>
        </div>
      </section>
      <?php endforeach; ?>
    </div>

  </section>

  <section class="lfdj-bb-season-panel lfdj-bb-season-panel--s1" data-panel="s1" hidden>

    <div class="lfdj-divtitle">
      <h4>Ligue interne Blood Bowl</h4>
      <h2>Vitré Bowl Cup — Saison 1</h2>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-trophy"></i>
      </div>
    </div>

    <div class="lfdj-bloc-text">
      <p>
        La première saison de la <strong>Vitré Bowl Cup</strong> est terminée : <strong><?= $lfdj_bb_s1_team_count ?> équipes</strong> engagées,
        <strong><?= $lfdj_bb_s1_journee_count ?> journées</strong> et <strong><?= $lfdj_bb_s1_match_count ?> matchs</strong> disputés en aller simple, tous contre tous.
        Championnat suivi et arbitré via <a href="https://mordorbihan.fr/fr/bloodbowl/competition/284" target="_blank" rel="noopener">Mordorbihan</a>.
      </p>
    </div>

    <article class="lfdj-bb-champion-card">
      <span class="lfdj-bb-champion-eyebrow"><i class="fa-solid fa-trophy" aria-hidden="true"></i> Championne de la Saison 1</span>
      <h3><?= htmlspecialchars($lfdj_bb_s1_champion["name"]) ?></h3>
      <p>
        <?= htmlspecialchars($lfdj_bb_s1_champion["race"]) ?> — coach <?= htmlspecialchars($lfdj_bb_s1_champion["coach"]) ?><br>
        <?= $lfdj_bb_s1_champion["w"] ?> victoires, <?= $lfdj_bb_s1_champion["d"] ?> nul, <?= $lfdj_bb_s1_champion["l"] ?> défaite sur <?= $lfdj_bb_s1_journee_count ?> journées — <?= $lfdj_bb_s1_champion["pts"] ?> points
      </p>
    </article>

    <div class="lfdj-divtitle">
      <h4>Après <?= $lfdj_bb_s1_journee_count ?> journées</h4>
      <h3>Classement final</h3>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-list-ol"></i>
      </div>
    </div>

    <div class="lfdj-bb-standings-wrap">
      <table class="lfdj-bb-standings-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Équipe</th>
            <th>Race</th>
            <th>Coach</th>
            <th>J</th>
            <th>V</th>
            <th>N</th>
            <th>D</th>
            <th>Marqués</th>
            <th>Encaissés</th>
            <th>Diff.</th>
            <th>Pts</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lfdj_bb_s1_standings as $i => $s): ?>
          <tr class="<?= $i === 0 ? "lfdj-bb-champion-row" : "" ?>">
            <td><?= $i + 1 ?></td>
            <td class="lfdj-bb-team-name"><?= htmlspecialchars($s["name"]) ?></td>
            <td><?= htmlspecialchars($s["race"]) ?></td>
            <td><?= htmlspecialchars($s["coach"]) ?></td>
            <td><?= $s["played"] ?></td>
            <td><?= $s["w"] ?></td>
            <td><?= $s["d"] ?></td>
            <td><?= $s["l"] ?></td>
            <td><?= $s["for"] ?></td>
            <td><?= $s["against"] ?></td>
            <td><?= $s["diff"] > 0 ? "+" . $s["diff"] : $s["diff"] ?></td>
            <td class="lfdj-bb-pts"><?= $s["pts"] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="lfdj-bb-results-toggle">
      <button type="button" class="lfdj-bb-results-toggle-btn" aria-expanded="false" aria-controls="lfdj-bb-results-grid">
        Afficher les <?= $lfdj_bb_s1_match_count ?> résultats de la saison
      </button>
      <div class="lfdj-bb-results-grid" id="lfdj-bb-results-grid" hidden>
        <?php foreach ($lfdj_bb_s1_matches as $journee => $matches): foreach ($matches as $match):
          [$lfdj_bb_scoreA, $lfdj_bb_scoreB] = array_map("intval", explode(" - ", $match["score"]));
          $lfdj_bb_loserClassA = $lfdj_bb_scoreA < $lfdj_bb_scoreB ? " lfdj-bb-result-team--loser" : "";
          $lfdj_bb_loserClassB = $lfdj_bb_scoreB < $lfdj_bb_scoreA ? " lfdj-bb-result-team--loser" : "";
        ?>
        <article class="lfdj-bb-result-card">
          <span class="lfdj-bb-result-team lfdj-bb-result-team--a<?= $lfdj_bb_loserClassA ?>">
            <span aria-hidden="true"><?= $lfdj_bb_team_emoji[$match["a"]] ?? "" ?></span>
            <span class="lfdj-bb-result-team-name"><?= htmlspecialchars($match["a"]) ?></span>
          </span>
          <span class="lfdj-bb-result-score"><?= htmlspecialchars($match["score"]) ?></span>
          <span class="lfdj-bb-result-team lfdj-bb-result-team--b<?= $lfdj_bb_loserClassB ?>">
            <span class="lfdj-bb-result-team-name"><?= htmlspecialchars($match["b"]) ?></span>
            <span aria-hidden="true"><?= $lfdj_bb_team_emoji[$match["b"]] ?? "" ?></span>
          </span>
          <span class="lfdj-bb-result-meta"><?= htmlspecialchars($journee) ?></span>
        </article>
        <?php endforeach; endforeach; ?>
      </div>
    </div>

    <div class="lfdj-divtitle">
      <h4>Elles ont fait la saison</h4>
      <h3>Équipes engagées</h3>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-shield-halved"></i>
      </div>
    </div>

    <div class="lfdj-bb-teams-grid">
      <?php foreach ($lfdj_bb_s1_teams as $team): lfdj_bb_team_card($team); endforeach; ?>
    </div>

    <div class="lfdj-divtitle">
      <h4>Petits exploits de la saison</h4>
      <h3>Palmarès</h3>
      <div class="lfdj-title-icon">
        <i class="fa-solid fa-medal"></i>
      </div>
    </div>

    <div class="lfdj-bb-achievements-grid">
      <?php foreach ($lfdj_bb_s1_achievements as $award): ?>
      <article class="lfdj-bb-achievement-card">
        <i class="<?= $award["icon"] ?>" aria-hidden="true"></i>
        <span class="lfdj-bb-achievement-title"><?= htmlspecialchars($award["title"]) ?></span>
        <span class="lfdj-bb-achievement-name-row">
          <span aria-hidden="true"><?= $lfdj_bb_team_emoji[$award["team"] ?? $award["name"]] ?? "" ?></span>
          <span class="lfdj-bb-achievement-name"><?= htmlspecialchars($award["name"]) ?></span>
        </span>
        <span class="lfdj-bb-achievement-stat"><?= htmlspecialchars($award["stat"]) ?></span>
      </article>
      <?php endforeach; ?>
    </div>

  </section>

</div>

<hr class="lfdj-midpage">

<?php require('importation-php/footer.php'); ?>
<script src="./importation-js/bloodbowl.js"></script>
</body>
</html>
