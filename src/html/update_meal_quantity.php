<?php
include '../php/connection.php'; // Assurez-vous que le chemin vers la connexion est correct

// Sélectionner le nombre de patients hospitalisés pour chaque régime
$regimes = ['normal', 'diabétique', 'sans sel', 'végétarien']; // Liste des régimes (ajout de végétarien)
foreach ($regimes as $regime) {
    // Récupérer le nombre de patients hospitalisés pour chaque régime
    $stmt = $conn->prepare("SELECT COUNT(*) FROM patients WHERE statut = 'hospitalisé' AND regime = ?");
    $stmt->bind_param("s", $regime); // Le type de la variable est une chaîne
    $stmt->execute();
    $stmt->bind_result($patientCount);
    $stmt->fetch();

    // Vérifier si le comptage des patients est correct
    if ($stmt) {
        echo "Nombre de patients hospitalisés pour le régime $regime: " . $patientCount . "<br>";
    } else {
        echo "Erreur lors de la récupération du comptage pour le régime $regime : " . $conn->error . "<br>";
    }

    $stmt->close();

    // Mettre à jour la quantité du repas en fonction du régime
    $stmt2 = $conn->prepare("UPDATE repas SET quantite = ? WHERE regime = ? AND categorie IN ('petit_dejeuner', 'dejeuner', 'diner')");
    $stmt2->bind_param("is", $patientCount, $regime); // Le premier paramètre est un entier pour la quantité, et le deuxième est une chaîne pour le régime

    if (!$stmt2->execute()) {
        echo "Erreur lors de la mise à jour pour le régime $regime : " . $stmt2->error . "<br>";
    } else {
        echo "Quantité mise à jour pour le régime $regime : " . $patientCount . "<br>";
    }

    $stmt2->close();
}

header("Location: ../html/cuisinier_dashboard.php?maj=ok");
exit();

$conn->close();
?>
