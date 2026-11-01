<?php
session_start(); // Démarrez la session si vous en avez besoin pour d'autres fonctionnalités
include('../php/connection.php'); // Incluez votre fichier de connexion à la base de données

// Vérifier si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $cin = $_POST['cin'];
    $role = $_POST['role'];
    $mdp = $_POST['mdp'];
    $confirm_mdp = $_POST['confirm_mdp'];

    // Validation basique des entrées
    $erreurs = [];

    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if (empty($role)) {
        $erreurs[] = "Le rôle est obligatoire.";
    }
    if (empty($mdp)) {
        $erreurs[] = "Le mot de passe est obligatoire.";
    }
    if (empty($confirm_mdp)) {
        $erreurs[] = "La confirmation du mot de passe est obligatoire.";
    }
    if ($mdp !== $confirm_mdp) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }
    // Vous pouvez ajouter plus de validations ici (par exemple, format du CIN, longueur du mot de passe, etc.)

    if (!empty($erreurs)) {
        // Stocker les erreurs en session
        $_SESSION['erreurs_inscription'] = $erreurs;
        // Stocker les données du formulaire en session pour les pré-remplir
        $_SESSION['form_data'] = [
            'nom' => $nom,
            'cin' => $cin,
            'role' => $role
        ];
        header("Location: pageajoututilisateur.php"); // Rediriger vers la page du formulaire
        exit();
    }

    // Hacher le mot de passe avant de le stocker dans la base de données
    // ATTENTION: Il est FORTEMENT RECOMMANDÉ d'utiliser password_hash() pour hacher les mots de passe de manière sécurisée.
    // Exemple : $hashed_mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $hashed_mdp = $mdp; // Votre code actuel NE HACHE PAS le mot de passe. C'est une faille de sécurité.

    // Préparer la requête SQL pour insérer l'utilisateur
    $stmt = $conn->prepare("INSERT INTO utilisateur (nom, cin, role, mdp) VALUES (?, ?, ?, ?)");

    // Vérifier si la préparation de la requête a échoué
    if ($stmt === false) {
        $_SESSION['erreurs_inscription'][] = "Erreur de préparation de la requête : " . $conn->error;
        $_SESSION['form_data'] = [
            'nom' => $nom,
            'cin' => $cin,
            'role' => $role
        ];
        header("Location: pageajoututilisateur.php");
        exit();
    }

    $cin_val = !empty($cin) ? $cin : null; // Définir à null si CIN est vide et la colonne est NULLable.

    $stmt->bind_param("ssss", $nom, $cin, $role, $hashed_mdp);


    // Exécuter la requête
    if ($stmt->execute()) {
        // Redirection vers admin_dashboard.php en cas de succès
        header("Location: admin_dashboard.php?status=success_add_user");
        exit();
    } else {
        // Gérer les erreurs d'exécution (par exemple, CIN déjà existant si UNIQUE)
        $_SESSION['erreurs_inscription'] = []; // Réinitialiser pour éviter les erreurs précédentes
        if ($conn->errno == 1062) { // Code d'erreur pour les entrées dupliquées (par ex. CIN unique)
            $_SESSION['erreurs_inscription'][] = "Un utilisateur avec ce CIN existe déjà. Veuillez en choisir un autre.";
        } else {
            $_SESSION['erreurs_inscription'][] = "Une erreur est survenue lors de l'ajout de l'utilisateur : " . $stmt->error;
        }
        // Stocker les données du formulaire même en cas d'erreur de base de données
        $_SESSION['form_data'] = [
            'nom' => $nom,
            'cin' => $cin,
            'role' => $role
        ];
        header("Location: pageajoututilisateur.php"); // Rediriger vers la page du formulaire
        exit();
    }

    // Fermer la déclaration
    $stmt->close();
} else {
    // Si quelqu'un tente d'accéder directement à ajouter_utilisateur.php sans soumettre le formulaire
    header("Location: pageajoututilisateur.php"); // Rediriger vers la page du formulaire
    exit();
}

// Fermer la connexion à la base de données à la fin du script
$conn->close();
?>