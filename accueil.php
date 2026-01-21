
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

$total = 0;
$nb = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Matières</title>
</head>
<body>

<h2>Élève : <?= htmlspecialchars($eleve['nom_prenom']) ?></h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Matière</th>
        <th>Action</th>
    </tr>

<?php foreach ($notes as $n): ?>
<?php
    $moy = (
        $n['interro1'] +
        $n['interro2'] +
        $n['interro3'] +
        $n['devoir1'] +
        $n['devoir2']
    ) / 5;

    $total += $moy;
    $nb++;
?>
<tr>
    <td><?= htmlspecialchars($n['nom_matiere']) ?></td>
    <td>
        <a href="details_matiere.php?id_eleve=<?= $id_eleve ?>&matiere=<?= urlencode($n['nom_matiere']) ?>">
            Voir les détails
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php if ($nb > 0): ?>
<p><strong>Moyenne générale annuelle :
<?= number_format($total / $nb, 2) ?>
</strong></p>
<?php endif; ?>

<p><a href="liste_eleve.php">⬅ Retour à la liste</a></p>

</body>
</html>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Matières de <?= htmlspecialchars($nom_eleve) ?></title>
<style>
body { font-family: Arial; background: #f0f2f5; padding: 20px;}
table { border-collapse: collapse; width: 60%; margin: auto; }
th, td { border: 1px solid #aaa; padding: 10px; text-align: center; }
th { background-color: #3a7d44; color: white; }
tr:nth-child(even) { background-color: #f9f9f9; }
a { text-decoration: none; color: #3a7d44; font-weight: bold; }
a:hover { text-decoration: underline; }
h2 { text-align: center; color: #333; }
p { text-align: center; font-weight: bold; }
</style>
</head>
<body>


<p style="text-align:center;"><a href="liste_eleve.php">Retour à la liste des élèves</a></p>

</body>
</html>