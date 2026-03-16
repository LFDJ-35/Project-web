<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
    <title>Trombinoscope – Les membres de La Forge des Joueurs à Vitré</title>
    <meta name="description"
        content="Découvrez le trombinoscope de La Forge des Joueurs : les membres de l'association de jeux de rôle, jeux de société et figurines à Vitré." />
    <?php require('importation-php/regles.php');
    include('importation-php/telemetrie.php'); ?>

    <style>
        /* ── Trombinoscope grid ── */
        .trombi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 24px;
            max-width: 1200px;
            margin: 40px auto 60px auto;
            padding: 0 5%;
        }

        /* ── Single card ── */
        .member-card {
            background-color: var(--background);
            border: 1px solid rgba(200, 164, 77, 0.25);
            border-radius: 12px;
            padding: 24px 16px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .member-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(200, 164, 77, 0.18);
        }

        /* ── Slot vide ── */
        .member-card.slot-empty {
            border-style: dashed;
            border-color: rgba(200, 164, 77, 0.2);
            opacity: 0.45;
        }

        .member-card.slot-empty:hover {
            transform: none;
            box-shadow: none;
        }

        /* ── Avatar (tous les membres, photo ou pas) ── */
        .member-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: rgba(200, 164, 77, 0.12);
            border: 3px dashed rgba(200, 164, 77, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(200, 164, 77, 0.4);
            font-size: 28px;
            object-fit: cover; /* ignoré si c'est une div, utile si on passe à <img> */
            flex-shrink: 0;
        }

        /* Quand on a une vraie photo : remplacer la div par <img class="member-avatar member-avatar-photo"> */
        img.member-avatar {
            border-style: solid;
            border-color: var(--primary-color);
        }

        /* ── Pseudo ── */
        .member-name {
            font-family: var(--font-secondary);
            font-size: 17px;
            font-weight: 700;
            color: var(--black-color);
            text-transform: none;
            margin: 0;
            line-height: 1.2;
        }

        .member-name-empty {
            font-family: var(--font-third);
            font-size: 13px;
            color: rgba(141, 141, 141, 0.6);
            font-style: italic;
        }

        /* ── Titre (ex : "Maître des Panthères") ── */
        .member-title {
            font-family: var(--font-secondary);
            font-size: 11px;
            font-style: italic;
            color: var(--primary-color);
            margin: -6px 0 0 0;
            line-height: 1.3;
        }

        /* ── Séparateur ── */
        .member-card hr {
            width: 100%;
            border: none;
            border-top: 1px solid rgba(200, 164, 77, 0.2);
            margin: 2px 0;
        }

        /* ── Tags communs ── */
        .tag-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .tag {
            font-family: var(--font-third);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 9px;
            border-radius: 20px;
            background-color: rgba(200, 164, 77, 0.12);
            color: var(--black-color);
            line-height: 1.4;
        }

        /* Rôles spéciaux */
        .tag-president {
            background-color: var(--primary-color);
            color: #171717;
            font-weight: 700;
        }

        .tag-bureau {
            background-color: var(--secondary-color);
            color: #fff;
            font-weight: 600;
        }

        .tag-mj {
            background-color: rgba(142, 83, 58, 0.15);
            color: var(--secondary-color);
            font-weight: 600;
        }

        /* ── Couleurs des tags de jeux au hover ── */
        /* Transition douce */
        .tag-game {
            transition: background-color 0.2s ease, color 0.2s ease;
            cursor: default;
        }

        /* ── Palette jeux ── */
        .tag-game.game-dnd:hover          { background-color: #7b2d8b; color: #fff; }   /* D&D — violet */
        .tag-game.game-warhammer:hover    { background-color: #b22222; color: #fff; }   /* Warhammer — rouge sang */
        .tag-game.game-zombicide:hover    { background-color: #2e7d32; color: #fff; }   /* Zombicide — vert */
        .tag-game.game-cyberpunk:hover    { background-color: #d32f2f; color: #fff; }   /* Cyberpunk RED — rouge vif */
        .tag-game.game-pathfinder:hover   { background-color: #e65100; color: #fff; }   /* Pathfinder — orange */
        .tag-game.game-starwars:hover     { background-color: #1565c0; color: #FFE81F; } /* Star Wars — bleu/jaune */
        .tag-game.game-cthulhu:hover      { background-color: #37474f; color: #a5d6a7; } /* Cthulhu — vert sombre */
        .tag-game.game-bloodbowl:hover    { background-color: #4a148c; color: #fff; }   /* Blood Bowl — violet foncé */
        .tag-game.game-runewars:hover     { background-color: #880e4f; color: #fff; }   /* RuneWars — rose foncé */
        .tag-game.game-starfinder:hover   { background-color: #0d47a1; color: #fff; }   /* Starfinder — bleu */
        .tag-game.game-shadowrun:hover    { background-color: #212121; color: #76ff03; } /* Shadowrun — noir/vert néon */
        .tag-game.game-pokemontcg:hover   { background-color: #ffcc00; color: #c00; }   /* Pokémon TCG — jaune/rouge */
        .tag-game.game-magicthegathering:hover { background-color: #1a237e; color: #ffd54f; } /* MTG — bleu/or */
        /* Fallback générique pour n'importe quel .tag-game sans classe spécifique */
        .tag-game:hover                   { background-color: rgba(200,164,77,0.5); color: var(--black-color); }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .trombi-grid {
                grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
                gap: 16px;
                padding: 0 4%;
            }
        }

        /* ── Titre de section ── */
        .trombi-section-title {
            text-align: center;
            margin: 60px auto 0 auto;
            padding: 0 5%;
        }
    </style>
</head>

<body class="lfdj-maincontainer">

    <?php require('importation-php/menu.php'); ?>

    <div class="lfdj-divtitle" style="margin-top: 55px;">
        <h4 style="text-align:center;">Association de jeux à Vitré</h4>
        <h2>Les membres</h2>
        <div class="lfdj-title-icon"><i class="fa-solid fa-users"></i></div>
    </div>

    <div class="lfdj-bloc-text">
        <p>Retrouvez ici tous les membres actifs de La Forge des Joueurs. Chaque carte présente le pseudo, le rôle et les jeux de prédilection de chacun.</p>
    </div>

    <!-- ═══════════════════════════════════════════
         GRILLE MEMBRES  —  20 slots
         Pour ajouter un membre : dupliquer un bloc
         .member-card et retirer la classe slot-empty.
    ═══════════════════════════════════════════ -->
    <div class="trombi-grid">

        <!-- ── Membre 1 ── -->
        <div class="member-card">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name">Kalimsharr</p>
            <p class="member-title">Seigneur des Donjons</p>
            <hr>
            <div class="tag-group">
                <span class="tag tag-president">Président</span>
                <span class="tag tag-mj">Maître du Jeu</span>
                <span class="tag">Joueur</span>
            </div>
            <hr>
            <div class="tag-group">
                <span class="tag tag-game game-dnd">🐉 D&D</span>
                <span class="tag tag-game game-warhammer">🔨 Warhammer</span>
                <span class="tag tag-game game-zombicide">🧟 Zombicide</span>
            </div>
        </div>

        <!-- ── Membre 2 ── -->
        <div class="member-card">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name">Spirito</p>
            <p class="member-title">Maître des Panthères</p>
            <hr>
            <div class="tag-group">
                <span class="tag tag-bureau">Bureau</span>
                <span class="tag tag-mj">Maître du Jeu</span>
                <span class="tag">Joueur</span>
            </div>
            <hr>
            <div class="tag-group">
                <span class="tag tag-game game-dnd">🐉 D&D</span>
                <span class="tag tag-game game-warhammer">🔨 Warhammer</span>
                <span class="tag tag-game game-zombicide">🧟 Zombicide</span>
            </div>
        </div>

        <!-- ── Membre 3 ── -->
        <div class="member-card">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name">Lucaschou</p>
            <p class="member-title">Forgeron en Chef</p>
            <hr>
            <div class="tag-group">
                <span class="tag tag-bureau">Bureau</span>
                <span class="tag tag-mj">Maître du Jeu</span>
            </div>
            <hr>
            <div class="tag-group">
                <span class="tag tag-game game-dnd">🐉 D&D</span>
                <span class="tag tag-game game-warhammer">🔨 Warhammer</span>
                <span class="tag tag-game game-zombicide">🧟 Zombicide</span>
            </div>
        </div>

        <!-- ── Membre 4 ── -->
        <div class="member-card">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name">Terminator</p>
            <p class="member-title">Exterminateur de Tables</p>
            <hr>
            <div class="tag-group">
                <span class="tag tag-mj">Maître du Jeu</span>
                <span class="tag">Joueur</span>
            </div>
            <hr>
            <div class="tag-group">
                <span class="tag tag-game game-dnd">🐉 D&D</span>
                <span class="tag tag-game game-warhammer">🔨 Warhammer</span>
                <span class="tag tag-game game-zombicide">🧟 Zombicide</span>
            </div>
        </div>

        <!-- ══════════════════════════════════════
             SLOTS VIDES (5 → 20)
             Remplacer slot-empty par vos données
        ══════════════════════════════════════ -->

        <!-- ── Slot 5 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 6 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 7 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 8 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 9 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 10 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 11 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 12 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 13 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 14 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 15 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 16 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 17 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 18 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 19 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

        <!-- ── Slot 20 ── -->
        <div class="member-card slot-empty">
            <div class="member-avatar"><i class="fa-solid fa-user"></i></div>
            <p class="member-name-empty">Membre à venir</p>
        </div>

    </div><!-- /trombi-grid -->

    <?php require('importation-php/footer.php'); ?>

</body>
</html>
