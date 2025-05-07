<?php
session_start();
session_destroy(); // Supprime toutes les sessions
header("Location: index.php"); // Redirige vers la page d'accueil générique
exit();
?>