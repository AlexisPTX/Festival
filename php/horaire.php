<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "festival";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT programme.joursPro, programme.capacitePro - COALESCE(SUM(reservation.nbPlacesRes), 0) AS difference_capacite 
                        FROM programme 
                        LEFT JOIN reservation ON programme.joursPro = reservation.joursRes 
                        GROUP BY programme.joursPro, programme.capacitePro;");
    $stmt->execute();
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $resultat = array_reverse($resultat);
    
    
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Horaires</title>
    <link rel="icon" type="image/icon" href="../images/sonic.png">
    <link rel="stylesheet" type="text/css" href="../css/style_horaires.css">
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
                <a href="identification.php">Compte</a>
            </div>
                <img src="../images/sonic.png">
        </nav>
    </header>

    <div class="container">
        <article>
            <h2>Vendredi</h2>
            <?php
                foreach( $resultat as $row ) {
                    if($row["joursPro"] == "Vendredi"){
                        echo '<p class=capacite>' . $row['difference_capacite'] . ' places restantes</p><br>';
                    }
                }
            ?>
            <ul>
                <li>Ouverture des portes : 17h</li>
                <li>18h : Dadju</li>
                <li>19h : Djadja & Dinaz </li>
                <li>20h30 : Tayc</li>
                <li>22h : Tiakola</li>
                <li>0h : Damso</li>
                <li>Fermeture de la scène : 2h</li>
                <li>Fermeture des portes : 3h</li>
            </ul>
        </article>

        <article>
            <h2>Samedi</h2>
            <?php
                foreach( $resultat as $row ) {
                    if($row["joursPro"] == "Samedi"){
                        echo '<p class=capacite>' . $row['difference_capacite'] . ' places restantes</p><br>';
                    }
                }
            ?>
            <ul>
                <li>Ouverture des portes : 16h</li>
                <li>17h : Franglish</li>
                <li>18h : Black M </li>
                <li>19h : Jok'Air</li>
                <li>20h30 : Ninho</li>
                <li>22h : Gims</li>
                <li>0h : Gazo </li>
                <li>Fermeture de la scène : 2h</li>
                <li>Fermeture des portes : 3h</li>
            </ul>
        </article>

        <article>
            <h2>Dimanche</h2>
            <?php
                foreach( $resultat as $row ) {
                    if($row["joursPro"] == "Dimanche"){
                        echo '<p class=capacite>' . $row['difference_capacite'] . ' places restantes</p><br>';
                    }
                }
            ?>
            <ul>
                <li>Ouverture des portes : 16h</li>
                <li>17h : Stromae </li>
                <li>18h : Mika</li>
                <li>19h : Vianney</li>
                <li>20h : 47Ter </li>
                <li>21h : Bigflo & Oli </li>
                <li>22h : M.Pokora</li>
                <li>1h : Soprano</li>
                <li>Fermeture de la scène : 4h</li>
                <li>Fermeture des portes : 5h</li>
            </ul>
        </article>
    </div>
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