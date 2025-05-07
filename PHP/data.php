<?php
// -------------------------------------------------
// Inclusion des paramètres de configuration
// -------------------------------------------------
include('config.php');

// -------------------------------------------------
// Vérification de la connexion utilisateur
// -------------------------------------------------
$isLoggedIn = isset($_SESSION["id_utilisateur"]);
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: authentification.php");
    exit();
}

// -------------------------------------------------
// Récupération des informations de session utilisateur
// -------------------------------------------------
$id_utilisateur = $_SESSION["id_utilisateur"];
$nom = $_SESSION["nom"];
$prenom = $_SESSION["prenom"];
$id_fonction = $_SESSION["id_fonction"];

// -------------------------------------------------
// Inclusion des données nécessaires
// -------------------------------------------------
include('collaborateurs.php');
include('types.php');

// -------------------------------------------------
// Définir l'ordre de tri par défaut
// -------------------------------------------------
$orderBy = "date_ajout DESC";
$whereClause = ""; 

// -------------------------------------------------
// Gérer les options de tri via paramètres GET
// -------------------------------------------------
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

// -------------------------------------------------
// Appliquer les filtres si spécifiés
// -------------------------------------------------
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

// -------------------------------------------------
// Récupérer les données depuis la base
// -------------------------------------------------
$query = "SELECT * FROM data $whereClause ORDER BY $orderBy";
$allStmt = $pdo->query($query);
$allData = $allStmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------------------------------------
// Traitement des formulaires de modification/suppression
// -------------------------------------------------
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

<!-- -------------------------------------------------
     Début du document HTML
-------------------------------------------------- -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- -------------------------------------------------
         Métadonnées de la page
    -------------------------------------------------- -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Collaboration</title>

    <!-- -------------------------------------------------
         Feuille de style externe
    -------------------------------------------------- -->
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE2/CSS/style_page_edition.css">

    <!-- -------------------------------------------------
         Librairie jQuery
    -------------------------------------------------- -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- -------------------------------------------------
         Script pour afficher/masquer les formulaires d’édition
    -------------------------------------------------- -->
    <script>
        function toggleEditForm(id) {
            let form = document.getElementById("edit-form-" + id);
            form.style.display = form.style.display === "block" ? "none" : "block";
        }
    </script>
</head>
<body>

<!-- -------------------------------------------------
     En-tête du site (titre + navigation + déconnexion)
-------------------------------------------------- -->
<header>
    <h1 class="site-title">Données</h1>

    <div class="logout-link">
        <a href="http://localhost/SITE_MOLENE2/PHP/logout.php">Déconnexion</a>
    </div>

    <!-- -------------------------------------------------
         Menu de navigation principal
    -------------------------------------------------- -->
    <nav>
        <ul>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/projet_molene.php">Projet sélectionné</a></li>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/carte.php">Carte</a></li>
            <li><a href="http://localhost/SITE_MOLENE2/PHP/ajout_donnee.php">Ajouter des données</a></li>
        </ul>
    </nav>
</header>

<!-- -------------------------------------------------
     Section de tri et filtres
-------------------------------------------------- -->
<section class="actions">
    <div class="sort-container">
        <button id="sortBtn">Trier les données <span>▼</span></button>

        <!-- -------------------------------------------------
             Menu déroulant avec différents critères de tri
        -------------------------------------------------- -->
        <ul class="accordion" id="sortMenu">
            <li><a href="?order=date_asc">Trier par Date (Ascendant)</a></li>
            <li><a href="?order=date_desc">Trier par Date (Descendant)</a></li>

            <!-- Tri par type -->
            <li class="sub-accordion">
                <button class="sub-accordion-toggle">Trier par Type <span>▼</span></button>
                <ul class="sub-accordion-content">
                    <li><a href="?order=type&filter=video">Vidéo</a></li>
                    <li><a href="?order=type&filter=photo">Photo</a></li>
                    <li><a href="?order=type&filter=audio">Audio</a></li>
                    <li><a href="?order=type&filter=document">Document</a></li>
                </ul>
            </li>

            <!-- Tri par niveau -->
            <li class="sub-accordion">
                <button class="sub-accordion-toggle">Trier par Niveau <span>▼</span></button>
                <ul class="sub-accordion-content">
                    <li><a href="?order=niveau&filter=1">Niveau 1</a></li>
                    <li><a href="?order=niveau&filter=2">Niveau 2</a></li>
                    <li><a href="?order=niveau&filter=3">Niveau 3</a></li>
                    <li><a href="?order=niveau&filter=4">Niveau 4</a></li>
                </ul>
            </li>

            <!-- Tri par collaborateur -->
            <li class="sub-accordion">
                <button class="sub-accordion-toggle">Trier par Collaborateur <span>▼</span></button>
                <ul class="sub-accordion-content">
                    <?php foreach ($collaborateurs as $collaborateur): ?>
                        <li>
                            <a href="?order=collaborateur&filter=<?= htmlspecialchars($collaborateur['id_utilisateur']) ?>">
                                <?= htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
