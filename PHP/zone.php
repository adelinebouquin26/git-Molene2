<?php
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');

// Récupérer toutes les zones de données stockées
$stmt = $pdo->query("SELECT dp.h3_zone, d.nom FROM data_polygons dp JOIN data d ON dp.data_id = d.id_data");


$data_polygons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convertir les données pour JavaScript
foreach ($data_polygons as &$polygon) {
    $polygon['h3_zone'] = json_decode($polygon['h3_zone'], true); // Décoder le JSON des hexagones
}

echo "<script>var savedZones = " . json_encode($data_polygons) . ";</script>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zones Enregistrées</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/h3-js@4.1.0/dist/h3-js.umd.js"></script>
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE/CSS/carte.css">

</head>
<body>
    <header>
        Cartographie des récits et socio-écosystèmes
    </header>
    <div class="button-container">
        <button onclick="window.location.href='carte.php'">Ajouter une zone</button>
    </div>
    <div id="map"></div>

    <script>
    var map = L.map('map').setView([48.395, -4.958], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    if (typeof savedZones !== "undefined") {
        savedZones.forEach(zoneData => {
            let mergedPolygon = [];

            zoneData.h3_zone.forEach(h3Index => {
                let polygonCoords = h3.cellToBoundary(h3Index).map(c => [c[0], c[1]]);
                mergedPolygon.push(polygonCoords);
            });

            if (mergedPolygon.length > 0) {
                let polygon = L.polygon(mergedPolygon, {
                    color: "transparent",  // 🔹 Bordure invisible
                    weight: 0,             // 🔹 Supprime les contours
                    fillColor: "blue",     // 🔹 Uniformiser la couleur
                    fillOpacity: 0.8,        // 🔹 Améliorer la fusion visuelle
                    fillRule: "evenodd",

                }).addTo(map);
                polygon.bindTooltip(`<strong>${zoneData.nom}</strong>`, { permanent: false });
            }
        });
    }

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
                if (!chemin) {
                    L.popup()
                        .setLatLng(this.getBounds().getCenter())
                        .setContent(`<strong>${zoneData.nom}</strong><br><p>Aucune donnée enregistrée</p>`)
                        .openOn(map);
                    return;
                }

                // Vérifier l'extension du fichier pour décider comment l'afficher
                let extension = chemin.split('.').pop().toLowerCase();
                let content = "";

                if (["png", "jpg", "jpeg", "gif"].includes(extension)) {
                    // 🔹 Afficher une image directement
                    content = `<img src="${chemin}" style="max-width:200px;max-height:200px;">`;
                } else if (["txt", "csv", "json"].includes(extension)) {
                    // 🔹 Charger et afficher le contenu textuel du fichier
                    fetch(chemin)
                        .then(response => response.text())
                        .then(fileContent => {
                            L.popup()
                                .setLatLng(polygon.getBounds().getCenter())
                                .setContent(`<strong>${zoneData.nom}</strong><br><pre style="max-height:150px;overflow:auto;">${fileContent}</pre>`)
                                .openOn(map);
                        })
                        .catch(error => console.error("Erreur de chargement du fichier :", error));
                    return;
                } else {
                    // 🔹 Autre format (on propose juste un lien)
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
