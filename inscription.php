<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Hachage du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Vérifier si l'email est déjà utilisé
    $sql_verif = "SELECT * FROM utilisateurs WHERE email = ?";
    $stmt_verif = $conn->prepare($sql_verif);
    $stmt_verif->bind_param("s", $email);
    $stmt_verif->execute();
    $result = $stmt_verif->get_result();

    if ($result->num_rows > 0) {
        echo "Un compte avec cet email existe déjà.";
    } else {
        // Requête SQL pour l'insertion
        $query = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        // Lier les valeurs
        $stmt->bind_param("sss", $nom_utilisateur, $email, $mot_de_passe_hache);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Compte créé avec succès. <a href='connexion.php'>Se connecter</a>";
        } else {
            echo "Erreur lors de la création du compte : " . $stmt->error;
        }

        $stmt->close();
    }

    $stmt_verif->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Créer un compte</h1>
</header>

<main class="container">
    <form method="POST" action="inscription.php">
        <label for="nom_utilisateur">Nom d'utilisateur :</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Vous avez déjà un compte ? <a href="connexion.php">Se connecter</a></p>
</main>

</body>
</html>
