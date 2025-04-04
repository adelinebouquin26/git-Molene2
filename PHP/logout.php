<?php
session_start();
session_destroy(); // Supprime toutes les sessions
header("Location: accueil.php"); // Redirige vers la page d'accueil
exit();
?>