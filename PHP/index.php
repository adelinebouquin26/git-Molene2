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
            <img src="..\image\ile_molene_recadrer.jpg" alt="Île de Molène">
            <div class="login-link">
                <?php if ($isLoggedIn): ?>
                    <a href="http://localhost/SITE_MOLENE2/PHP/logout.php">Log out</a>
                <?php else: ?>
                    <a href="http://localhost/SITE_MOLENE2/PHP/authentification.php">Log in</a>
                <?php endif; ?>
            </div>
            <h1>Île de Molène<br>Érosion et Submersion</h1>
            <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="http://localhost/SITE_MOLENE2/PHP/carte.php">Carte interactive</a></li>
                <li>
                    <?php if ($isLoggedIn): ?>
                        <a href="http://localhost/SITE_MOLENE2/PHP/page_ajout.php">Ajouter des données</a>
                    <?php else: ?>
                        <a href="http://localhost/SITE_MOLENE2/PHP/authentification.php">Ajouter des données</a>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if ($isLoggedIn): ?>
                        <a href="http://localhost/SITE_MOLENE2/PHP/page_edition.php">Mon espace</a>
                    <?php else: ?>
                        <a href="http://localhost/SITE_MOLENE2/PHP/authentification.php">Mon espace</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
        </div>
    </header>
    
    <main>
        <section class="intro">
            <h2>Changement climatique : Molène en première ligne</h2>
            <p>L’Île de Molène subit les effets croissants du changement climatique, avec une intensification de l’érosion côtière et des submersions marines. Ces phénomènes transforment progressivement le littoral et posent des enjeux majeurs pour l’environnement et les infrastructures locales.

                Une cartographie collaborative des impacts Ce site permet de recenser et visualiser les données sur l’érosion et les submersions grâce aux contributions des utilisateurs.
                
                Analyse et suivi en temps réel En cliquant sur la carte, accédez à une page détaillée pour explorer les observations et mieux comprendre l’évolution du littoral. Votre participation est essentielle pour affiner les analyses et anticiper les évolutions futures.</p>
        </section>

        <section class="featured">
            <img src="..\image\perrinremonte.png" alt="Cartographie">
            <div class="featured-text">
                <h3>Je pars cartographier une île bretonne à partir de ZERO</h3>
                <button>Lire l'article</button>
            </div>
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
