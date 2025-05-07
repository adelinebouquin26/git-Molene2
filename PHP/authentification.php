<?php
// ----------------------------------
// Initialisation de la session
// ----------------------------------
session_start();

// ----------------------------------
// Connexion à la base de données
// ----------------------------------
$conn = new mysqli("localhost", "root", "", "data_molène");

// -------------------------------------------------------
// Traitement du formulaire d'inscription ou de connexion
// -------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // --------------------------
    // Traitement de l'inscription
    // --------------------------
    if (isset($_POST["register"])) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $id_fonction = $_POST["id_fonction"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vérifie si l'email est déjà utilisé
        $query = $conn->prepare("SELECT Mail FROM utilisateur WHERE Mail = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        // Insère le nouvel utilisateur s'il n'existe pas
        if ($result->num_rows > 0) {
            $_SESSION["message"] = "Cet email est déjà utilisé.";
            $_SESSION["message_type"] = "error";
        } else {
            $query = $conn->prepare("INSERT INTO utilisateur (Nom, Prenom, Mail, MDP, id_fonction) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("ssssi", $nom, $prenom, $email, $hashed_password, $id_fonction);

            if ($query->execute()) {
                $_SESSION["message"] = "Inscription réussie ! Connectez-vous.";
                $_SESSION["message_type"] = "success";
            } else {
                $_SESSION["message"] = "Erreur lors de l'inscription.";
                $_SESSION["message_type"] = "error";
            }
        }

    // -------------------------
    // Traitement de la connexion
    // -------------------------
    } else {
        $query = $conn->prepare("SELECT id_utilisateur, Nom, Prenom, id_fonction, MDP FROM utilisateur WHERE Mail = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        // Vérifie si l'utilisateur existe et si le mot de passe est correct
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $hashStocke = $user["MDP"];
            if (password_verify($password, $hashStocke)) {
                // Stocker les infos de l'utilisateur en session
                $_SESSION["id_utilisateur"] = $user["id_utilisateur"];
                $_SESSION["nom"] = $user["Nom"];
                $_SESSION["prenom"] = $user["Prenom"];
                $_SESSION["id_fonction"] = $user["id_fonction"];
                header("Location: projets.php");
                exit();
            } else {
                $_SESSION["message"] = "Mot de passe incorrect.";
                $_SESSION["message_type"] = "error";
            }
        } else {
            $_SESSION["message"] = "Email introuvable.";
            $_SESSION["message_type"] = "error";
        }
    }
}
?>

<!-- ------------------------------------------- -->
<!-- Début de la page HTML pour authentification -->
<!-- ------------------------------------------- -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="http://localhost/SITE_MOLENE2/CSS/authentification.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- ------------------------------ -->
<!-- Popup de message de feedback  -->
<!-- ------------------------------ -->
<div id="popup-message" class="popup">
    <p id="popup-text"></p>
</div>

<!-- ---------------------------------------------- -->
<!-- Conteneur principal contenant les deux formulaires -->
<!-- ---------------------------------------------- -->
<div class="login-page">
  <div class="form">

    <!-- ----------------------------- -->
    <!-- Formulaire d'inscription      -->
    <!-- ----------------------------- -->
    <form class="register-form" method="POST" action="">
      <input type="text" name="nom" placeholder="Nom" required/>
      <input type="text" name="prenom" placeholder="Prénom" required/>
      <input type="email" name="email" placeholder="Adresse email" required/>
      <input type="password" name="password" placeholder="Mot de passe" required/>
      <select name="id_fonction" required>
        <option value="1">Particulier</option>
        <option value="2">Scientifique</option>
        <option value="3">Autre</option>
      </select>
      <button type="submit" name="register">Créer un compte</button>
      <p class="message">Déjà inscrit ? <a href="#">Se connecter</a></p>
    </form>

    <!-- ----------------------------- -->
    <!-- Formulaire de connexion       -->
    <!-- ----------------------------- -->
    <form class="login-form" method="POST" action="">
      <input type="email" name="email" placeholder="Adresse email" required/>
      <input type="password" name="password" placeholder="Mot de passe" required/>
      <button type="submit" name="login">Se connecter</button>
      <p class="message">Pas encore inscrit ? <a href="#">Créer un compte</a></p>
    </form>

  </div>
</div>

<!-- ------------------------------------------- -->
<!-- Script JS pour basculer entre les formulaires -->
<!-- ------------------------------------------- -->
<script>
  $('.message a').click(function(){
     $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
  });
</script>

<!-- -------------------------------------------------- -->
<!-- Script JS pour afficher et masquer les messages popups -->
<!-- -------------------------------------------------- -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let message = "<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>";
        let messageType = "<?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : ''; ?>";

        if (message !== "") {
            let popup = document.getElementById("popup-message");
            let popupText = document.getElementById("popup-text");

            popupText.textContent = message;
            popup.classList.add(messageType); // success ou error
            popup.classList.add("show");

            setTimeout(() => {
                popup.classList.remove("show", "success", "error");
            }, 5000);
        }

        <?php 
        // Nettoyage de la session pour ne pas garder les messages
        unset($_SESSION["message"]);
        unset($_SESSION["message_type"]); 
        ?>
    });
</script>

</body>
</html>
