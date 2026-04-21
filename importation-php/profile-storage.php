<?php

declare(strict_types=1);

const LFDJ_PROFILE_RANG_DEFAULT = 'En Manque d\'Originalité';

/** Nombre maximum de jeux enregistrés par fiche (Mon compte + page Membres). */
const LFDJ_PROFILE_GAMES_MAX = 5;

/** @return int[] */
function lfdj_profile_arrival_year_options(): array
{
    return range(2020, 2026);
}

/** Texte affiché pour le rang si le membre n’a rien saisi. */
function lfdj_profile_rang_display(string $rang): string
{
    $t = trim($rang);

    return $t !== '' ? $t : LFDJ_PROFILE_RANG_DEFAULT;
}

/**
 * Jeux fréquents à la Forge (emoji + libellé) — proposés sur le formulaire Mon compte.
 *
 * @return list<array{id:string,value:string}>
 */
function lfdj_profile_suggested_games(): array
{
    return [
        ['id' => 'root', 'value' => '🌳 Root'],
        ['id' => 'bloodbowl', 'value' => '🏈 Bloodbowl'],
        ['id' => 'saga', 'value' => '⚔️ Saga'],
        ['id' => 'warhammer40k', 'value' => '🛡️ Warhammer 40k'],
        ['id' => 'marvelcp', 'value' => '🦸 Marvel Crisis Protocol'],
        ['id' => 'gasland', 'value' => '🚗 Gasland'],
        ['id' => 'mtg', 'value' => '🃏 Magic the Gathering'],
        ['id' => 'fleshblood', 'value' => '🩸 Flesh & Blood'],
        ['id' => 'cyberpunk', 'value' => '🤖 Cyberpunk'],
        ['id' => 'collostle', 'value' => '🗿 Collostle'],
        ['id' => 'vtm', 'value' => '🧛 Vampire the Mascarade'],
        ['id' => 'dnd', 'value' => '🐉 D&D'],
        ['id' => 'catsmascarade', 'value' => '🐱 Cats la Mascarade'],
        ['id' => 'motw', 'value' => '👹 Monster of the Week'],
        ['id' => 'epyllion', 'value' => '🐲 Epyllion'],
        ['id' => 'runnetera', 'value' => '✨ Runnetera'],
    ];
}

/** @return array{pseudo:string,rang:string,age:string,ville:string,role:string,arrival_year:string,maitre_du_jeu:bool,games:list<string>,social_rows:list<array{type:string,value:string}>} */
function lfdj_profile_defaults(): array
{
    return [
        'pseudo' => '',
        'rang' => '',
        'age' => '',
        'ville' => '',
        'role' => 'membre',
        'arrival_year' => '',
        'maitre_du_jeu' => false,
        'games' => [],
        'social_rows' => [
            ['type' => 'website', 'value' => ''],
            ['type' => 'website', 'value' => ''],
            ['type' => 'website', 'value' => ''],
        ],
    ];
}

/** @return string[] */
function lfdj_profile_role_options(): array
{
    return ['president', 'bureau', 'membre', 'curieux'];
}

function lfdj_profile_role_label(string $role): string
{
    $map = [
        'president' => 'Président',
        'bureau' => 'Bureau',
        'membre' => 'Membre',
        'curieux' => 'Curieux / Curieuse',
    ];
    return $map[$role] ?? $role;
}

/** @return string[] */
function lfdj_profile_social_types(): array
{
    return ['website', 'instagram', 'facebook', 'twitter', 'artstation'];
}

function lfdj_profile_social_type_label(string $type): string
{
    $map = [
        'website' => 'Site web',
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'twitter' => 'Twitter / X',
        'artstation' => 'ArtStation',
    ];
    return $map[$type] ?? $type;
}

function lfdj_profile_social_icon_class(string $type): string
{
    return match ($type) {
        'website' => 'fa-solid fa-link',
        'instagram' => 'fa-brands fa-instagram',
        'facebook' => 'fa-brands fa-facebook-f',
        'twitter' => 'fa-brands fa-x-twitter',
        'artstation' => 'fa-brands fa-artstation',
        'deviantart' => 'fa-brands fa-artstation',
        default => 'fa-solid fa-link',
    };
}

/**
 * Liens réseau affichables (URL valide, valeur non vide).
 *
 * @param array<string, mixed> $profile profil normalisé
 * @return list<array{type:string,href:string}>
 */
