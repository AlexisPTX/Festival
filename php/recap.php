<?php
session_start();
if (!isset($_SESSION['load_count']['recap'])) {
    $_SESSION['load_count'] = array();
    $_SESSION['load_count']['recap'] = 0;
}
else if((isset($_GET['reset']) && $_GET['reset'] == 1) && (isset($temp) && $temp == 'register')){
    $_SESSION['load_count']['recap'] = 0;
    unset($_GET['reset']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit();
}
$_SESSION['load_count']['recap']++;
if ($_SESSION['load_count']['recap'] > 1  && (isset($temp) && $temp == 'register')) {
    unset($_SESSION['reservation']);
    $_SESSION['load_count']['recap'] = 0;
    session_abort();
    header('Location: ../index.html');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "festival";

$reservations = array();

if (isset($_GET['temp'])) {
    $temp = urldecode($_GET['temp']);
}

if (isset($_SESSION['reservation']) && ($temp == 'register')) {
    $reservations[] = [
        'nomRes' => isset($_SESSION['reservation']['nom']) ? $_SESSION['reservation']['nom'] : '',
        'nbPlacesRes' => isset($_SESSION['reservation']['places']) ? $_SESSION['reservation']['places'] : 0,
        'typePass' => isset($_SESSION['reservation']['typePass']) ? $_SESSION['reservation']['typePass'] : '',
        'joursRes' => isset($_SESSION['reservation']['jours']) ? $_SESSION['reservation']['jours'] : [],
        'commentaireRes' => isset($_SESSION['reservation']['commentaire']) ? $_SESSION['reservation']['commentaire'] : '',
        'loginRes' => isset($_SESSION['username']) ? $_SESSION['username'] :'',
    ];    
    unset($_SESSION['reservation']);
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO reservation (nomRes, typePass, joursRes, nbPlacesRes, commentaireRes, loginRes) VALUES (:nom, :typePass, :jours, :places, :commentaire, :username)");
        if (isset($reservations) && is_array($reservations)){
            foreach ($reservations as $reservation){
                if (!empty($reservation['joursRes'])) {
                    foreach ($reservation['joursRes'] as $jour) {
                        $stmt->bindParam(':nom', $reservation['nomRes']);
                        $stmt->bindParam(':places', $reservation['nbPlacesRes']);
                        $stmt->bindParam(':typePass', $reservation['typePass']);
                        $stmt->bindParam(':jours', $jour);
                        $stmt->bindParam(':commentaire', $reservation['commentaireRes']);
                        $stmt->bindParam(':username', $reservation['loginRes']);
                        $stmt->execute();
                    }
                }
            }
        }    
    } catch (PDOException $e) {
        header("Location: ../index.html");
        session_abort();
        $_SESSION['load_count']['recap'] = 0;
        $conn = null;
        exit();
    }
} elseif (isset($_SESSION['username']) && ($temp == 'login')) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM reservation where loginRes = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        header("Location: /index.html");
        session_abort();
        $_SESSION['load_count']['recap'] = 0;
        $conn = null;
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif de la réservation</title>
    <link rel="icon" type="image/icon" href="../images/sonic.png">
    <link rel="stylesheet" type="text/css" href="../css/style_recap.css">
    <link href="https://fonts.cdnfonts.com/css/svetze" rel="stylesheet">
</head>
<body>
    <header>
        <div class="banner">
            <img src="../images/fond.jpg">
        </div>
        <nav>
            <div class="liens">
                <a href="/index.php#body">Accueil</a>
                <a href="horaire.php">Horaires</a>
            </div>
            <img src="../images/sonic.png">
        </nav>
    </header>
    <h2>Récapitulatif</h2>
    <div class="recap">
        <?php if (isset($reservations) && is_array($reservations) && (!empty($reservations))): ?>
            <?php foreach ($reservations as $reservation): ?>
                <?php if (isset($reservation) && $reservation['nomRes'] != ''): ?>
                    <div class="reservation">
                        <p>Nom : <?php echo $reservation['nomRes']; ?></p>
                        <p>Type de Pass : <?php echo $reservation['typePass']; ?></p>
                        <ul>Jours(s) sélectionné(s) :
                            <?php if (!empty($reservation['joursRes'])): ?>
                                <?php if ($temp == 'register'): ?>
                                    <?php foreach ($reservation['joursRes'] as $jour): ?>
                                        <li><?php echo $jour; ?></li>
                                    <?php endforeach; ?>
                                <?php else: echo $reservation['joursRes']; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                        <p>Nombre de place(s) : <?php echo $reservation['nbPlacesRes']; ?></p>
                        <?php if (!empty($reservation['commentaireRes'])): ?>
                            <p>Commentaire :<br><?php echo $reservation['commentaireRes']; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune réservation trouvée</p>
        <?php endif; ?>
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
</html>