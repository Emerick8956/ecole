<?php
session_start();
require_once("connexion.php");

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['connecte'])){
    header("Location: login.php");
    exit();
}

// Récupère tous les élèves
$stmt = $conn->query("SELECT * FROM eleves ORDER BY nom_prenom ASC");
$eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des élèves</title>
<style>
body { font-family: Arial; background: #f0f2f5; padding: 20px;}
table { border-collapse: collapse; width: 80%; margin: auto; }
th, td { border: 1px solid #aaa; padding: 10px; text-align: left; }
th { background-color: #3a7d44; color: white; }
tr:nth-child(even) { background-color: #f9f9f9; }
a { text-decoration: none; color: #3a7d44; font-weight: bold; }
a:hover { text-decoration: underline; }
h2 { text-align: center; color: #333; }
</style>
</head>
<body>

<h2>Liste des élèves</h2>

<table>
    <tr>
        <th>Nom et prénom</th>
    </tr>
    <?php foreach($eleves as $eleve): ?>
        <tr>
            <td>
                <a href="accueil.php?id_eleve=<?= $eleve['id_eleve'] ?>">
                    <?= htmlspecialchars($eleve['nom_prenom']) ?>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>