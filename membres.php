<?php

declare(strict_types=1);

require_once __DIR__ . '/importation-php/auth-session.php';
require_once __DIR__ . '/importation-php/profile-storage.php';
require_once __DIR__ . '/importation-php/profile-avatar.php';

$members = lfdj_profiles_list_public();
$nMembers = count($members);
$emptySlots = $nMembers < 20 ? 20 - $nMembers : 0;

/**
 * @param array{pseudo:string,rang:string,age:string,ville:string,role:string,arrival_year:string,maitre_du_jeu:bool,games:list<string>,social_rows:list<array{type:string,value:string}>} $p
 */
function lfdj_membres_role_tag_html(array $p): string
{
    $role = $p['role'] ?? 'membre';
    if ($role === 'president') {
        return '<span class="tag tag-president">Président</span>';
    }
    if ($role === 'bureau') {
        return '<span class="tag tag-bureau">' . htmlspecialchars(lfdj_profile_role_label('bureau'), ENT_QUOTES, 'UTF-8') . '</span>';
    }
    if ($role === 'curieux') {
        return '<span class="tag tag-membre-role">' . htmlspecialchars(lfdj_profile_role_label('curieux'), ENT_QUOTES, 'UTF-8') . '</span>';
    }

    return '<span class="tag tag-membre-role">' . htmlspecialchars(lfdj_profile_role_label('membre'), ENT_QUOTES, 'UTF-8') . '</span>';
}

?>
<!DOCTYPE html>
<html lang="fr" class="no-js lfdj-page-membres">
<head>
  <title>Membres | La Forge des Joueurs à Vitré</title>
  <meta name="description"
    content="Les membres de La Forge des Joueurs : association de jeux de rôle, jeux de société et figurines à Vitré." />
  <?php require __DIR__ . '/importation-php/regles.php'; ?>
</head>

<body class="lfdj-maincontainer">

  <?php require __DIR__ . '/importation-php/menu.php'; ?>

  <div class="lfdj-divtitle lfdj-divtitle--membres">
    <h4 style="text-align:center;">Association de jeux à Vitré</h4>
    <h2>Les membres</h2>
    <div class="lfdj-title-icon"><i class="fa-solid fa-users"></i></div>
  </div>

  <div class="lfdj-bloc-text">
    <p>Retrouvez ici les membres qui ont renseigné leur fiche. Pseudo, statut et jeux préférés viennent des données enregistrées sur le site.</p>
  </div>

  <div class="trombi-grid">

    <?php foreach ($members as $row): ?>
      <?php
        $mid = $row['id'];
        $p = $row['profile'];
        $pseudo = htmlspecialchars($p['pseudo'], ENT_QUOTES, 'UTF-8');
        $rangDisp = htmlspecialchars(lfdj_profile_rang_display($p['rang'] ?? ''), ENT_QUOTES, 'UTF-8');
        $avWeb = lfdj_profile_avatar_web_src($mid);
      ?>
      <div class="member-card">
        <?php if ($avWeb !== null): ?>
          <img class="member-avatar member-avatar-photo" src="<?php echo htmlspecialchars($avWeb, ENT_QUOTES, 'UTF-8'); ?>"
            width="90" height="90" alt="" loading="lazy" />
        <?php else: ?>
          <div class="member-avatar" aria-hidden="true"><i class="fa-solid fa-user"></i></div>
        <?php endif; ?>
        <p class="member-name"><?php echo $pseudo; ?></p>
        <p class="member-title"><?php echo $rangDisp; ?></p>
        <?php
          $ageStr = trim((string) ($p['age'] ?? ''));
          $villeStr = trim((string) ($p['ville'] ?? ''));
          $metaLine = '';
          if ($ageStr !== '' && $villeStr !== '') {
              $metaLine = htmlspecialchars($ageStr, ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($villeStr, ENT_QUOTES, 'UTF-8');
          } elseif ($ageStr !== '') {
              $metaLine = htmlspecialchars($ageStr, ENT_QUOTES, 'UTF-8');
          } elseif ($villeStr !== '') {
              $metaLine = htmlspecialchars($villeStr, ENT_QUOTES, 'UTF-8');
          }
          if ($metaLine !== ''):
        ?>
          <p class="member-meta"><?php echo $metaLine; ?></p>
        <?php endif; ?>
        <?php
          $socialLinks = lfdj_profile_social_links_for_display($p);
          $ariaPseudo = htmlspecialchars(trim((string) ($p['pseudo'] ?? '')), ENT_QUOTES, 'UTF-8');
        ?>
        <?php if ($socialLinks !== []): ?>
          <nav class="member-social" aria-label="Liens de <?php echo $ariaPseudo; ?>">
            <?php foreach ($socialLinks as $sl):
                $st = $sl['type'];
                $href = htmlspecialchars($sl['href'], ENT_QUOTES, 'UTF-8');
                $label = htmlspecialchars(lfdj_profile_social_type_label($st), ENT_QUOTES, 'UTF-8');
                $icon = lfdj_profile_social_icon_class($st);
            ?>
              <a class="member-social-btn member-social-btn--<?php echo htmlspecialchars($st, ENT_QUOTES, 'UTF-8'); ?>"
                href="<?php echo $href; ?>"
                target="_blank" rel="noopener noreferrer"
                title="<?php echo $label; ?>"
                aria-label="<?php echo $label; ?>">
                <i class="<?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i>
              </a>
            <?php endforeach; ?>
          </nav>
        <?php endif; ?>
        <hr>
        <div class="tag-group">
          <?php echo lfdj_membres_role_tag_html($p); ?>
          <?php if (!empty($p['maitre_du_jeu'])): ?>
            <span class="tag tag-pill-mj">Maître du Jeu</span>
          <?php endif; ?>
        </div>
        <hr>
        <div class="tag-group">
          <?php
            $gamesRaw = isset($p['games']) && is_array($p['games']) ? $p['games'] : [];
            $gamesOut = [];
            foreach ($gamesRaw as $g) {
                $g = trim((string) $g);
                if ($g !== '') {
                    $gamesOut[] = $g;
                }
            }
            if ($gamesOut === []):
          ?>
            <span class="member-games-empty">—</span>
          <?php else: ?>
            <?php foreach ($gamesOut as $g): ?>
              <span class="tag tag-game"><?php echo htmlspecialchars($g, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <?php for ($i = 0; $i < $emptySlots; $i++): ?>
      <div class="member-card slot-empty">
        <div class="member-avatar" aria-hidden="true"><i class="fa-solid fa-user"></i></div>
        <p class="member-name-empty">Membre à venir</p>
      </div>
    <?php endfor; ?>

  </div>

  <?php require __DIR__ . '/importation-php/footer.php'; ?>

</body>
</html>
