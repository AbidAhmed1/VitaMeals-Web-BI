<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle 'cuisinier'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'cuisinier') {
    header("Location: ../html/login_cuisinier.php");
    exit();
}

include('../php/connection.php'); // Inclure la connexion à la base de données

// Récupérer la liste des repas depuis la base de données
$sql = "SELECT * FROM repas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Repas</title>
    <link rel="stylesheet" href="../css/Gestion-Repas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../javascript/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Galindo&family=Grenze:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lalezar&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Righteous&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
   <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    
    <script src="../javascript/script.js"></script>
<style>
    .gdr {
    font-size: 40px;
    color:#175674;
    margin: 0 0 35px 0;
    font-weight: bold;
    letter-spacing: 0.1em;
    text-rendering: optimizeLegibility;
    font-family: "Oswald", sans-serif;
    font-optical-sizing: auto;
    transform: translateY(15px);
  }
</style>
</head>
<body>
     <section class="section-1">
    	<header>

    		<h2 class="logo"><img src="logovitameals.png" alt=""></h2>
	    	<nav>
                <a href="../html/acceuil.html" target="_blank"><i class="acc"></i> Accueil</a>
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
        <section class="patients-section">
            <h1 class="gdr">Gestion des Repas</h1>
            <section class="table-body">

                <table class="meal-list">
                    <thead>
                        <tr>
                            <th>Nom du Plat <span class="icon-arrow">&UpArrow;</span></th>
                            <th>Description <span class="icon-arrow">&UpArrow;</span></th>
                            <th>Catégorie <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Regime<span class="icon-arrow">&UpArrow;</span></th>
                            <th>Quantité <span class="icon-arrow">&UpArrow;</span></th>
                            <th>Action <span class="icon-arrow">&UpArrow;</span></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Vérifier si la requête a retourné des résultats
                        if ($result->num_rows > 0) {
                            // Parcourir les résultats et afficher chaque ligne dans un tableau
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['nom_repas']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categorie']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['regime']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['quantite']) . "</td>";
                                echo "<td><a href='../html/edit-repas.php?id_repas=" . $row['id_repas'] . "' class='modif'>Modifier</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun repas trouvé</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <br><br>
                <form action="update_meal_quantity.php" method="post" style="margin-bottom: 20px;">
    <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Mettre à jour les quantités des repas
    </button>
</form>

                <button type="submit" class="btn btn-outline-info"> <a href="../html/add-repas.php" class="btnAj">Ajouter un Plat</a></button>
                <a href="logout.php" class="btn btn-danger" class="btn btn-primary" id="deco">Déconnecter</a>

            </section>
        </section>
    </main>
    <?php
if (isset($_GET['maj']) && $_GET['maj'] === 'ok') {
    echo '<p style="color: green;">Quantités mises à jour avec succès !</p>';
}
?>

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