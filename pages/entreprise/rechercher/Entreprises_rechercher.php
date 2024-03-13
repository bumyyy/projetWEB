<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="Entreprises_rechercher.css">
</head>
<body>


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


<form id="form" method="POST">
<div class="sub">
    
        <input type="text" id="search" placeholder="Rechercher entreprises">

        <div class="combox">
            <div id="comboboxSecteur"></div>
            
            <div id="comboboxVille"></div>

        <select id="rate" >
            <option value="x">note</option>
            <option value="1">1 étoile</option>
            <option value="2">2 étoiles</option>
            <option value="3">3 étoiles</option>
            <option value="4">4 étoiles</option>
            <option value="5">5 étoiles</option>
            </select>
        </div>
    
    <div class="wrap">
        <button type="submit" class="search"><img src="img\loupe.png"></button>
    </form>
        <button class="create">+</button>
    </div>
        

</div>

<div id="main" class="main"></div>
<div id="pagination"></div>

<footer class="footer">
    <img src="img/youtube.png" alt="YouTube">
    <img src="img/linkedin.png" alt="LinkedIn">
    <img src="img/facebook.png" alt="Facebook">
    <img src="img/twitter.png" alt="Twitter">
    <img src="img/instagram.png" alt="Instagram">
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>
</body>
<script src="fillCombobox.js"></script>
<script src="fillMain.js"></script>
<script src="editCompany.js"></script>
</html>