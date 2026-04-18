<?php

declare(strict_types=1);

require_once __DIR__ . '/importation-php/auth-session.php';
require_once __DIR__ . '/importation-php/profile-storage.php';

$u = $_SESSION['discord_user'] ?? null;
$flashOk = $_SESSION['auth_flash_ok'] ?? null;
$flashErr = $_SESSION['auth_flash_error'] ?? null;
unset($_SESSION['auth_flash_ok'], $_SESSION['auth_flash_error']);

if (!empty($u) && empty($_SESSION['csrf_profile'])) {
    $_SESSION['csrf_profile'] = bin2hex(random_bytes(16));
}

$profileErrors = [];
$saveOk = false;

if (is_array($u) && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $token = $_POST['csrf'] ?? '';
    $expected = $_SESSION['csrf_profile'] ?? '';
    if ($expected === '' || !is_string($token) || !hash_equals($expected, $token)) {
        $profileErrors[] = 'Jeton de sécurité invalide. Rechargez la page et réessayez.';
    } else {
        $v = lfdj_profile_validate_and_normalize($_POST);
        if (!$v['ok']) {
            $profileErrors = $v['errors'];
        } else {
            try {
                lfdj_profile_save((string) $u['id'], $v['profile']);
                $saveOk = true;
            } catch (Throwable $e) {
                $profileErrors[] = 'Enregistrement impossible pour le moment.';
            }
        }
    }
}

$profile = is_array($u) ? lfdj_profile_load((string) $u['id']) : lfdj_profile_defaults();
if (is_array($u) && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && $profileErrors !== []) {
    $profile = array_merge($profile, [
        'pseudo' => isset($_POST['pseudo']) ? (string) $_POST['pseudo'] : $profile['pseudo'],
        'age' => isset($_POST['age']) ? (string) $_POST['age'] : $profile['age'],
        'role' => isset($_POST['role']) ? (string) $_POST['role'] : $profile['role'],
        'games' => isset($_POST['games']) ? (string) $_POST['games'] : $profile['games'],
        'social_links' => isset($_POST['social_links']) ? (string) $_POST['social_links'] : $profile['social_links'],
    ]);
}

$csrf = $_SESSION['csrf_profile'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
  <title>Mon compte | La Forge des Joueurs</title>
  <meta name="description" content="Espace membre La Forge des Joueurs : connexion Discord et fiche d’informations." />
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
    <?php if (is_string($flashOk) && $flashOk !== ''): ?>
      <p class="lfdj-flash lfdj-flash--ok"><?php echo htmlspecialchars($flashOk, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if (is_string($flashErr) && $flashErr !== ''): ?>
      <p class="lfdj-flash lfdj-flash--err"><?php echo htmlspecialchars($flashErr, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <?php if (!is_array($u)): ?>
      <p>Connectez-vous avec Discord pour accéder à votre fiche membre.</p>
      <p><a class="lfdj-btn-discord" href="./auth-discord.php"><i class="fa-brands fa-discord" aria-hidden="true"></i> Connexion avec Discord</a></p>
    <?php else: ?>
      <?php if ($saveOk): ?>
        <p class="lfdj-flash lfdj-flash--ok">Profil enregistré.</p>
      <?php endif; ?>
      <?php foreach ($profileErrors as $msg): ?>
        <p class="lfdj-flash lfdj-flash--err"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endforeach; ?>

      <form class="lfdj-form-profile" method="post" action="./mon-compte.php">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>" />

        <label class="lfdj-label" for="pseudo">Pseudo affiché (menu du site)</label>
        <input class="lfdj-input" id="pseudo" name="pseudo" type="text" required maxlength="80"
          value="<?php echo htmlspecialchars($profile['pseudo'], ENT_QUOTES, 'UTF-8'); ?>" autocomplete="nickname" />

        <label class="lfdj-label" for="age">Âge</label>
        <input class="lfdj-input lfdj-input--narrow" id="age" name="age" type="number" min="13" max="120" step="1" placeholder="optionnel"
          value="<?php echo htmlspecialchars($profile['age'], ENT_QUOTES, 'UTF-8'); ?>" />

        <label class="lfdj-label" for="role">Place dans l’association</label>
        <select class="lfdj-input" id="role" name="role">
          <?php foreach (lfdj_profile_role_options() as $opt): ?>
            <option value="<?php echo htmlspecialchars($opt, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $profile['role'] === $opt ? ' selected' : ''; ?>>
              <?php echo htmlspecialchars(lfdj_profile_role_label($opt), ENT_QUOTES, 'UTF-8'); ?>
            </option>
          <?php endforeach; ?>
        </select>

        <label class="lfdj-label" for="games">Jeux auxquels vous jouez</label>
        <textarea class="lfdj-textarea" id="games" name="games" rows="5" maxlength="2000"><?php echo htmlspecialchars($profile['games'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label class="lfdj-label" for="social_links">Liens vers vos réseaux (une URL par ligne)</label>
        <textarea class="lfdj-textarea" id="social_links" name="social_links" rows="4" maxlength="2000"><?php echo htmlspecialchars($profile['social_links'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <button class="lfdj-btn-submit" type="submit">Enregistrer</button>
      </form>
    <?php endif; ?>
  </div>

  <?php require __DIR__ . '/importation-php/footer.php'; ?>
</body>
</html>