function lfdj_profile_social_links_for_display(array $profile): array
{
    $rows = $profile['social_rows'] ?? [];
    if (!is_array($rows)) {
        return [];
    }
    $out = [];
    $allowed = lfdj_profile_social_types();
    foreach ($rows as $r) {
        if (!is_array($r)) {
            continue;
        }
        $v = trim((string) ($r['value'] ?? ''));
        if ($v === '') {
            continue;
        }
        if (filter_var($v, FILTER_VALIDATE_URL) === false) {
            continue;
        }
        $t = (string) ($r['type'] ?? 'website');
        if ($t === 'deviantart') {
            $t = 'artstation';
        }
        if (!in_array($t, $allowed, true)) {
            $t = 'website';
        }
        $out[] = ['type' => $t, 'href' => $v];
    }

    return $out;
}

function lfdj_profiles_dir(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'profiles';
}

/**
 * @param array<string, mixed> $data
 * @return array{pseudo:string,rang:string,age:string,ville:string,role:string,arrival_year:string,maitre_du_jeu:bool,games:list<string>,social_rows:list<array{type:string,value:string}>}
 */
function lfdj_profile_normalize_loaded(array $data): array
{
    $base = lfdj_profile_defaults();

    foreach (['pseudo', 'rang', 'age', 'ville', 'role', 'arrival_year'] as $k) {
        if (isset($data[$k]) && is_string($data[$k])) {
            $base[$k] = $data[$k];
        }
    }

    if (isset($data['maitre_du_jeu'])) {
        $base['maitre_du_jeu'] = (bool) $data['maitre_du_jeu'];
    }

    $roleLegacy = ['directeur' => 'president', 'ca' => 'bureau', 'membres' => 'membre'];
    if (isset($roleLegacy[$base['role']])) {
        $base['role'] = $roleLegacy[$base['role']];
    }
    if (!in_array($base['role'], lfdj_profile_role_options(), true)) {
        $base['role'] = 'membre';
    }

    $ay = trim($base['arrival_year']);
    if ($ay !== '' && !in_array((int) $ay, lfdj_profile_arrival_year_options(), true)) {
        $base['arrival_year'] = '';
    }

    if (isset($data['games'])) {
        if (is_array($data['games'])) {
            $base['games'] = [];
            foreach ($data['games'] as $g) {
                $g = trim((string) $g);
                if ($g !== '') {
                    $base['games'][] = $g;
                }
            }
        } elseif (is_string($data['games']) && $data['games'] !== '') {
            foreach (preg_split('/\r\n|\n|\r/', $data['games']) ?: [] as $line) {
                $line = trim($line);
                if ($line !== '') {
                    $base['games'][] = $line;
                }
            }
        }
        if (count($base['games']) > LFDJ_PROFILE_GAMES_MAX) {
            $base['games'] = array_slice($base['games'], 0, LFDJ_PROFILE_GAMES_MAX);
        }
    }

    if (isset($data['social_rows']) && is_array($data['social_rows'])) {
        $rows = [];
        for ($i = 0; $i < 3; $i++) {
            $r = $data['social_rows'][$i] ?? null;
            $t = 'website';
            $v = '';
            if (is_array($r)) {
                $t = isset($r['type']) && is_string($r['type']) ? $r['type'] : 'website';
                $v = isset($r['value']) && is_string($r['value']) ? $r['value'] : '';
            }
            if ($t === 'deviantart') {
                $t = 'artstation';
            }
            if (!in_array($t, lfdj_profile_social_types(), true)) {
                $t = 'website';
            }
            $rows[] = ['type' => $t, 'value' => $v];
        }
        $base['social_rows'] = $rows;
    } elseif (isset($data['social_links']) && is_string($data['social_links']) && $data['social_links'] !== '') {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\n|\r/', $data['social_links']) ?: [])));
        $base['social_rows'] = [
            ['type' => 'website', 'value' => $lines[0] ?? ''],
            ['type' => 'website', 'value' => $lines[1] ?? ''],
            ['type' => 'website', 'value' => $lines[2] ?? ''],
        ];
    }

    return $base;
}

/** @return array{pseudo:string,rang:string,age:string,ville:string,role:string,arrival_year:string,maitre_du_jeu:bool,games:list<string>,social_rows:list<array{type:string,value:string}>} */
function lfdj_profile_load(string $discordId): array
{
    $dir = lfdj_profiles_dir();
    $file = $dir . DIRECTORY_SEPARATOR . preg_replace('/[^0-9]/', '', $discordId) . '.json';
    if (!is_readable($file)) {
        return lfdj_profile_defaults();
    }
    $raw = file_get_contents($file);
    if ($raw === false) {
        return lfdj_profile_defaults();
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return lfdj_profile_defaults();
    }

    return lfdj_profile_normalize_loaded($data);
}

