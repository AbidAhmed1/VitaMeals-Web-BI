<?php
include '../php/connection.php';

if (!isset($_GET['cin'])) {
    die("Aucun patient sélectionné.");
}

$cin = intval($_GET['cin']);
$query = "SELECT * FROM patients WHERE cin = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $cin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Patient non trouvé.");
}

$patient = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Patient</title>
    <link rel="stylesheet" href="../css/editpatient.css"> 
    <script src="../javascript/script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">  
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Righteous&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Galindo&family=Grenze:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lalezar&display=swap" rel="stylesheet">


</head>
<body>

     <!--=============== barre de navigation  ===============-->
     <section class="section-1">
    	<header>

    		<h2 class="logo"><img src="logovitameals.png" alt=""></h2>
	    	<nav>
                <a href="../html/acceuil.html"><i class="acc"></i> Accueil</a>
                <a href="../html/patient.html" ><i class="pat"></i> patient</a>
                <a href="../html/login.html" ><i class="log"></i> se connecter</a>
                <a href="../html/contact.html" ><i class="cont"></i> Contact</a>
                <a href="../html/a-propos.html" ><i class="aprop"></i> À propos</a>

            </nav>
    	</header>

    </section>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
    	$(document).ready(function(){
    		$(window).on('scroll', function(){
    			if ($(window).scrollTop()) {
                    $("header").addClass('bgc');
    			}else{
                    $("header").removeClass('bgc');
    			}
    		});
    	});
    </script>

    <main>
        <section class="bg">
            <div class="content">
            <h2>Modifier les informations du patient</h2>
            
            <form action="save_patient_changes.php" method="POST" id="editPatientForm">
    <!-- Champ caché pour l'ID du patient à modifier -->
    <input type="hidden" name="cin" value="<?php echo $patient['cin']; ?>">

    <!-- Numéro de chambre -->
    <label for="roomNumber">Numéro de chambre :</label>
    <input type="number" id="roomNumber" name="roomNumber" min="0" value="<?php echo $patient['num_chambre']; ?>" required>

    <!-- Régime alimentaire -->
    <label for="diet">Régime alimentaire :</label>
    <select id="diet" name="diet" required>
        <option value="Normal" <?php if ($patient['regime'] == 'Normal') echo 'selected'; ?>>Normal</option>
        <option value="Diabétique" <?php if ($patient['regime'] == 'Diabétique') echo 'selected'; ?>>Diabétique</option>
        <option value="Sans sel" <?php if ($patient['regime'] == 'Sans sel') echo 'selected'; ?>>Sans sel</option>
        <option value="Végétarien" <?php if ($patient['regime'] == 'Végétarien') echo 'selected'; ?>>Végétarien</option>
    </select>

    <!-- Allergies -->
    <label for="allergies">Allergies :</label>
    <textarea id="allergies" name="allergies" rows="3"><?php echo $patient['allergies']; ?></textarea>

    <!-- Bouton -->
    <button type="submit" class="btn btn-outline-danger">Sauvegarder les modifications</button>
</form>

            
            
          </div>
        </section>
    </main>

	<footer >

       <!-- Footer Area DEBUT  -->
     
       <footer class="foter">
        <div class="footer-area">
            
            <div class="columns column-one">
                <div class="about">    		<h2 class="logo2"><img src="logovitameals.png" alt=""></h2>
                </div>
            </div>

            <ul class="columns column-two">
                <h4>Links</h4>
                <li><a href="../html/acceuil.html" target="_blank">Accuiel</a></li>
                <li><a href="../html/a-propos.html" target="_blank">A propos</a></li>
                <li><a href="../html/contact.html" target="_blank">Contact</a></li>

            </ul>

            <ul class="columns column-three">
                <h4>Partenaires</h4>
                <li><a href="https://www.vitalait.net/tun/fr" target="_blank">Vitalait</a></li>
                <li><a href="https://chahia.com.tn/" target="_blank">Chahia</a></li>
                <li><a href="https://www.tunisierecyclage.org/" target="_blank">Tunisie Recyclage</a></li>
                <li><a href="https://www.facebook.com/FruitsSecsMamya/" target="_blank">Mamya épicerie</a></li>
                <li><a href="https://www.agritable.tn/" target="_blank">Agritable</a></li>
              
            </ul>

            <ul class="columns column-four">
                <div class="footer-address">
                    <h4>Address</h4>
                    <li>Rue Med -V</li>
                    <li>Résidence de la liberté</li>
                    <li>A coté de l'hopital militaire</li>
                    <li>Tunisie</li>
                </div>
                <div class="footer-tel">
                    <h4>Telephone</h4>
                    <li>+216 44145268</li>
                </div>
            </ul>

        </div>

        <div class="copyright">&copy; Tous droits réservés-2025</div>

    </footer>
        <!-- Footer Area FIN  -->

</body>
</html>
