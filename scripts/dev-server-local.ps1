# Serveur de developpement local (sans Docker) - La Forge des Joueurs
# Usage : powershell -ExecutionPolicy Bypass -File .\scripts\dev-server-local.ps1

$ErrorActionPreference = 'Stop'
$root = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
Set-Location $root

$avatarsDir = Join-Path $root 'images\profile-avatars'
if (-not (Test-Path $avatarsDir)) {
    New-Item -ItemType Directory -Force -Path $avatarsDir | Out-Null
    Write-Host 'Dossier cree : images\profile-avatars' -ForegroundColor DarkGray
}

$phpCmd = Get-Command php -ErrorAction SilentlyContinue
if (-not $phpCmd) {
    Write-Host ''
    Write-Host 'PHP nest pas installe ou pas dans le PATH Windows.' -ForegroundColor Yellow
    Write-Host ''
    Write-Host 'Option A - winget (Windows 10/11) :' -ForegroundColor Cyan
    Write-Host '  winget source update'
    Write-Host '  winget install PHP.PHP.8.4'
    Write-Host '  Si erreur 404 : essayez  winget install PHP.PHP.8.3  ou le ZIP (option B).'
    Write-Host '  (evitez : winget install php  seul - mauvais paquet possible.)'
    Write-Host '  Puis fermez et rouvrez ce terminal, verifiez : php -v'
    Write-Host ''
    Write-Host 'Option B - ZIP manuel :' -ForegroundColor Cyan
    Write-Host '  1. Telechargez PHP 8.x VS16 x64 Thread Safe (ZIP) : https://windows.php.net/download/'
    Write-Host '  2. Decompressez dans un dossier fixe, ex. C:\php'
    Write-Host '  3. Variables environnement : ajoutez C:\php au Path utilisateur ou machine'
    Write-Host '  4. Dans C:\php, copiez php.ini-development en php.ini'
    Write-Host '  5. Dans php.ini, decommentez la ligne extension=gd (enlever ; devant)'
    Write-Host '  6. Verifiez extension_dir = ext (dossier des extensions PHP)'
    Write-Host '  7. Rouvrez ce terminal et relancez ce script'
    Write-Host ''
    exit 1
}

$gdCheck = & php -r "echo extension_loaded('gd') ? '1' : '0';" 2>$null
if ($gdCheck -ne '1') {
    Write-Host ''
    Write-Host 'Extension GD manquante (photos de profil).' -ForegroundColor Yellow
    Write-Host ''
    Write-Host 'Emplacement du php.ini :' -ForegroundColor Cyan
    & php --ini 2>$null
    Write-Host 'Ouvrez ce php.ini, decommentez extension=gd, enregistrez, puis relancez ce script.'
    Write-Host ''
    exit 1
}

Write-Host ''
Write-Host 'PHP OK + GD OK' -ForegroundColor Green
Write-Host 'Site : http://127.0.0.1:8080/index.php' -ForegroundColor Cyan
Write-Host 'Arret : Ctrl+C' -ForegroundColor DarkGray
Write-Host ''

& php -S 127.0.0.1:8080 -t $root