/** Pseudo affiché dans l’en-tête : fiche si renseigné, sinon nom Discord. */
function lfdj_header_display_name(): string
{
    $u = $_SESSION['discord_user'] ?? null;
    if (!is_array($u) || empty($u['id'])) {
        return '';
    }
    $prof = lfdj_profile_load((string) $u['id']);
    $p = trim($prof['pseudo'] ?? '');
    if ($p !== '') {
        return $p;
    }
    $d = $u['display'] ?? $u['global_name'] ?? $u['username'] ?? '';
    return is_string($d) ? $d : '';
}

/**
 * @param array{pseudo:string,rang:string,age:string,ville:string,role:string,arrival_year:string,maitre_du_jeu:bool,games:list<string>,social_rows:list<array{type:string,value:string}>} $profile
 */
function lfdj_profile_save(string $discordId, array $profile): void
{
    $dir = lfdj_profiles_dir();
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0750, true) && !is_dir($dir)) {
            throw new RuntimeException('Impossible de créer le dossier des profils.');
        }
    }
    $safeId = preg_replace('/[^0-9]/', '', $discordId);
    if ($safeId === '') {
        throw new InvalidArgumentException('Identifiant Discord invalide.');
    }
    $file = $dir . DIRECTORY_SEPARATOR . $safeId . '.json';
    $payload = json_encode($profile, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    if ($payload === false) {
        throw new RuntimeException('Sérialisation JSON impossible.');
    }
    if (file_put_contents($file, $payload, LOCK_EX) === false) {
        throw new RuntimeException('Échec de l’enregistrement du profil.');
    }
}

/**
 * Année d’arrivée pour le tri : croissant (2020 avant 2026), sans année valide en dernier dans le groupe.
 *
 * @param array<string, mixed> $profile
 */
function lfdj_profile_arrival_year_sort_key(array $profile): int
{
    $y = trim((string) ($profile['arrival_year'] ?? ''));
    if ($y === '' || !ctype_digit($y)) {
        return 9999;
    }
    $yi = (int) $y;
    if (!in_array($yi, lfdj_profile_arrival_year_options(), true)) {
        return 9999;
    }

    return $yi;
}

/**
 * Profils avec pseudo renseigné, triés : statut (président → bureau → membre → curieux),
 * puis année « Depuis ? » (croissant), puis pseudo (A → Z, insensible à la casse).
 *
 * @return list<array{id:string,profile:array}>
 */
function lfdj_profiles_list_public(): array
{
    $dir = lfdj_profiles_dir();
    $out = [];
    if (!is_dir($dir)) {
        return $out;
    }
    $roleOrder = ['president' => 0, 'bureau' => 1, 'membre' => 2, 'curieux' => 3];
    foreach (scandir($dir) ?: [] as $f) {
        if (!preg_match('/^(\d+)\.json$/', $f, $m)) {
            continue;
        }
        $id = $m[1];
        $prof = lfdj_profile_load($id);
        if (trim($prof['pseudo']) === '') {
            continue;
        }
        $out[] = ['id' => $id, 'profile' => $prof];
    }
    usort($out, static function (array $a, array $b) use ($roleOrder): int {
        $ra = $roleOrder[$a['profile']['role'] ?? ''] ?? 9;
        $rb = $roleOrder[$b['profile']['role'] ?? ''] ?? 9;
        if ($ra !== $rb) {
            return $ra <=> $rb;
        }
        $ka = lfdj_profile_arrival_year_sort_key($a['profile']);
        $kb = lfdj_profile_arrival_year_sort_key($b['profile']);
        if ($ka !== $kb) {
            return $ka <=> $kb;
        }

        return strcasecmp((string) ($a['profile']['pseudo'] ?? ''), (string) ($b['profile']['pseudo'] ?? ''));
    });

    return $out;
}

/**
 * @return array{ok:bool,errors:string[],profile?:array{pseudo:string,rang:string,age:string,ville:string,role:string,arrival_year:string,maitre_du_jeu:bool,games:list<string>,social_rows:list<array{type:string,value:string}>}}
 */
