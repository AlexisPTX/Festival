<?php
session_start();
// Récupération des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['load_count']['recap'] = 0;
    $nom = htmlspecialchars($_POST['nom']);
    $places = intval($_POST['places']); // Assure que la valeur est un entier
    $typePass = $_POST['choix']; // Cette valeur peut être 'normal' ou 'vip'
    
    $jours = [];
    if(isset($_POST['vendredi'])) $jours[] = "Vendredi";
    if(isset($_POST['samedi'])) $jours[] = "Samedi";
    if(isset($_POST['dimanche'])) $jours[] = "Dimanche";
    
    $commentaire = htmlspecialchars($_POST['commentaire']);


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
    
    foreach($jours as $jour){
        foreach($resultat as $row) {
            if($row["joursPro"] == $jour && $row['difference_capacite'] < $places) {
                $_SESSION['erreur_message'] = "Il ne reste pas assez de places pour votre demande";
                header('Location: ../index.php');
                $conn = null;
                exit;
            }    
        }
    }
    // Stocker les données dans la session
    $_SESSION['reservation'] = [
        'nom' => $nom,
        'typePass' => $typePass,
        'jours' => $jours,
        'places' => $places,
        'commentaire' => $commentaire,
        'page' => 'formulaire'
    ];
    if ($_SESSION['reservation']['nom'] == '' || $_SESSION['reservation']['typePass'] == '' || empty($_SESSION['reservation']['jours']) || $_SESSION['reservation']['places'] == 0){
        session_abort();
        header("Location: horaire.php");
        $_SESSION['load_count']['formulaire'] = 0;
        $conn = null;
        exit();
    }
    header("Location: identification.php");
    $conn = null;
    exit();
}
?>
