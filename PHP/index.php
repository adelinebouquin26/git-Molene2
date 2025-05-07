<?php
//---- Démarrer la session pour vérifier si l'utilisateur est connecté
session_start();
$isLoggedIn = isset($_SESSION["id_utilisateur"]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Île de Molène - Érosion et Submersion</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <!-- -------------------------------------------------
         En-tête de la page avec image et liens de connexion/déconnexion
    -------------------------------------------------- -->
    <header>
        <div class="hero">
            <img src="..\image\visuel_accueil_1.jpg" alt="Imaginaire">
            <div class="login-link">
                <?php if ($isLoggedIn): ?>
                    <!-- ---- L'utilisateur est connecté, affiche le lien de déconnexion -->
                    <a href="http://localhost/SITE_MOLENE2/PHP/logout.php">Deconnexion</a>
                <?php else: ?>
                    <!-- ---- L'utilisateur n'est pas connecté, affiche le lien de connexion -->
                    <a href="http://localhost/SITE_MOLENE2/PHP/authentification.php">Connexion</a>
                <?php endif; ?>
            </div>
            <h1>Récits et imaginaires croisés<br></h1><br><h2>Espace d'échange, de création et de partage</h2>
        </div>
    </header>
    
    <!-- -------------------------------------------------
         Section principale du contenu avec description du site
    -------------------------------------------------- -->
    <main>
        <section class="intro">
            <h2>Bienvenue sur Récits et imaginaires croisés</h2>
            <h3>Un espace collaboratif dédié à la gestion et au partage de données</h3>
            <p>Notre plateforme a été conçue pour faciliter le stockage, le partage et la visualisation de données au sein de projets collaboratifs.</p>
            
            <h3>Un espace de stockage et de partage</h3>
            <p>Ce site permet de créer des projets collaboratifs où chaque utilisateur peut stocker, organiser et partager des données avec son équipe. Qu’il s’agisse d’analyses scientifiques, de rapports ou de fichiers multimédias, tout est centralisé pour une meilleure gestion.</p>

            <h3>Une visualisation intuitive des données</h3>
            <p>Les données enregistrées peuvent être visualisées de manière interactive grâce à des outils adaptés, notamment des cartes et des graphiques dynamiques, afin d’exploiter l’information plus efficacement.</p>

            <h3>Comment utiliser le site ?</h3>
            <ul>
                <li><strong>Créer un compte :</strong> L’inscription est nécessaire pour interagir avec les autres utilisateurs et gérer des projets.<p></li>
                <li><strong>Créer ou rejoindre un projet :</strong> Chaque utilisateur peut créer un projet public ou privé et y ajouter ses propres données via son espace personnel.<p></li>
                <li><strong>Classer les données par niveau :</strong> Lorsqu’une donnée est ajoutée, elle doit être classée selon son niveau de traitement.</li>
            </ul>
        </section>

        <!-- -------------------------------------------------
             Section expliquant le système des niveaux de traitement des données
        -------------------------------------------------- -->
        <section class="intro">
            <h2>Le système des niveaux de traitement</h2>
            
            <h3>Niveau 1</h3>
            <p>La donnée n’a pas encore été traitée.</p>            
            <h3>Niveau 2</h3>
            <p>La donnée est en cours de pré-analyse.</p>
            <h3>Niveau 3</h3>
            <p>La donnée a été modifiée ou enrichie (exemple : annotations, premières analyses).</p>
            <h3>Niveau 4</h3>
            <p>Le traitement est finalisé (exemple : un montage vidéo terminé).</p>
        </section>

    </main>
    
    <!-- -------------------------------------------------
         Section de pied de page avec informations de contact
    -------------------------------------------------- -->
    <footer style="padding: 30px 0; text-align: center; font-size: 14px;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h3 style="margin-bottom: 10px;">Projet "Récits et Imaginaires Croisés"</h3>
            <p>Réalisé par Raphaël & Adeline dans le cadre du projet de fin d'études M1 à l'ISEN Brest.</p>
            
            <div style="margin-top: 20px;">
                <h4>Contact</h4>
                <p>Email Raphaël : <a href="mailto:raphael@example.com" style="color: #007bff;">raphael.cardinal@isen-ouest.yncrea.com</a></p>
                <p>Email Adeline : <a href="mailto:adeline@example.com" style="color: #007bff;">adeline.bouquin@isen-ouest.yncrea.com</a></p>
                <p>ISEN Brest : <a href="https://isen-brest.fr" target="_blank" style="color: #007bff;">www.isen-brest.fr</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
