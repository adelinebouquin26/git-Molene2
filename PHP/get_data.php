<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');

// Récupération des données (adaptation selon ta base)
$query = $pdo->query("SELECT nom, lat, lng, description FROM data WHERE lat IS NOT NULL AND lng IS NOT NULL");
$points = $query->fetchAll(PDO::FETCH_ASSOC);

// Envoi des données en JSON
header('Content-Type: application/json');
echo json_encode($points);
?>
