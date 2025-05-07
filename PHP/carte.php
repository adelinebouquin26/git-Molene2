<?php
// ----------------------------------
// Connexion à la base de données
// ----------------------------------
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');

// -------------------------------------------------
// Récupération des zones H3 liées à chaque donnée
// -------------------------------------------------
$stmt = $pdo->query("SELECT dp.h3_zone, d.nom FROM data_polygons dp JOIN data d ON dp.data_id = d.id_data");
$data_polygons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// -------------------------------------------------
// Décodage du JSON des hexagones pour JavaScript
// -------------------------------------------------
foreach ($data_polygons as &$polygon) {
    $polygon['h3_zone'] = json_decode($polygon['h3_zone'], true);
}

// -------------------------------------------------
// Envoi des données au script JavaScript
// -------------------------------------------------
echo "<script>var savedZones = " . json_encode($data_polygons) . ";</script>";
?>

<!-- ------------------------------------------- -->
<!-- Début de la page HTML affichant les zones   -->
<!-- ------------------------------------------- -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zones Enregistrées</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/h3-js@4.1.0/dist/h3-js.umd.js"></script>
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE2/CSS/carte.css">
</head>

<body>
    <!-- ------------------------ -->
    <!-- En-tête de navigation   -->
    <!-- ------------------------ -->
    <header>
        Cartographie des récits et socio-écosystèmes
        <nav>
            <ul>
                <li><a href="projet_molene.php">Projet sélectionné</a></li>
                <li><a href="data.php">Données</a></li>
            </ul>
        </nav>
    </header>

    <!-- ------------------------ -->
    <!-- Bouton pour ajouter une zone -->
    <!-- ------------------------ -->
    <div class="button-container">
        <button onclick="window.location.href='zone.php'">Ajouter une zone</button>
    </div>

    <!-- ------------------------ -->
    <!-- Carte Leaflet           -->
    <!-- ------------------------ -->
    <div id="map"></div>

    <!-- ------------------------ -->
    <!-- Script de cartographie  -->
    <!-- ------------------------ -->
    <script>
        // Initialisation de la carte centrée sur Molène
        var map = L.map('map').setView([48.395, -4.958], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // -------------------------------
        // Affichage des zones H3 sur la carte
        // -------------------------------
        if (typeof savedZones !== "undefined") {
            savedZones.forEach(zoneData => {
                let mergedPolygon = [];

                zoneData.h3_zone.forEach(h3Index => {
                    let polygonCoords = h3.cellToBoundary(h3Index).map(c => [c[0], c[1]]);
                    mergedPolygon.push(polygonCoords);
                });

                if (mergedPolygon.length > 0) {
                    let polygon = L.polygon(mergedPolygon, {
                        color: "transparent",
                        weight: 0,
                        fillColor: "blue",
                        fillOpacity: 0.1,
                        fillRule: "evenodd"
                    }).addTo(map);
                    polygon.bindTooltip(`<strong>${zoneData.nom}</strong>`, { permanent: false });
                }
            });
        }

        // ---------------------------------------
        // Interaction au double-clic sur une zone
        // ---------------------------------------
        savedZones.forEach(zoneData => {
            let mergedPolygon = [];

            zoneData.h3_zone.forEach(h3Index => {
                let polygonCoords = h3.cellToBoundary(h3Index).map(c => [c[0], c[1]]);
                mergedPolygon.push(polygonCoords);
            });

            if (mergedPolygon.length > 0) {
                let polygon = L.polygon(mergedPolygon, {
                    color: "transparent",
                    weight: 0,
                    fillColor: "blue",
                    fillOpacity: 0.5
                }).addTo(map);

                polygon.bindTooltip(`<strong>${zoneData.nom}</strong>`, { permanent: false });

                polygon.on("dblclick", function () {
                    fetch("get_data.php", {
                        method: "POST",
                        body: JSON.stringify({ nom: zoneData.nom }),
                        headers: { "Content-Type": "application/json" }
                    })
                    .then(res => res.json())
                    .then(data => {
                        let chemin = data.chemin;
                        let extension = chemin?.split('.').pop().toLowerCase();
                        let content = "";

                        if (!chemin) {
                            L.popup()
                                .setLatLng(this.getBounds().getCenter())
                                .setContent(`<strong>${zoneData.nom}</strong><br><p>Aucune donnée enregistrée</p>`)
                                .openOn(map);
                            return;
                        }

                        // Affichage dynamique selon le type de fichier
                        if (["png", "jpg", "jpeg", "gif"].includes(extension)) {
                            content = `<img src="${chemin}" style="max-width:200px;max-height:200px;">`;
                        } else if (["txt", "csv", "json"].includes(extension)) {
                            fetch(chemin)
                                .then(response => response.text())
                                .then(fileContent => {
                                    L.popup()
                                        .setLatLng(this.getBounds().getCenter())
                                        .setContent(`<strong>${zoneData.nom}</strong><br><pre style="max-height:150px;overflow:auto;">${fileContent}</pre>`)
                                        .openOn(map);
                                })
                                .catch(error => console.error("Erreur de chargement du fichier :", error));
                            return;
                        } else {
                            content = `<a href="${chemin}" target="_blank">Ouvrir le fichier</a>`;
                        }

                        L.popup()
                            .setLatLng(this.getBounds().getCenter())
                            .setContent(`<strong>${zoneData.nom}</strong><br>${content}`)
                            .openOn(map);
                    })
                    .catch(error => console.error("Erreur de récupération des données :", error));
                });
            }
        });
    </script>
</body>
</html>
