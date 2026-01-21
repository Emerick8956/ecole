<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=ecole;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion OK !"; // Optionnel pour tester
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
