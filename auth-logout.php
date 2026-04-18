<?php

declare(strict_types=1);

require_once __DIR__ . '/importation-php/auth-session.php';

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], !empty($p['secure']), $p['httponly']);
}
session_destroy();

header('Location: /mon-compte.php', true, 302);
exit;
