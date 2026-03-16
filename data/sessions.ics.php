<?php
$sessionsFile = __DIR__ . '/sessions.json';

if (!file_exists($sessionsFile)) {
    http_response_code(404);
    exit('sessions.json introuvable');
}

$data = json_decode(file_get_contents($sessionsFile), true);

if (!$data || empty($data['events'])) {
    http_response_code(500);
    exit('Données calendrier invalides');
}

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="la-forge-des-joueurs-sessions.ics"');

echo "BEGIN:VCALENDAR\r\n";
echo "VERSION:2.0\r\n";
echo "PRODID:-//La Forge des Joueurs//Calendrier Sessions//FR\r\n";
echo "CALSCALE:GREGORIAN\r\n";
echo "METHOD:PUBLISH\r\n";
echo "X-WR-CALNAME:" . ($data['calendar_name'] ?? 'Calendrier') . "\r\n";
echo "X-WR-TIMEZONE:" . ($data['timezone'] ?? 'Europe/Paris') . "\r\n";

foreach ($data['events'] as $event) {
    $title = $event['title'] ?? $data['default_title'] ?? 'Session';
    $location = $event['location'] ?? $data['default_location'] ?? '';
    $startTime = $event['start_time'] ?? $data['default_start_time'] ?? '14:00';
    $endTime = $event['end_time'] ?? $data['default_end_time'] ?? '01:00';
    $description = $event['description'] ?? $data['default_description'] ?? '';
    $date = $event['date'] ?? null;
    $timezone = $data['timezone'] ?? 'Europe/Paris';

    if (!$date) {
        continue;
    }

    $start = new DateTime($date . ' ' . $startTime, new DateTimeZone($timezone));

    $endDate = $date;
    if ($endTime < $startTime) {
        $endDate = date('Y-m-d', strtotime($date . ' +1 day'));
    }

    $end = new DateTime($endDate . ' ' . $endTime, new DateTimeZone($timezone));

    $uid = md5($date . $title) . "@laforgedesjoueurs.fr";
    $dtstamp = gmdate('Ymd\THis\Z');

    echo "BEGIN:VEVENT\r\n";
    echo "UID:$uid\r\n";
    echo "DTSTAMP:$dtstamp\r\n";
    echo "DTSTART;TZID=$timezone:" . $start->format('Ymd\THis') . "\r\n";
    echo "DTEND;TZID=$timezone:" . $end->format('Ymd\THis') . "\r\n";
    echo "SUMMARY:" . addcslashes($title, ",;") . "\r\n";
    echo "LOCATION:" . addcslashes($location, ",;") . "\r\n";
    echo "DESCRIPTION:" . addcslashes($description, ",;") . "\r\n";
    echo "END:VEVENT\r\n";
}

echo "END:VCALENDAR\r\n";