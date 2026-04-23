<?php
// On lit les différents fichiers présents dans images/photos-caroussel
$all_images = glob("images/photos-caroussel/*.webp");

if($all_images == False)
{
    // Une erreur s'est produite.
    error_log("Impossible de récupérer les images du caroussel");
}

// mélange déjà les images
shuffle($all_images);
// Délai de départ aléatoire entre 0 et -90s (négatif = démarre "en cours de route")
$delay = rand(0, 90);
?>

<div class="lfdj-carousel-wrap">
    <div class="lfdj-carousel-track" style="animation-delay: -<?= $delay ?>s;">
        <?php foreach ($all_images as $photo) : ?>
            <div class="lfdj-carousel-item">
                <img
                    src="<?= $photo ?>"
                    alt="Photo de La Forge des Joueurs"
                    loading="lazy"
                >
            </div>
        <?php endforeach; ?>
    </div>
</div>