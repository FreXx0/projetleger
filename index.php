<?php
// Connexion à la base de données
$servername = "localhost"; // Définir le nom du serveur de base de données (ici localhost pour un serveur local)
$username = "root"; // Définir le nom d'utilisateur pour se connecter à la base de données (ici root)
$password = ""; // Définir le mot de passe pour la connexion à la base de données (ici vide)
$dbname = "bibliotheque"; // Définir le nom de la base de données à utiliser

// Créer une connexion à la base de données avec les paramètres précédents
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Si la connexion échoue, afficher un message d'erreur et arrêter l'exécution
}

// Récupérer les livres de la base de données
$sql = "SELECT * FROM livres"; // La requête SQL pour récupérer tous les livres de la table 'livres'
$result = $conn->query($sql); // Exécution de la requête et récupération du résultat
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définir l'encodage des caractères à UTF-8 pour gérer les caractères spéciaux -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Assurer la responsivité sur les appareils mobiles -->
    <title>Gestion de Bibliothèque</title> <!-- Titre de la page qui apparaîtra dans l'onglet du navigateur -->
    <link rel="stylesheet" href="style.css"> <!-- Lien vers la feuille de style externe (style.css) -->
</head>
<body>

<header>
    <div class="header-content">
        <h1>Bibliothèque - Gestion des Livres</h1> <!-- Titre principal de la page -->
    </div>
</header>

<nav class="navbar">
    <a href="index.php" class="navbar-link">Accueil</a> <!-- Lien vers la page d'accueil -->
    <a href="ajouter.php" class="navbar-link">Ajouter un Livre</a> <!-- Lien vers la page d'ajout d'un livre -->
    <a href="livre_a_la_une.php" class ="navbar-link">Livre à La Une </a> <!-- Lien vers la page Livre à la une -->
    <a href="deconnexion.php" class="navbar-link">Se Connecter</a> <!-- Lien vers la page de Connexion -->
</nav>

<main class="container">
    <h2>Derniers livres ajoutés</h2> <!-- Sous-titre pour cette section de la page -->
    
    <div class="table-wrapper">
        <table class="book-table"> <!-- Début de la table pour afficher les livres -->
            <thead>
                <tr>
                    <th>Titre</th> <!-- Colonne pour le titre du livre -->
                    <th>Auteur</th> <!-- Colonne pour l'auteur du livre -->
                    <th>Genre</th> <!-- Colonne pour le genre du livre -->
                    <th>Actions</th> <!-- Colonne pour les actions (modifier, supprimer) -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) { // Vérifier s'il y a des livres dans le résultat
                    // Affichage des livres
                    while ($row = $result->fetch_assoc()) { // Pour chaque livre récupéré
                        echo "<tr>
                                <td>{$row['titre']}</td> <!-- Affichage du titre du livre -->
                                <td>{$row['auteur']}</td> <!-- Affichage de l'auteur du livre -->
                                <td>{$row['genre']}</td> <!-- Affichage du genre du livre -->
                                <td>
                                    <a href='modifier.php?id={$row['id']}' class='btn-edit'>Modifier</a> <!-- Lien pour modifier le livre, passe l'id du livre -->
                                    <a href='supprimer.php?id={$row['id']}' class='btn-delete'>Supprimer</a> <!-- Lien pour supprimer le livre, passe l'id du livre -->
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucun livre trouvé</td></tr>"; // Si aucun livre n'est trouvé, afficher ce message
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<footer>
    <p>&copy; 2025 Bibliothèque - Tous droits réservés</p> <!-- Pied de page avec le copyright -->
</footer>

</body>
</html>

<?php
$conn->close(); // Fermer la connexion à la base de données après avoir fini
?>