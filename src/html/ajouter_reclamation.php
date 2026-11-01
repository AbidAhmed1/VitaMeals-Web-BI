<?php
// Inclure le fichier de connexion à la base de données
include('../php/connection.php');

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_reclamation = $_POST['date_reclamation'];
    $description = $_POST['description'];

    // 1. Vérifier si le CIN existe dans la table 'patients'
    $sql_check_cin = "SELECT COUNT(*) FROM patients WHERE cin = ?";
    if ($stmt_check = $conn->prepare($sql_check_cin)) {
        $stmt_check->bind_param("s", $cin);
        $stmt_check->execute();
        $stmt_check->bind_result($cin_exists);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($cin_exists == 0) {
            // Le CIN n'existe pas dans la table patients
            echo "<script>alert('Erreur: Le CIN fourni n\'existe pas dans notre base de données des patients. Veuillez vérifier votre CIN ou vous inscrire si vous n\'êtes pas encore patient.'); window.location.href='reclamation.html';</script>";
            $conn->close();
            exit(); // Arrêter l'exécution du script
        }
    } else {
        echo "Erreur de préparation de la vérification du CIN : " . $conn->error;
        $conn->close();
        exit();
    }

    // Si le CIN existe, procéder à l'insertion de la réclamation
    $sql = "INSERT INTO reclamation (cin, nom, prenom, date_reclamation, description, statut)
            VALUES (?, ?, ?, ?, ?, 'en cours')";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssss", $cin, $nom, $prenom, $date_reclamation, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Réclamation envoyée avec succès.'); window.location.href='reclamation.html';</script>";
        } else {
            echo "Erreur lors de l'envoi : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erreur de préparation : " . $conn->error;
    }
}

$conn->close();
?>