<?php
// Connexion à la base
include '../php/connection.php'; // Chemin selon ton projet

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécuriser les données
    $roomNumber = htmlspecialchars($_POST['roomNumber']);
    $diet = htmlspecialchars($_POST['diet']);
    $allergies = htmlspecialchars($_POST['allergies']);
    $cin = intval($_POST['cin']);

    // Vérifier que toutes les données sont là
    if (!empty($roomNumber) && !empty($diet) && isset($cin)) {
        // Vérifier si le patient avec ce CIN existe
        $checkCinQuery = "SELECT * FROM patients WHERE cin = ?";
        $stmtCheck = $conn->prepare($checkCinQuery);
        $stmtCheck->bind_param("i", $cin);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // Requête UPDATE
            $sql = "UPDATE patients SET num_chambre = ?, regime = ?, allergies = ? WHERE cin = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssi", $roomNumber, $diet, $allergies, $cin);
                if ($stmt->execute()) {
                    // Succès : rediriger vers le dashboard
                    header("Location: medecin_dashboard.php");
                    exit();
                } else {
                    echo "Erreur d'exécution : " . $stmt->error;
                }
            } else {
                echo "Erreur de préparation : " . $conn->error;
            }
        } else {
            echo "Aucun patient trouvé avec ce CIN.";
        }
    } else {
        echo "Champs requis manquants.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
