<?php
include '../php/connection.php'; // fais attention au chemin correct !

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $tel = $_POST['tel'];
    $adresse = $_POST['adresse'];
    $num_chambre = $_POST['num_chambre'];
    $regime = $_POST['regime'];
    $allergies = $_POST['allergies'];
    $statut = $_POST['statut'];

 $stmt = $conn->prepare("INSERT INTO patients (cin, nom, prenom, date_naissance, tel, adresse, num_chambre, regime, allergies, statut)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // 8 paramètres donc 8 lettres dans bind_param ("ssssisss")
        $stmt->bind_param("isssssssss", $cin ,$nom, $prenom, $date_naissance, $tel, $adresse, $num_chambre, $regime, $allergies, $statut);
        $stmt->execute();
        $stmt->close();
        header("Location: ../html/medecin_dashboard.php");
        exit();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
}
?>
