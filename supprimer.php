<?php
// Connexion à la base de données
$host = "localhost"; 
$dbname = "bibliotheque"; 
$username = "root"; 
$password = "";

try {
    // Tentative de connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Récupération de l'ID du livre à supprimer depuis l'URL (paramètre GET)
    $id = $_GET['id'];

    // Requête SQL pour supprimer le livre avec l'ID donné
    $sql = "DELETE FROM livres WHERE id = ?";
    
    // Préparation de la requête pour éviter les injections SQL
    $stmt = $pdo->prepare($sql);
    
    // Exécution de la requête avec l'ID du livre
    $stmt->execute([$id]);

    // Redirection vers la page d'accueil après suppression
    header("Location: index.php");
    exit(); // Arrêt du script pour s'assurer que la redirection est bien effectuée

} catch (PDOException $e) {
    // En cas d'erreur, affiche un message d'erreur
    echo "❌ Erreur : " . $e->getMessage();
}
?>
