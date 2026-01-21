<?php
session_start();
require_once("connexion.php");

$eleve_id = $_SESSION['eleve_id'];
$nom_eleve = $_SESSION['nom_eleve'];

function color_note($note) {
    return "note";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace Élève</title>
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
        }

        table {
            border-collapse: collapse;
            width: 100%;
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
            font-weight: normal;
        }

        a.button {
            display:inline-block;
            margin-top:20px;
            padding:8px 15px;
            background:#3a7d44;
            color:white;
            text-decoration:none;
        }

        .footer {
            margin-top:30px;
            font-size:12px;
            color:#555;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Mon Espace Élève</h1>
</div>

<h2>Salut <?= htmlspecialchars($nom_eleve); ?>, voici tes notes</h2>

<table>
    <tr>
        <th>Matière</th>
        <th>Interro 1</th>
        <th>Interro 2</th>
        <th>Interro 3</th>
        <th>Devoir 1</th>
        <th>Devoir 2</th>
        <th>Moyenne</th>
    </tr>

<?php
$stmt = $conn->prepare("SELECT * FROM notes WHERE id_eleve = ?");
$stmt->execute([$eleve_id]);
$notes_eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($notes_eleves as $notes) {
    $moyenne = (
        $notes['interro1'] +
        $notes['interro2'] +
        $notes['interro3'] +
        $notes['devoir1'] +
        $notes['devoir2']
    ) / 5;
?>
    <tr>
        <td><?= htmlspecialchars($notes['nom_matiere']) ?></td>
        <td class="note"><?= $notes['interro1'] ?></td>
        <td class="note"><?= $notes['interro2'] ?></td>
        <td class="note"><?= $notes['interro3'] ?></td>
        <td class="note"><?= $notes['devoir1'] ?></td>
        <td class="note"><?= $notes['devoir2'] ?></td>
        <td class="note"><?= number_format($moyenne, 2) ?></td>
    </tr>
<?php } ?>

</table>

<a class="button" href="login.php">Déconnexion</a>

<div class="footer">© 2026 – Projet de stage</div>

</body>
</html>
