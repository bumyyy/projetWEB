<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="companystats.css">
</head>
<body>
    
<header class="header">
    <div class="header-logo">
        <img src="img/logo.png" alt="Logo">
    </div>
    <nav>
        <ul class="header-nav">
            <li>Stages</li>
            <li>Entreprises</li>
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


<!--La class carre représente ici les blocks dans lequels sont placé les informations lié aux entreprises-->

<div class="main">

<div class="alldiag">
<div class="diag1">
    <div class="diagtitle">
        <h1>Secteur d'activité</h1>
    </div>
    <div class="diagsect">
<p class="sec1">secteur 1</p> <p class="sec2">secteur 2</p> <p class="sec3">secteur 3</p> 
    </div>
    <div class="Secteur" id="Secteur"></div>
</div>
<div class="diag1">
<div class="diagtitle">
        <h1>Localité</h1>
    </div>
    <div class="diagsect">
    <p class="sec1">secteur 1</p> <p class="sec2">secteur 2</p> <p class="sec3">secteur 3</p> 
    </div>
    <div class="Localité" id="Localité"></div>
</div>
</div>

<div class="top3">
<div class="diag1">
<div class="diagtitle2">
        <h1>TOP 3</h1>
    </div>
</div>
    <div class="carre">
        <div class="name">
            <h1 class="entreprise">Entreprise1</h1>
            <div class='rating' data-rating='3'>
                    <input type='hidden' id='rating-value' name='rating-value' value='0'>
                    <span class='star' data-value='5'>&#9733;</span>
                    <span class='star' data-value='4'>&#9733;</span>
                    <span class='star' data-value='3'>&#9733;</span>
                    <span class='star' data-value='2'>&#9733;</span>
                    <span class='star' data-value='1'>&#9733;</span>
                </div>
        </div>
        <div class="downligne">
            <div class="secteur">
                <h2>Secteur</h2>
                <p class="sech1">secteur</p> 
            </div> 
            <div class="localité">
                <h2>Localité</h2>
                <p class="localh1"></p>
            </div>
        </div> 
        
    </div>
    <div class="carre">
        <div class="name">
            <h1 class="entreprise">Entreprise1</h1>
            <div class='rating' data-rating='3'>
                    <input type='hidden' id='rating-value' name='rating-value' value='0'>
                    <span class='star' data-value='5'>&#9733;</span>
                    <span class='star' data-value='4'>&#9733;</span>
                    <span class='star' data-value='3'>&#9733;</span>
                    <span class='star' data-value='2'>&#9733;</span>
                    <span class='star' data-value='1'>&#9733;</span>
                </div>
        </div>
        <div class="downligne">
            <div class="secteur">
                <h2>Secteur</h2>
                <p class="sech1">secteur</p> 
            </div> 
            <div class="localité">
                <h2>Localité</h2>
                <p class="localh1"></p>
            </div>
        </div> 
        
    </div>
    <div class="carre">
        <div class="name">
            <h1 class="entreprise">Entreprise1</h1>
            <div class='rating' data-rating='3'>
                    <input type='hidden' id='rating-value' name='rating-value' value='0'>
                    <span class='star' data-value='5'>&#9733;</span>
                    <span class='star' data-value='4'>&#9733;</span>
                    <span class='star' data-value='3'>&#9733;</span>
                    <span class='star' data-value='2'>&#9733;</span>
                    <span class='star' data-value='1'>&#9733;</span>
                </div>
        </div>
        <div class="downligne">
            <div class="secteur">
                <h2>Secteur</h2>
                <p class="sech1">secteur</p> 
            </div> 
            <div class="localité">
                <h2>Localité</h2>
                <p class="localh1"></p>
            </div>
        </div> 
        
    </div>


</div>



</div>
<footer class="footer">
    <img src="img/youtube.png" alt="YouTube">
    <img src="img/linkedin.png" alt="LinkedIn">
    <img src="img/facebook.png" alt="Facebook">
    <img src="img/twitter.png" alt="Twitter">
    <img src="img/instagram.png" alt="Instagram">
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>
<script src="companystats.js"></script>
</body>
</html>