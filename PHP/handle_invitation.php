<!-- handle_invitation.php -->
<?php
include('config.php');
$id_utilisateur = $_SESSION['id_utilisateur'];
$id_projet = $_POST['id_projet'];
$decision = $_POST['decision'];

if ($decision == 'accepter') {
    $stmt = $pdo->prepare("UPDATE utilisateur_projet SET role = 'membre' WHERE id_utilisateur = ? AND id_projet = ?");
} else {
    $stmt = $pdo->prepare("DELETE FROM utilisateur_projet WHERE id_utilisateur = ? AND id_projet = ?");
}
$stmt->execute([$id_utilisateur, $id_projet]);
?>
