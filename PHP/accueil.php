<?php
session_start();
$isLoggedIn = isset($_SESSION["id_utilisateur"]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Île de Molène - Érosion et Submersion</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <header>
        <div class="hero">
            <img src="..\image\imaginaire.jpg" alt="Imaginaire">
            <div class="login-link">
                <?php if ($isLoggedIn): ?>
                    <a href="http://localhost/SITE_MOLENE2/PHP/logout.php">Log out</a>
                <?php else: ?>
                    <a href="http://localhost/SITE_MOLENE2/PHP/authentification.php">Log in</a>
                <?php endif; ?>
            </div>
            <h1>Récits et imaginaires croisés<br>Espace d'échange, de création et de partage</h1>
        </div>
    </header>
    
    <main>
        <section class="intro">
            <h2>Bienvenue sur Récits et imaginaires croisés</h2>
            <h3>Un espace collaboratif dédié à la gestion et au partage de données</h3>
            <p>Notre plateforme a été conçue pour faciliter le stockage, le partage et la visualisation de données au sein de projets collaboratifs.
            <h3>Un espace de stockage et de partage</h3>
            Ce site permet de créer des projets collaboratifs où chaque utilisateur peut stocker, organiser et partager des données avec son équipe. Qu’il s’agisse d’analyses scientifiques, de rapports ou de fichiers multimédias, tout est centralisé pour une meilleure gestion.
            <h3>Une visualisation intuitive des données</h3>
            Les données enregistrées peuvent être visualisées de manière interactive grâce à des outils adaptés, notamment des cartes et des graphiques dynamiques, afin d’exploiter l’information plus efficacement.
            <h3>Comment utiliser le site ?</h3>
            1️⃣ Créer un compte : L’inscription est nécessaire pour interagir avec les autres utilisateurs et gérer des projets.<p>
            2️⃣ Créer ou rejoindre un projet : Chaque utilisateur peut créer un projet public ou privé et y ajouter ses propres données via son espace personnel.<p>
            3️⃣ Classer les données par niveau de chaleur : Lorsqu’une donnée est ajoutée, elle doit être classée selon son niveau de traitement.<p>
        </p>
        </section>

        <section class="intro">
            <h2>Le système des niveaux de chaleur</h2>
            <h3>Les données suivent un processus de traitement représenté par un thermomètre :</h3>
            <h3>Niveau 1 (donnée chaude 🔥) : </h3>
            La donnée vient d’être ajoutée et n’a pas encore été traitée.            
            <h3>Niveau 2</h3>
            La donnée est en cours de pré-analyse.
            <h3>Niveau 3</h3>
            La donnée a été modifiée ou enrichie (exemple : annotations, premières analyses).
            <h3>Niveau 4 (donnée froide ❄️) : </h3>
            Le traitement est finalisé (exemple : un montage vidéo terminé).

        </p>
        </section>

    </main>
    
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>Informations générales</h4>
                <ul>
                    <li><a href="#">Mentions légales</a></li>
                    <li><a href="#">Politique de confidentialité</a></li>
                    <li><a href="#">Conditions d’utilisation</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Navigation rapide</h4>
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Carte interactive</a></li>
                    <li><a href="#">S’inscrire / Se connecter</a></li>
                    <li><a href="#">Ajouter des données</a></li>
                    <li><a href="#">Espace personnel</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Ressources et Contacts</h4>
                <ul>
                    <li><a href="#">À propos du projet</a></li>
                    <li><a href="#">Documentation scientifique</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
