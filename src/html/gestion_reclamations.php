<?php
session_start();
include('../php/connection.php');

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: login_administrateur.php");
    exit();
}

// Si un changement de statut a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_reclamation'], $_POST['nouveau_statut'])) {
    $id_reclamation = $_POST['id_reclamation'];
    $nouveau_statut = $_POST['nouveau_statut'];

    $update_sql = "UPDATE reclamation SET statut = ? WHERE id_reclamation = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $nouveau_statut, $id_reclamation);
    $stmt->execute();
    $stmt->close();
}

// Récupérer toutes les réclamations
$sql = "SELECT * FROM reclamation ORDER BY date_reclamation DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Administrateur</title>
    <link rel="stylesheet" href="tt.css">
    <link rel="stylesheet" href="../css/administrateurdash">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>

       
       *{
	padding: 0;
	margin: 0;
	box-sizing: border-box;
}
body {
    background: no-repeat center / cover url('/docteur/css/backgroundconatc.jpg');

}
 /* DEBUT BARRE NAV  */ 
 .section-1 {
	width: 100%;
	background-size: cover;
	height: 35vh;
	background-position: center;
}
.logo img {
    height: 30px; /* Réduit la hauteur à 30 pixels (ajustez selon vos besoins) */
    /* Si vous préférez définir la largeur : */
    /* width: 80px; */
}
 .logo2 img{
    height: 60px; /* Réduit la hauteur à 30 pixels (ajustez selon vos besoins) */
    /* Si vous préférez définir la largeur : */
    /* width: 80px; */
 }

header {
	display: flex;
	padding: 30px;
	align-items: center;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	transition: 500ms;
    background-color:#312b3d;
    justify-content: center;
	z-index: 100;
}

nav a {
	margin-left: 120px;
	font-size: 15px;
	text-decoration: none;
	font-family: sans-serif;
	color: #eee;
	text-transform: uppercase;
	border-bottom:  3px solid transparent;
	padding: 10px 1px;
	transition: 200ms;
}
.active {
	border-color: #00B3FF;
}
nav a:hover {
	border-color: #00B3FF;
}
.logo {
	font-size: 20px;
	font-family: sans-serif;
	margin-left: 60px;
	color: #fff;
    justify-content:right;
}
.bgc {
	background: #eee;
	padding: 10px;
}
.bgc .logo {
	font-size: 30px;
	color: #000;
}
.bgc nav a {
	color: #222;
}




@media (max-width: 769px){
	header {
		flex-direction: column;
		padding: 20px;
	}
	nav {
		padding: 15px;
		margin: 0px;
	}
}

 /* FIN BARRE NAV*/ 
 /* Debut contenu*/ 
   
 
        h1 {
            text-align: center;
        }
        .back {
            margin-top: 20px;
            text-align: center;
        }
        .back a {
            text-decoration: none;
            color: #4CAF50;
        }

  .table-body {
    width: 100%; /* Le tableau prend toute la largeur du conteneur .content */
    max-height: none; /* Le tableau peut avoir sa hauteur initiale */
    background-color: #fffb;
    margin: 20px auto; /* Centre le tableau horizontalement et ajoute un peu de marge verticale */
    border-radius: .6rem;
    overflow: auto;
    overflow: overlay;
  }
  .table-body::-webkit-scrollbar{
    width: 0.5rem;
    height: 0.5rem;
  }
  
  .table-body::-webkit-scrollbar-thumb{
    border-radius: .5rem;
    background-color: #0004;
    visibility: hidden;
  }
  
  
  
  
  
  table {
    width: 100%;
  }
  
  
  
  table, th, td {
    border-collapse: collapse;
    padding: 1rem;
    text-align: left;
  }
  
  thead th {
    position: sticky;
    top: 0;
    left: 0;
    background-color: #d5d1defe;
    cursor: pointer;
    text-transform: capitalize;
  }
  
  tbody tr:nth-child(even) {
    background-color: #0000000b;
  }
  
  tbody tr {
    --delay: .1s;
    transition: .5s ease-in-out var(--delay), background-color 0s;
  }
  
  tbody tr.hide {
    opacity: 0;
    transform: translateX(100%);
  }
  
  tbody tr:hover {
    background-color: #fff6 !important;
  }
  
  tbody tr td,
  tbody tr td p,
  tbody tr td img {
    transition: .2s ease-in-out;
  }
  
  tbody tr.hide td,
  tbody tr.hide td p {
    padding: 0;
    font: 0 / 0 sans-serif;
    transition: .2s ease-in-out .5s;
  }
  
  tbody tr.hide td img {
    width: 0;
    height: 0;
    transition: .2s ease-in-out .5s;
  }

    thead th span.icon-arrow {
    display: inline-block;
    width: 1.3rem;
    height: 1.3rem;
    border-radius: 50%;
    border: 1.4px solid transparent;
    
    text-align: center;
    font-size: 1rem;
    
    margin-left: .5rem;
    transition: .2s ease-in-out;
  }
  
  thead th:hover span.icon-arrow{
    border: 1.4px solid #6c00bd;
  }
  
  thead th:hover {
    color: #6c00bd;
  }
  
  thead th.active span.icon-arrow{
    background-color: #6c00bd;
    color: #fff;
  }
  
  thead th.asc span.icon-arrow{
    transform: rotate(180deg);
  }
  
  thead th.active,tbody td.active {
    color: #6c00bd;
  }


         /* Footer Area */

 footer {
	background-color: #312b3d;
 }
