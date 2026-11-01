<?php
session_start();
include('../php/connection.php'); // Include your database connection file

// Vérifier si l'utilisateur est connecté et a le rôle 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $userId = $_POST['user_id'];
    $nom = $_POST['nom'];
    $role = $_POST['role'];
    $mdp = $_POST['mdp'];

    // Basic validation (you might want more robust validation)
    if (empty($userId) || empty($nom) || empty($role) || empty($mdp)) {
        $_SESSION['message'] = "Tous les champs sont requis.";
        $_SESSION['message_type'] = "error";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Prepare an update statement
    // Using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE utilisateur SET nom = ?, mdp = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $nom, $mdp, $role, $userId); // "sssi" means string, string, string, integer

    if ($stmt->execute()) {
        $_SESSION['message'] = "Informations utilisateur mises à jour avec succès.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour des informations utilisateur: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the admin dashboard
    header("Location: admin_dashboard.php");
    exit();
} else {
    // If accessed directly without POST data
    header("Location: admin_dashboard.php");
    exit();
}
?>