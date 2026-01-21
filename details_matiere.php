<?php
session_start();
require_once("connexion.php");

$eleve_id = $_SESSION['eleve_id'];
$nom_eleve = $_SESSION['nom_eleve'];

function color_note($note) {
    if($note < 10) return "red";
    elseif($note < 15) return "orange";
    else return "green";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace Élève</title>
    <style>
        body {
            font-family: Verdana, sans-serif;
            background-color: #e8f0fe;
            padding: 20px;
        }
        .header {
            background:#3a7d44;
            color:white;
            padding:10px;
            border-radius:5px;
            margin-bottom:20px;
        }
        .header h1 { margin:0; font-size:22px; }
        h2 { color: #333; margin-bottom:10px; }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            border-radius:5px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
            transition: 0.3s;
        }
        th {
            background-color: #3a7d44;
            color: white;
        }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #d1e7dd; }

        .red { color: red; font-weight:bold; }
        .orange { color: orange; font-weight:bold; }
        .green { color: green; font-weight:bold; }

        a.button {
            display:inline-block;
            margin-top:20px;
            padding:10px 20px;
            background:#3a7d44;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }
        a.button:hover { background:#2f6131; }

        .footer { margin-top:30px; color:#555; font-size:12px; }
    </style>
</head>
<body>

<div class="header">
    <h1>Mon Espace Élève</h1>
</div>

<h2>Salut <?php echo htmlspecialchars($nom_eleve); ?>, voici tes notes !</h2>

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
    $notes_eleves = $stmt->fetchAll();

    foreach($notes_eleves as $notes) {
        $moyenne = ($notes['interro1'] + $notes['interro2'] + $notes['interro3'] + $notes['devoir1'] + $notes['devoir2']) / 5;

        echo "<tr>
                <td>{$notes['nom_matiere']}</td>
                <td class='".color_note($notes['interro1'])."'>".$notes['interro1']."</td>
                <td class='".color_note($notes['interro2'])."'>".$notes['interro2']."</td>
                <td class='".color_note($notes['interro3'])."'>".$notes['interro3']."</td>
                <td class='".color_note($notes['devoir1'])."'>".$notes['devoir1']."</td>
                <td class='".color_note($notes['devoir2'])."'>".$notes['devoir2']."</td>
                <td class='".color_note($moyenne)."'>".number_format($moyenne,2)."</td>
              </tr>";
    }
    ?>
</table>

<a class="button" href="login.php">Déconnexion</a>

<div class="footer">© 2026 École – Projet Stage</div>

</body>
</html>
