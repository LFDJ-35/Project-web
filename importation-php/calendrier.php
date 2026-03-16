<?php
$sessionsFile = __DIR__ . '/../data/sessions.json';
$data = [];

if (file_exists($sessionsFile)) {
    $json = file_get_contents($sessionsFile);
    $data = json_decode($json, true);
}

$months = [
    1 => 'Janvier',
    2 => 'Février',
    3 => 'Mars',
    4 => 'Avril',
    5 => 'Mai',
    6 => 'Juin',
    7 => 'Juillet',
    8 => 'Août',
    9 => 'Septembre',
    10 => 'Octobre',
    11 => 'Novembre',
    12 => 'Décembre'
];

$grouped = [];

// Aujourd'hui à 00:00:00 pour garder toute la journée en cours
$today = new DateTime('today', new DateTimeZone('Europe/Paris'));

if (!empty($data['events']) && is_array($data['events'])) {
    foreach ($data['events'] as $event) {
        if (empty($event['date'])) {
            continue;
        }

        $eventDate = DateTime::createFromFormat('Y-m-d', $event['date'], new DateTimeZone('Europe/Paris'));

        if (!$eventDate) {
            continue;
        }

        // On ignore les dates déjà passées
        if ($eventDate < $today) {
            continue;
        }

        $monthNumber = (int) $eventDate->format('n');
        $day = $eventDate->format('j');

        $grouped[$monthNumber][] = $day;
    }
}