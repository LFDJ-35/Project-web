<!DOCTYPE html>

<html lang="fr">

<head>
  <title>La Forge des Joueurs – Association de jeux à Vitré</title>

  <?php require('importation-php/seo.php') ?>
  <?php require('importation-php/regles.php'); ?>

</head>

<body class="lfdj-maincontainer">

  <?php require('importation-php/menu.php'); ?>

  <div class="lfdj-divtitle">
    <h4>La Forge des Joueurs</h4>
    <h2>L'Association<br></h2>
    <div class="lfdj-title-icon"><i class="fa-solid fa-place-of-worship"></i></div>
  </div>

  <div class="lfdj-bloc-text">
    <p>
      La Forge des Joueurs est une association vitréenne dédiée aux jeux de rôle, aux jeux de figurines, aux jeux de cartes et aux jeux de société.
      Elle réunit des joueurs et joueuses de tous âges et de tous horizons, débutants comme confirmés, autour du plaisir de jouer, d’échanger et de partager des moments conviviaux.
    </p>
    <p>
      Les rencontres ont lieu <strong>deux samedis par mois</strong> au Mille-Club du Chêne, à Vitré et plus rarement, à la salle des sports de Bais. Certains jeux sont joués de manière régulière au sein de l’association, comme Blood Bowl, qui fait l’objet de ligues et de tournois internes, ou encore de nombreuses campagnes de jeu de rôle menées sur plusieurs mois.
      La Forge des Joueurs entretient également des partenariats avec plusieurs acteurs du milieu ludique local.
    </p>
    <p>
      L’adhésion à l’association est fixée à 20 € par an ou 10 € pour six mois. La première session est gratuite afin de permettre à chacun de découvrir l’association avant de s’engager.
    </p>
  </div>


  <div class="lfdj-divtitle">
    <h4> Forgez vos dés, affûtez vos pinceaux</h4>
    <h3>Rejoignez-nous ?</h2>
      <div class="lfdj-title-icon"><i class="fa-solid fa-comments"></i></div>
  </div>

  <div class="lfdj-bloc-text">
    <p>
      La majeure partie de la communication de la Forge des Joueurs se fait via <a href="./discord" class="discord">Discord</a>, qui constitue notre canal principal d’échange et d’organisation.
      Les réseaux sociaux sont néanmoins consultés régulièrement pour suivre l’actualité de l’association et les annonces importantes.
      La <strong>boîte mail</strong> est à privilégier pour les demandes plus spécifiques ou personnelles, que vous ne souhaitez pas forcément aborder publiquement.
    </p>
  </div>


  <div class="ldfj-socials custom-social-icons">

    <a href="mailto:laforgedesjoueurs@gmail.com" class="mail">
      <i class="fa-solid fa-envelope"></i>
    </a>
    <a href="./discord" class="discord">
      <i class="fa-brands fa-discord"></i>
    </a>

    <a href="https://www.instagram.com/laforgedesjoueurs" class="instagram">
      <i class="fa-brands fa-instagram"></i>
    </a>

    <a href="https://www.facebook.com/p/La-Forge-des-Joueurs-61553294218921" class="facebook">
      <i class="fa-brands fa-facebook"></i>
    </a>
  </div>

  <div class="lfdj-divtitle">
    <h4>Nos rendez-vous</h4>
    <h2>Calendrier</h2>
    <div class="lfdj-title-icon"><i class="fa-solid fa-calendar-days"></i></div>
  </div>

  <div class="lfdj-bloc-text">
    <p>
      Les rencontres de la Forge des Joueurs se déroulent généralement de <strong>14h à 01h</strong> au Mille-Club du Chêne, à Vitré et plus rarement, à la salle des sports de Bais.
      Les <strong>après-midis</strong> sont consacrés aux jeux de société, de plateau et de figurines, ainsi qu’à la découverte de nouveaux jeux.
      Les <strong>soirées</strong> sont, quant à elles, principalement dédiées au jeu de rôle, avec des univers variés et accessibles à tous.
      Une pause conviviale est généralement prévue en début de soirée pour se restaurer avant de reprendre les parties.
    </p>
  </div>


  <?php
  date_default_timezone_set('Europe/Paris');

  $lfdj_mois_fr = [1=>'Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
  $lfdj_jours_fr = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];

  require('importation-php/agenda-data.php');

  function lfdj_agenda_prepare($lieux, $mois_fr, $jours_fr){
    $today = new DateTime('today');
    $all = [];
    foreach($lieux as $cle => $lieu){
      foreach($lieu['dates'] as $d){
        $dt = new DateTime($d);
        if($dt >= $today){
          $all[] = ['date' => $dt, 'lieu' => $cle, 'label' => $lieu['label'], 'url' => $lieu['url']];
        }
      }
    }
    usort($all, fn($a, $b) => $a['date'] <=> $b['date']);

    $format = function($item) use ($mois_fr, $jours_fr){
      $dt = $item['date'];
      return [
        'jour'   => $jours_fr[(int)$dt->format('w')],
        'numero' => $dt->format('d'),
        'mois'   => $mois_fr[(int)$dt->format('n')],
        'annee'  => $dt->format('Y'),
        'lieu'   => $item['lieu'],
        'label'  => $item['label'],
        'url'    => $item['url'],
      ];
    };

    $next = $all ? $format(array_shift($all)) : null;
    $rows = array_map($format, $all);

    return ['featured' => $next, 'rows' => $rows];
  }

  $lfdj_agenda = lfdj_agenda_prepare($lfdj_agenda_lieux, $lfdj_mois_fr, $lfdj_jours_fr);
  ?>

  <div class="lfdj-agenda-single" id="calenadars">
    <?php if($lfdj_agenda['featured']): $f = $lfdj_agenda['featured']; ?>
    <div class="lfdj-agenda-next lfdj-agenda-next--<?= $f['lieu'] ?>">
      <span class="lfdj-agenda-next-eyebrow">Prochaine séance</span>
      <div class="lfdj-agenda-next-body">
        <strong class="lfdj-agenda-next-day"><?= $f['numero'] ?></strong>
        <span class="lfdj-agenda-next-month"><?= $f['mois'] ?></span>
        <a class="lfdj-agenda-next-venue" href="<?= $f['url'] ?>"><?= $f['label'] ?></a>
      </div>
    </div>
    <?php else: ?>
    <p class="lfdj-agenda-empty">Aucune date prévue pour le moment.</p>
    <?php endif; ?>

    <?php if($lfdj_agenda['rows']): ?>
    <ul class="lfdj-agenda-rows">
      <?php foreach($lfdj_agenda['rows'] as $r): ?>
      <li class="lfdj-agenda-row lfdj-agenda-row--<?= $r['lieu'] ?>">
        <span class="lfdj-agenda-row-date"><?= $r['numero'] ?> <?= $r['mois'] ?></span>
        <a class="lfdj-agenda-row-venue" href="<?= $r['url'] ?>"><?= $r['label'] ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>

  <div class="lfdj-agenda-actions">
    <a href="https://www.helloasso.com/associations/la-forge-des-joueurs/adhesions/adhesion-2026-1"
      target="_blank"
      rel="noopener"
      class="lfdj-cta-btn lfdj-cta-btn--gold">
      <i class="fa-solid fa-hand-holding-heart" aria-hidden="true"></i> Adhérer à l'association</a>

    <a href="./calendrier.ics.php" download class="lfdj-agenda-download-link" aria-label="Télécharger le calendrier au format ICS">
      <i class="fa-solid fa-download" aria-hidden="true"></i>
      <span class="lfdj-agenda-download-format">.ICS</span>
    </a>
  </div>

  <div class="lfdj-bloc-text">
    <iframe
      src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fp%2FLa-Forge-des-Joueurs-61553294218921&tabs=timeline&width=500&height=700&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
      style="border:none; overflow:hidden; width:100%; max-width:500px; height:700px;" scrolling="no" frameborder="0"
      allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
    </iframe>
  </div>

  </div>

  <?php require('importation-php/footer.php'); ?>
</body>

</html>