<?php
session_start();  // Démarre la session pour vérifier si l'utilisateur est connecté

// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");  // Redirige l'utilisateur vers la page de connexion
    exit();
}

$utilisateur_id = $_SESSION["user_id"];  // Récupère l'ID de l'utilisateur connecté

// Connexion à la base de données avec PDO
$pdo = new PDO("mysql:host=localhost;dbname=bibliotheque;charset=utf8", "root", "");

// Initialisation du message vide
$message = "";

// Vérification si le formulaire a été soumis via la méthode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $genre = $_POST["genre"];
    $note = $_POST["note"];

    // Requête SQL pour insérer un nouveau livre dans la base de données
    $sql = "INSERT INTO livres (titre, auteur, genre, note) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    // Exécution de la requête avec les données du formulaire
    $stmt->execute([$titre, $auteur, $genre, $note]);

    // Message de succès après l'ajout du livre
    $message = "✅ Livre ajouté ! <a href='index.php'>Voir mes livres</a>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<header>
    <div class="header-content">
        <h1>Bibliothèque - Ajouter un Livre</h1> 
    </div>
</header>

<nav class="navbar">
    <a href="index.php" class="navbar-link">Accueil</a> 
    <a href="ajouter.php" class="navbar-link">Ajouter un Livre</a>  
    <a href="deconnexion.php" class="navbar-link">Se Déconnecter</a> 
</nav>

<main class="container">
    <?php if ($message): ?>  <!-- Si un message est défini (livre ajouté avec succès), il est affiché -->
        <p class="success-message"><?= $message ?></p>
    <?php endif; ?>

    <h2 class="form-title">➕ Ajouter un livre</h2>

    <!-- Formulaire d'ajout de livre -->
    <form method="post" class="book-form">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" required>  <!-- Champ pour le titre du livre -->

        <label for="auteur">Auteur :</label>
        <input type="text" name="auteur" id="auteur" required>  <!-- Champ pour l'auteur du livre -->

        <label for="genre">Genre :</label>
        <input type="text" name="genre" id="genre">  <!-- Champ pour le genre du livre -->

        <label for="note">Note (0 à 5 étoiles) :</label>
        <input type="number" name="note" id="note" min="0" max="5">  <!-- Champ pour la note du livre, de 0 à 5 -->

        <button type="submit" class="btn-submit">Ajouter</button>  <!-- Bouton pour soumettre le formulaire -->
    </form>
</main>

<footer>
    <p>&copy; 2025 Bibliothèque - Tous droits réservés</p>
</footer>

</body>
</html>
