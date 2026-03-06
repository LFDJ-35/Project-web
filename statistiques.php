<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>Statistiques du site – La Forge des Joueurs</title>
<meta name="description" content="Consultez les statistiques de fréquentation du site de La Forge des Joueurs : visites par page et par mois." />
<?php require('importation-php/regles.php'); ?>
<meta name="robots" content="noindex, nofollow">
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
        <div class="lfdj-kaz-research2">
            <input class="lfdj-kaz-research" type="text" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher un mois ou une page...">
        </div>

        <table id="statsTable">
            <thead>
                <tr class="lfdj-tr1">
                    <th class="lfdj-th1" onclick="sortTable(0)">
                        Mois<span id="arrow0">↕</span>
                    </th>
                    <th class="lfdj-th1" onclick="sortTable(1)">
                        Page<span id="arrow1">↕</span>
                    </th>
                    <th class="lfdj-th1" onclick="sortTable(2)">
                        Nmb. visites<span id="arrow2">↕</span>
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
                    echo "<td class='lfdj-td2'>$mois</td>";
                    echo "<td class='lfdj-td2'><code>$page</code></td>";
                    echo "<td class='lfdj-td2'>
                            <span>$visites</span>
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