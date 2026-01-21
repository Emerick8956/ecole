<?php
session_start();
require_once("connexion.php");

if(!isset($_SESSION['eleve_id']) && !isset($_SESSION['prof'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Liste des élèves</h2>";
echo "<table border='1' style='border-collapse: collapse; width: 50%;'>";
echo "<tr><th>Nom et Prénoms</th></tr>";

// Si c'est un parent, on affiche uniquement son enfant
if($_SESSION['prof'] === false) {
    $stmt = $conn->prepare("SELECT * FROM eleves WHERE id_eleve = ?");
    $stmt->execute([$_SESSION['eleve_id']]);
} else {
    // Professeur voit tous les élèves
    $stmt = $conn->query("SELECT * FROM eleves");
}

$eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($eleves as $eleve) {
    echo "<tr>";
    echo "<td><a href='accueil.php?id={$eleve['id_eleve']}'>" . htmlspecialchars($eleve['nom_prenom']) . "</a></td>";
    echo "</tr>";
}

echo "</table>";
?>
