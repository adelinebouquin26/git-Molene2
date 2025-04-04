<?php
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['nom']) || empty($data['hexes'])) {
    echo json_encode(["success" => false, "message" => "Données invalides"]);
    exit;
}

$nom = $data['nom'];
$hexes = $data['hexes'];

$stmt = $pdo->prepare("SELECT id_data, chemin FROM data WHERE nom = ?");
$stmt->execute([$nom]);
$dataInfo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dataInfo) {
    echo json_encode(["success" => false, "message" => "Donnée non trouvée"]);
    exit;
}

$data_id = $dataInfo['id_data'];
$chemin = $dataInfo['chemin'];

// Supprimer les anciennes zones de cette donnée
$stmt = $pdo->prepare("DELETE FROM data_polygons WHERE data_id = ?");
$stmt->execute([$data_id]);

// Insérer la nouvelle zone sous forme de JSON
$zone = json_encode($hexes);
$stmt = $pdo->prepare("INSERT INTO data_polygons (data_id, h3_zone, chemin) VALUES (?, ?, ?)");
$success = $stmt->execute([$data_id, $zone, $chemin]);

// ✅ Renvoie juste du JSON propre, SANS redirection
echo json_encode(["success" => $success]);
exit;
?>
