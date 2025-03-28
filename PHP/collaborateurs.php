<?php
// Paramètres de la connexion à la base de données
$host = "localhost"; // ou l'adresse de ton serveur
$username = "root"; // ton nom d'utilisateur
$password = ""; // ton mot de passe
$database = "data_molène"; // le nom de ta base de données

// Connexion à la base de données
$conn = mysqli_connect($host, $username, $password, $database);

// Vérification de la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Requête SQL pour récupérer les collaborateurs
$query = "SELECT Nom, Prenom FROM utilisateur"; // Adaptation selon la structure de ta base de données
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erreur de la requête: " . mysqli_error($conn));
}

// Créer un tableau pour stocker les collaborateurs
$collaborateurs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $collaborateurs[] = $row;
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>