.footer-area {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: space-between;
    width: 70%;
    min-width: 700px;
    min-height: 250px;
    height: auto;
    padding-bottom: 50px;
}
.footer-area ul {
    list-style: none;
    padding-top: 10px;
}
.footer-area ul h4 {
    margin-bottom: 20px;
    color: #eee;
    position: relative;
}
.footer-area ul h4:after {
    content: '';
    display: block;
    height: 2px;
    width: 30px;
    border: none;
    background-color: rgb(118, 70, 180);
    margin-top: 5px;
    position: absolute;
    left: 0;
}
.footer-area ul li a, .column-four li {
    display: block;
    text-decoration: none;
    color: #999;
    padding: 3px 0;
    transition: padding 0.2s;
}
.footer-area ul li a:hover {
    color: steelblue;
    padding-left: 10px;
}

.columns {
    /* border: 1px solid purple; */
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: start;
    height: 100%;
}
.column-one {
    width: 25%;
    min-width: 250px;
    gap: 30px;
}
.column-one .logo {
    display: inline;
    height: 50px;
    width: 240px;
    font-size: 2rem;
    color: #eee;
}
.column-one .logo span {
    color: steelblue;
}
.column-two, .column-three, .column-four {
    width: auto;
    min-width: 150px;
}
.column-four {
    gap: 30px;
}

/* Copyright Area */
.copyright {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #64577eea;
    height: 30px;
    width: 100%;
    bottom: 0;
}

.footer-tel{
   margin-left:20%;
}

.LSP {
    font-size: 3.5em;
    font-weight: 800;
    color:#175674;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Ombre subtile */
    letter-spacing: -0.05em; /* Ajustement de l'espacement des lettres */
    text-align: center;
    margin-bottom: 1.2em;
    background-repeat: no-repeat;
    background-size: 80px auto; 
    background-position:  center 20%;
    font-family: "Oswald", sans-serif;
    font-optical-sizing: auto;
    z-index: -1; 
}
</style>
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
<h1 class="LSP">Gestion des Réclamations</h1>
<section class="table-body">
<table class="meal-list">
    <thead>
    <tr>
        <th>ID <span class="icon-arrow">&UpArrow;</span></th>
        <th>CIN <span class="icon-arrow">&UpArrow;</span></th>
        <th>Nom <span class="icon-arrow">&UpArrow;</span></th>
        <th>Prénom <span class="icon-arrow">&UpArrow;</span></th>
        <th>Date <span class="icon-arrow">&UpArrow;</span></th>
        <th>Description <span class="icon-arrow">&UpArrow;</span></th>
        <th>Statut <span class="icon-arrow">&UpArrow;</span></th>
        <th>Action <span class="icon-arrow">&UpArrow;</span></th>
    </tr>
</thead>
    <?php while ($row = $result->fetch_assoc()): ?>
     <tbody>
    <tr>
            <td><?= $row['id_reclamation'] ?></td>
            <td><?= $row['cin'] ?></td>
            <td><?= $row['nom'] ?></td>
            <td><?= $row['prenom'] ?></td>
            <td><?= $row['date_reclamation'] ?></td>
            <td><?= $row['description'] ?></td>
            <td>
                <form method="POST" style="margin: 0;">
                    <input type="hidden" name="id_reclamation" value="<?= $row['id_reclamation'] ?>">
                    <select name="nouveau_statut">
                        <option value="en cours" <?= ($row['statut'] == 'en cours') ? 'selected' : '' ?>>en cours</option>
                        <option value="résolu" <?= ($row['statut'] == 'résolu') ? 'selected' : '' ?>>résolu</option>
                        <option value="rejeté" <?= ($row['statut'] == 'rejeté') ? 'selected' : '' ?>>rejeté</option>
                    </select>
            </td>
            <td>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </form>
            </td>
        </tr>
    </tbody>
    <?php endwhile; ?>

</table>
</section>
<div class="back">
    <a href="administrateur_dashboard.php">← Retour au tableau de bord</a>
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

<?php
$conn->close();
?>
