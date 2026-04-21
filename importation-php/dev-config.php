<?php

declare(strict_types=1);

require_once __DIR__ . '/config-env.php';

/** Accès à mon-compte.php sans OAuth pour mise en page / config locale. Jamais en production. */
function lfdj_dev_mon_compte_preview_enabled(): bool
{
    $v = strtolower(trim((string) (lfdj_env('LFDJ_DEV_MON_COMPTE_PREVIEW', '') ?? '')));
    return $v === '1' || $v === 'true' || $v === 'yes';
}

/** @return array<string, mixed> */
function lfdj_dev_mock_discord_user(): array
{
    return [
        'id' => '900000000000000001',
        'username' => 'apercu_config',
        'global_name' => null,
        'discriminator' => '0',
        'avatar' => null,
        'email' => null,
        'display' => 'Aperçu (sans Discord)',
    ];
}
