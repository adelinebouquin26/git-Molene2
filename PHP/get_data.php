<?php
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$data = json_decode(file_get_contents("php://input"), true);
$nom = $data['nom'];

$stmt = $pdo->prepare("SELECT chemin FROM data WHERE nom = ?");
$stmt->execute([$nom]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo json_encode(["error" => "Aucune donnée trouvée pour ce nom"]);
    exit;
}

// 🔹 Définir l'URL de base (modifie selon ton projet)
$baseURL = "http://localhost/SITE_MOLENE2/"; 

// 🔹 Construire le chemin absolu
$result['chemin'] = $baseURL . ltrim($result['chemin'], "/"); // Supprime "/" en début si présent

// 🔹 Envoyer la réponse JSON avec le chemin absolu
echo json_encode($result);
?>
