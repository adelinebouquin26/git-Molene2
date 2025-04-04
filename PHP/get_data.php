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

echo json_encode($result);
?>
