<?php
include('config.php'); // Connexion à la base de données

$isLoggedIn = isset($_SESSION["id_utilisateur"]);

//Ajoute ceci pour récupérer l’ID du projet depuis l’URL :
//$id_projet = isset($_GET['id']) ? intval($_GET['id']) : null;
//if (!$id_projet) {
//    die("Aucun projet sélectionné.");
//}

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

    // Vérifier si l'utilisateur a une invitation en attente
    $stmtNotif = $pdo->prepare("SELECT role FROM utilisateur_projet WHERE id_utilisateur = :id_utilisateur AND id_projet = :id_projet AND role = 'en attente'");
    $stmtNotif->bindParam(":id_utilisateur", $id_utilisateur);
    $stmtNotif->bindParam(":id_projet", $id_projet);
    $stmtNotif->execute();
    $invitation = $stmtNotif->fetch(PDO::FETCH_ASSOC);

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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <h1>Île de Molène</h1><br><h2>Érosion et Submersion</h2>
            <nav>
                <ul>
                    <li><a href="projets.php">Projets</a></li>
                    <li><a href="http://localhost/SITE_MOLENE2/PHP/carte.php">Carte</a></li>
                    <li><a href="http://localhost/SITE_MOLENE2/PHP/data.php">Données</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <section class="intro">
            <h2>Bienvenue sur la page dédiée au Projet Molène.</h2>
            <p>Ce projet a pour objectif de cartographier et d'analyser différentes zones géographiques à l’aide d’une carte interactive basée sur des hexagones (technologie H3).<br><p>
Il permet de reccueillir, visualiser et organiser des données liées à chaque zone, que ce soit pour des besoins scientifiques, environnementaux ou collaboratifs.<br><p>
Sur cette page, vous pourrez :<br><p>
-Visualiser la carte interactive du projet,<br><p>
-Sélectionner des zones spécifiques pour y ajouter ou consulter des données,<br><p>
-Explorer les informations existantes et collaborer avec d'autres participants,<br><p>
-Contribuer à l’enrichissement du projet en proposant vos propres données.<br><p>

Ce projet repose sur la collaboration entre plusieurs utilisateurs et vise à construire progressivement une base de données riche, précise et utile.<br><p>

Prêt à explorer et contribuer au projet Molène ?<br><p>

Utilisez les outils à votre disposition pour commencer dès maintenant !</p>
        </section>

        <!--<section class="featured">
            <img src="..\image\perrinremonte.png" alt="Cartographie">
            <div class="featured-text">
                <h3>Je pars cartographier une île bretonne à partir de ZERO</h3>
                <button>Lire l'article</button>
            </div>
        </section>-->

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

            <!-- Barre de recherche d'utilisateur -->
            <input type="text" id="search-user" placeholder="Rechercher et Ajouter un nouveau collaborateur...">
            <div id="user-results"></div>
        
            <!-- Zone de notification d'invitation -->
            <?php if ($invitation): ?>
                <div class="invitation-notification">
                    <p>Vous avez été invité à rejoindre ce projet.</p>
                    <button onclick="acceptInvitation(<?= $id_projet ?>, <?= $id_utilisateur ?>)">Accepter</button>
                    <button onclick="rejectInvitation(<?= $id_projet ?>, <?= $id_utilisateur ?>)">Refuser</button>
                </div>
            <?php endif; ?>

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

    <!--Collaborateur ajout-->
    <script>
        $(document).ready(function() {
            $('#user-results').hide(); // Cache la barre au chargement de la page

            $('#search-user').on('keyup', function() {
                let query = $(this).val().trim(); // Supprime les espaces inutiles

                if (query.length > 1) {  
                    $.post('search_user.php', {query: query}, function(data) {
                        if (data.trim() !== '') { // Vérifie s'il y a des résultats
                            $('#user-results').html(data).show(); // Affiche la barre
                        } else {
                            $('#user-results').hide(); // Cache la barre si aucun résultat
                        }
                    });
                } else {
                    $('#user-results').hide(); // Cache si l'entrée est vide
                }
            });
        });


        function inviteUser(userId, projectId) {
            $.post('invite_user.php', {user_id: userId, project_id: projectId}, function(response) {
                alert(response);
            });
        }

        function acceptInvitation(projectId, userId) {
            $.post('handle_invitation.php', {project_id: projectId, user_id: userId, action: 'accept'}, function() {
                location.reload();
            });
        }

        function rejectInvitation(projectId, userId) {
            $.post('handle_invitation.php', {project_id: projectId, user_id: userId, action: 'reject'}, function() {
                location.reload();
            });
        }

    </script>
</body>
</html>
