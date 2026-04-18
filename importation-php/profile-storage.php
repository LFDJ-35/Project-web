<?php

declare(strict_types=1);

/** @return array{pseudo:string,age:string,role:string,games:string,social_links:string} */
function lfdj_profile_defaults(): array
{
    return [
        'pseudo' => '',
        'age' => '',
        'role' => 'curieux',
        'games' => '',
        'social_links' => '',
    ];
}

function lfdj_profiles_dir(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'profiles';
}

/** @return array{pseudo:string,age:string,role:string,games:string,social_links:string} */
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
    $base = lfdj_profile_defaults();
    foreach ($base as $k => $_) {
        if (isset($data[$k]) && is_string($data[$k])) {
            $base[$k] = $data[$k];
        }
    }
    return $base;
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
 * @param array{pseudo:string,age:string,role:string,games:string,social_links:string} $profile
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

/** @return string[] */
function lfdj_profile_role_options(): array
{
    return ['directeur', 'ca', 'membres', 'curieux'];
}

function lfdj_profile_role_label(string $role): string
{
    $map = [
        'directeur' => 'Directeur / Directrice',
        'ca' => 'CA',
        'membres' => 'Membres',
        'curieux' => 'Curieux / curieuses',
    ];
    return $map[$role] ?? $role;
}

/**
 * @return array{ok:bool,errors:string[],profile?:array{pseudo:string,age:string,role:string,games:string,social_links:string}}
 */
function lfdj_profile_validate_and_normalize(array $post): array
{
    $errors = [];
    $pseudo = isset($post['pseudo']) ? trim((string) $post['pseudo']) : '';
    if ($pseudo === '') {
        $errors[] = 'Le pseudo est obligatoire.';
    } elseif (mb_strlen($pseudo) > 80) {
        $errors[] = 'Le pseudo est trop long (80 caractères max).';
    }

    $ageRaw = isset($post['age']) ? trim((string) $post['age']) : '';
    $age = '';
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

    $role = isset($post['role']) ? (string) $post['role'] : '';
    if (!in_array($role, lfdj_profile_role_options(), true)) {
        $errors[] = 'Rôle dans l’association invalide.';
        $role = 'curieux';
    }

    $games = isset($post['games']) ? trim((string) $post['games']) : '';
    if (mb_strlen($games) > 2000) {
        $errors[] = 'La liste des jeux est trop longue.';
    }

    $socialRaw = isset($post['social_links']) ? trim((string) $post['social_links']) : '';
    if (mb_strlen($socialRaw) > 2000) {
        $errors[] = 'Les liens sont trop longs.';
    }
    $lines = preg_split('/\r\n|\n|\r/', $socialRaw) ?: [];
    $urls = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }
        if (filter_var($line, FILTER_VALIDATE_URL) === false) {
            $errors[] = 'Lien non valide : ' . mb_substr($line, 0, 80);
            break;
        }
        $urls[] = $line;
    }
    if (count($urls) > 20) {
        $errors[] = 'Maximum 20 liens.';
    }

    if ($errors !== []) {
        return ['ok' => false, 'errors' => $errors];
    }

    return [
        'ok' => true,
        'errors' => [],
        'profile' => [
            'pseudo' => $pseudo,
            'age' => $age,
            'role' => $role,
            'games' => $games,
            'social_links' => implode("\n", $urls),
        ],
    ];
}

