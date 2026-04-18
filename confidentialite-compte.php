<?php require_once __DIR__ . '/importation-php/auth-session.php'; ?>
<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
  <title>Confidentialité — compte membre | La Forge des Joueurs</title>
  <meta name="description" content="Politique de confidentialité relative à la connexion Discord et aux données du formulaire membre de La Forge des Joueurs." />
  <?php require __DIR__ . '/importation-php/regles.php'; ?>
</head>
<body class="lfdj-maincontainer">

  <?php require __DIR__ . '/importation-php/menu.php'; ?>

  <div class="lfdj-divtitle">
    <h4>Données personnelles</h4>
    <h2>Confidentialité (compte)</h2>
    <div class="lfdj-title-icon">
      <i class="fa-solid fa-shield-halved"></i>
    </div>
  </div>

  <div class="lfdj-bloc-text">
    <p>
      La présente page complète les <a href="./mentions-legales.php">mentions légales</a> pour le service de
      <strong>connexion au site via Discord</strong> et le <strong>formulaire « Mon compte »</strong>.
    </p>

    <h3 class="lfdj-privacy-block-title">Responsable du traitement</h3>
    <p>
      <strong>LA FORGE DES JOUEURS</strong>, association loi 1901 — 27 Rue Notre Dame, 35500 Vitré, France.<br>
      Contact : <a href="mailto:laforgedesjoueurs@gmail.com">laforgedesjoueurs@gmail.com</a>
    </p>

    <h3 class="lfdj-privacy-block-title">Données collectées</h3>
    <ul class="lfdj-privacy-list">
      <li>
        <strong>Lors de la connexion Discord</strong> : identifiant Discord, nom d’utilisateur / nom d’affichage, adresse e-mail
        (si vous l’autorisez côté Discord), avatar — conformément aux scopes OAuth demandés (<em>identify</em>, <em>email</em>).
      </li>
      <li>
        <strong>Via le formulaire « Mon compte »</strong> : pseudo affiché, âge (facultatif), rôle au sein de l’association,
        jeux pratiqués, liens vers vos réseaux (facultatif).
      </li>
    </ul>

    <h3 class="lfdj-privacy-block-title">Finalités</h3>
    <p>
      Reconnaître les membres sur le site, afficher et mettre à jour une fiche d’informations utile à l’association
      (organisation, communication interne, statistiques locales). Les finalités pourront être précisées ultérieurement ;
      en cas de changement substantiel, cette page sera mise à jour.
    </p>

    <h3 class="lfdj-privacy-block-title">Base légale</h3>
    <p>
      Exécution de mesures précontractuelles / relation avec les membres et, le cas échéant, intérêt légitime de l’association
      pour gérer son fonctionnement. Pour certaines données (ex. âge, liens), la base peut être le <strong>consentement</strong>,
      recueilli par l’usage du formulaire.
    </p>

    <h3 class="lfdj-privacy-block-title">Destinataires & hébergement</h3>
    <p>
      Les données techniques de session sont stockées sur l’hébergement du site. Discord USA (Discord Inc.) intervient en tant
      que fournisseur d’authentification ; consultez la
      <a href="https://discord.com/privacy" rel="noopener noreferrer" target="_blank">politique de confidentialité de Discord</a>.
    </p>

    <h3 class="lfdj-privacy-block-title">Durées de conservation</h3>
    <p>
      Données de session : jusqu’à déconnexion ou expiration du cookie de session. Données du formulaire « Mon compte » :
      conservées tant que le compte / la fiche est utile aux finalités ci-dessus ; vous pouvez demander leur suppression
      (voir ci-dessous).
    </p>

    <h3 class="lfdj-privacy-block-title">Vos droits</h3>
    <p>
      Conformément au RGPD, vous disposez des droits d’accès, de rectification, d’effacement, de limitation, d’opposition
      et de portabilité (s’ils s’appliquent), ainsi que du droit d’introduire une réclamation auprès de la CNIL
      (<a href="https://www.cnil.fr" rel="noopener noreferrer" target="_blank">cnil.fr</a>).
      Pour exercer vos droits : <a href="mailto:laforgedesjoueurs@gmail.com">laforgedesjoueurs@gmail.com</a>.
    </p>

    <h3 class="lfdj-privacy-block-title">Sécurité</h3>
    <p>
      Le secret OAuth (client secret) est conservé uniquement sur le serveur (fichier non versionné). Les fichiers de profil
      sont stockés dans un répertoire non accessible publiquement. Utilisez HTTPS (déjà imposé sur ce site).
    </p>
  </div>

  <?php require __DIR__ . '/importation-php/footer.php'; ?>
</body>
</html>
