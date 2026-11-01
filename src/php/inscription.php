<?php
include('connection.php'); // Assure-toi que le chemin est correct.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification que les clés 'nom', 'cin', 'role', 'mdp', et 'confirm_mdp' existent dans $_POST
    if (isset($_POST['nom'], $_POST['cin'], $_POST['role'], $_POST['mdp'], $_POST['confirm_mdp'])) {
        $nom = $_POST['nom'];
        $cin = $_POST['cin'];
        $role = $_POST['role'];
        $mdp = $_POST['mdp'];
        $confirm_mdp = $_POST['confirm_mdp'];

        // Vérifier si les mots de passe correspondent
        if ($mdp !== $confirm_mdp) {
            echo "Les mots de passe ne correspondent pas.";
        } else {
            // Insérer les données dans la base de données sans hacher le mot de passe
            $sql = "INSERT INTO utilisateur (nom, cin, role, mdp) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $nom, $cin, $role, $mdp);
                if ($stmt->execute()) {
                    echo "Inscription réussie.";
                } else {
                    echo "Erreur lors de l'enregistrement.";
                }
            } else {
                echo "Erreur de préparation de la requête.";
            }
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
