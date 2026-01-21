<?php
session_start();
require_once("connexion.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$eleve_id = $_GET['eleve'];
$matiere = $_GET['matiere'] ?? '';

$stmt = $conn->prepare("SELECT * FROM notes WHERE id_eleve = ? AND nom_matiere = ?");
$stmt->execute([$eleve_id, $matiere]);
$notes = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de <?php echo htmlspecialchars($matiere); ?></title>
    <style>
        body { font-family: Arial; padding: 20px; background: #eef2f7; }
        table { width: 60%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 10px; text-align: center; }
        th { background: #4CAF50; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Détails pour <?php echo htmlspecialchars($matiere); ?></h2>
    <?php if($notes): ?>
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
            <?php
                $moy = ($notes['interro1']+$notes['interro2']+$notes['interro3']+$notes['devoir1']+$notes['devoir2'])/5;
            ?>
            <td><?php echo $notes['interro1']; ?></td>
            <td><?php echo $notes['interro2']; ?></td>
            <td><?php echo $notes['interro3']; ?></td>
            <td><?php echo $notes['devoir1']; ?></td>
            <td><?php echo $notes['devoir2']; ?></td>
            <td><?php echo number_format($moy,2); ?></td>
        </tr>
    </table>
    <?php else: ?>
        <p>Aucune note disponible pour cette matière.</p>
    <?php endif; ?>
    <p><a href="accueil.php?eleve=<?php echo $eleve_id; ?>">Retour aux matières</a></p>
</body>
</html>
