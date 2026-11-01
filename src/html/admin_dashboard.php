<?php
session_start();
include('../php/connection.php');

// Vérifier si l'utilisateur est connecté et a le rôle 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

$sqlUtilisateurs = "SELECT user_id, nom, mdp, role FROM utilisateur"; // Removed cin as it's not in your form
$resultUtilisateurs = $conn->query($sqlUtilisateurs);
$utilisateurs = [];
if ($resultUtilisateurs->num_rows > 0) {
    while ($row = $resultUtilisateurs->fetch_assoc()) {
        $utilisateurs[] = $row;
    }
}

$sqlPatients = "SELECT cin, nom, prenom, date_naissance, tel , num_chambre, regime, allergies, statut
  FROM patients"; // Ajustez la requête et les colonnes selon votre table patients
$resultPatients = $conn->query($sqlPatients);
$patients = [];
if ($resultPatients->num_rows > 0) {
    while ($row = $resultPatients->fetch_assoc()) {
        $patients[] = $row;
    }
}

$sqlReclamations = "SELECT id_reclamation, cin AS cin_patient, nom AS nom_patient, prenom AS prenom_patient, description, statut, date_reclamation FROM reclamation";$resultReclamations = $conn->query($sqlReclamations);
$reclamations = [];
if ($resultReclamations->num_rows > 0) {
    while ($row = $resultReclamations->fetch_assoc()) {
        $reclamations[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Administrateur</title>
    <link rel="stylesheet" href="../css/admindash.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cal+Sans&family=Devonshire&family=Lobster&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=swipe_vertical" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://app.powerbi.com/reportEmbed?reportId=f879d25a-eefd-49b2-acf4-d98fdbe520e2&autoAuth=true&ctid=dbd6664d-4eb9-46eb-99d8-5c43ba153c61">
<style>
    /* Styles pour le tableau */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .user-table th, .user-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .user-table th {
        background-color: #f2f2f2;
    }

    .redimensionner-image {
  width: 250px; /* Définissez la largeur souhaitée */
  height: auto; /* La hauteur s'ajustera automatiquement pour conserver les proportions */
}
</style>
</head>
<body>

    <div class="sidebar">
        <a href="#" class="logo">
            <div class="logo-name">
                <img src="logovitameals.png" alt="">
            </div>
        </a>
        <ul class="side-menu">
            <li><button onclick="afficherContenu('liste-utilisateurs')"><i class='bx bx-store-alt'></i>Liste utilisateurs</button></li>
            <li><button onclick="afficherContenu('bilan')"><i class='bx bx-analyse'></i>Bilan</button></li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="../html/login.html" class="logout">
                    <i class='bx bx-log-out-circle'></i> Se déconnecter</a>
            </li>
        </ul>
    </div>
    <div class="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="../html/acceuil.html" target="_blank"><i class="acc"></i> Accueil</a>
            <a href="../html/reclamation.html" ><i class="pat"></i> Espace patient</a>
            <a href="../html/login.html" ><i class="log"></i> se connecter</a>
            <a href="../html/contact.html" ><i class="cont"></i> Contact</a>
            <a href="../html/a-propos.html" ><i class="aprop"></i> À propos</a>
            <a href="#" class="profile">
<img src="logouser.png" alt="">
            </a>
        </nav>

        <main>
            <div class="header">
                <div class="left">
                    <h1>Bonjour admin</h1>
                    <form action="#">
                        <div class="form-input">
                            <input type="search" placeholder="Search..." id="userSearchInput">
                        </div>
                    </form>
                </div>

               <script>
                
               </script>
            </div>

            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'>   <img src="logoutili.png" alt=""> </i>
                    <span class="info">
                        <h3>
                            <?php echo count($utilisateurs); ?>
                        </h3>
                        <p class="nbr">Nombre d'utilisateurs</p>
                    </span>
                </li>
                <li><i class='bx bx-show-alt'> <img src="logopat.png" alt=""   ></i>
                    <span class="info">
                        <h3>
                            <?php echo count($patients); ?>
                        </h3>
                        <p class="nbr">Nombre de patients</p>
                    </span>
                </li>
                <li><i class='bx bx-line-chart'> <img src="logorecl.png" alt=""></i>
                    <span class="info">
                        <h3>
                            <?php echo count($reclamations); ?>
                        </h3>
                        <p class="nbr">Nombre de réclamations</p>
                    </span>
                </li>
            </ul>
            <div class="bottom-data">
                <div class="orders">
                    <div class="header">

                    </div>
                    <div id="liste-utilisateurs-content" style="display: none;">
                        <h2 class="decor">Liste des utilisateurs</h2>
                        <?php if (!empty($utilisateurs)): ?>
                            <table class="user-table" id="userTable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Rôle</th>
                                            <th>Mot de passe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($utilisateurs as $utilisateur): ?>
                                            <tr data-user-id="<?php echo $utilisateur['user_id']; ?>"
                                                data-user-nom="<?php echo htmlspecialchars($utilisateur['nom']); ?>"
                                                data-user-role="<?php echo htmlspecialchars($utilisateur['role']); ?>"
                                                data-user-mdp="<?php echo htmlspecialchars($utilisateur['mdp']); ?>">
                                                <td><?php echo $utilisateur['user_id']; ?></td>
                                                <td><?php echo $utilisateur['nom']; ?></td>
                                                <td><?php echo $utilisateur['role']; ?></td>
                                                <td><?php echo $utilisateur['mdp']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                            </table>
                        <?php else: ?>
                            <p>Aucun utilisateur trouvé.</p>
                        <?php endif; ?>
                               <div id="patient-details-container" style="margin-top: 20px;">
                                <h2 class="decor2">Détails d'utilisateur</h2>
                                <table id="patient-details-table">
                                    <form id="patient-details-form" action="update_user_details.php" method="post">
                                        <tr><th>ID</th><td> <input type="text" name="user_id" id="details-userid-display" class="form-control" readonly></td></tr>
                                        <tr><th>Nom</th><td><input type="text" name="nom" id="details-nomut" class="form-control"></td></tr>
                                        <tr><th>Rôle</th><td>
                                            <select name="role" id="details-role" class="form-control">
                                                <option value="medecin">medecin</option>
                                                <option value="cuisinier">cuisinier</option>
                                                <option value="administrateur">administrateur</option>
                                                <option value="admin">admin</option>
                                            </select>
                                        </td>
                                        <tr><th>Mot de passe</th><td><input type="text" name="mdp" id="details-mdp" class="form-control"></td></tr>
                                        </tr>
                                        <tr><td colspan="2"><button type="submit" class="btn btn-outline-success">Enregistrer les modifications</button></td></tr>
                                        <tr><td colspan="2"><a  class="btn btn-outline-success" href="../html/pageajoututilisateur.php">Ajouter Utilisateur</a></td> </tr>

                                    </form>
                                </table>
                                </div>
                            </div>
                    
                <div id="bilan-content" style="display: none;">
                    <h2 class="decor">Bilan</h2>
                    <iframe title="vitameals" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=f879d25a-eefd-49b2-acf4-d98fdbe520e2&autoAuth=true&ctid=dbd6664d-4eb9-46eb-99d8-5c43ba153c61" frameborder="0" allowFullScreen="true"></iframe>
                </div>
                               
                <div class="reminders">
            
                </div>
        </main>

    </div>

    <script src="../javascript/admindash.js"></script>
    <script>

        // JS POUR RECHERCHE (existing code, moved for clarity)
        document.addEventListener('DOMContentLoaded', function() {
            const userSearchInput = document.getElementById('userSearchInput');
            const userTable = document.getElementById('userTable');

            if (userSearchInput && userTable) {
                userSearchInput.addEventListener('keyup', function() {
                    const searchTerm = userSearchInput.value.toLowerCase();
                    const tableRows = userTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                    for (let i = 0; i < tableRows.length; i++) {
                        let row = tableRows[i];
                        let found = false;
                        const cells = row.getElementsByTagName('td');
                        for (let j = 0; j < cells.length; j++) {
                            const cellText = cells[j].textContent.toLowerCase();
                            if (cellText.includes(searchTerm)) {
                                found = true;
                                break;
                            }
                        }

                        if (found) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            }

            // --- New JavaScript for row click and form population ---
            const userTableBody = userTable.getElementsByTagName('tbody')[0];
            const detailsUserIdDisplay = document.getElementById('details-userid-display');
            const detailsNomUt = document.getElementById('details-nomut');
            const detailsRole = document.getElementById('details-role');
            const detailsMdp = document.getElementById('details-mdp');
            const patientDetailsContainer = document.getElementById('patient-details-container');

            userTableBody.addEventListener('click', function(event) {
                let targetRow = event.target.closest('tr'); // Get the closest <tr> ancestor

                if (targetRow && targetRow.hasAttribute('data-user-id')) {
                    const userId = targetRow.getAttribute('data-user-id');
                    const userNom = targetRow.getAttribute('data-user-nom');
                    const userRole = targetRow.getAttribute('data-user-role');
                    const userMdp = targetRow.getAttribute('data-user-mdp');

                    // Populate the form fields
                    detailsUserIdDisplay.value = userId;
                    detailsNomUt.value = userNom;
                    detailsRole.value = userRole;
                    detailsMdp.value = userMdp;

                    // Optionally, scroll to the details section or make it more prominent
                    patientDetailsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        function afficherContenu(section) {
            document.getElementById('liste-utilisateurs-content').style.display = 'none';
            document.getElementById('bilan-content').style.display = 'none';

            document.getElementById(section + '-content').style.display = 'block';

            let boutons = document.querySelectorAll('.side-menu button');
            boutons.forEach(btn => btn.parentNode.classList.remove('active'));
            let boutonClique = document.querySelector(`.side-menu button[onclick="afficherContenu('${section}')"]`);
            if (boutonClique) {
                boutonClique.parentNode.classList.add('active');
            }
        }
    </script>

</body>
</html>