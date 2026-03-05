<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="fr" class="no-js"><![endif]-->

<head>
<title>La Forge des Joueurs – Association de jeux à Vitré</title>
<meta name="description" content="La Forge des Joueurs est une association vitréenne dédiée aux jeux de rôle, jeux de figurines, jeux de société et cartes. Rejoignez-nous à Vitré." />
<?php require('importation-php/regles.php'); include('importation-php/telemetrie.php'); ?>
</head>

<body class="lfdj-maincontainer">

    <?php require('importation-php/menu.php'); ?>

    <div class="lfdj-bloc-text">
        <h2 style="text-align: center; color: var(--primary-color);">Membres de la Forge</h1>
        
        <div class="trombi-container">
            <div class="member-card">
                <div class="member-photo">
                    <img src="../images/trombinoscope/Placeholder.jpg" alt="Photo de Membre">
                </div>
                <div class="member-info">
                    <h1>Nom du Membre</h1>
                    <span class="badge-role">Président</span>
                    <p class="presentation">Passionné de jeux de rôle depuis 10 ans, j'aime créer des univers immersifs pour mes joueurs.</p>
                    
                    <div class="status">
                        <strong>Rôle :</strong> <span class="tag">Maître du Jeu</span> <span class="tag">Joueur</span>
                    </div>
                    
                    <div class="games">
                        <p><strong>Jeux favoris :</strong> Warhammer, Donjons & Dragons, Zombicide.</p>
                    </div>
                </div>
            </div>    
        </div>

        <div class="trombi-container">
            <div class="member-card">
                <div class="member-photo">
                    <img src="../images/trombinoscope/Placeholder.jpg" alt="Photo de Membre">
                </div>
                <div class="member-info">
                    <h1>Nom du Membre</h1>
                    <span class="badge-role">Président</span>
                    <p class="presentation">Passionné de jeux de rôle depuis 10 ans, j'aime créer des univers immersifs pour mes joueurs.</p>
                    
                    <div class="status">
                        <strong>Rôle :</strong> <span class="tag">Maître du Jeu</span> <span class="tag">Joueur</span>
                    </div>
                    
                    <div class="games">
                        <p><strong>Jeux favoris :</strong> Warhammer, Donjons & Dragons, Zombicide.</p>
                    </div>
                </div>
            </div>    
        </div>

        <div class="trombi-container">
            <div class="member-card">
                <div class="member-photo">
                    <img src="../images/trombinoscope/Placeholder.jpg" alt="Photo de Membre">
                </div>
                <div class="member-info">
                    <h1>Nom du Membre</h1>
                    <span class="badge-role">Président</span>
                    <p class="presentation">Passionné de jeux de rôle depuis 10 ans, j'aime créer des univers immersifs pour mes joueurs.</p>
                    
                    <div class="status">
                        <strong>Rôle :</strong> <span class="tag">Maître du Jeu</span> <span class="tag">Joueur</span>
                    </div>
                    
                    <div class="games">
                        <p><strong>Jeux favoris :</strong> Warhammer, Donjons & Dragons, Zombicide.</p>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <?php require('importation-php/footer.php'); ?>

</body>

<style>
h1{
  font-family: var(--font-primary);
  font-weight: 900;
  font-size: 30px;
  line-height: 36px;
  text-transform: lowercase;
  color: var(--secondary-color);
}
.lfdj-maincontainer {
    display: flex;
    flex-direction: column;
    min-height: 100vh; 
}

.lfdj-bloc-text {
    flex: 1;
    max-width: 1400px !important;
}

.trombi-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px 0;
}

.member-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid #444;
    border-radius: 10px;
    width: 100%;
    max-width: 1000px;
    display: flex;
    overflow: hidden;
    transition: transform 0.3s;
}

.member-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
}

.member-photo img {
    width: auto;
    max-width: 250px;
    height: auto;
    max-height: 250px;
    object-fit: cover;
    border-right: 2px solid var(--primary);
}

.member-info {
    padding: 15px;
    color: white;
    margin: 10px;
}

.badge-role {
    font-size: 1.5em;
    color: var(--primary-color);
    margin: 20px;
}

.tag {
    background: #333;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.9em;
    margin-right: 5px;
}

.presentation {
    font-style: italic;
    font-size: 0.9em;
    margin: 10px 0;
}
</style>