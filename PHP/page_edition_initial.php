<?php

session_start();

/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
exit();*/

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["id_utilisateur"])) {
    header("Location: login.php"); // Redirection vers la connexion si non connecté
    exit();
}

$id_utilisateur = $_SESSION["id_utilisateur"];
$nom = $_SESSION["nom"];
$prenom = $_SESSION["prenom"];
$id_fonction = $_SESSION["id_fonction"];

// Inclure les fichiers nécessaires
include('collaborateurs.php');
include('donnees.php');
include('types.php');

// Connexion à la base
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');

// Déterminer l'ordre de tri par défaut
$orderBy = "date_ajout DESC"; // Valeur par défaut
$whereClause = ""; 

// Vérifier si un tri spécifique est demandé
if (isset($_GET['order'])) {
    switch ($_GET['order']) {
        case "date_asc":
            $orderBy = "date_ajout ASC";
            break;
        case "date_desc":
            $orderBy = "date_ajout DESC";
            break;
        case "type":
            $orderBy = "id_type ASC";
            break;
        case "niveau":
            $orderBy = "id_niveau ASC";
            break;
        case "collaborateur":
            $orderBy = "id_utilisateur ASC";
            break;
    }
}

// Vérifier si un filtre spécifique est appliqué
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];

    if ($_GET['order'] === "type") {
        switch ($filter) {
            case "video": $whereClause = "WHERE id_type = 1"; break;
            case "photo": $whereClause = "WHERE id_type = 3"; break;
            case "audio": $whereClause = "WHERE id_type = 2"; break;
            case "document": $whereClause = "WHERE id_type = 4"; break;
        }
    }

    if ($_GET['order'] === "niveau") {
        $whereClause = "WHERE id_niveau = " . intval($filter);
    }

    if ($_GET['order'] === "collaborateur") {
        $whereClause = "WHERE id_utilisateur = " . intval($filter);
    }
}

// Exécuter la requête avec filtre + tri
$query = "SELECT * FROM data $whereClause ORDER BY $orderBy";
$allStmt = $pdo->query($query);
$allData = $allStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les 5 dernières données ajoutées
$recentStmt = $pdo->query("SELECT * FROM data ORDER BY date_ajout DESC LIMIT 5");
$recentData = $recentStmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Collaboration</title>
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE/CSS/style_page_edition.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <header>
        <h1> <?= htmlspecialchars($prenom) ?> <?= htmlspecialchars($nom) ?> </h1>
        <!--<p>Votre ID utilisateur : <?= $id_utilisateur ?></p>-->
        <!--<p>Votre fonction : <?= $id_fonction ?></p>-->
    </header>
    
    <section class="collaborators">
        <h2>Utilisateurs</h2>
        <div class="collab-list">
            <?php
            // Afficher les collaborateurs dynamiquement
            foreach ($collaborateurs as $collaborateur) {
                echo "<div class='collaborator'>" . htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']) . "</div>";
            }
            ?>
        </div>
    </section>

    <section class="actions">
    <button id="sortBtn" class="sort-btn">Trier les données</button>
    
    <div class="accordion" id="sortMenu" style="display: none;">
        <div class="accordion-content">
            <a href="?order=date_asc">Trier par Date (Ascendant)</a>
            <a href="?order=date_desc">Trier par Date (Descendant)</a>

            <!-- Accordéon pour le tri par Type -->
            <button class="sub-accordion-toggle">Trier par Type ▼</button>
            <div class="sub-accordion-content">
                <a href="?order=type&filter=video">Vidéo</a>
                <a href="?order=type&filter=photo">Photo</a>
                <a href="?order=type&filter=audio">Audio</a>
                <a href="?order=type&filter=document">Document</a>
            </div>

            <!-- Accordéon pour le tri par Niveau -->
            <button class="sub-accordion-toggle">Trier par Niveau ▼</button>
            <div class="sub-accordion-content">
                <a href="?order=niveau&filter=1">Niveau 1</a>
                <a href="?order=niveau&filter=2">Niveau 2</a>
                <a href="?order=niveau&filter=3">Niveau 3</a>
                <a href="?order=niveau&filter=4">Niveau 4</a>
            </div>

            <!-- Accordéon pour le tri par Collaborateur -->
            <button class="sub-accordion-toggle">Trier par Collaborateur ▼</button>
            <div class="sub-accordion-content">
                <?php foreach ($collaborateurs as $collaborateur): ?>
                    <a href="?order=collaborateur&filter=<?= htmlspecialchars($collaborateur['id_utilisateur']) ?>">
                        <?= htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    
    <a href="page_ajout.php" class="bouton-ajout">Ajouter des données</a>
