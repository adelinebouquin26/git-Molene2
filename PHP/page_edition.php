<?php

session_start();

$isLoggedIn = isset($_SESSION["id_utilisateur"]);

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modifier'])) {
        $id = $_POST['id_data'];
        $nouveau_nom = $_POST['nom'];
        $nouveau_niveau = $_POST['id_niveau'];

        $stmt = $pdo->prepare("UPDATE data SET nom = ?, id_niveau = ? WHERE id_data = ?");
        $stmt->execute([$nouveau_nom, $nouveau_niveau, $id]);

        echo "<p class='success-message'>Donnée modifiée avec succès !</p>";
    }

    if (isset($_POST['supprimer'])) {
        $id = $_POST['id_data'];

        $stmt = $pdo->prepare("DELETE FROM data WHERE id_data = ?");
        $stmt->execute([$id]);

        echo "<p class='success-message'>Donnée supprimée avec succès !</p>";
    }
} 

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Collaboration</title>
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE2/CSS/style_page_edition.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
    function toggleEditForm(id) {
        let form = document.getElementById("edit-form-" + id);
        form.style.display = form.style.display === "block" ? "none" : "block";
    }
</script>


</head>
<body>
    <header>
        <h1 class="site-title">GeoRécits</h1>

        <div class="logout-link">
                <a href="http://localhost/SITE_MOLENE2/PHP/logout.php">Déconnexion</a>
        </div>


        <div class="collaborator-name">
            <?= htmlspecialchars($prenom) ?> <?= htmlspecialchars($nom) ?>
        </div>
        <nav>
            
        <ul>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/index.php">Accueil</a></li>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/carte.php">Carte interactive</a></li>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/page_ajout.php" >Ajouter des données</a>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/page_edition.php">Mon espace</a></li>
        </ul>
    </nav>
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
    <div class="sort-container">
    <button id="sortBtn">Trier les données <span>▼</span></button>

    <ul class="accordion" id="sortMenu">
        <li><a href="?order=date_asc">Trier par Date (Ascendant)</a></li>
        <li><a href="?order=date_desc">Trier par Date (Descendant)</a></li>

        <li class="sub-accordion">
            <button class="sub-accordion-toggle">Trier par Type <span>▼</span></button>
            <ul class="sub-accordion-content">
                <li><a href="?order=type&filter=video">Vidéo</a></li>
                <li><a href="?order=type&filter=photo">Photo</a></li>
                <li><a href="?order=type&filter=audio">Audio</a></li>
                <li><a href="?order=type&filter=document">Document</a></li>
            </ul>
        </li>

        <li class="sub-accordion">
            <button class="sub-accordion-toggle">Trier par Niveau <span>▼</span></button>
            <ul class="sub-accordion-content">
                <li><a href="?order=niveau&filter=1">Niveau 1</a></li>
                <li><a href="?order=niveau&filter=2">Niveau 2</a></li>
                <li><a href="?order=niveau&filter=3">Niveau 3</a></li>
                <li><a href="?order=niveau&filter=4">Niveau 4</a></li>
            </ul>
        </li>

        <li class="sub-accordion">
            <button class="sub-accordion-toggle">Trier par Collaborateur <span>▼</span></button>
            <ul class="sub-accordion-content">
                <?php foreach ($collaborateurs as $collaborateur): ?>
                    <li><a href="?order=collaborateur&filter=<?= htmlspecialchars($collaborateur['id_utilisateur']) ?>">
                        <?= htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']) ?>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
