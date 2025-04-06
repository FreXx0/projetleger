<?php
$host = "localhost";
$dbname = "bibliotheque";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $genre = $_POST['genre'];
    $note = $_POST['note'];

    $sql = "UPDATE livres SET titre = ?, auteur = ?, genre = ?, note = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $auteur, $genre, $note, $id]);

    header("Location: index.php");
    exit();
}

// Récupération du livre à modifier
$sql = "SELECT * FROM livres WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$livre = $stmt->fetch();

if (!$livre) {
    echo "Livre non trouvé.";
    exit();
}
?>

<h1>✏️ Modifier le livre</h1>
<form method="post">
    <label>Titre :</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required><br><br>

    <label>Auteur :</label><br>
    <input type="text" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required><br><br>

    <label>Genre :</label><br>
    <input type="text" name="genre" value="<?= htmlspecialchars($livre['genre']) ?>"><br><br>

    <label>Note :</label><br>
    <input type="number" name="note" value="<?= htmlspecialchars($livre['note']) ?>" min="0" max="5"><br><br>

    <button type="submit">💾 Enregistrer</button>
</form>
<br>
<a href="index.php">📚 Retour à la liste</a>
