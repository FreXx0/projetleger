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

// Récupérer les livres de la base de données
$sql = "SELECT * FROM livres";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Bibliothèque</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers ton fichier CSS -->
</head>
<body>

<header>
    <div class="header-content">
        <h1>Bibliothèque - Gestion des Livres</h1>
    </div>
</header>

<nav class="navbar">
    <a href="index.php" class="navbar-link">Accueil</a>
    <a href="ajouter.php" class="navbar-link">Ajouter un Livre</a>
</nav>

<main class="container">
    <h2>Liste des Livres</h2>
    
    <div class="table-wrapper">
        <table class="book-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Affichage des livres
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['titre']}</td>
                                <td>{$row['auteur']}</td>
                                <td>{$row['genre']}</td>
                                <td>
                                    <a href='modifier.php?id={$row['id']}' class='btn-edit'>Modifier</a>
                                    <a href='supprimer.php?id={$row['id']}' class='btn-delete'>Supprimer</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun livre trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<footer>
    <p>&copy; 2025 Bibliothèque - Tous droits réservés</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
