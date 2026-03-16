<?php
$photos = range(1, 54);
shuffle($photos); // mélange déjà les images
$photos = array_merge($photos, $photos);

// Délai de départ aléatoire entre 0 et -90s (négatif = démarre "en cours de route")
$delay = rand(0, 90);
?>

<div class="lfdj-carousel-wrap">
    <div class="lfdj-carousel-track" style="animation-delay: -<?= $delay ?>s;">
        <?php foreach ($photos as $n) : ?>
            <div class="lfdj-carousel-item">
                <img
                    src="images/photos-caroussel/photo <?= $n ?>.webp"
                    alt="Photo de La Forge des Joueurs"
                    loading="lazy"
                >
            </div>
        <?php endforeach; ?>
    </div>
</div>