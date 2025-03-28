<?php

session_start();

$isLoggedIn = isset($_SESSION["id_utilisateur"]);

if (!$isLoggedIn) {
    die("Vous devez être connecté pour ajouter une donnée.");
}

$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $date_prise = $_POST['date_prise'];
    $date_ajout = date("Y-m-d"); 
    $id_type = $_POST['id_type'];
    $id_niveau = $_POST['id_niveau'];
    $id_utilisateur = $_SESSION["id_utilisateur"]; // ✅ Utiliser l'ID et non le nom

    // Gestion du fichier uploadé
    $chemin = "";
    if (!empty($_FILES["fichier"]["name"])) {
        $dossierUpload = "uploads/";
        if (!is_dir($dossierUpload)) {
            mkdir($dossierUpload, 0777, true);
        }

        $fichier_nom = basename($_FILES["fichier"]["name"]);
        $chemin = $dossierUpload . $fichier_nom;
        move_uploaded_file($_FILES["fichier"]["tmp_name"], $chemin);
    }

    // Insérer dans la base de données
    $stmt = $pdo->prepare("INSERT INTO data (nom, date_prise, date_ajout, chemin, id_type, id_niveau, id_utilisateur) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $date_prise, $date_ajout, $chemin, $id_type, $id_niveau, $id_utilisateur]);

    echo "<p class='success-message'>Donnée ajoutée avec succès ! <a href='page_edition.php'>Retour</a></p>";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une donnée</title>
    <link rel="stylesheet" href="../CSS/style_form.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter une nouvelle donnée</h2>
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
        <p>
        <a href = 'page_edition.php'  class="bouton-ajout" >retour</a>
    </div>
</body>
</html>
