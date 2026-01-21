<?php
session_start();
require_once("connexion.php");

if (!isset($_SESSION['connecte'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id_eleve'])) {
    header("Location: liste_eleve.php");
    exit();
}

$id_eleve = $_GET['id_eleve'];

$stmt = $conn->prepare("SELECT nom_prenom FROM eleves WHERE id_eleve = ?");
$stmt->execute([$id_eleve]);
$eleve = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $conn->prepare("SELECT * FROM notes WHERE id_eleve = ?");
$stmt->execute([$id_eleve]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Matières</title>
<style>
body {
    font-family: Arial;
    background: #f0f2f5;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

table {
    border-collapse: collapse;
    width: 60%;
    margin: auto;
}

th, td {
    border: 1px solid #aaa;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #3a7d44;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

a.matiere {
    color: #000;
    text-decoration: none;
    font-weight: bold;
}

a.matiere:hover {
    text-decoration: underline;
}


a.button {
    display: inline-block;
    padding: 10px 20px;
    margin-top: 20px;
    background: #3a7d44;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

a.button:hover {
    background: #2f6131;
}

p {
    text-align: center;
    font-weight: bold;
}
</style>
</head>
<body>

<h2>Élève : <?= htmlspecialchars($eleve['nom_prenom']) ?></h2>

<table>
    <tr>
        <th>Matière</th>
        <th>Moyenne</th>
    </tr>

<?php foreach ($notes as $n): 
    $moyenne = (
        $n['interro1'] +
        $n['interro2'] +
        $n['interro3'] +
        $n['devoir1'] +
        $n['devoir2']
    ) / 5;
?>
<tr>
    <td>
        <a class="matiere"
           href="details_matiere.php?id_eleve=<?= $id_eleve ?>&matiere=<?= urlencode($n['nom_matiere']) ?>">
            <?= htmlspecialchars($n['nom_matiere']) ?>
        </a>
    </td>
    <td><?= number_format($moyenne, 2) ?></td>
</tr>
<?php endforeach; ?>
</table>

<p>
<a class="button" href="traitement_login.php">Retour à la liste des élèves</a>
</p>

</body>
</html>
