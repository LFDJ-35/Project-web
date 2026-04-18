<?php

declare(strict_types=1);

require_once __DIR__ . '/importation-php/auth-session.php';
require_once __DIR__ . '/importation-php/discord-oauth.php';

try {
    $state = lfdj_random_state();
    $_SESSION['oauth_discord_state'] = $state;
    header('Location: ' . lfdj_discord_authorize_url($state), true, 302);
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Configuration OAuth Discord : vérifiez le fichier .env sur le serveur.';
    exit;
}
exit;
