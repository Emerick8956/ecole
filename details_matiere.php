<?php
session_start();
require_once("connexion.php");

// Vérifie si on a l'id de l'élève et la matière
if (!isset($_GET['id_eleve']) || !isset($_GET['matiere'])) {
    header("Location: liste_eleve.php");
    exit();
}

$id_eleve = $_GET['id_eleve'];
$matiere = $_GET['matiere'];

// Récupère le nom de l'élève
$stmt = $conn->prepare("SELECT nom_prenom FROM eleves WHERE id_eleve = ?");
$stmt->execute([$id_eleve]);
$eleve = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupère uniquement les notes de la matière sélectionnée
$stmt = $conn->prepare("SELECT * FROM notes WHERE id_eleve = ? AND nom_matiere = ?");
$stmt->execute([$id_eleve, $matiere]);
$notes = $stmt->fetch(PDO::FETCH_ASSOC);

function color_note($note) {
    return "note"; // toutes les notes en noir
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Notes de <?= htmlspecialchars($matiere) ?></title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

.header {
    background:#3a7d44;
    color:white;
    padding:10px;
    margin-bottom:20px;
}

h2 {
    color:#333;
    text-align:center;
}

table {
    border-collapse: collapse;
    width: 60%;
    margin: auto;
    background: white;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    color: #000;
}

th {
    background-color: #eee;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #fafafa;
}

.note {
    color: #000;
}

a.button {
    display:inline-block;
    margin-top:20px;
    padding:8px 15px;
    background:#3a7d44;
    color:white;
    text-decoration:none;
}

a.button:hover {
    background:#2f6131;
}
</style>
</head>
<body>

<div class="header">
    <h1>Notes par Matière</h1>
</div>

<h2><?= htmlspecialchars($eleve['nom_prenom']) ?> – <?= htmlspecialchars($matiere) ?></h2>

<?php if ($notes): 
    $moyenne = (
        $notes['interro1'] +
        $notes['interro2'] +
        $notes['interro3'] +
        $notes['devoir1'] +
        $notes['devoir2']
    ) / 5;
?>
<table>
    <tr>
        <th>Interro 1</th>
        <th>Interro 2</th>
        <th>Interro 3</th>
        <th>Devoir 1</th>
        <th>Devoir 2</th>
        <th>Moyenne</th>
    </tr>
    <tr>
        <td class="note"><?= $notes['interro1'] ?></td>
        <td class="note"><?= $notes['interro2'] ?></td>
        <td class="note"><?= $notes['interro3'] ?></td>
        <td class="note"><?= $notes['devoir1'] ?></td>
        <td class="note"><?= $notes['devoir2'] ?></td>
        <td class="note"><?= number_format($moyenne,2) ?></td>
    </tr>
</table>
<?php else: ?>
<p style="text-align:center; font-weight:bold;">Aucune note trouvée pour cette matière.</p>
<?php endif; ?>

<p style="text-align:center;">
    <a class="button" href="accueil.php?id_eleve=<?= $id_eleve ?>">Retour aux matières</a>
</p>  
<p>

    <a class="button" href="login.php">Déconnexion</a>
</p>

</body>
</html>
