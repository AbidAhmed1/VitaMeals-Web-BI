<?php
session_start();
include('../php/connection.php');

// Vérifier si l'utilisateur est connecté et a le rôle 'admin'
// Cette section semble être pour une page d'administration où un admin crée des utilisateurs.
// Si cette page est pour l'inscription publique, vous pouvez supprimer ou commenter cette vérification.
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pageinscription.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&display=swap" rel="stylesheet">
    <title>Inscription</title>
</head>
<body>

    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="logovitameals.png" alt="">
                </span>
                <div class="text logo-text">
                    <span class="name">Vita</span>
                    <span class="profession">Meals</span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="../html/acceuil.html" target="_blank">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Accueil</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../html/login.html" target="_blank">
                            <i class='bx bx-log-in icon'></i>
                            <span class="text nav-text">Se connecter</span>
                        </a>
                    </li>
                </ul>
                <li class="mode" class="bottom-content">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <br>
        <h1 class="insc">Inscrivez-vous !</h1>
        <br>
        <form class="row g-3 needs-validation d-flex flex-column align-items-center" novalidate action="ajouter_utilisateur.php" method="POST">
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Nom:</label>
                <input type="text" class="form-control" id="validationCustom02" name="nom" required>
                <div class="valid-feedback">Looks good!</div>
            </div>

            <div class="col-md-4">
                <label for="validationCustomCIN" class="form-label">CIN:</label>
                <input type="number" class="form-control" id="validationCustomCIN" min="0" name="cin">
                <div class="valid-feedback">Looks good!</div>
            </div>

            <div class="col-md-4">
                <label for="validationCustomRole" class="form-label">Rôle:</label>
                <select class="form-select" id="validationCustomRole" name="role" required>
                    <option selected disabled value="">Sélectionner un rôle</option>
                    <option value="medecin">Docteur</option>
                    <option value="cuisinier">Cuisinier</option>
                    <option value="administrateur">Administrateur</option>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un rôle.</div>
            </div>

            <div class="col-md-4">
                <label for="validationCustomPassword" class="form-label">Mot de passe :</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                        </svg>
                    </span>
                    <input type="password" class="form-control" id="validationCustomPassword" aria-describedby="inputGroupPrepend" name="mdp">
                    <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustomConfirmPassword" class="form-label">Confirmer le mot de passe :</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                        </svg>
                    </span>
                    <input type="password" class="form-control" id="validationCustomConfirmPassword" aria-describedby="inputGroupPrepend" name="confirm_mdp" required>
                    <div class="invalid-feedback">Veuillez confirmer le mot de passe.</div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-primary" id="btn" type="submit">S'inscrire</button>
            </div>
        </form>
    </section>

<script src="../js/pageinscription.js"></script>

</body>
</html>