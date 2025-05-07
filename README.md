Récits et Imaginaires Croisés

Présentation du projet
Récits et Imaginaires Croisés est une plateforme web collaborative permettant d'explorer, de structurer et de visualiser des données ancrés dans des territoires spécifiques. Elle associe des contenus multimédias (textes, sons, images) à une carte interactive basée sur un maillage hexagonal dynamique.

Ce projet s’inscrit à la croisée des technologies du web, de la cartographie et de la narration.

Fonctionnalités principales
- Création de compte et authentification
- Ajout, modification et suppression de données multimédias
- Visualisation des données sur carte interactive
- Classification par type, niveau, collaborateur

Installation (en local) :
Pour tester ou développer ce projet en local, suivez les étapes ci-dessous.

Pré-requis
Avant de commencer, assurez-vous d’avoir :

1. Un compte GitHub
   → Créez un compte ici : https://github.com/join
2. Git installé sur votre ordinateur
   → Téléchargez Git ici : https://git-scm.com/downloads

Pour vérifier l’installation, ouvrez un terminal et tapez :
   git --version

Étapes pour cloner le projet

1. Ouvrir un terminal (ou Git Bash)
2. (Optionnel mais recommandé) Créez un dossier pour accueillir le projet :
   mkdir projet_molene
   cd projet_molene
3. Cloner le dépôt GitHub :
   git clone https://github.com/adelinebouquin26/git-Molene2.git
4. Entrer dans le dossier du projet cloné :
   cd git-Molene2

Importer la base de données :

- Ouvrir phpMyAdmin
- Créer une nouvelle base de données
- Importer le fichier script.sql (fourni dans le dossier projet_molene)

Lancer le serveur local (XAMPP, WAMP ou autre) :

Placer le dossier du projet dans htdocs
Accéder via http://localhost/nom-du-dossier

Structure du projet

index.php                → Page d’accueil
└──> authentification.php       → Connexion / Inscription
     └──> projets.php                  → Liste des projets
          ├──> projet_molene.php           → Page spécifique d’un projet
          │     ├──> zone.php                  → Carte interactive – attribution
          │     ├──> carte.php                 → Carte interactive – visualisation
          │     ├──> data.php                  → Visualisation / tri des données
          │     ├──> search_user.php           → Recherche de collaborateurs
          │     ├──> invite_user.php           → Ajout collaborateur
          │     └──> handle_invitation.php     → Réponse à une invitation (pas encore fonctionnel)
          └──> mon_espace.php              → Espace personnel
                └──> ajout_donnee.php          → Ajout de données

Compte pour se connecter au site web avec les droits du projet Molène:
Adresse mail : admin_demo@gmail.com
Mot de passe : Version1_2025!


Suivi et contact
Projet réalisé dans le cadre de l’ISEN Brest, sous la supervision de :

Thierry Le Pors (aspects techniques)
Manuel Irles (suivi projet / pédagogie)
Isabelle Elizéon (porteuse du besoin) 
