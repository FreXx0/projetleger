<!DOCTYPE html>
<html lang="fr">
<!-- Déclare que le document est en HTML5 et que la langue du contenu est le français -->

<head>
    <meta charset="UTF-8">
    <!-- Spécifie l'encodage des caractères utilisé dans le document (UTF-8) -->
    <title>Ajouter un livre</title>
    <!-- Titre de la page qui s'affiche dans l'onglet du navigateur -->
</head>

<body>
    <h1>Ajouter un livre à ma bibliothèque</h1>

    <form action="ajouter.php" method="post">
        <!-- Formulaire qui envoie une requête POST vers la page 'ajouter.php' -->

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

    <br>
    <a href="index.php">📚 Voir les livres</a>
    <!-- Lien qui redirige l'utilisateur vers la page 'index.php' pour voir la liste des livres -->
</body>
</html>
