<?php
require_once("connexion.php");

$matieres = ['Français', 'Mathématiques', 'PCT'];

foreach ($matieres as $matiere) {
    for ($i = 1; $i <= 10; $i++) {

        $stmt = $conn->prepare(
            "SELECT interro1, interro2, interro3, devoir1, devoir2
             FROM notes
             WHERE id_eleve = ? AND nom_matiere = ?"
        );
        $stmt->execute([$i, $matiere]);
        $notes = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($notes) {
            $moyenne = (
                $notes['interro1'] +
                $notes['interro2'] +
                $notes['interro3'] +
                $notes['devoir1'] +
                $notes['devoir2']
            ) / 5;

            $colonne = "id_eleve" . $i;
            $stmt2 = $conn->prepare(
                "UPDATE matieres SET $colonne = ? WHERE nom_matiere = ?"
            );
            $stmt2->execute([$moyenne, $matiere]);
        }
    }
}

echo "Toutes les moyennes ont été calculées et enregistrées avec succès !";