function lfdj_profile_validate_and_normalize(array $post): array
{
    $errors = [];

    $pseudo = isset($post['pseudo']) ? trim((string) $post['pseudo']) : '';
    if ($pseudo === '') {
        $errors[] = 'Le pseudo affiché est obligatoire.';
    } elseif (mb_strlen($pseudo) > 80) {
        $errors[] = 'Le pseudo affiché est trop long (80 caractères max).';
    }

    $rang = isset($post['rang']) ? trim((string) $post['rang']) : '';
    if (mb_strlen($rang) > 120) {
        $errors[] = 'Le rang imaginaire est trop long (120 caractères max).';
    }

    $age = '';
    $ageRaw = isset($post['age']) ? trim((string) $post['age']) : '';
    if ($ageRaw !== '') {
        if (!ctype_digit($ageRaw)) {
            $errors[] = 'L’âge doit être un nombre entier.';
        } else {
            $n = (int) $ageRaw;
            if ($n < 13 || $n > 120) {
                $errors[] = 'L’âge doit être compris entre 13 et 120.';
            } else {
                $age = (string) $n;
            }
        }
    }

    $ville = isset($post['ville']) ? trim((string) $post['ville']) : '';
    if (mb_strlen($ville) > 80) {
        $errors[] = 'La ville est trop longue (80 caractères max).';
    }

    $role = isset($post['role']) ? (string) $post['role'] : '';
    if (!in_array($role, lfdj_profile_role_options(), true)) {
        $errors[] = 'Statut associatif invalide ou manquant.';
        $role = 'membre';
    }

    $arrival_year = '';
    $ayRaw = isset($post['arrival_year']) ? trim((string) $post['arrival_year']) : '';
    if ($ayRaw !== '') {
        if (!ctype_digit($ayRaw)) {
            $errors[] = 'L’année d’arrivée doit être un nombre.';
        } else {
            $y = (int) $ayRaw;
            if (!in_array($y, lfdj_profile_arrival_year_options(), true)) {
                $errors[] = 'L’année d’arrivée doit être comprise entre 2020 et 2026.';
            } else {
                $arrival_year = (string) $y;
            }
        }
    }

    $gamesIn = isset($post['games']) && is_array($post['games']) ? $post['games'] : [];
    $games = [];
    foreach ($gamesIn as $g) {
        $g = trim((string) $g);
        if ($g === '') {
            continue;
        }
        if (mb_strlen($g) > 120) {
            $errors[] = 'Un jeu indiqué est trop long (120 caractères max).';
            break;
        }
        $games[] = $g;
    }
    if (count($games) > LFDJ_PROFILE_GAMES_MAX) {
        $errors[] = 'Vous ne pouvez indiquer que ' . LFDJ_PROFILE_GAMES_MAX . ' jeux au maximum.';
    }

    $types = isset($post['social_type']) && is_array($post['social_type']) ? $post['social_type'] : [];
    $values = isset($post['social_value']) && is_array($post['social_value']) ? $post['social_value'] : [];
    $allowed = lfdj_profile_social_types();
    $social_rows = [];
    for ($i = 0; $i < 3; $i++) {
        $t = isset($types[$i]) ? (string) $types[$i] : 'website';
        if ($t === 'deviantart') {
            $t = 'artstation';
        }
        if (!in_array($t, $allowed, true)) {
            $t = 'website';
        }
        $v = isset($values[$i]) ? trim((string) $values[$i]) : '';
        if (mb_strlen($v) > 200) {
            $errors[] = 'Une URL réseau est trop longue (200 caractères max).';
            break;
        }
        if ($v !== '' && filter_var($v, FILTER_VALIDATE_URL) === false) {
            $errors[] = 'Chaque lien doit être une URL complète valide (ex. https://instagram.com/…).';
            break;
        }
        $social_rows[] = ['type' => $t, 'value' => $v];
    }

    $maitreDuJeu = isset($post['maitre_du_jeu']) && (string) $post['maitre_du_jeu'] === '1';

    if ($errors !== []) {
        return ['ok' => false, 'errors' => $errors];
    }

    return [
        'ok' => true,
        'errors' => [],
        'profile' => [
            'pseudo' => $pseudo,
            'rang' => $rang,
            'age' => $age,
            'ville' => $ville,
            'role' => $role,
            'arrival_year' => $arrival_year,
            'maitre_du_jeu' => $maitreDuJeu,
            'games' => $games,
            'social_rows' => $social_rows,
        ],
    ];
}