</section>

    
    <section class="recent-data">
    <h2>Données récemment ajoutées</h2>
    
    <div class="data-list">
        <?php
        if (!empty($recentData)) {
            foreach ($recentData as $data) {
                echo "<div class='data-card'>";
                echo "<strong>" . htmlspecialchars($data['nom']) . "</strong>";
                echo " (Ajouté le " . htmlspecialchars($data['date_ajout']) . ")";
            
                // Trouver le bon type correspondant à l'id_type de la donnée
                $type_nom = "Inconnu"; // Valeur par défaut au cas où aucun type ne correspond
                foreach ($types as $type) {
                    if ($type['id_type'] == $data['id_type']) {
                        $type_nom = htmlspecialchars($type['fk_type']);
                        break; // On a trouvé le bon type, on arrête la boucle
                    }
                }
                echo " (Type : " . $type_nom . ")";
            
                echo " (Niveau : " . htmlspecialchars($data['id_niveau']) . ")";
            
                // Trouver le bon utilisateur correspondant à id_utilisateur de la donnée
                $collab_nom = "Inconnu";
                foreach ($collaborateurs as $collaborateur) {
                    if ($collaborateur['id_utilisateur'] == $data['id_utilisateur']) {
                        $collab_nom = htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']);
                        break;
                    }
                }
                echo " (Collaborateur : " . $collab_nom . ")";
            
                // Vérifier si un chemin existe et le rendre cliquable
                if (!empty($data['chemin'])) {
                    $chemin_fichier = "/site_molene/" . ltrim($data['chemin'], '/');
                    echo "<br><a href='" . htmlspecialchars($chemin_fichier) . "' target='_blank'>Voir le fichier</a>";
                }
            
                echo "</div>";
            }
            
        } else {
            echo "<p>Aucune donnée disponible.</p>";
        }
        ?>
    </div>
</section>

<section class="recent-data"> 
    <h2>Gérer l'affichage des données</h2>
    
    <p>
        <div class="data-list">
            <?php
            if (!empty($allData)) {
                foreach ($allData as $data) {
                    echo "<div class='data-card'>";
                    echo "<strong>" . htmlspecialchars($data['nom']) . "</strong>";
                    echo " (Ajouté le " . htmlspecialchars($data['date_ajout']) . ")";

                    // Trouver le bon type correspondant à l'id_type de la donnée
                $type_nom = "Inconnu"; // Valeur par défaut au cas où aucun type ne correspond
                foreach ($types as $type) {
                    if ($type['id_type'] == $data['id_type']) {
                        $type_nom = htmlspecialchars($type['fk_type']);
                        break; // On a trouvé le bon type, on arrête la boucle
                    }
                }
                echo " (Type : " . $type_nom . ")";
            
                echo " (Niveau : " . htmlspecialchars($data['id_niveau']) . ")";
            
                // Trouver le bon utilisateur correspondant à id_utilisateur de la donnée
                $collab_nom = "Inconnu";
                foreach ($collaborateurs as $collaborateur) {
                    if ($collaborateur['id_utilisateur'] == $data['id_utilisateur']) {
                        $collab_nom = htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']);
                        break;
                    }
                }
                echo " (Collaborateur : " . $collab_nom . ")";

                    // Vérifier si un chemin existe et le rendre cliquable
                    if (!empty($data['chemin'])) {
                        $chemin_fichier = "/site_molene/" . ltrim($data['chemin'], '/');
                        echo "<br><a href='" . htmlspecialchars($chemin_fichier) . "' target='_blank'>Voir le fichier</a>";
                    }
                    
                    echo "</div>";
                }
            } else {
                echo "<p>Aucune donnée disponible.</p>";
            }
            ?>
        </div>
</section>

<!--<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionne le bouton principal pour ouvrir le menu principal
        const sortBtn = document.getElementById("sortBtn");
        const sortMenu = document.getElementById("sortMenu");

        // Sélectionne tous les boutons qui ouvrent un sous-accordéon
        const subAccordionToggles = document.querySelectorAll(".sub-accordion-toggle");

        // Toggle du menu principal
        sortBtn.addEventListener("click", function () {
            sortMenu.style.display = sortMenu.style.display === "block" ? "none" : "block";
        });

        // Toggle des sous-menus
        subAccordionToggles.forEach(function (toggle) {
            toggle.addEventListener("click", function () {
                const subMenu = this.nextElementSibling;
                if (subMenu) {
                    subMenu.style.display = subMenu.style.display === "block" ? "none" : "block";
                }
            });
        });
    });
</script>-->

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Gestion du menu déroulant principal
    const sortBtn = document.getElementById("sortBtn");
    const sortMenu = document.getElementById("sortMenu");

    if (sortBtn && sortMenu) {
        sortBtn.addEventListener("click", function () {
            if (sortMenu.style.display === "block") {
                sortMenu.style.display = "none";
            } else {
                sortMenu.style.display = "block";
                sortMenu.style.visibility = "visible"; // Assure la visibilité
                sortMenu.style.opacity = "1"; // Rendre visible
            }
        });
    }

    // Gestion des sous-menus
    document.querySelectorAll(".sub-accordion-toggle").forEach(button => {
        button.addEventListener("click", function () {
            let subMenu = this.nextElementSibling;
            if (subMenu.style.display === "block") {
                subMenu.style.display = "none";
            } else {
                subMenu.style.display = "block";
                subMenu.style.visibility = "visible"; // Assure la visibilité
                subMenu.style.opacity = "1"; // Rendre visible
            }
        });
    });
});
</script>



</body>
</html>
