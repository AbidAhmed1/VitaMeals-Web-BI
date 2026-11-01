<?php
session_start();
include('../php/connection.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'medecin') {
    header("Location: login_docteur.php");
    exit();
}

$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
}

$sql = "SELECT * FROM patients WHERE nom LIKE ? OR prenom LIKE ? OR cin LIKE ?";
$stmt = $conn->prepare($sql);
$searchTermWithWildcards = '%' . $searchTerm . '%';
$stmt->bind_param('sss', $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Gestion des Hôpitaux</title>
    <link rel="stylesheet" href="../css/patientS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="../javascript/script.js"></script>
</head>
<body>
    <section class="section-1">
        <header>
   		<h2 class="logo"><img src="logovitameals.png" alt=""></h2>
	    	<nav>
                <a href="../html/acceuil.html" target="_blank"><i class="acc"></i> Accueil</a>
                <a href="../html/reclamation.html" ><i class="pat"></i> Espace patient</a>
                <a href="../html/login.html" ><i class="log"></i> se connecter</a>
                <a href="../html/contact.html" ><i class="cont"></i> Contact</a>
                <a href="../html/a-propos.html" ><i class="aprop"></i> À propos</a>

            </nav>
        </header>
    </section>
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
        <section class="patients-section">
            <h1 class="LSP">Liste des Patients</h1>
            <form class="search-form" method="POST">
                <input type="text" placeholder="Rechercher un patient..." name="search" id="search-input" value="<?php echo $searchTerm; ?>">
                <button type="submit" class="search-btn">Rechercher</button>
            </form>

            <section class="table-body">
                <table>
                    <thead>
                        <tr>
                            <th>CIN</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Chambre</th>
                            <th>Régime</th>
                            <th>Allergies</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['cin'] . "</td>";
                                echo "<td>" . $row['nom'] . "</td>";
                                echo "<td>" . $row['prenom'] . "</td>";
                                echo "<td>" . $row['date_naissance'] . "</td>";
                                echo "<td>" . $row['tel'] . "</td>";
                                echo "<td>" . $row['adresse'] . "</td>";
                                echo "<td>" . $row['num_chambre'] . "</td>";
                                echo "<td>" . $row['regime'] . "</td>";
                                echo "<td>" . $row['allergies'] . "</td>";
                                echo "<td>" . $row['statut'] . "</td>";
                                echo '<td><a href="edit-patient.php?cin=' . $row['cin'] . '" class="btn btn-warning">Modifier</a></td>';
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>Aucun patient trouvé.</td></tr>";
                        }
                        ?>
                    </tbody>
                    </table>
            <br><br>
            <button type="button" class="btn btn-outline-info">
  <a href="add-patient.html" class="btnAj" style="text-decoration: none; color: inherit;">Ajouter un Patient</a>
  <a href="logout.php" class="btn btn-danger" class="btn btn-primary" id="deco">Déconnecter</a>

</button>
 </button>

        </section>
    </main>
</section>
    <br> <br> <br>

      <!-- Footer Area DEBUT  -->
     
      <footer class="foter">
        <div class="footer-area">
            
            <div class="columns column-one">
                <div class="about">    		<h2 class="logo2"><img src="logovitameals.png" alt=""></h2>
                </div>
            </div>

            <ul class="columns column-two">
                <h4>Links</h4>
                <li><a href="../html/acceuil.html " target="_blank">Accuiel</a></li>
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
