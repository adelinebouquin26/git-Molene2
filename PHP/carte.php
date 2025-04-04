<?php
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');

// Récupérer toutes les zones de données stockées
$stmt = $pdo->query("SELECT dp.h3_zone, d.nom, dp.data_id FROM data_polygons dp JOIN data d ON dp.data_id = d.id_data");

$data_polygons = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach ($data_polygons as &$polygon) {
    $polygon['h3_zone'] = json_decode($polygon['h3_zone'], true);
}

echo "<script>var savedZones = " . json_encode($data_polygons) . ";</script>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hex Picker - Leaflet Map with H3</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/h3-js@4.1.0/dist/h3-js.umd.js"></script>
    <style>
        body, html { margin: 0; padding: 0; height: 100%; width: 100%; }
        #map { height: 100%; width: 100%; }
        .card {
            position: absolute; top: 10px; right: 10px;
            background-color: white; border: 1px solid #ccc; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); padding: 15px; z-index: 1000;
            width: 250px;
        }
        #hexagonCounter { font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    
    <div id="map"></div>

    <div class="card">
        <select id="resolutionSelect">
            <?php for ($i = 0; $i <= 15; $i++) { echo "<option value='$i'>Resolution: $i</option>"; } ?>
        </select>
        <input type="text" id="nom" placeholder="Nom de la donnée">
        <div id="fileLinks"></div>
        <button id="saveButton">Enregistrer</button>
        <button id="clearButton" disabled>Effacer Sélection</button>
        <div id="hexagonCounter">Hexagones sélectionnés: 0</div>
        <button onclick="window.location.href='zone.php'">Retour</button>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    <script>
    var map = L.map('map').setView([48.395, -4.958], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

if (typeof savedZones !== "undefined") {
    
    console.log("Données chargées :", savedZones);

    savedZones.forEach(zoneData => {
        let mergedPolygon = [];

        zoneData.h3_zone.forEach(h3Index => {
            let polygonCoords = h3.cellToBoundary(h3Index).map(c => [c[0], c[1]]);
            mergedPolygon.push(polygonCoords);
        });

        if (mergedPolygon.length > 0) {
            let polygon = L.polygon(mergedPolygon, {
                color: "green",
                weight: 2,
                fillOpacity: 0.5
            }).addTo(map);

            // 🔹 Infobulle au survol (corrigée)
            polygon.bindTooltip(`<strong>${zoneData.nom}</strong>`, { 
                permanent: false, 
                direction: "auto", 
                opacity: 0.8 
            });

            // 🔹 Popup au clic pour supprimer
            polygon.on("click", function (e) {
                L.popup()
                    .setLatLng(e.latlng)
                    .setContent(`
                        <strong>${zoneData.nom}</strong><br>
                        Hexagones: ${zoneData.h3_zone.length}<br>
                        <button onclick="deleteData(${zoneData.data_id})" 
                            style="background:red;color:white;padding:5px;border:none;border-radius:3px;cursor:pointer;">
                            Supprimer cette donnée
                        </button>
                    `)
                    .openOn(map);
            });
        }
    });
}


    var h3Resolution = 10;
    var selectedCells = new Set();
    var cellPolygons = {};

    function toggleButtons() {
        document.getElementById("hexagonCounter").textContent = `Hexagones sélectionnés: ${selectedCells.size}`;
        document.getElementById("saveButton").disabled = selectedCells.size === 0;
        document.getElementById("clearButton").disabled = selectedCells.size === 0;
    }

    function drawHexagons() {
        Object.values(cellPolygons).forEach(polygon => map.removeLayer(polygon));
        cellPolygons = {};
        selectedCells.clear();
        toggleButtons();

        let bounds = map.getBounds();
        let hexagons = h3.polygonToCells(
            [
                [bounds.getNorthWest().lat, bounds.getNorthWest().lng],
                [bounds.getSouthWest().lat, bounds.getSouthWest().lng],
                [bounds.getSouthEast().lat, bounds.getSouthEast().lng],
                [bounds.getNorthEast().lat, bounds.getNorthEast().lng],
            ],
            h3Resolution
        );

        hexagons.forEach(h3Index => {
            let polygonCoords = h3.cellToBoundary(h3Index).map(c => [c[0], c[1]]);
            let polygon = L.polygon(polygonCoords, { color: 'blue', weight: 1, fillOpacity: 0 });

            polygon.on('click', function () {
                if (selectedCells.has(h3Index)) {
                    selectedCells.delete(h3Index);
                    this.setStyle({ fillOpacity: 0 });
                } else {
                    selectedCells.add(h3Index);
                    this.setStyle({ fillOpacity: 0.5, color: 'red' });
                }
                toggleButtons();
            });

            cellPolygons[h3Index] = polygon;
            polygon.addTo(map);
        });
    }

    document.getElementById("resolutionSelect").addEventListener("change", function () {
        h3Resolution = parseInt(this.value, 10);
        drawHexagons();
    });

    document.getElementById("saveButton").addEventListener("click", function () {
        let nom = document.getElementById("nom").value;
        let hexes = Array.from(selectedCells);

        fetch("save_data.php", {
            method: "POST",
            body: JSON.stringify({ nom: nom, hexes: hexes }),
            headers: { "Content-Type": "application/json" }
        }).then(res => res.json()).then(data => {
            if (data.success) {
                window.location.href = `zones.php?nom=${encodeURIComponent(nom)}`;
            }
        });
    });

    map.on('moveend', drawHexagons);
    drawHexagons();

    saveButton.addEventListener("click", function () {
    let nom = document.getElementById("nom").value;
    let hexes = Array.from(selectedCells);

    fetch("save_data.php", {
        method: "POST",
        body: JSON.stringify({ nom: nom, hexes: hexes }),
        headers: { "Content-Type": "application/json" }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Données enregistrées avec succès !");
            window.location.reload();  // 🚀 Recharge juste la page
        } else {
            alert("Erreur : " + data.message);
        }
    })
    .catch(error => alert("Erreur réseau : " + error));
});

    function deleteData(data_id) {
        if (!confirm("Voulez-vous vraiment supprimer cette donnée ?")) return;

        fetch("delete_data.php", {
            method: "POST",
            body: JSON.stringify({ data_id: data_id }),
            headers: { "Content-Type": "application/json" }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Donnée supprimée avec succès !");
                window.location.reload();  // 🚀 Recharge la page pour mettre à jour la carte
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(error => alert("Erreur réseau : " + error));
    }



    </script>
</body>
</html>
