<?php
include('config.php'); // Connexion à la base de données

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // Recherche des collaborateurs dont le prénom ou nom correspond à la requête
    $stmt = $pdo->prepare("SELECT id_utilisateur, nom, prenom FROM utilisateur WHERE nom LIKE :query OR prenom LIKE :query LIMIT 5");
    $stmt->execute(['query' => '%' . $query . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        foreach ($results as $result) {
            echo "<div class='user-result' onclick='inviteUser({$result['id_utilisateur']}, 1)'>" . htmlspecialchars($result['prenom'] . ' ' . $result['nom']) . "</div>";
        }
    } else {
        echo "<div>Aucun utilisateur trouvé.</div>";
    }
}
?>
