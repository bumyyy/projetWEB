<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="<?php echo HOST; ?>/public/accueil.css">
    <link rel="stylesheet" href="/public/style.css">
    <script src="/public/index.js" defer></script>
</head>

<body>

<header class="header">
    <div class="header-logo">
        <a href="Stagetier.fr"><img src="/public/img/logo.png" alt="Logo"></a> 
    </div>
    <nav>
        <ul class="header-nav">
            <a href=""></a><li>Stages</li>
            <li><a href="http://stagetier.fr/pages/entreprise/rechercher/Entreprises_rechercher.php">Entreprises</a></li>
            <li>Pilotes</li>
            <li>Étudiants</li>
            <li>Candidature</li>
        </ul>
    </nav>
    <div class="header-icons">
        <img src="/public/img/reglage.png" alt="Réglages">
        <img src="/public/img/profile.png" id="profile" alt="Profil">
    </div>
</header>

<div class="profil-content" id="informations">
    <div>
        <h2 class="text">Vos Informtaions</h2>
        <div class="div1"><p>Nom :<?php //$_SESSION['userData']['nom']?></p></div>
        <div class="div2"><p>Prénom :<?php //$_SESSION['userData']['prenom']?></p></div>
        <div><p>Type :<?php //$_SESSION['userData']['type']?></p></div>
        <form action="/Logout" method="post">
            <button class="btn" id="deco" type="submit" value="Déconnexion">Déconnexion</button>
        </form>
    </div>
</div>

<div class="content">
    <h1>Nous transformons les moments gênants en opportunités de carrière</h1>
</div>


<footer class="footer">
    <a href="https://youtube.com"><img src="<?php echo HOST; ?>/public/img/youtube.png" alt="YouTube"></a>
    <a href="https://www.linkedin.com/in/anne-portal-7683bb241/"><img src="<?php echo HOST; ?>/public/img/linkedin.png" alt="LinkedIn"></a>
    <a href="https://www.facebook.com"><img src="<?php echo HOST; ?>/public/img/facebook.png" alt="Facebook"></a>
    <a href="https://www.twitter.com"><img src="<?php echo HOST; ?>/public/img/twitter.png" alt="Twitter"></a>
    <a href="https://www.instagram.com"><img src="<?php echo HOST; ?>/public/img/instagram.png" alt="Instagram"></a>
    <p>© 2024 Stage_Tier - Tous droits réservés</p>
</footer>

</body>
</html>