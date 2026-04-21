<?php

declare(strict_types=1);

require_once __DIR__ . '/importation-php/auth-session.php';
require_once __DIR__ . '/importation-php/profile-storage.php';
require_once __DIR__ . '/importation-php/profile-avatar.php';
require_once __DIR__ . '/importation-php/dev-config.php';

$sessUser = $_SESSION['discord_user'] ?? null;
$devMonComptePreview = lfdj_dev_mon_compte_preview_enabled() && !is_array($sessUser);
$u = is_array($sessUser) ? $sessUser : ($devMonComptePreview ? lfdj_dev_mock_discord_user() : null);

$flashOk = $_SESSION['auth_flash_ok'] ?? null;
$flashErr = $_SESSION['auth_flash_error'] ?? null;
unset($_SESSION['auth_flash_ok'], $_SESSION['auth_flash_error']);

if (!empty($u) && empty($_SESSION['csrf_profile'])) {
    $_SESSION['csrf_profile'] = bin2hex(random_bytes(16));
}

$profileErrors = [];
$saveOk = false;
$profileAvatarError = null;

if (is_array($u) && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $token = $_POST['csrf'] ?? '';
    $expected = $_SESSION['csrf_profile'] ?? '';
    if ($expected === '' || !is_string($token) || !hash_equals($expected, $token)) {
        $profileErrors[] = 'Jeton de sécurité invalide. Rechargez la page et réessayez.';
    } else {
        $avatarF = isset($_FILES['profile_avatar']) && is_array($_FILES['profile_avatar']) ? $_FILES['profile_avatar'] : null;
        $removeAvatar = isset($_POST['remove_avatar']) && (string) $_POST['remove_avatar'] === '1';
        $preflightAvatar = lfdj_profile_avatar_preflight($avatarF);
        $v = lfdj_profile_validate_and_normalize($_POST);
        if ($preflightAvatar !== null) {
            $profileErrors[] = $preflightAvatar;
        }
        if (!$v['ok']) {
            $profileErrors = array_merge($profileErrors, $v['errors']);
        }
        if ($profileErrors === []) {
            try {
                lfdj_profile_save((string) $u['id'], $v['profile']);
                $fe = $avatarF !== null ? (int) ($avatarF['error'] ?? UPLOAD_ERR_NO_FILE) : UPLOAD_ERR_NO_FILE;
                if ($fe === UPLOAD_ERR_OK && $avatarF !== null) {
                    $ae = lfdj_profile_avatar_save_from_upload((string) $u['id'], $avatarF);
                    if ($ae !== null) {
                        $profileAvatarError = $ae;
                    }
                } elseif ($removeAvatar) {
                    lfdj_profile_avatar_delete((string) $u['id']);
                }
                $saveOk = true;
            } catch (Throwable $e) {
                $profileErrors[] = 'Enregistrement impossible pour le moment.';
            }
        }
    }
}

$profile = is_array($u) ? lfdj_profile_load((string) $u['id']) : lfdj_profile_defaults();
if (is_array($u) && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && $profileErrors !== []) {
    $gamesRep = isset($_POST['games']) && is_array($_POST['games']) ? array_map('strval', $_POST['games']) : ($profile['games'] ?? []);
    $st = isset($_POST['social_type']) && is_array($_POST['social_type']) ? $_POST['social_type'] : [];
    $sv = isset($_POST['social_value']) && is_array($_POST['social_value']) ? $_POST['social_value'] : [];
    $socialMerge = [];
    for ($i = 0; $i < 3; $i++) {
        $socialMerge[] = [
            'type' => isset($st[$i]) ? (string) $st[$i] : 'website',
            'value' => isset($sv[$i]) ? (string) $sv[$i] : '',
        ];
    }
    $profile = array_merge($profile, [
        'pseudo' => isset($_POST['pseudo']) ? (string) $_POST['pseudo'] : $profile['pseudo'],
        'rang' => isset($_POST['rang']) ? (string) $_POST['rang'] : $profile['rang'],
        'age' => isset($_POST['age']) ? (string) $_POST['age'] : $profile['age'],
        'ville' => isset($_POST['ville']) ? (string) $_POST['ville'] : $profile['ville'],
        'role' => isset($_POST['role']) ? (string) $_POST['role'] : $profile['role'],
        'arrival_year' => isset($_POST['arrival_year']) ? (string) $_POST['arrival_year'] : ($profile['arrival_year'] ?? ''),
        'maitre_du_jeu' => isset($_POST['maitre_du_jeu']) && (string) $_POST['maitre_du_jeu'] === '1',
        'games' => $gamesRep,
        'social_rows' => $socialMerge,
    ]);
}

