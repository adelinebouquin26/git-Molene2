<?php
// ----------------------------
// Initialisation de la session
// ----------------------------
session_start();

// ---------------------------
// Variable pour la modale JS
// ---------------------------
$showSuccessPopup = false;

// ------------------------------
// Vérifie si l'utilisateur est connecté
// ------------------------------
$isLoggedIn = isset($_SESSION["id_utilisateur"]);

if (!$isLoggedIn) {
    die("Vous devez être connecté pour ajouter une donnée.");
}

// ------------------------------
// Connexion à la base de données
// ------------------------------
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// ------------------------------
// Traitement du formulaire POST
// ------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $date_prise = $_POST['date_prise'];
    $date_ajout = date("Y-m-d"); 
    $id_type = $_POST['id_type'];
    $id_niveau = $_POST['id_niveau'];
    $id_utilisateur = $_SESSION["id_utilisateur"]; // ✅ Utiliser l'ID et non le nom

    // ---------------------------------------------
    // Traitement du fichier uploadé
    // ---------------------------------------------
    $fichier_nom = basename($_FILES["fichier"]["name"]);
    $dossierUpload = "../uploads/";
    $cheminPhysique = $dossierUpload . $fichier_nom; // chemin pour enregistrer physiquement le fichier
    move_uploaded_file($_FILES["fichier"]["tmp_name"], $cheminPhysique);
    $chemin = "uploads/" . $fichier_nom; // chemin pour affichage ou téléchargement

    // ---------------------------------------------
    // Insertion dans la base de données
    // ---------------------------------------------
    $stmt = $pdo->prepare("INSERT INTO data (nom, date_prise, date_ajout, chemin, id_type, id_niveau, id_utilisateur) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $date_prise, $date_ajout, $chemin, $id_type, $id_niveau, $id_utilisateur]);

    // ---------------------------------------------
    // Afficher la pop-up de succès
    // ---------------------------------------------
    $showSuccessPopup = true;
}
?>

<!-- ------------------------------ -->
<!-- Modale de succès après ajout  -->
<!-- ------------------------------ -->
<?php if ($showSuccessPopup): ?>
<div id="successPopup" class="modal">
    <div class="modal-content">
        <span id="closePopup" class="close">&times;</span>
        <p class="success-message">Donnée ajoutée avec succès !</p>
        <a href="mon_espace.php" class="success-link">Retour</a>
    </div>
</div>
<?php endif; ?>

<!-- ------------------------------ -->
<!-- Page HTML pour ajout de donnée -->
<!-- ------------------------------ -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une donnée</title>
    <link rel="stylesheet" href="../CSS/ajout_donnee.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter une nouvelle donnée</h2>

        <!-- ---------------------------------------- -->
        <!-- Formulaire d'envoi d'une nouvelle donnée -->
        <!-- ---------------------------------------- -->
        <form action="page_ajout.php" method="POST" enctype="multipart/form-data">
            <label>Nom :</label>
            <input type="text" name="nom" required>

            <label>Date de prise :</label>
            <input type="date" name="date_prise">

            <label>Type de fichier :</label>
            <select name="id_type" required>
                <option value="1">Vidéo</option>
                <option value="2">Audio</option>
                <option value="3">Photo</option>
                <option value="4">Document</option>
            </select>

            <label>Niveau :</label>
            <select name="id_niveau">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <label>Choisir un fichier :</label>
            <input type="file" name="fichier" accept="image/*,video/*,audio/*">

            <button type="submit">Ajouter</button>
        </form>

        <!-- Lien de retour -->
        <p>
        <a href='mon_espace.php' class="button-link">retour</a>
    </div>

    <!-- -------------------------------------------- -->
    <!-- Script JS pour gérer la modale de confirmation -->
    <!-- -------------------------------------------- -->
    <script>
        window.onload = function() {
            <?php if ($showSuccessPopup): ?>
                document.getElementById("successPopup").style.display = "block";
            <?php endif; ?>

            // Fermer la modale au clic sur la croix
            document.getElementById("closePopup").addEventListener("click", function() {
                document.getElementById("successPopup").style.display = "none";
            });
        }
    </script>
</body>
</html>
