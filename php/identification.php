<?php
session_start();
$_SESSION['load_count']['recap'] = 0;
if (isset($_SESSION['reservation']) && ($_SESSION['reservation']['page'] != 'formulaire')){
    session_abort();
    header("Location: ../index.html");
}

else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Récupérer les données du formulaire d'inscription
    $registerName = htmlspecialchars($_POST['register_name']);
    $registerFirstName = htmlspecialchars($_POST['register_firstname']);
    $_SESSION['username'] = htmlspecialchars($_POST['register_username']);
    $registerPassword = password_hash($_POST['register_password'], PASSWORD_DEFAULT);

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "festival";

    if(isset($_SESSION['reservation']) && $_SESSION['reservation']['page'] == 'formulaire') {
        $temp = urlencode('register');
    }else{
        $temp = urlencode('login');
    }   
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt2 = $conn->prepare("SELECT loginUser FROM utilisateurs WHERE loginUser = :username");
    $stmt2->bindParam(':username', $_SESSION['username']);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);

    if(isset($result) && (!empty($result))) {
        $errorMessageInscription = "Nom d'utilisateur déjà utilisé";
    }
    else{
        try {
            // Préparation de la requête SQL pour l'insertion
            $stmt = $conn->prepare("INSERT INTO utilisateurs (loginUser, nomUser, prenomUser, passwordUser) VALUES (:username, :register_nom, :prenom, :mot_de_passe)");

            // Liaison des paramètres
            $stmt->bindParam(':register_nom', $registerName);
            $stmt->bindParam(':prenom', $registerFirstName);
            $stmt->bindParam(':username', $_SESSION['username']);
            $stmt->bindParam(':mot_de_passe', $registerPassword);

            $stmt->execute();
            // Redirection vers la page de récapitulatif après une inscription réussie
            if(isset($_SESSION['reservation']['page']) && $_SESSION['reservation']['page'] == 'formulaire'){
                header("Location: recap.php?temp=$temp&reset=1");
                $_SESSION['load_count']['identification'] = 0;
                $conn = null;
                exit();
                
            }else{
                header('Location: ../index.html');
                session_abort();
                $_SESSION['load_count']['identification'] = 0;
                unset($_SESSION);
                $conn =null;
                exit();
            }

        } catch (PDOException $e) {
            header("Location: /index.html");
            session_abort();
            $_SESSION['load_count']['identification'] = 0;
            $conn = null;
            exit();
        }
    }
}
// Exemple de code pour la connexion (à adapter en fonction de votre implémentation)
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Récupérer les données du formulaire de connexion
    $loginUsername = htmlspecialchars($_POST['login_username']);
    $loginPassword = $_POST['login_password'];

    // Connexion à la base de données (à remplacer par vos informations de connexion)
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "festival";

    if(isset($_SESSION['reservation']) && $_SESSION['reservation']['page'] == 'formulaire') {
        $temp = urlencode('register');
    }else{
        $temp = urlencode('login');
    }    

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL pour récupérer le mot de passe enregistré pour cet utilisateur
        $stmt = $conn->prepare("SELECT passwordUser FROM utilisateurs WHERE loginUser = :username");
        $stmt->bindParam(':username', $loginUsername);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($result && password_verify($loginPassword, $result['passwordUser'])) {
            // Connexion réussie, rediriger vers la page de récapitulatif
            $_SESSION['username'] = $loginUsername;
            header("Location: recap.php?temp=$temp&reset=1");
            $_SESSION['load_count']['identification'] = 0;
            $conn = null;
            exit();
        } else {
            $errorMessageConnexion = "Nom d'utilisateur ou mot de passe incorrect";
        }

    } catch (PDOException $e) {
        header("Location: ../index.html");
        session_abort();
        $conn = null;
        $_SESSION['load_count']['identification'] = 0;
        exit();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link rel="icon" type="image/icon" href="../images/sonic.png">
    <link rel="stylesheet" type="text/css" href="../css/style_identification.css">
    <link href="https://fonts.cdnfonts.com/css/svetze" rel="stylesheet">
</head>
<body>
    <header>
        <div class="banner">
            <img src="../images/fond.jpg">
        </div>
        <nav>
            <div class="liens">
                <a href="../index.php#body">Accueil</a>
                <a href="../index.php#formulaire">Réserver</a>
                <a href="horaire.php">Horaires</a>
            </div>
                <img src="../images/sonic.png">
        </nav>
    </header>
    <main>
        <div class="inscription">
            <form method="POST" action="../php/identification.php?reset=1">
                <h2>Inscription</h2><br>
                <label for="register_name">Nom :</label>
                <input type="text" name="register_name" <?php echo isset($_SESSION['reservation']['nom']) ? 'value="' . htmlspecialchars($_SESSION['reservation']['nom']) . '" readonly' : 'required'; ?>><br>


                <label for="register_firstname">Prénom :</label>
                <input type="text" name="register_firstname" required><br>

                <label for="register_username">Nom d'utilisateur :</label>
                <input type="text" name="register_username" required><br>
                
                <label for="register_password">Mot de passe :</label>
                <input type="password" name="register_password" required><br><br>

                <?php
                    if (isset($errorMessageInscription)) {
                        echo '<p class="error-message">' . $errorMessageInscription . '</p><br>';
                    }
                    else echo'<br>';
                ?>
                
                <input class="button" type="submit" name="register" value="S'inscrire">
            </form>
        </div>

        <div class="connexion">
            <form method="POST" action="../php/identification.php?reset=1">
                <h2>Connexion</h2><br><br>
                <label for="login_username">Nom d'utilisateur :</label>
                <input type="text" name="login_username" required><br>
                    
                <label for="login_password">Mot de passe :</label>
                <input type="password" name="login_password" required><br><br>
                
                <?php
                    if (isset($errorMessageConnexion)) {
                        echo '<p class="error-message">' . $errorMessageConnexion . '</p><br>';
                    }
                    else echo'<br>';
                ?>
                <br>
                <input class="button" type="submit" name="login" value="Se connecter">
            </form>
        </div>
    </main>
    <footer id="contact">
            <div class="liens">
                <a href="mailto:sonic.summer-fest@gmail.com">Nous écrire</a>
                <a href="tel:0123456789">Nous appeler</a>
            </div>
            <div class="photos">
                <a href="https://www.instagram.com" title="Instagram"><img src="../images/insta.png"></a>
                <a href="https://twitter.com/?lang=fr" title="Instagram"><img src="../images/twitter.png"></a>
                <a href="https://www.tiktok.com/fr/" title="Instagram"><img src="../images/tiktok.png"></a>  
            </div>
    </footer>
</body>
</html>