<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

// Création d'une connexion à la base de données avec MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Si la connexion échoue, un message d'erreur est affiché.
}

session_start();  // Démarre une session pour pouvoir stocker des informations sur l'utilisateur connecté.

$message = ""; // Variable pour afficher un message après la soumission du formulaire.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Si la méthode de la requête est POST (c'est-à-dire que le formulaire a été soumis)
    // Récupérer les données envoyées par le formulaire
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérifier si un utilisateur existe avec l'email saisi
    $sql = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = $conn->query($sql);

    // Si un utilisateur est trouvé avec cet email
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();  // Récupère les informations de l'utilisateur trouvé
        // Vérifier si le mot de passe saisi correspond à celui stocké dans la base de données
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            // Si le mot de passe est correct, enregistrer les informations dans la session
            $_SESSION['user_id'] = $row['id'];  // L'ID de l'utilisateur est enregistré en session
            $_SESSION['nom'] = $row['nom'];  // Le nom de l'utilisateur est enregistré en session
            header("Location: index.php");  // Redirige l'utilisateur vers la page d'accueil
            exit();
        } else {
            $message = "❌ Mot de passe incorrect.";  
        }
    } else {
        $message = "❌ Aucun utilisateur trouvé avec cet email.";  
    }
}

$conn->close();  // Ferme la connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->
</head>
<body>

<header>
    <div class="header-content">
        <h1>Connexion à la Bibliothèque</h1> 
    </div>
</header>

<nav class="navbar">
    <a href="index.php" class="navbar-link">Accueil</a> 
    <a href="inscription.php" class="navbar-link">Créer un compte</a>
</nav>

<main class="container">
    <h2>🔐 Connexion</h2>

    <?php if (!empty($message)): ?>  <!-- Si un message d'erreur existe, il est affiché -->
        <p style="color: red; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" action="connexion.php" style="margin-top: 20px;">
        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" required><br><br> 

        <label for="mot_de_passe">Mot de passe :</label><br>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br> 

        <button type="submit">Se connecter</button>  
    </form>

    <p style="margin-top: 15px;">Vous n'avez pas de compte ? <a href="inscription.php">Créer un compte</a></p>  <!-- Lien vers la page d'inscription -->
</main>

<footer>
    <p>&copy; 2025 Bibliothèque - Tous droits réservés</p>
</footer>

</body>
</html>
