<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "bibliotheque");

// Vérifie si la connexion échoue
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Si un livre est à ajouter
if (isset($_GET['ajouter_id'])) {
    $id = intval($_GET['ajouter_id']);

    // On récupère les infos du livre dans livre_a_la_une
    $sql = "SELECT * FROM livre_a_la_une WHERE id = $id LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Sécurise les données avec real_escape_string pour éviter les injections SQL
        $titre = $conn->real_escape_string($row['titre']);
        $auteur = $conn->real_escape_string($row['auteur']);
        $genre = 'Sport'; // Tu peux adapter selon le livre

        // On insère dans la table livres
        $insert = "INSERT INTO livres (titre, auteur, genre) VALUES ('$titre', '$auteur', '$genre')";
        $conn->query($insert);
    }

    // Redirige l'utilisateur vers la page pour éviter de rajouter le livre plusieurs fois si la page est rafraîchie
    header("Location: livre_a_la_une.php");
    exit();
}

// On récupère tous les livres à la une
$sql = "SELECT * FROM livre_a_la_une";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livres à la Une</title>
</head>
<body>
    <h1>📚 Livres à la Une</h1>

    <!-- Tableau HTML pour afficher les livres -->
    <table border="1" cellpadding="8">
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date de sortie</th>
            <th>Action</th>
        </tr>
        <!-- Boucle PHP pour afficher chaque ligne de la table -->
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['titre']) ?></td>
            <td><?= htmlspecialchars($row['auteur']) ?></td>
            <td><?= htmlspecialchars($row['date_sortie']) ?></td>
            <td>
                <a href="livre_a_la_une.php?ajouter_id=<?= $row['id'] ?>">Ajouter</a> <!-- Bouton pour ajouter le livre à la liste -->
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <!-- Lien de retour vers la page d'accueil -->
    <a href="index.php">← Retour à l'accueil</a>
</body>
</html>

<!-- Ferme la connexion à la BDD -->
<?php $conn->close(); ?>
