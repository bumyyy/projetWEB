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

<div class="content">
    
</div>
<div class="sub">
    <input type="text" placeholder="Rechercher entreprises">
    <div class="combox">
    <select name="secteur d'activité" id="act_sec">
        <?php 
        $data = json_decode("http://localhost/projetWEB/api/index.php?demande=combox/secteur")
        
        <option value=" "> </option>
        ?>
        

        </select>
    <select name="localité" id="localité">
        <option value="Aix-en-Provence">Aix-en-Provence</option>
        <option value="Marseille">Marseille</option>
        <option value="Paris">Paris</option>
        <option value="Nice">Nice</option>
        </select>

    <select name="évaluation" id="rate">
        <option value="1 étoile">1 étoile</option>
        <option value="2 étoiles">2 étoiles</option>
        <option value="3 étoiles">3 étoiles</option>
        <option value="4 étoiles">4 étoiles</option>
        <option value="5 étoiles">5 étoiles</option>
        </select>
    </div>
    <div class="create">
        <button>+</button>
    </div>
</div>

<!--La class carre représente ici les blocks dans lequels sont placé les informations lié aux entreprises-->
<div class="main">
<div class="ligne">
    <div class="carre">
            <div class="name">
                <h1>Entreprise1</h1>
                <p>informatique</p>
            </div>
        <div class="localité">
            <h2>Localité</h2>
            <p>Paris
            Lyon lyon</p>
        </div>
        <div class="secteur">
            <h2>Note</h2>
            <div class="rating" data-rating="3">
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
                <span class="star"></span>
            </div>
        </div> 
        
    </div>

    <div class="mod">
        <span class="update"></span>
        <span class="delete"></span>
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
</body>
</html>