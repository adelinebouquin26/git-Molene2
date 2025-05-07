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
            <img src="..\image\carte_monde.png" alt="Projets">
            <div class="login-link">
                <?php if ($isLoggedIn): ?>
                    <a href="logout.php">Déconnexion</a> 
                <?php else: ?>
                    <a href="authentification.php">Déconnexion</a>
                <?php endif; ?>
            </div>
            <h1>Projets<br>Privés et publics</h1>
            <nav>
                <ul>
                    <li><a href="zone.php">Carte</a></li>
                    <li>
                        <?php if ($isLoggedIn): ?>
                            <a href="mon_espace.php">Mon espace</a>
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
                                <a href="projet_molene.php"><?= htmlspecialchars($projet['nom']) ?></a>
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

 

      <div style="margin-top: 20px; font-size: 12px; color: #777;">

      </div>

    </div>

  </footer>
</body>
</html>