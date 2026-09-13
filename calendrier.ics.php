<?php
date_default_timezone_set('Europe/Paris');
require('importation-php/agenda-data.php');

$today = new DateTime('today');
$events = [];
foreach($lfdj_agenda_lieux as $lieu){
  foreach($lieu['dates'] as $d){
    $dt = new DateTime($d);
    if($dt >= $today){
      $events[] = ['date' => $dt, 'label' => $lieu['label']];
    }
  }
}
usort($events, fn($a, $b) => $a['date'] <=> $b['date']);

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="calendrier-la-forge-des-joueurs.ics"');

echo "BEGIN:VCALENDAR\r\n";
echo "VERSION:2.0\r\n";
echo "PRODID:-//La Forge des Joueurs//Calendrier des sessions//FR\r\n";
echo "CALSCALE:GREGORIAN\r\n";

foreach($events as $e){
  $start = clone $e['date'];
  $start->setTime(14, 0);
  $end = clone $e['date'];
  $end->setTime(23, 59);
  $uid = $start->format('Ymd').'-'.md5($e['label']).'@laforgedesjoueurs.fr';

  echo "BEGIN:VEVENT\r\n";
  echo "UID:{$uid}\r\n";
  echo "DTSTAMP:".gmdate('Ymd\THis\Z')."\r\n";
  echo "DTSTART:".$start->format('Ymd\THis')."\r\n";
  echo "DTEND:".$end->format('Ymd\THis')."\r\n";
  echo "SUMMARY:Session La Forge des Joueurs - {$e['label']}\r\n";
  echo "LOCATION:{$e['label']}\r\n";
  echo "END:VEVENT\r\n";
}

echo "END:VCALENDAR\r\n";
