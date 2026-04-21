<?php

declare(strict_types=1);

require_once __DIR__ . '/importation-php/auth-session.php';
require_once __DIR__ . '/importation-php/discord-oauth.php';

$err = $_GET['error'] ?? null;
if (is_string($err) && $err !== '') {
    $desc = isset($_GET['error_description']) ? (string) $_GET['error_description'] : '';
    $_SESSION['auth_flash_error'] = 'Connexion Discord annulée ou refusée.' . ($desc !== '' ? ' ' . $desc : '');
    header('Location: /mon-compte.php', true, 302);
    exit;
}

$code = isset($_GET['code']) ? (string) $_GET['code'] : '';
$state = isset($_GET['state']) ? (string) $_GET['state'] : '';
$expected = $_SESSION['oauth_discord_state'] ?? '';

if ($code === '' || $state === '' || $expected === '' || !hash_equals($expected, $state)) {
    $_SESSION['auth_flash_error'] = 'Session de connexion invalide ou expirée. Réessayez.';
    header('Location: /mon-compte.php', true, 302);
    exit;
}

unset($_SESSION['oauth_discord_state']);

try {
    $token = lfdj_discord_exchange_code($code);
    $user = lfdj_discord_fetch_user($token['access_token']);
} catch (Throwable $e) {
    $reason = trim($e->getMessage());
    $_SESSION['auth_flash_error'] = 'Échec de la connexion Discord.'
        . ($reason !== '' ? ' Détail: ' . $reason : '')
        . ' Vérifiez l’URL de callback et le secret OAuth dans le portail développeur.';
    header('Location: /mon-compte.php', true, 302);
    exit;
}

$display = $user['global_name'] ?? $user['username'] ?? 'Membre';
$_SESSION['discord_user'] = [
    'id' => (string) $user['id'],
    'username' => (string) ($user['username'] ?? ''),
    'global_name' => $user['global_name'] ?? null,
    'discriminator' => (string) ($user['discriminator'] ?? '0'),
    'avatar' => $user['avatar'] ?? null,
    'email' => $user['email'] ?? null,
    'display' => is_string($display) ? $display : 'Membre',
];

$_SESSION['auth_flash_ok'] = 'Vous êtes connecté·e avec Discord.';

if (empty($_SESSION['csrf_profile'])) {
    $_SESSION['csrf_profile'] = bin2hex(random_bytes(16));
}

header('Location: /mon-compte.php', true, 302);
exit;
