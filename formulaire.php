<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un livre</title>
</head>
<body>
    <h1>Ajouter un livre à ma bibliothèque</h1>
    <form action="ajouter.php" method="post">
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
</body>
</html>
