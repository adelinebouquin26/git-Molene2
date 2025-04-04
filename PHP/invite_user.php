
<!-- invite_user.php -->
<?php
include('config.php');

$id_utilisateur = $_SESSION['id_utilisateur'];
$id_projet = $_POST['project_id'] ?? null;
$id_invite = $_POST['user_id'] ?? null;

if (!$id_projet || !$id_invite) {
    die("Erreur : project_id ou user_id manquant !");
}

$stmt = $pdo->prepare("INSERT INTO utilisateur_projet (id_utilisateur, id_projet, role) VALUES (?, ?, 'en_attente')");
$stmt->execute([$id_invite, $id_projet]);
?>

