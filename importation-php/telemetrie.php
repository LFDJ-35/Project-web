<?php
$cookieName = "lfdj_session_id";
if (!isset($_COOKIE[$cookieName])) {
    $uuid = uniqid('lfdj_', true);
    setcookie($cookieName, $uuid, time() + (30 * 60), "/");
} else {
    $uuid = $_COOKIE[$cookieName];
}

$timestamp = date('c'); 
$pageVisitee = $_SERVER['REQUEST_URI'];

$pageVisitee = str_replace(',', ' ', $pageVisitee);

$ligneCsv = "$uuid,$timestamp,$pageVisitee" . PHP_EOL;

$fichier = __DIR__ . '/../stats_parcours.csv';
file_put_contents($fichier, $ligneCsv, FILE_APPEND | LOCK_EX);
?>