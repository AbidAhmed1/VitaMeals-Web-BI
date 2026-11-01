<?php
session_start();
include('../php/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_repas = isset($_POST['id_repas']) ? intval($_POST['id_repas']) : 0;
    $nom_repas = trim($_POST['nom_repas']);
    $description = trim($_POST['description']);
    $categorie = trim($_POST['categorie']);
    $regime = trim($_POST['regime']);
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 0;

    if ($id_repas > 0 && $nom_repas && $description && $categorie && $regime && $quantite > 0) {
        $sql = "UPDATE repas 
                SET nom_repas = ?, description = ?, categorie = ?, regime = ?, quantite = ?
                WHERE id_repas = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // ✅ Ici on corrige : tous sauf quantite et id_repas sont strings
            $stmt->bind_param("ssssii", $nom_repas, $description, $categorie, $regime, $quantite, $id_repas);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header("Location: cuisinier_dashboard.php?success=1");
                exit();
            } else {
                echo "Erreur d'exécution : " . $stmt->error;
            }
        } else {
            echo "Erreur de préparation : " . $conn->error;
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }

    $conn->close();
}
?>
