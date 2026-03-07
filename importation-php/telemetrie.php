<?php

$page = $_SERVER['PHP_SELF']; 
$mois = date('Y-m');

$fichier_log = __DIR__ . '/../stats_visites.txt';

$entree = $mois . " | " . $page . PHP_EOL;

file_put_contents($fichier_log, $entree, FILE_APPEND);
?>