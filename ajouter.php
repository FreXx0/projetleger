<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, redirige-le vers la page de connexion
    header("Location: connexion.php");
    exit();
}

$utilisateur_id = $_SESSION["user_id"]; // Correction ici

$pdo = new PDO("mysql:host=localhost;dbname=bibliotheque;charset=utf8", "root", "");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $genre = $_POST["genre"];
    $note = $_POST["note"];

    $sql = "INSERT INTO livres (titre, auteur, genre, note, utilisateur_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $auteur, $genre, $note, $utilisateur_id]);

    echo "✅ Livre ajouté ! <a href='index.php'>Voir mes livres</a>";
}
?>

<h2>➕ Ajouter un livre</h2>
<form method="post">
    <label>Titre :</label><br>
    <input type="text" name="titre" required><br><br>
    <label>Auteur :</label><br>
    <input type="text" name="auteur" required><br><br>
    <label>Genre :</label><br>
    <input type="text" name="genre"><br><br>
    <label>Note (0 à 5 étoiles) :</label><br>
    <input type="number" name="note" min="0" max="5"><br><br>
    <button type="submit">Ajouter</button>
</form>
