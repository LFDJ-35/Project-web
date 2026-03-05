<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>Statistiques | La Forge des Joueurs</title>
<meta name="description" content="Statistiques des visites par mois et par pages" />
<?php require('importation-php/regles.php'); ?>
<style>
    .lfdj-maincontainer {
        display: flex;
        flex-direction: column;
        min-height: 100vh; 
    }

    .lfdj-bloc-text {
        flex: 1;
    }
</style>
</head>

<script>
function filterTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("statsTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdMois = tr[i].getElementsByTagName("td")[0];
        let tdPage = tr[i].getElementsByTagName("td")[1];
        if (tdMois || tdPage) {
            let txtValue = (tdMois.textContent || tdMois.innerText) + (tdPage.textContent || tdPage.innerText);
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("statsTable");
    switching = true;
    dir = "asc"; 

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            let valX = x.innerText.toLowerCase();
            let valY = y.innerText.toLowerCase();

            if (n === 2) {
                valX = parseInt(x.innerText) || 0;
                valY = parseInt(y.innerText) || 0;
            }

            if (dir == "asc") {
                if (valX > valY) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (valX < valY) {
                    shouldSwitch = true;
                    break;
                }
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }

    updateSortIcons(n, dir);
}

function updateSortIcons(columnIndex, direction) {
    const arrowIds = ["arrow0", "arrow1", "arrow2"];
    
    arrowIds.forEach((id, index) => {
        const arrowSpan = document.getElementById(id);
        if (arrowSpan) {
            if (index === columnIndex) {
                arrowSpan.innerHTML = (direction === "asc") ? " ▲" : " ▼";
                arrowSpan.style.color = "gold";
            } else {
                arrowSpan.innerHTML = " ↕";
                arrowSpan.style.color = "white";
            }
        }
    });
}
</script>

<body class="lfdj-maincontainer">

    <?php require('importation-php/menu.php'); ?>

    <div class="lfdj-divtitle">
        <h2>Statistiques de visites par mois et par page :</h2>
        <div class="lfdj-title-icon">
            <i class="fa-solid fa-book-open"></i>
        </div>
    </div>

    <div class="lfdj-bloc-text">
        <div style="margin-bottom: 20px; text-align: center;">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher un mois ou une page..." 
                style="padding: 10px; width: 60%; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <table id="statsTable" style="width: 100%; border-collapse: collapse; color: white;">
            <thead>
                <tr style="background-color: rgba(255,255,255,0.1);">
                    <th onclick="sortTable(0)" style="cursor:pointer; padding: 12px; border-bottom: 2px solid var(--primary-color);">
                        Mois <span id="arrow0">↕</span>
                    </th>
                    <th onclick="sortTable(1)" style="cursor:pointer; padding: 12px; border-bottom: 2px solid var(--primary-color);">
                        Page visitée <span id="arrow1">↕</span>
                    </th>
                    <th onclick="sortTable(2)" style="cursor:pointer; padding: 12px; border-bottom: 2px solid var(--primary-color);">
                        Nombre de visites <span id="arrow2">↕</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stats = file(__DIR__ . '/stats_visites.txt', FILE_IGNORE_NEW_LINES);
                $compteur = array_count_values($stats);

                foreach ($compteur as $ligne => $visites) {
                    $data = explode(" | ", $ligne);
                    $mois = $data[0] ?? 'Inconnu';
                    $page = $data[1] ?? 'Inconnu';
                    
                    echo "<tr>";
                    echo "<td style='padding: 10px; border-bottom: 1px solid #444;'>$mois</td>";
                    echo "<td style='padding: 10px; border-bottom: 1px solid #444;'><code>$page</code></td>";
                    echo "<td style='padding: 10px; border-bottom: 1px solid #444; text-align: center;'>
                            <span style='background: var(--primary-color); color: black; padding: 2px 8px; border-radius: 10px; font-weight: bold;'>$visites</span>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
        
    <?php require('importation-php/footer.php'); ?>

</body>
</html>