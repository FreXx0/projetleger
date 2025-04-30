<?php
// Connexion à la base de données
$servername = "localhost"; // Nom du serveur de la base de données (ici, le serveur local)
$username = "root"; // Nom d'utilisateur pour se connecter à la base de données (ici root)
$password = ""; // Mot de passe pour la connexion (ici vide)
$dbname = "bibliotheque"; // Nom de la base de données à utiliser

// Création d'une nouvelle connexion MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Si la connexion échoue, afficher un message d'erreur et arrêter l'exécution
}

$message = ""; // Initialisation d'une variable pour stocker le message à afficher à l'utilisateur

// Vérification de la méthode de requête POST (pour savoir si le formulaire a été soumis)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données soumises par le formulaire
    $nom_utilisateur = $_POST['nom_utilisateur']; // Nom d'utilisateur saisi
    $email = $_POST['email']; // Email saisi
    $mot_de_passe = $_POST['mot_de_passe']; // Mot de passe saisi

    // Hashage du mot de passe pour le sécuriser avant de l'enregistrer
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Vérification si l'email existe déjà dans la base de données
    $sql_verif = "SELECT * FROM utilisateurs WHERE email = ?"; // Requête pour vérifier l'email
    $stmt_verif = $conn->prepare($sql_verif); // Préparation de la requête
    $stmt_verif->bind_param("s", $email); // Liaison du paramètre (email) à la requête
    $stmt_verif->execute(); // Exécution de la requête
    $result = $stmt_verif->get_result(); // Récupération du résultat de la requête

    // Vérification si un utilisateur avec le même email existe
    if ($result->num_rows > 0) {
        $message = "❌ Un compte avec cet email existe déjà.";
    } else {
        // Si l'email n'existe pas, procéder à l'ajout du nouvel utilisateur
        $query = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)"; // Requête pour insérer un nouvel utilisateur
        $stmt = $conn->prepare($query); // Préparation de la requête d'insertion

        // Vérification si la préparation de la requête a échoué
        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $conn->error); // Si erreur dans la préparation, afficher le message d'erreur
        }

        // Liaison des paramètres (nom, email, mot de passe haché) à la requête
        $stmt->bind_param("sss", $nom_utilisateur, $email, $mot_de_passe_hache);

        // Exécution de la requête d'insertion
        if ($stmt->execute()) {
            $message = "✅ Compte créé avec succès. <a href='connexion.php'>Se connecter</a>";
        } else {
            $message = "❌ Erreur lors de la création du compte : " . $stmt->error;
        }

        $stmt->close(); // Fermeture de la requête préparée
    }

    $stmt_verif->close(); // Fermeture de la requête de vérification
    $conn->close(); // Fermeture de la connexion à la base de données
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définir l'encodage des caractères à UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Assurer la responsivité sur les appareils mobiles -->
    <title>Inscription</title> <!-- Titre de la page qui apparaîtra dans l'onglet du navigateur -->
    <link rel="stylesheet" href="style.css"> <!-- Lien vers la feuille de style externe pour la mise en forme -->
</head>
<body>

<header>
    <div class="header-content">
        <h1>Créer un compte</h1> 
    </div>
</header>

<nav class="navbar">
    <a href="index.php" class="navbar-link">Accueil</a> 
    <a href="connexion.php" class="navbar-link">Connexion</a> 
</nav>

<main class="container">
    <h2>📝 Inscription</h2> 

    <?php if (!empty($message)): ?> <!-- Si un message est présent (succès ou erreur), l'afficher -->
        <p style="color: <?= str_starts_with($message, '✅') ? 'green' : 'red' ?>; font-weight: bold;">
            <?= $message ?> <!-- Affichage du message avec une couleur (verte pour succès, rouge pour erreur) -->
        </p>
    <?php endif; ?>

    <form method="POST" action="inscription.php" style="margin-top: 20px;">
        <label for="nom_utilisateur">Nom d'utilisateur :</label><br>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required><br><br> 

        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" required><br><br> 

        <label for="mot_de_passe">Mot de passe :</label><br>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br> 

        <button type="submit">S'inscrire</button> 
    </form>

    <p style="margin-top: 15px;">Déjà inscrit ? <a href="connexion.php">Se connecter</a></p>
</main>

<footer>
    <p>&copy; 2025 Bibliothèque - Tous droits réservés</p>
</footer>

</body>
</html>
