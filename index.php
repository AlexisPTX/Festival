<?php session_start();?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Sonic Summer Fest</title>
    <link rel="icon" type="image/icon" href="images/sonic.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="../script/script.js"></script>
    <link href="https://fonts.cdnfonts.com/css/svetze" rel="stylesheet">
</head>

<body>
    <header>
        <div class="banner">
            <img src="images/fond.jpg">
        </div>
        <nav>
            <div class="liens">
                <a href="#body">Accueil</a>
                <a href="#formulaire">Réserver</a>
                <a href="php/horaire.php">Horaires</a>
                <a href="php/identification.php?reset=1">Compte</a>
            </div>
                <img src="images/sonic.png">
        </nav>
    </header>
    <h3 id="visites"><span id="visitors">0</span> personnes visitent le site actuellement</h3>
    <article>
        <section class="container">
            <div class="card">
                <div class="card-image car-1"></div>
                    <h2>L'Éclat Magique de l'Été</h2>
                    <p>Explorez l'univers visuel ensorcelant du Sonic Summer Fest, où les décors artistiques et les jeux de lumières créent une atmosphère féérique. Plongez dans une expérience immersive où la scénographie devient le parfait écrin pour sublimer les performances musicales.</p>
                    <a href="">Lire plus</a>
                </div>
            <div class="card">
                <div class="card-image car-2"></div>
                    <h2>Un Festival Électrisant</h2>
                    <p>Découvrez comment le Sonic Summer Fest transforme chaque édition en une aventure sensorielle époustouflante, où la musique devient le fil conducteur d'une célébration estivale inoubliable, entre rires, danses et énergie contagieuse.</p>
                    <a href="">Lire plus</a>
                </div>
            <div class="card">
                <div class="card-image car-3"></div>
                    <h2>Une Ascension Prestigieuse</h2>
                    <p>Plongez dans le succès mondial du Sonic Summer Fest, devenu une institution musicale incontournable. Découvrez comment ce festival attire les foules du monde entier avec sa programmation exceptionnelle, créant une expérience culturelle unique à chaque édition.</p>
                    <a href="">Lire plus</a>
                </div>
        </section>
    </article>

    <h2 id="formulaire">Formulaire réservation :</h2>
    <div class="formulaire">
        <form method="post" action="../php/formulaire.php">
            <label for="nom">Nom (4 to 20 characters) :</label><br> 
                <input type="text" name="nom" id="nom" minlength="4" maxlength="20" size="25" placeholder="Saisir nom" required>
            <br><br>
            <label for="places">Nombres de places :</label><br>
                <input type="number" name="places" id="places" min="1" max="25000" step="1" value="0">
            <br><br>
            <label for="pass">Type de pass :</label><br>
                <div id="pass">
                    <input type="radio" id="choix1" name="choix" value="Normal" checked><label for="choix1"> Normal</label>
                    <input type="radio" id="choix2" name="choix" value="Vip"><label for="choix2"> VIP</label>
                </div>
            <br>
            <label for="jours">Jour(s) souhaité(s) :</label><br>
                <div id="jours">
                    <input type="checkbox" id="vendredi" name="vendredi"><label for="vendredi"> Vendredi</label>
                    <input type="checkbox" id="samedi" name="samedi"><label for="samedi"> Samedi</label>
                    <input type="checkbox" id="dimanche" name="dimanche"><label for="dimanche"> Dimanche</label>
                </div>
            <br>
            <label for="commentaire">Commentaire :</label><br>
                <textarea id="commentaire" name="commentaire" rows="4" cols="30" placeholder="Saisir commentaire"></textarea><br>
            <?php
            if (isset($_SESSION['erreur_message'])) {
                echo '<p class="error-message">' . $_SESSION['erreur_message'] . '</p>';
                unset($_SESSION['erreur_message']);
            }
            ?>
            <br>
            <button id="valider" type="submit">Valider</button>
        </form>    
    </div>

    <footer id="contact">
            <div class="liens">
                <a href="mailto:sonic.summer-fest@gmail.com">Nous écrire</a>
                <a href="tel:0123456789">Nous appeler</a>
            </div>
            <div class="photos">
                <a href="https://www.instagram.com" title="Instagram"><img src="images/insta.png"></a>
                <a href="https://twitter.com/?lang=fr" title="Instagram"><img src="images/twitter.png"></a>
                <a href="https://www.tiktok.com/fr/" title="Instagram"><img src="images/tiktok.png"></a>  
            </div>
    </footer>
</body>
</html>