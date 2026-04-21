<?php

declare(strict_types=1);

/** Taille de sortie (carré), en pixels. */
const LFDJ_PROFILE_AVATAR_SIDE = 400;

/** Poids max du fichier envoyé (avant traitement), en octets. */
const LFDJ_PROFILE_AVATAR_MAX_UPLOAD_BYTES = 524288; // 512 Ko

/** Qualité JPEG finale (après recadrage carré). */
const LFDJ_PROFILE_AVATAR_JPEG_QUALITY = 82;

function lfdj_profile_avatar_dir(): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'profile-avatars';
}

function lfdj_profile_avatar_safe_id(string $discordId): string
{
    return preg_replace('/[^0-9]/', '', $discordId) ?: '';
}

/** Chemin absolu du fichier JPEG servi publiquement. */
function lfdj_profile_avatar_fs_path(string $discordId): string
{
    return lfdj_profile_avatar_dir() . DIRECTORY_SEPARATOR . lfdj_profile_avatar_safe_id($discordId) . '.jpg';
}

function lfdj_profile_avatar_exists(string $discordId): bool
{
    $id = lfdj_profile_avatar_safe_id($discordId);
    if ($id === '') {
        return false;
    }
    return is_readable(lfdj_profile_avatar_fs_path($discordId));
}

/** URL relative pour &lt;img src&gt; (depuis la racine du site), ou null si aucun fichier. */
function lfdj_profile_avatar_web_src(string $discordId): ?string
{
    if (!lfdj_profile_avatar_exists($discordId)) {
        return null;
    }
    $id = lfdj_profile_avatar_safe_id($discordId);

    return './images/profile-avatars/' . $id . '.jpg';
}

function lfdj_profile_avatar_delete(string $discordId): void
{
    $p = lfdj_profile_avatar_fs_path($discordId);
    if (is_file($p)) {
        @unlink($p);
    }
}

/**
 * Contrôle rapide avant enregistrement du profil (taille, code d’erreur PHP).
 *
 * @param array{name?:string,type?:string,tmp_name?:string,error?:int,size?:int}|null $f
 */
function lfdj_profile_avatar_preflight(?array $f): ?string
{
    if ($f === null) {
        return null;
    }
    $err = (int) ($f['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($err === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($err !== UPLOAD_ERR_OK) {
        return match ($err) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Fichier trop volumineux (limite dépassée).',
            UPLOAD_ERR_PARTIAL => 'Fichier reçu incomplet — réessayez.',
            default => 'Envoi du fichier refusé ou incomplet.',
        };
    }
    $size = (int) ($f['size'] ?? 0);
    if ($size <= 0) {
        return 'Fichier vide ou illisible.';
    }
    if ($size > LFDJ_PROFILE_AVATAR_MAX_UPLOAD_BYTES) {
        return 'Le fichier est trop volumineux (maximum ' . (int) (LFDJ_PROFILE_AVATAR_MAX_UPLOAD_BYTES / 1024) . ' Ko).';
    }

    return null;
}

/**
 * @param array{name?:string,type?:string,tmp_name?:string,error?:int,size?:int} $f entrée $_FILES['…']
 * @return null|string null si OK, sinon message d’erreur
 */
function lfdj_profile_avatar_save_from_upload(string $discordId, array $f): ?string
{
    $safeId = lfdj_profile_avatar_safe_id($discordId);
    if ($safeId === '') {
        return 'Identifiant invalide pour la photo.';
    }

    $err = (int) ($f['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($err === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($err !== UPLOAD_ERR_OK) {
        return 'Envoi du fichier incomplet ou refusé par le serveur.';
    }

    $size = (int) ($f['size'] ?? 0);
    if ($size <= 0 || $size > LFDJ_PROFILE_AVATAR_MAX_UPLOAD_BYTES) {
        return 'Le fichier est trop volumineux (maximum ' . (int) (LFDJ_PROFILE_AVATAR_MAX_UPLOAD_BYTES / 1024) . ' Ko).';
    }

    $tmp = (string) ($f['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return 'Fichier temporaire introuvable.';
    }

    $mime = '';
    if (class_exists('finfo')) {
        $fi = new finfo(FILEINFO_MIME_TYPE);
        $m = $fi->file($tmp);
        if (is_string($m)) {
            $mime = $m;
        }
    }
    if ($mime === '' && function_exists('mime_content_type')) {
        $m = @mime_content_type($tmp);
        if (is_string($m)) {
            $mime = $m;
        }
    }

    $allowed = ['image/jpeg' => 'jpeg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) {
        return 'Format non accepté : utilisez une image JPEG, PNG ou WebP.';
    }

    $info = @getimagesize($tmp);
    if ($info === false || ($info[0] ?? 0) < 8 || ($info[1] ?? 0) < 8) {
        return 'Image illisible ou trop petite.';
    }

    if (!function_exists('imagecreatetruecolor')) {
        return 'Le serveur ne dispose pas de l’extension GD nécessaire pour traiter l’image.';
    }

    $src = match ($mime) {
        'image/jpeg' => @imagecreatefromjpeg($tmp),
        'image/png' => @imagecreatefrompng($tmp),
        'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmp) : false,
        default => false,
    };
    if ($src === false) {
        return 'Impossible de décoder l’image.';
    }

    $sw = imagesx($src);
    $sh = imagesy($src);
    $side = min($sw, $sh);
    $sx = (int) (($sw - $side) / 2);
    $sy = (int) (($sh - $side) / 2);

    $dst = imagecreatetruecolor(LFDJ_PROFILE_AVATAR_SIDE, LFDJ_PROFILE_AVATAR_SIDE);
    if ($dst === false) {
        imagedestroy($src);
        return 'Erreur interne lors du redimensionnement.';
    }

    imagecopyresampled($dst, $src, 0, 0, $sx, $sy, LFDJ_PROFILE_AVATAR_SIDE, LFDJ_PROFILE_AVATAR_SIDE, $side, $side);
    imagedestroy($src);

    $dir = lfdj_profile_avatar_dir();
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
            imagedestroy($dst);
            return 'Impossible de créer le dossier des photos.';
        }
    }

    $out = lfdj_profile_avatar_fs_path($discordId);
    if (!imagejpeg($dst, $out, LFDJ_PROFILE_AVATAR_JPEG_QUALITY)) {
        imagedestroy($dst);
        return 'Échec de l’enregistrement de l’image.';
    }
    imagedestroy($dst);

    return null;
}
