<?php
include '../php/connection.php'; // Assurez-vous que le chemin vers la connexion est correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mealName = $_POST['mealName'];
    $mealDescription = $_POST['mealDescription'];
    $mealCategory = $_POST['mealCategory'];
    $mealRegime = $_POST['regime'];  // Corrigé ici, on utilise 'regime' au lieu de 'mealRegime'
    $mealQuantity = $_POST['mealQuantity'];

    // En supposant que regime est une chaîne de caractères
    $stmt = $conn->prepare("INSERT INTO repas (nom_repas, description, categorie, regime, quantite) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $mealName, $mealDescription, $mealCategory, $mealRegime, $mealQuantity);

    if ($stmt->execute()) {
        header("Location: ../html/cuisinier_dashboard.php"); 
        exit();
    } else {
        echo "Erreur lors de l'ajout du repas: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
