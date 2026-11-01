<?php
include('../php/connection.php');

if (isset($_POST['cin']) && isset($_POST['statut'])) {
    $cin = $_POST['cin'];
    $statut = $_POST['statut'];

    echo "Cin: " . $cin . " | Statut: " . $statut;  // Ajoute cette ligne pour voir les données envoyées

    $sql = "UPDATE patients SET statut = ? WHERE cin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $statut, $cin);

    if ($stmt->execute()) {
        header("Location: liste_patients.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour du statut. Code d'erreur: " . $stmt->error;
    }
} else {
    echo "Requête invalide.";
}
