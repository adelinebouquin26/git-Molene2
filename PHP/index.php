<?php
include('config.php'); // Connexion à la base de données

$isLoggedIn = isset($_SESSION["id_utilisateur"]);

// Récupération des collaborateurs du projet
try {
    $stmt = $pdo->prepare("
        SELECT u.nom, u.prenom, up.role 
        FROM utilisateur u 
        JOIN utilisateur_projet up ON u.id_utilisateur = up.id_utilisateur 
        WHERE up.id_projet = 1
    ");
    $stmt->execute();
    $collaborateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
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
                    <a href="http://localhost/SITE_MOLENE2/PHP/logout.php"> Déconnexion </a>
                <?php else: ?>
                    <a href="http://localhost/SITE_MOLENE2/PHP/authentification.php"> Connexion </a>
                <?php endif; ?>
            </div>
            <h1>Île de Molène<br>Érosion et Submersion</h1>
            <nav>
                <ul>
                    <li><a href="projets.php">Accueil</a></li>
                    <li><a href="index.php">Projet</a></li>
                    <li><a href="http://localhost/SITE_MOLENE2/PHP/carte.php">Carte interactive</a></li>
                    <li><a href="http://localhost/SITE_MOLENE2/PHP/page_edition.php">Données</a></li>
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
            <p>L’Île de Molène subit les effets croissants du changement climatique, avec une intensification de l’érosion côtière et des submersions marines...</p>
        </section>

        <section class="featured">
            <img src="..\image\perrinremonte.png" alt="Cartographie">
            <div class="featured-text">
                <h3>Je pars cartographier une île bretonne à partir de ZERO</h3>
                <button>Lire l'article</button>
            </div>
        </section>

        <!-- Section Collaborateurs -->
        <section class="collaborators">
            <h2>Collaborateurs</h2>
            <div class="collaborators-container">
                <?php foreach ($collaborateurs as $collaborateur): ?>
                    <div class="collaborator-card">
                        <img src="../image/avatar-placeholder.jpg" alt="Avatar">
                        <div class="collaborator-name"><?= htmlspecialchars($collaborateur['prenom'] . ' ' . $collaborateur['nom']) ?></div>
                        <div class="collaborator-role"><?= htmlspecialchars($collaborateur['role']) ?></div>
                    </div>
                <?php endforeach; ?>
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
