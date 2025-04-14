<?php
// Démarre une session PHP. Cela permet de manipuler des variables de session (par exemple, pour suivre l'utilisateur connecté).
session_start();

// Détruit toutes les données de la session (par exemple, déconnecte l'utilisateur).
session_destroy();

// Redirige l'utilisateur vers la page de connexion après la déconnexion.
header("Location: connexion.php");

// Arrête l'exécution du script après la redirection, pour s'assurer que rien d'autre n'est exécuté.
exit();
