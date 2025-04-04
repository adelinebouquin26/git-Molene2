<?php
$pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '');
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['data_id'])) {
    echo json_encode(["success" => false, "message" => "Données invalides"]);
    exit;
}

$data_id = $data['data_id'];

// Supprimer la donnée de `data_polygons`
$stmt = $pdo->prepare("DELETE FROM data_polygons WHERE data_id = ?");
$success = $stmt->execute([$data_id]);

echo json_encode(["success" => $success]);
?>
