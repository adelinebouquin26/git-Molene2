<?php
// Connexion à la base de données
$host = "localhost";
$username = "root"; // Ton utilisateur MySQL (par défaut root)
$password = ""; // Ton mot de passe MySQL (laisser vide si non défini)
$database = "data_molène"; // Remplace par le nom de ta base

$conn = mysqli_connect($host, $username, $password, $database);

// Vérification de la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Requête SQL pour récupérer les 10 dernières données ajoutées
$query = "SELECT nom, date_ajout, chemin FROM data ORDER BY date_ajout DESC LIMIT 10";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur de la requête: " . mysqli_error($conn));
}

// Stocker les données dans un tableau
$donnees = [];
while ($row = mysqli_fetch_assoc($result)) {
    $donnees[] = $row;
}

// Fermer la connexion
mysqli_close($conn);
?>
