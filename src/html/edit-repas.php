<?php
session_start();
include('../php/connection.php');

if (!isset($_GET['id_repas'])) {
    echo "Aucun repas sélectionné.";
    exit();
}

$id_repas = intval($_GET['id_repas']);

$sql = "SELECT * FROM repas WHERE id_repas = $id_repas";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Repas non trouvé.";
    exit();
}

$repas = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Repas</title>
    <link rel="stylesheet" href="../css/edit-repas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
    <section class="bg">
        <div class="content">
            <h2>Modifier un repas</h2>

            <form action="save_repas_changes.php" method="POST" id="editRepasForm">
                <input type="hidden" name="id_repas" value="<?php echo $repas['id_repas']; ?>">

                <label>Nom du repas :</label>
                <input type="text" name="nom_repas" value="<?php echo htmlspecialchars($repas['nom_repas']); ?>" required>

                <label>Catégorie :</label>
                <select name="categorie" required>
                    <option value="petit_dejeuner" <?php if($repas['categorie'] == 'petit_dejeuner') echo 'selected'; ?>>Petit Déjeuner</option>
                    <option value="dejeuner" <?php if($repas['categorie'] == 'dejeuner') echo 'selected'; ?>>Déjeuner</option>
                    <option value="diner" <?php if($repas['categorie'] == 'diner') echo 'selected'; ?>>Dîner</option>
                </select>
                <label>Régime :</label>
                <select name="regime" required>
    <option value="sans sel" <?php if($repas['regime'] == 'sans sel') echo 'selected'; ?>>Sans Sel</option>
    <option value="diabétique" <?php if($repas['regime'] == 'diabétique') echo 'selected'; ?>>Diabétique</option>
    <option value="régime normal" <?php if($repas['regime'] == 'régime normal') echo 'selected'; ?>>Régime Normal</option>
    <option value="végétarien" <?php if($repas['regime'] == 'végétarien') echo 'selected'; ?>>Végétarien</option>
</select>




                <label>Description :</label>
                <textarea name="description" rows="3"><?php echo htmlspecialchars($repas['description']); ?></textarea>

                <label>Quantité :</label>
                <input type="number" name="quantite" value="<?php echo $repas['quantite']; ?>" min="0" required>

                <button type="submit" class="btn btn-outline-danger">Modifier le repas</button>
            </form>

        </div>
    </section>
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
