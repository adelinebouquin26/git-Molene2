<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartographie des récits</title>
    
    <!-- Styles-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE/CSS/carte.css">
    
</head>
<body>

<header>
    Cartographie des récits et socio-écosystèmes
</header>

<a href="page_edition.php" class="back-btn">Retour</a>

<!-- Conteneur de la carte -->
<div id="map"></div>

<!-- Script Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Initialisation de la carte
    var map = L.map('map').setView([48.3972, -4.9556], 15);


    // Ajouter un fond de carte OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Récupération des données depuis get_data.php
    fetch('get_data.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(point => {
                L.marker([point.lat, point.lng]).addTo(map)
                    .bindPopup(`<b>${point.nom}</b><br>${point.description}`);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des données :', error));
</script>

</body>
</html>