</div>

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
            
                    // Vérifier si un chemin existe et afficher les liens de fichier
                    if (!empty($data['chemin'])) {
                        $chemin_fichier = "/site_molene/" . ltrim($data['chemin'], '/');
                        
                        echo "<p> <a href='" . htmlspecialchars($chemin_fichier) . "' target='_blank' class='btn'>Voir le fichier</a>";
                        echo "<a href='" . htmlspecialchars($chemin_fichier) . "' download class='btn'>Télécharger</a>";
                    }
    
                    echo "</div>"; // Fermeture du div data-card
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
                
                    // Type de fichier
                    $type_nom = "Inconnu";
                    foreach ($types as $type) {
                        if ($type['id_type'] == $data['id_type']) {
                            $type_nom = htmlspecialchars($type['fk_type']);
                            break;
                        }
                    }
                    echo " (Type : " . $type_nom . ")";
                
                    echo " (Niveau : " . htmlspecialchars($data['id_niveau']) . ")";
                
                    // Collaborateur
                    $collab_nom = "Inconnu";
                    foreach ($collaborateurs as $collaborateur) {
                        if ($collaborateur['id_utilisateur'] == $data['id_utilisateur']) {
                            $collab_nom = htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']);
                            break;
                        }
                    }
                    echo " (Collaborateur : " . $collab_nom . ")";
                
                    // Lien pour voir/télécharger le fichier
                    if (!empty($data['chemin'])) {
                        $chemin_fichier = "/site_molene/" . ltrim($data['chemin'], '/');
                        echo "<p> <a href='" . htmlspecialchars($chemin_fichier) . "' target='_blank' class='btn'>Voir le fichier</a>";
                        echo "<a href='" . htmlspecialchars($chemin_fichier) . "' download class='btn'>Télécharger</a>";
                    }
                
                    // BOUTON MODIFIER
                    echo "<button onclick='toggleEditForm(" . $data['id_data'] . ")' class='btn'>Modifier<span>▼</span></button>";
                
                    // FORMULAIRE MODIFIER (À INSÉRER ICI)
                    echo "<div id='edit-form-" . $data['id_data'] . "' class='edit-form' style='display: none;'>
                            <form action='' method='POST'>
                                <input type='hidden' name='id_data' value='" . $data['id_data'] . "'>
                                
                                <label>Nouveau Nom :</label>
                                <input type='text' name='nom' value='" . htmlspecialchars($data['nom']) . "' required>
                
                                <label>Nouveau Niveau :</label>
                                <select name='id_niveau'>
                                    <option value='1' " . ($data['id_niveau'] == 1 ? 'selected' : '') . ">1</option>
                                    <option value='2' " . ($data['id_niveau'] == 2 ? 'selected' : '') . ">2</option>
                                    <option value='3' " . ($data['id_niveau'] == 3 ? 'selected' : '') . ">3</option>
                                    <option value='4' " . ($data['id_niveau'] == 4 ? 'selected' : '') . ">4</option>
                                </select>
                
                                <button type='submit' name='modifier'>Enregistrer</button>
                                <button type='submit' name='supprimer' onclick='return confirm(\"Supprimer cette donnée ?\")'>Supprimer</button>
                            </form>
                        </div>";
                
                    echo "</div>"; // Fin du data-card
                }
                
            } else {
                echo "<p>Aucune donnée disponible.</p>";
            }
            ?>
        </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Gestion de l'affichage du menu principal
    document.getElementById('sortBtn').addEventListener('click', function () {
        let menu = document.getElementById('sortMenu');
        this.classList.toggle('active');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    // Gestion des sous-menus
    document.querySelectorAll('.sub-accordion-toggle').forEach(button => {
        button.addEventListener('click', function () {
            let parent = this.parentElement;
            let content = parent.querySelector('.sub-accordion-content');

            // Fermer tous les autres sous-menus
            document.querySelectorAll('.sub-accordion').forEach(sub => {
                if (sub !== parent) {
                    sub.classList.remove('active');
                    sub.querySelector('.sub-accordion-content').style.display = 'none';
                }
            });

            // Ouvrir/fermer le sous-menu sélectionné
            parent.classList.toggle('active');
            content.style.display = parent.classList.contains('active') ? 'block' : 'none';
        });
    });
});

</script>

</body>
</html>
