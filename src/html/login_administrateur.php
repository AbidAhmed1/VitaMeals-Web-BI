<?php
// login_administrateur.php
session_start();
include('../php/connection.php');
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $mdp = $_POST['mdp'];

    $sql = "SELECT * FROM utilisateur WHERE nom = ? AND mdp = ? AND role = 'administrateur'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $nom, $mdp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['role'] = 'administrateur';
        header("Location: administrateur_dashboard.php");
        exit();
    } else {
        $error = "Nom ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/PagecssdesUX.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">


    <title>pageinscription</title>
</head>
<body>

    <nav class="sidebar close">
        <header>        
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">LOGO</span>
                    <span class="profession">NOM</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search...">
                </li>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="../html/acceuil.html">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Accuiel</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../html/login.html">
                   <i class='bx bx-log-in icon' ></i>
                            <span class="text nav-text">Se connecter </span>
                        </a>
                    </li>


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

        <div class="container">
            <div class="row justify-content-center">        

                <div class="col-md-6 login-form">
                    <h2 class="insc">Connexion</h2>

                    <form method="post" action="login_administrateur.php">
                        <div class="group-input">
                            <input type="text" required id="login" class="form-control" name="nom">
                            <span></span>
                            <label for="login">Login:</label>
                        </div>
                        <div class="group-input">
                            <input type="password" required id="password" name="mdp" class="form-control">
                            <span></span>
                            <label for="password">Mot de passe:</label>
                        </div>
                        <button type="submit" class="btn btn-outline-success" id="secon">Se connecter</button>

                        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

                    </form>
                </div>
            </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    


  </section>   

<script src="../js/pageinscription.js">  </script>
</body>
</html>