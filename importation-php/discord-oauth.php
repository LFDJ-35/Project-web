<?php

declare(strict_types=1);

function lfdj_discord_config(): array
{
    $id = lfdj_env('DISCORD_CLIENT_ID');
    $secret = lfdj_env('DISCORD_CLIENT_SECRET');
    $redirect = lfdj_env('DISCORD_REDIRECT_URI');
    if ($id === null || $secret === null || $redirect === null) {
        throw new RuntimeException('Configuration Discord incomplète (.env).');
    }
    return [
        'client_id' => $id,
        'client_secret' => $secret,
        'redirect_uri' => $redirect,
    ];
}

function lfdj_discord_authorize_url(string $state): string
{
    $c = lfdj_discord_config();
    $q = http_build_query([
        'client_id' => $c['client_id'],
        'redirect_uri' => $c['redirect_uri'],
        'response_type' => 'code',
        'scope' => 'identify email',
        'state' => $state,
        'prompt' => 'consent',
    ], '', '&', PHP_QUERY_RFC3986);
    return 'https://discord.com/api/oauth2/authorize?' . $q;
}

/**
 * @return array{access_token:string, token_type:string, expires_in:int, refresh_token?:string, scope:string}
 */
function lfdj_discord_exchange_code(string $code): array
{
    $c = lfdj_discord_config();
    $body = http_build_query([
        'client_id' => $c['client_id'],
        'client_secret' => $c['client_secret'],
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $c['redirect_uri'],
    ]);

    $ch = curl_init('https://discord.com/api/oauth2/token');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
    ]);
    $raw = curl_exec($ch);
    $err = curl_error($ch);
    $code_http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) {
        throw new RuntimeException('Discord token: ' . $err);
    }
    $data = json_decode($raw, true);
    if (!is_array($data) || empty($data['access_token'])) {
        $msg = is_array($data) && isset($data['error_description']) ? (string) $data['error_description'] : $raw;
        throw new RuntimeException('Discord token HTTP ' . $code_http . ': ' . $msg);
    }
    return $data;
}

/**
 * @return array{id:string, username:string, discriminator:string, global_name?:string|null, avatar?:string|null, email?:string|null}
 */
function lfdj_discord_fetch_user(string $accessToken): array
{
    $ch = curl_init('https://discord.com/api/users/@me');
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $accessToken],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
    ]);
    $raw = curl_exec($ch);
    $err = curl_error($ch);
    $code_http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false) {
        throw new RuntimeException('Discord @me: ' . $err);
    }
    $data = json_decode($raw, true);
    if (!is_array($data) || empty($data['id'])) {
        throw new RuntimeException('Discord @me HTTP ' . $code_http . ': ' . $raw);
    }
    return $data;
}

function lfdj_random_state(int $bytes = 16): string
{
    return bin2hex(random_bytes($bytes));
}
