<?php
// Inclure la connexion à la base de données depuis config.php
include('config.php');

$isLoggedIn = isset($_SESSION["id_utilisateur"]);
$id_utilisateur = $isLoggedIn ? $_SESSION["id_utilisateur"] : null;

try {
    // Récupérer les projets publics
    $stmtPublic = $pdo->prepare("SELECT * FROM projet WHERE est_prive = 0");
    $stmtPublic->execute();
    $projetsPublics = $stmtPublic->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les projets privés de l'utilisateur connecté
    $projetsPrives = [];
    if ($isLoggedIn) {
        $stmtPrivate = $pdo->prepare("SELECT p.* FROM projet p
            JOIN utilisateur_projet up ON p.id_projet = up.id_projet
            WHERE up.id_utilisateur = :id_utilisateur AND p.est_prive = 1");
        $stmtPrivate->bindParam(":id_utilisateur", $id_utilisateur);
        $stmtPrivate->execute();
        $projetsPrives = $stmtPrivate->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Île de Molène - Projets</title>
    <link rel="stylesheet" href="../CSS/projets.css">
</head>
<body>
    <header>
        <div class="hero">
            <img src="..\image\projets.jpg" alt="Projets">
            <div class="login-link">
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php">Log out</a> 
                <?php else: ?>
                    <a href="authentification.php">Log in</a>
                <?php endif; ?>
            </div>
            <h1>Projets<br>Privés et publics</h1>
            <nav>
                <ul>
                    <li><a href="projets.php">Accueil</a></li>
                    <li><a href="carte.php">Carte interactive</a></li>
                    <li>
                        <?php if ($isLoggedIn): ?>
                            <a href="page_edition.php">Mon espace</a>
                        <?php else: ?>
                            <a href="authentification.php">Mon espace</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        
        <section id="projects">

            <div class="project-tile">
                <h1>Projets privés</h1>
                <div class="project-cards">
                    <?php if ($isLoggedIn && count($projetsPrives) > 0): ?>
                        <?php foreach ($projetsPrives as $projet): ?>
                            <div class="card1">
                                <img src="../image/projetmolene.png" alt="<?= htmlspecialchars($projet['nom']) ?>">
                                <code>Projet Privé</code>
                                <a href="http://localhost/SITE_MOLENE2/PHP/index.php" target="_blank"><?= htmlspecialchars($projet['nom']) ?></a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun projet privé.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="project-tile">
                <h1>Projets publics</h1>
                <div class="project-cards">
                    <?php if (count($projetsPublics) > 0): ?>
                        <?php foreach ($projetsPublics as $projet): ?>
                            <div class="card1">
                                <img src="../image/public_projet.png" alt="<?= htmlspecialchars($projet['nom']) ?>">
                                <code>Projet Public</code>
                                <a href="projet.php?id=<?= $projet['id_projet'] ?>"><?= htmlspecialchars($projet['nom']) ?></a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun projet public.</p>
                    <?php endif; ?>
                </div>
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