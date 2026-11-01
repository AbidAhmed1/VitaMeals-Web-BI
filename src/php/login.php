<?php
session_start();
include("connection.php"); // Assure-toi que ce fichier contient bien $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    // Debug temporaire
    if (empty($role) || empty($nom) || empty($mdp)) {
        echo "<p style='color:red;'>Tous les champs sont obligatoires.</p>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE nom = ? AND mdp = ? AND role = ?");
    $stmt->bind_param("sss", $nom, $mdp, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "<p style='color:red;'>Erreur dans la requête SQL.</p>";
        exit;
    }

    if ($result->num_rows == 1) {
        $_SESSION['nom'] = $nom;
        $_SESSION['role'] = $role;

        // Redirection selon le rôle
        switch ($role) {
            case 'medecin':
                header("Location: ../html/dashboard_medecin.html");
                exit;
            case 'cuisinier':
                header("Location: ../html/dashboard_cuisinier.html");
                exit;
            case 'administrateur':
                header("Location: ../html/dashboard_admin.html");
                exit;
            case 'admin':
                header("Location: ../html/dashboard_admin.html");
                exit;
            default:
                echo "<p style='color:red;'>Rôle non reconnu.</p>";
                exit;
        }
    } else {
        echo "<p style='color:red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des Hôpitaux</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .login-form-container {
            display: none;
            text-align: center;
            margin-top: 30px;
        }
        .error-message {
            color: red;
            margin: 10px;
        }
    </style>
</head>
<body>

<!-- Barre de navigation -->
<section class="section-1">
    <header>
        <h2 class="logo">LOGONOM</h2>
        <nav>
            <a href="../html/acceuil.html">Accueil</a>
            <a href="../html/contact.html">Contact</a>
            <a href="../html/a-propos.html">À propos</a>
        </nav>
    </header>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(window).on('scroll', function() {
        $("header").toggleClass('bgc', $(window).scrollTop());
    });
</script>

<br><br><br><br><br><br><br><br>

<main>
    <h1>Êtes-vous ?</h1>
    <div class="roles-container">
    <a href="../html/login_docteur.php" class="role-icon">
    <i class="fas fa-user-md icon"></i>
    <span class="role-label">Docteur</span>
</a>

<a href="../html/login_administrateur.php" class="role-icon">
    <i class="fas fa-users-cog icon"></i>
    <span class="role-label">Administrateur</span>
</a>

<a href="../html/login_cuisinier.php" class="role-icon">
    <i class="fas fa-utensils icon"></i>
    <span class="role-label">Cuisinier</span>
</a>

<a href="../html/login_admin.php" class="role-icon">
    <i class="fas fa-shield-alt icon"></i>
    <span class="role-label">Admin</span>
</a>

    </div>

   
</main>

<script>
    document.querySelectorAll('.role-icon').forEach(btn => {
        btn.addEventListener('click', function() {
            const role = this.getAttribute('data-role');
            document.getElementById('roleInput').value = role;
            document.getElementById('form-section').style.display = 'block';
            window.scrollTo({ top: document.getElementById('form-section').offsetTop - 50, behavior: 'smooth' });
        });
    });
</script>

<!-- Footer -->
<footer>
    <div class="footer-area">
        <div class="columns column-one">
            <div class="logo"><span>LOGO</span>NOM</div>
            <div class="about">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae quas alias iusto natus repudiandae nulla.</div>
        </div>

        <ul class="columns column-two">
            <h4>Links</h4>
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Portfolio</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Terms</a></li>
        </ul>

        <ul class="columns column-three">
            <h4>Other Links</h4>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Linux</a></li>
            <li><a href="#">WebDev</a></li>
            <li><a href="#">Figma</a></li>
            <li><a href="#">WordPress</a></li>
            <li><a href="#">Inkscape</a></li>
            <li><a href="#">Fonts</a></li>
        </ul>

        <ul class="columns column-four">
            <div class="footer-address">
                <h4>Address</h4>
                <li>007 Bond Street</li>
                <li>London</li>
                <li>JB1 007</li>
                <li>United Kingdom</li>
            </div>
            <div class="footer-tel">
                <h4>Telephone</h4>
                <li><a href="tel:0800007007">0800007007</a></li>
            </div>
        </ul>
    </div>

    <div class="copyright">&copy; LOGONOM</div>
</footer>

</body>
</html>
