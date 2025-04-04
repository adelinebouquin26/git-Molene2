<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=data_molène', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>