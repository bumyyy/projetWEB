<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="Entreprises_creer.css">
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
        <option value="informatique">informatique</option>
        <option value="informatique">BTP</option>
        <option value="informatique">economie</option>
        <option value="informatique">commerce</option>
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

<div class="main">
 <form action="" class="create_entrep">
    <h1>Créer une entreprise</h1>
    <div class="company">
        <h2>Nom de l'entreprise</h2>
        <input type="text" name="nom" id="form_input">
    </div>
    <div class="activité">
        <h2>Secteur d'activité</h2>
        <select name="secteur" id="Secteur"></select>
    </div>
    <h2>Localité</h2>
    <div class="localite">
        <input type="text">
        <input type="button" value="+" id="ville">
    </div>

    <h2>Note</h2>
    <div class="rating" data-rating="3">
    <input type="hidden" id="rating-value" name="rating-value" value="0">
  <span class="star" data-value="1">&#9733;</span>
  <span class="star" data-value="2">&#9733;</span>
  <span class="star" data-value="3">&#9733;</span>
  <span class="star" data-value="4">&#9733;</span>
  <span class="star" data-value="5">&#9733;</span>
    </div>
 </form>
</div>


<footer class="footer">
    <img src="img/youtube.png" alt="YouTube">
    <img src="img/linkedin.png" alt="LinkedIn">
    <img src="img/facebook.png" alt="Facebook">
    <img src="img/twitter.png" alt="Twitter">
    <img src="img/instagram.png" alt="Instagram">
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>
<script src="Entreprises_creer.js"></script>
</body>
</html>