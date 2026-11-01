<?php
session_start();

// Vérifie si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: login_administrateur.php"); // Redirige vers la page de login
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administrateur</title>
    <link rel="stylesheet" href="../css/administrateurdash.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Share+Tech&display=swap" rel="stylesheet">

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
        <h1 class="bienv">Vous êtes connecté en tant qu'<strong>administrateur</strong></h1>

    <div class="dashboard">
    
       

        <h3 class="bienv">Actions disponibles :</h3>
    <div class="card-container">
        <div class="card">
            <h2> Créer un compte </h2>
                 <a href="inscription.html">Ici</a>
            </p>
        </div>
        <div class="card">
            <h2> Ajouter un patient</h2>
                 <a href="add-patient.html">Ici</a>
            </p>
        </div>
        <div class="card">
            <h2> Listes des patients </h2>
                 <a href="liste_patients.php">Ici</a>
            </p>
        </div>
        <div class="card">
            <h2> Gérer les réclamations </h2>
            <a href="gestion_reclamations.php">Ici</a>
            </p>
        </div>
    </div>

          <div class="logout">
            <a href="logout.php" >Se déconnecter</a>
        </div>
    </div>
</main>
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
