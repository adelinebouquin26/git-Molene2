<?php
// Connexion à la base de données
$host = "localhost";
$username = "root"; // Ton utilisateur MySQL (par défaut root)
$password = ""; // Ton mot de passe MySQL (laisser vide si non défini)
$database = "data_molène"; // Nom de ta base de données

$conn = mysqli_connect($host, $username, $password, $database);

// Vérification de la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Requête SQL pour récupérer les types
$query = "SELECT id_type, fk_type FROM type ";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur de la requête: " . mysqli_error($conn));
}

// Stocker les types dans un tableau
$types = [];
while ($row = mysqli_fetch_assoc($result)) {
    $types[] = $row;
}

// Fermer la connexion
mysqli_close($conn);
?>
