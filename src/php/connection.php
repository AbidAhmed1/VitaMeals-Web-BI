<?php
$servername = "localhost";
$username = "root";  // Utilisateur de la base de données
$password = "";      // Mot de passe de la base de données
$dbname = "hopital"; // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}/* else {
    echo "Connexion réussie";  // Ceci est juste pour déboguer
}*/
?>