$gamesList = isset($profile['games']) && is_array($profile['games']) ? $profile['games'] : [];
$gamesList = array_values(array_map('strval', $gamesList));
$gamesList = array_values(array_filter(array_map('trim', $gamesList), static fn(string $x): bool => $x !== ''));
if (count($gamesList) > LFDJ_PROFILE_GAMES_MAX) {
    $gamesList = array_slice($gamesList, 0, LFDJ_PROFILE_GAMES_MAX);
}
if ($gamesList === []) {
    $gamesList = [''];
}
$socialRows = $profile['social_rows'] ?? lfdj_profile_defaults()['social_rows'];
while (count($socialRows) < 3) {
    $socialRows[] = ['type' => 'website', 'value' => ''];
}
$socialRows = array_slice($socialRows, 0, 3);

$csrf = $_SESSION['csrf_profile'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
  <title>Mon compte | La Forge des Joueurs</title>
  <meta name="description" content="Espace membre : connexion Discord et fiche d’informations pour l’association La Forge des Joueurs." />
  <meta name="robots" content="noindex, nofollow" />
  <?php require __DIR__ . '/importation-php/regles.php'; ?>
</head>
<body class="lfdj-maincontainer">

  <?php require __DIR__ . '/importation-php/menu.php'; ?>

  <div class="lfdj-divtitle">
    <h4>Espace membre</h4>
    <h2>Mon compte</h2>
    <div class="lfdj-title-icon">
      <i class="fa-solid fa-user"></i>
    </div>
  </div>

  <div class="lfdj-bloc-text">
    <?php if ($devMonComptePreview): ?>
      <p class="lfdj-flash lfdj-flash--info">
        <strong>Mode aperçu (configuration)</strong> — page affichée sans connexion Discord. Vous pouvez utiliser <strong>Enregistrer</strong> :
        les données sont écrites dans un fichier JSON sous <code>data/profiles/</code>
        (fichier <code><?php echo htmlspecialchars((string) ($u['id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>.json</code>, compte fictif d’aperçu — pas votre vrai compte Discord).
        Retirez <code>LFDJ_DEV_MON_COMPTE_PREVIEW</code> du <code>.env</code> en production.
      </p>
    <?php endif; ?>
    <?php if (is_string($flashOk) && $flashOk !== ''): ?>
      <p class="lfdj-flash lfdj-flash--ok"><?php echo htmlspecialchars($flashOk, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (is_string($flashErr) && $flashErr !== ''): ?>
      <p class="lfdj-flash lfdj-flash--err"><?php echo htmlspecialchars($flashErr, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <?php if (!is_array($u)): ?>
      <p>
        Connectez-vous avec Discord pour accéder à votre fiche et indiquer vos informations pour l’association.
      </p>
      <p>
        <a class="lfdj-btn-discord" href="./auth-discord.php"><i class="fa-brands fa-discord" aria-hidden="true"></i> Connexion avec Discord</a>
      </p>
      <p class="lfdj-smallprint">
        En vous connectant, vous acceptez le traitement des données décrit dans la
        <a href="./confidentialite-compte.php">politique de confidentialité — compte membre</a>.
      </p>
    <?php else: ?>
      <?php
        $av = $u['avatar'] ?? null;
        $uid = (string) ($u['id'] ?? '');
        $localAv = lfdj_profile_avatar_web_src($uid);
        $avUrl = is_string($av) && $av !== ''
            ? 'https://cdn.discordapp.com/avatars/' . rawurlencode($uid) . '/' . rawurlencode($av) . '.png?size=128'
            : null;
        $headImg = $localAv ?? $avUrl;
      ?>
      <div class="lfdj-account-head">
        <?php if ($headImg !== null): ?>
          <img class="lfdj-account-avatar" src="<?php echo htmlspecialchars($headImg, ENT_QUOTES, 'UTF-8'); ?>" width="120" height="120" alt="" />
        <?php endif; ?>
        <p>
          Connecté·e en tant que <strong><?php echo htmlspecialchars((string) ($u['display'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong>
          <?php if (!empty($u['email'])): ?>
            <span class="lfdj-smallprint">(<?php echo htmlspecialchars((string) $u['email'], ENT_QUOTES, 'UTF-8'); ?>)</span>
          <?php endif; ?>
        </p>
        <p>
          <?php if ($devMonComptePreview): ?>
            <span class="lfdj-smallprint">Pas de session réelle — lien déconnexion masqué.</span>
          <?php else: ?>
            <a class="lfdj-link-muted" href="./auth-logout.php?next=<?php echo rawurlencode('/mon-compte.php'); ?>">Déconnexion</a>
          <?php endif; ?>
        </p>
      </div>

      <?php if ($saveOk): ?>
        <p class="lfdj-flash lfdj-flash--ok">
          <?php if ($devMonComptePreview): ?>
            Profil enregistré (mode aperçu) dans <code>data/profiles/<?php echo htmlspecialchars((string) ($u['id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>.json</code>.
          <?php else: ?>
            Profil enregistré.
          <?php endif; ?>
        </p>
      <?php endif; ?>
      <?php if (is_string($profileAvatarError) && $profileAvatarError !== ''): ?>
        <p class="lfdj-flash lfdj-flash--err">
          <strong>Photo de profil.</strong> <?php echo htmlspecialchars($profileAvatarError, ENT_QUOTES, 'UTF-8'); ?>
        </p>
      <?php endif; ?>
      <?php foreach ($profileErrors as $msg): ?>
        <p class="lfdj-flash lfdj-flash--err"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endforeach; ?>

      <p class="lfdj-form-intro">
        La mention <span class="lfdj-label-opt-mark">(*)</span> en fin de libellé indique un champ <strong>facultatif</strong>.
        Sans rang renseigné, le site affichera par défaut « <?php echo htmlspecialchars(LFDJ_PROFILE_RANG_DEFAULT, ENT_QUOTES, 'UTF-8'); ?> ».
      </p>

      <form class="lfdj-form-profile lfdj-form-profile--compact" method="post" action="./mon-compte.php" id="lfdj-profile-form" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />
        <input type="hidden" name="MAX_FILE_SIZE" value="524288" />

        <fieldset class="lfdj-fieldset lfdj-fieldset--avatar">
          <legend class="lfdj-label lfdj-label--legend">Photo d’illustration <span class="lfdj-label-opt-mark">(*)</span></legend>
          <p class="lfdj-field-hint">
            Une image <strong>carrée</strong> est idéale ; sinon le serveur recadre au centre en carré (<?php echo (int) LFDJ_PROFILE_AVATAR_SIDE; ?> px).
            Formats acceptés : JPEG, PNG ou WebP. Taille maximale du fichier envoyé : <strong><?php echo (int) (LFDJ_PROFILE_AVATAR_MAX_UPLOAD_BYTES / 1024); ?> Ko</strong>.
          </p>
          <div class="lfdj-form-avatar-row">
            <label class="lfdj-btn-secondary lfdj-btn-file" for="profile_avatar">Choisir une image…</label>
            <input class="lfdj-input-file-hidden" id="profile_avatar" name="profile_avatar" type="file"
              accept="image/jpeg,image/png,image/webp" />
            <span class="lfdj-file-name" id="lfdj-profile-avatar-filename" aria-live="polite"></span>
          </div>
          <?php if (lfdj_profile_avatar_exists((string) ($u['id'] ?? ''))): ?>
            <label class="lfdj-checkbox-label">
              <input type="checkbox" name="remove_avatar" value="1" />
              Retirer ma photo personnalisée (revenir à l’avatar Discord si disponible)
            </label>
          <?php endif; ?>
        </fieldset>

        <div class="lfdj-form-row lfdj-form-row--2">
          <div class="lfdj-form-field">
            <label class="lfdj-label" for="pseudo">Pseudo affiché</label>
            <input class="lfdj-input" id="pseudo" name="pseudo" type="text" maxlength="80" required
              value="<?php echo htmlspecialchars($profile['pseudo'], ENT_QUOTES, 'UTF-8'); ?>" autocomplete="nickname"
              placeholder="Pseudo" />
          </div>
          <div class="lfdj-form-field">
            <label class="lfdj-label" for="age">Âge <span class="lfdj-label-opt-mark">(*)</span></label>
            <input class="lfdj-input" id="age" name="age" type="number" min="13" max="120" step="1"
              value="<?php echo htmlspecialchars($profile['age'], ENT_QUOTES, 'UTF-8'); ?>"
              placeholder="Âge" />
          </div>
        </div>

        <label class="lfdj-label" for="rang">Rang bien particulier que vous vous donnez ! <span class="lfdj-label-opt-mark">(*)</span></label>
        <input class="lfdj-input" id="rang" name="rang" type="text" maxlength="120"
          value="<?php echo htmlspecialchars($profile['rang'], ENT_QUOTES, 'UTF-8'); ?>"
          placeholder="Laissez vide : libellé par défaut affiché sur le site (voir ci-dessus)" />
        <p class="lfdj-field-hint lfdj-field-hint--titles">Ex. : « Seigneur des Donjons », « Maître des Panthères », « Forgeron en Chef », « Exterminateur de Tables ».</p>

        <label class="lfdj-label" for="ville">Ville <span class="lfdj-label-opt-mark">(*)</span></label>
        <input class="lfdj-input" id="ville" name="ville" type="text" maxlength="80"
          value="<?php echo htmlspecialchars($profile['ville'], ENT_QUOTES, 'UTF-8'); ?>"
          placeholder="Ville" />

        <div class="lfdj-form-row lfdj-form-row--2">
          <div class="lfdj-form-field">
            <label class="lfdj-label" for="role">Statut associatif</label>
            <select class="lfdj-input" id="role" name="role" required>
              <?php foreach (lfdj_profile_role_options() as $opt): ?>
                <option value="<?php echo htmlspecialchars($opt, ENT_QUOTES, 'UTF-8'); ?>"<?php echo ($profile['role'] ?? 'membre') === $opt ? ' selected' : ''; ?>>
                  <?php echo htmlspecialchars(lfdj_profile_role_label($opt), ENT_QUOTES, 'UTF-8'); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="lfdj-form-field">
            <label class="lfdj-label" for="arrival_year">Depuis ? <span class="lfdj-label-opt-mark">(*)</span></label>
            <select class="lfdj-input" id="arrival_year" name="arrival_year">
              <option value="">—</option>
              <?php
                $selYear = (string) ($profile['arrival_year'] ?? '');
                foreach (lfdj_profile_arrival_year_options() as $y):
              ?>
                <option value="<?php echo $y; ?>"<?php echo $selYear === (string) $y ? ' selected' : ''; ?>><?php echo $y; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <label class="lfdj-checkbox-label lfdj-checkbox-label--block">
          <input type="checkbox" name="maitre_du_jeu" value="1"<?php echo !empty($profile['maitre_du_jeu']) ? ' checked' : ''; ?> />
          Maître du Jeu
        </label>
        <p class="lfdj-field-hint">Cochez si vous animez des parties.</p>

        <fieldset class="lfdj-fieldset">
          <legend class="lfdj-label lfdj-label--legend">Jeux auxquels vous jouez <span class="lfdj-label-opt-mark">(*)</span></legend>
          <p class="lfdj-field-hint">
            <strong><?php echo (int) LFDJ_PROFILE_GAMES_MAX; ?> jeux maximum</strong> seront affichés sur votre fiche publique.
            Nous vous conseillons d’en indiquer <strong>au moins 3</strong> si vous le pouvez.
          </p>
          <p class="lfdj-field-hint lfdj-field-hint--emoji">
            Jeux souvent joués à la Forge : un clic <strong>ajoute</strong> le libellé (avec emoji) dans votre liste, un second clic sur la même pastille le <strong>retire</strong>.
            Vous pouvez aussi saisir d’autres jeux librement dans les champs ci-dessous.
          </p>
          <div class="lfdj-games-suggest" role="group" aria-label="Jeux proposés">
            <?php foreach (lfdj_profile_suggested_games() as $sg): ?>
              <?php $gv = $sg['value']; ?>
              <button type="button" class="lfdj-game-suggest-btn"
                data-game-value="<?php echo htmlspecialchars($gv, ENT_QUOTES, 'UTF-8'); ?>"
                title="<?php echo htmlspecialchars('Ajouter ou retirer : ' . $gv, ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($gv, ENT_QUOTES, 'UTF-8'); ?>
              </button>
            <?php endforeach; ?>
          </div>
          <div class="lfdj-games-list" id="lfdj-games-list" data-max-rows="<?php echo (int) LFDJ_PROFILE_GAMES_MAX; ?>">
            <?php foreach ($gamesList as $idx => $g): ?>
              <div class="lfdj-games-row">
                <input class="lfdj-input" type="text" name="games[]" maxlength="120"
                  value="<?php echo htmlspecialchars((string) $g, ENT_QUOTES, 'UTF-8'); ?>"
                  placeholder="Ex. 🎲 Blood Bowl" />
                <button type="button" class="lfdj-btn-icon lfdj-games-remove" aria-label="Retirer ce jeu" title="Retirer">&times;</button>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="lfdj-btn-secondary" id="lfdj-games-add">Ajouter un jeu</button>
        </fieldset>

        <fieldset class="lfdj-fieldset">
          <legend class="lfdj-label lfdj-label--legend">Liens vers vos réseaux <span class="lfdj-label-opt-mark">(*)</span></legend>
          <p class="lfdj-field-hint">Trois emplacements au maximum : choisissez le type de réseau (icône affichée ailleurs sur le site) et indiquez une <strong>URL complète</strong> (https://…).</p>
          <?php foreach ($socialRows as $i => $row): ?>
            <?php
              $t = $row['type'] ?? 'website';
              $v = $row['value'] ?? '';
            ?>
            <div class="lfdj-social-row">
              <label class="lfdj-sr-only" for="social_type_<?php echo $i; ?>">Réseau <?php echo $i + 1; ?></label>
              <select class="lfdj-input lfdj-input--social-type" id="social_type_<?php echo $i; ?>" name="social_type[]">
                <?php foreach (lfdj_profile_social_types() as $st): ?>
                  <option value="<?php echo htmlspecialchars($st, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $t === $st ? ' selected' : ''; ?>>
                    <?php echo htmlspecialchars(lfdj_profile_social_type_label($st), ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input class="lfdj-input lfdj-input--social-value" type="text" name="social_value[]" maxlength="200"
                value="<?php echo htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); ?>"
                placeholder="https://…" />
            </div>
          <?php endforeach; ?>
        </fieldset>

        <p class="lfdj-smallprint">Données traitées conformément à la <a href="./confidentialite-compte.php">politique de confidentialité — compte membre</a>.</p>

        <button class="lfdj-btn-submit" type="submit">Enregistrer</button>
      </form>

      <script>
      (function () {
        var list = document.getElementById("lfdj-games-list");
        var addBtn = document.getElementById("lfdj-games-add");
        if (!list || !addBtn) return;
        var max = parseInt(list.getAttribute("data-max-rows") || "5", 10);

        function syncAddBtn() {
          var n = list.querySelectorAll(".lfdj-games-row").length;
          addBtn.disabled = n >= max;
          addBtn.style.opacity = n >= max ? "0.5" : "";
        }

        function bindRemove(row) {
          var btn = row.querySelector(".lfdj-games-remove");
          if (!btn) return;
          btn.addEventListener("click", function () {
            if (list.querySelectorAll(".lfdj-games-row").length <= 1) {
              row.querySelector("input").value = "";
              syncAddBtn();
              return;
            }
            row.remove();
            syncAddBtn();
          });
        }

        function createRow(val) {
          var row = document.createElement("div");
          row.className = "lfdj-games-row";
          row.innerHTML = '<input class="lfdj-input" type="text" name="games[]" maxlength="120" placeholder="Autre jeu…" />' +
            '<button type="button" class="lfdj-btn-icon lfdj-games-remove" aria-label="Retirer ce jeu" title="Retirer">&times;</button>';
          var inp = row.querySelector("input");
          if (val) {
            inp.value = val;
          }
          list.appendChild(row);
          bindRemove(row);
          syncAddBtn();
        }

        function getValues() {
          return Array.prototype.map.call(list.querySelectorAll(".lfdj-games-row input"), function (el) {
            return el.value.trim();
          });
        }

        function nonEmptyCount() {
          return getValues().filter(Boolean).length;
        }

        list.querySelectorAll(".lfdj-games-row").forEach(bindRemove);
        syncAddBtn();

        addBtn.addEventListener("click", function () {
          var n = list.querySelectorAll(".lfdj-games-row").length;
          if (n >= max) return;
          createRow("");
        });

        document.querySelectorAll(".lfdj-game-suggest-btn").forEach(function (btn) {
          btn.addEventListener("click", function () {
            var v = btn.getAttribute("data-game-value");
            if (!v) return;
            var inputs = list.querySelectorAll(".lfdj-games-row input");
            var vals = getValues();
            var idx = vals.indexOf(v);
            if (idx !== -1) {
              if (list.querySelectorAll(".lfdj-games-row").length <= 1) {
                inputs[idx].value = "";
                syncAddBtn();
                return;
              }
              inputs[idx].closest(".lfdj-games-row").remove();
              syncAddBtn();
              return;
            }
            if (nonEmptyCount() >= max) return;
            var placed = false;
            Array.prototype.forEach.call(inputs, function (inp) {
              if (!placed && !inp.value.trim()) {
                inp.value = v;
                placed = true;
              }
            });
            if (!placed && list.querySelectorAll(".lfdj-games-row").length < max) {
              createRow(v);
            }
            syncAddBtn();
          });
        });

        var fileInput = document.getElementById("profile_avatar");
        var fileLabel = document.getElementById("lfdj-profile-avatar-filename");
        if (fileInput && fileLabel) {
          fileInput.addEventListener("change", function () {
            var f = fileInput.files && fileInput.files[0];
            fileLabel.textContent = f ? f.name : "";
          });
        }
      })();
      </script>
    <?php endif; ?>
  </div>

  <?php require __DIR__ . '/importation-php/footer.php'; ?>
</body>
</html>
