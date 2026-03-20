<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>Statistiques du site – La Forge des Joueurs</title>
<meta name="description" content="Consultez les statistiques de fréquentation du site de La Forge des Joueurs : visites par page et par mois." />
<?php require('importation-php/regles.php'); ?>
<meta name="robots" content="noindex, nofollow">
</head>

<body class="lfdj-maincontainer">

    <?php require('importation-php/menu.php'); ?>

    <div class="lfdj-bloc-text">
        <h2 style="color: var(--primary-color); text-align: center;">Parcours Utilisateurs</h2>
        
        <table id="statsTable" style="width: 100%; border-collapse: collapse; color: white; border: 1px solid #333;">
            <thead>
                <tr style="background-color: rgba(255,255,255,0.05);">
                    <th style="padding: 12px; border: 1px solid #333; color: white;">Cookie</th>
                    <th style="padding: 12px; border: 1px solid #333; color: white;">Date de visite</th>
                    <th style="padding: 12px; border: 1px solid #333; color: white;">Page</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cheminFichier = __DIR__ . '/stats_parcours.csv';
                
                if (file_exists($cheminFichier)) {
                    $lignes = file($cheminFichier, FILE_IGNORE_NEW_LINES);
                    
                    $lignes = array_reverse($lignes);

                    foreach ($lignes as $ligne) {
                        $data = str_getcsv($ligne, ",", '"', "\\");
                        
                        if(count($data) < 3) continue;

                        $uuid = $data[0];
                        $dateVisite = $data[1]; 
                        $page = $data[2];

                        echo "<tr>";
                        echo "<td style='padding: 12px; border: 1px solid #333; text-align: center;'><code>$uuid</code></td>";
                        echo "<td style='padding: 12px; border: 1px solid #333; text-align: center;'>$dateVisite</td>";
                        echo "<td style='padding: 12px; border: 1px solid #333; text-align: center; color: #4db8ff;'>$page</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='padding: 20px; text-align: center;'>Aucune donnée disponible.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
        
    <?php require('importation-php/footer.php'); ?>

</body>
</html>