</section>

<!-- -------------------------------------------------
     Section principale d'affichage des données
-------------------------------------------------- -->
<section class="recent-data"> 
    <h2>Gérer l'affichage des données</h2>

    <div class="data-list">
        <?php
        if (!empty($allData)) {
            foreach ($allData as $data) {
                echo "<div class='data-card'>";

                // -------------------------------------------------
                // Affichage du nom de la donnée
                // -------------------------------------------------
                echo "<strong>" . htmlspecialchars($data['nom']) . "</strong>";

                // -------------------------------------------------
                // Bouton pour afficher les détails
                // -------------------------------------------------
                echo "<button class='btn info-btn' onclick='toggleDetails(" . $data['id_data'] . ")'>ℹ</button>";

                // -------------------------------------------------
                // Bloc de détails masqués
                // -------------------------------------------------
                echo "<div id='details-" . $data['id_data'] . "' class='details-overlay'>
                        <p>Ajouté le " . htmlspecialchars($data['date_ajout']) . "</p>";

                // Afficher le type
                $type_nom = "Inconnu";
                foreach ($types as $type) {
                    if ($type['id_type'] == $data['id_type']) {
                        $type_nom = htmlspecialchars($type['fk_type']);
                        break;
                    }
                }
                echo "<p>Type : $type_nom</p>";
                echo "<p>Niveau : " . htmlspecialchars($data['id_niveau']) . "</p>";

                // Afficher le collaborateur
                $collab_nom = "Inconnu";
                foreach ($collaborateurs as $collaborateur) {
                    if ($collaborateur['id_utilisateur'] == $data['id_utilisateur']) {
                        $collab_nom = htmlspecialchars($collaborateur['Prenom']) . " " . htmlspecialchars($collaborateur['Nom']);
                        break;
                    }
                }
                echo "<p>Collaborateur : $collab_nom</p>";
                echo "</div>";

                // -------------------------------------------------
                // Lien pour voir et télécharger le fichier
                // -------------------------------------------------
                if (!empty($data['chemin'])) {
                    $chemin_fichier = "/site_molene2/" . ltrim($data['chemin'], '/');
                    echo "<p> <a href='" . htmlspecialchars($chemin_fichier) . "'  class='btn'>Voir le fichier</a>";
                    echo "<a href='" . htmlspecialchars($chemin_fichier) . "' download class='btn'>Télécharger</a>";
                }

                // -------------------------------------------------
                // Bouton pour afficher le formulaire de modification
                // -------------------------------------------------
                echo "<button onclick='toggleEditForm(" . $data['id_data'] . ")' class='btn'>Modifier<span>▼</span></button>";

                // -------------------------------------------------
                // Formulaire de modification/suppression
                // -------------------------------------------------
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

<!-- -------------------------------------------------
     Scripts JavaScript
-------------------------------------------------- -->
<script>
// -------------------------------------------------
// Afficher/Masquer le formulaire de modification
// -------------------------------------------------
function toggleEditForm(id) {
    let form = document.getElementById("edit-form-" + id);
    form.style.display = form.style.display === "block" ? "none" : "block";
}

// -------------------------------------------------
// Gérer le menu de tri et les sous-menus
// -------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('sortBtn').addEventListener('click', function () {
        let menu = document.getElementById('sortMenu');
        this.classList.toggle('active');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    document.querySelectorAll('.sub-accordion-toggle').forEach(button => {
        button.addEventListener('click', function () {
            let parent = this.parentElement;
            let content = parent.querySelector('.sub-accordion-content');

            document.querySelectorAll('.sub-accordion').forEach(sub => {
                if (sub !== parent) {
                    sub.classList.remove('active');
                    sub.querySelector('.sub-accordion-content').style.display = 'none';
                }
            });

            parent.classList.toggle('active');
            content.style.display = parent.classList.contains('active') ? 'block' : 'none';
        });
    });
});

// -------------------------------------------------
// Afficher/Masquer les détails d'une donnée
// -------------------------------------------------
let currentOpenDetails = null;

function toggleDetails(id) {
    const el = document.getElementById('details-' + id);

    if (currentOpenDetails && currentOpenDetails !== el) {
        currentOpenDetails.style.display = 'none';
    }

    if (el.style.display === 'block') {
        el.style.display = 'none';
        currentOpenDetails = null;
    } else {
        el.style.display = 'block';
        currentOpenDetails = el;
    }
}

// -------------------------------------------------
// Fermer les détails si clic en dehors
// -------------------------------------------------
document.addEventListener('click', function(event) {
    if (currentOpenDetails && !event.target.closest('.details-overlay') && !event.target.classList.contains('info-btn')) {
        currentOpenDetails.style.display = 'none';
        currentOpenDetails = null;
    }
});
</script>

</body>
</html>
