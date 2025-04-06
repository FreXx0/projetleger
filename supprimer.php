<?php
$host = "localhost";
$dbname = "bibliotheque";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $id = $_GET['id'];
    $sql = "DELETE FROM livres WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: index.php");
    exit();

} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
