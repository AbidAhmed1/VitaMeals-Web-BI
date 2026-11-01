<?php
session_start();
include('../php/connection.php');

// Vérifier si l'utilisateur est connecté et a le rôle 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Requête pour récupérer les informations de l'utilisateur
    $sql = "SELECT * FROM utilisateur WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }
} else {
    echo "ID de l'utilisateur invalide.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $role = $_POST['role'];
    $new_password = $_POST['password'];

    // Si un nouveau mot de passe est fourni, le mettre à jour
    if (!empty($new_password)) {
        // Requête pour mettre à jour le nom, le rôle et le mot de passe
        $sql_update = "UPDATE utilisateur SET nom = ?, role = ?, mdp = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $nom, $role, $new_password, $user_id);
    } else {
        // Si aucun mot de passe n'est fourni, seulement le nom et le rôle sont mis à jour
        $sql_update = "UPDATE utilisateur SET nom = ?, role = ? WHERE user_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssi", $nom, $role, $user_id);
    }

    if ($stmt_update->execute()) {
        echo "Utilisateur modifié avec succès.";
        header("Location: admin_dashboard.php");
    } else {
        echo "Erreur lors de la modification.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Modifier l'utilisateur</h1>
    <form action="edit-user.php?id=<?php echo $user['user_id']; ?>" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $user['nom']; ?>" required>

        <label for="role">Rôle :</label>
        <select id="role" name="role" required>
            <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Administrateur</option>
            <option value="medecin" <?php echo $user['role'] == 'medecin' ? 'selected' : ''; ?>>Médecin</option>
            <option value="cuisinier" <?php echo $user['role'] == 'cuisinier' ? 'selected' : ''; ?>>Cuisinier</option>
        </select>

        <label for="password">Nouveau mot de passe :</label>
        <input type="password" id="password" name="password" placeholder="Saisissez un nouveau mot de passe">

        <input type="submit" value="Modifier">
    </form>
</body>
</html>
