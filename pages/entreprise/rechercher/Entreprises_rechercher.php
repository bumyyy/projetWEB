<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="Entreprises_rechercher.css">
</head>
<body>
<?php
require_once __DIR__ . "/../../vendor/autoload.php";
use App\UserSessionManager;
$sessionManager = new UserSessionManager();
$sessionManager->verifySession();  

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/chemin/vers/vos/templates');
$twig = new \Twig\Environment($loader);
?>

<header class="header">
    <div class="header-logo">
    <a href="http://stagetier.fr/accueil"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <nav>
        <ul class="header-nav">
            <li>Stages</li>
            <li><a href="http://stagetier.fr/entreprise/rechercher/Entreprises_rechercher.php">Entreprises</a></li>
            <li>Pilotes</li>
            <li>Étudiants</li>
            <li>Candidature</li>
        </ul>
    </nav>
    <div class="header-icons">
        <img src="img/reglage.png" alt="Réglages">
        <img src="img/profile.png" alt="Profil">
    </div>
</header>

<div class="content">
    
</div>
<form method="POST">
<div class="sub">
    
            <input type="text" name="rechercher" placeholder="Rechercher entreprises">

        <div class="combox">
        <select name="act_sec">
            <option value="x">Secteur</option>

            {% $data = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=combox/secteur")) %}
            {% foreach ($data as $secteur)  %}
                <option value='{{$secteur->nom}}'>{{ $secteur->nom }}</option>; 
            {% } %}
            
            </select>
        <select name="localité">
            <option value="x">Ville</option>
            <?php 
            $data = json_decode(file_get_contents("http://localhost/projetWEB/api/index.php?demande=combox/ville"));
            foreach ($data as $ville) {
                echo "<option value='{$ville->nom}'>$ville->nom</option>";
            }
            ?>
            </select>

        <select name="rate">
            <option value="x">Note</option>
            <option value="1">1 étoile</option>
            <option value="2">2 étoiles</option>
            <option value="3">3 étoiles</option>
            <option value="4">4 étoiles</option>
            <option value="5">5 étoiles</option>
            </select>
        </div>
    
    <div class="wrap">
        <button type="submit" class="search">=</button>
    </form>
        <button class="create">+</button>
    </div>
        

</div>

<!--Le block de code qui permet de réaliser l'algorithme de filtre-->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "Files/rechercher.php";
}
?>

<!--La classe carre représente ici les blocks dans lequels sont placé les informations lié aux entreprises-->
<div class="main">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include "Files/ajouter.php";
        }
        ?>

</div>


<footer class="footer">
    <img src="img/youtube.png" alt="YouTube">
    <img src="img/linkedin.png" alt="LinkedIn">
    <img src="img/facebook.png" alt="Facebook">
    <img src="img/twitter.png" alt="Twitter">
    <img src="img/instagram.png" alt="Instagram">
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>
</body>
</html>