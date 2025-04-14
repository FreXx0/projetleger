<?php
// Connexion à la base de données
$host = "localhost"; 
$dbname = "bibliotheque"; 
$username = "root"; 
$password = ""; 

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password); // Création d'une instance PDO pour se connecter à la base de données avec l'encodage UTF-8

$id = $_GET['id'] ?? null; // Récupération de l'identifiant du livre depuis l'URL (si présent), sinon null
?>

<?php
// Vérification si le formulaire a été soumis en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs saisies dans le formulaire
    $titre = $_POST['titre']; 
    $auteur = $_POST['auteur']; 
    $genre = $_POST['genre']; 
    $note = $_POST['note'];

    // Requête SQL pour mettre à jour les informations du livre dans la base de données
    $sql = "UPDATE livres SET titre = ?, auteur = ?, genre = ?, note = ? WHERE id = ?"; // Requête d'UPDATE avec des paramètres
    $stmt = $pdo->prepare($sql); // Préparation de la requête
    $stmt->execute([$titre, $auteur, $genre, $note, $id]); // Exécution de la requête avec les paramètres

    // Redirection vers la page d'accueil après la mise à jour
    header("Location: index.php");
    exit(); // Interruption de l'exécution du script pour éviter que du code ne s'exécute après la redirection
}

// Récupération des informations du livre à modifier depuis la base de données
$sql = "SELECT * FROM livres WHERE id = ?"; // Requête SQL pour récupérer un livre en fonction de son identifiant
$stmt = $pdo->prepare($sql); // Préparation de la requête
$stmt->execute([$id]); // Exécution de la requête avec l'id du livre
$livre = $stmt->fetch(); // Récupération des données du livre sous forme de tableau associatif

// Vérification si le livre existe dans la base de données
if (!$livre) {
    echo "Livre non trouvé."; // Si aucun livre n'est trouvé avec cet identifiant, afficher un message d'erreur
    exit(); // Arrêter l'exécution du script
}
?>

<!-- Formulaire de modification du livre -->
<h1>✏️ Modifier le livre</h1> 

<!-- Formulaire de type POST pour soumettre les modifications -->
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

<!-- Lien pour revenir à la page de la liste des livres -->
<a href="index.php">📚 Retour à la liste</a>
