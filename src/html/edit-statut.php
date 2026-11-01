<?php
include('../php/connection.php');

if (!isset($_GET['cin'])) {
    echo "Aucun patient sélectionné.";
    exit;
}

$cin = $_GET['cin'];

$sql = "SELECT * FROM patients WHERE cin = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Patient non trouvé.";
    exit;
}

$patient = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Statut</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">  
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Righteous&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .content {
    font-size: 40px;
    color:#1eb86b;
    margin: 0 0 35px 0;
    font-weight: bold;
    font-family:initial;
    letter-spacing: 0.1em;
    text-rendering: optimizeLegibility;
    font-family: "Oswald", sans-serif;
    font-optical-sizing: auto;
  }
  label{
    font-size: 15px;
    font-weight: bold;
    margin: 0 0 35px 0;
    font-family: "Oswald", sans-serif;
    font-optical-sizing: auto;
    font-style: normal;


}
    </style>

</head>
<body class="p-4">
    <h2 class="content">Modifier le statut du patient</h2>

    <form action="update-statut.php" method="POST">
        <input type="hidden" name="cin" value="<?php echo $patient['cin']; ?>">

        <div class="mb-3">
            <label class="form-label">Nom :</label>
            <input type="text" class="form-control" value="<?php echo $patient['nom']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom :</label>
            <input type="text" class="form-control" value="<?php echo $patient['prenom']; ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut :</label>
            <select name="statut" id="statut" class="form-select" required>
    <option value="hospitalisé" <?php if ($patient['statut'] == 'hospitalisé') echo 'selected'; ?>>Hospitalisé</option>
    <option value="sorti" <?php if ($patient['statut'] == 'sorti') echo 'selected'; ?>>Sorti</option>
</select>

        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="liste_patients.php" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>
