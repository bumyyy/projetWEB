<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="<?php echo HOST; ?>/public/layout.css">
</head>
<body>

<header class="header">
    <div class="header-logo">
        <a href="Stagetier.fr"></a><img src="<?php echo HOST; ?>/public/img/logo.png" alt="Logo"></a> 
    </div>
    <nav>
        <ul class="header-nav">
            <a href=""></a><li>Stages</li>
            <li><a href="<?php echo HOST; ?>/company/">Entreprises</a></li>
            <li><a href="<?php echo HOST; ?>/pilot/">Pilotes</a></li>
            <li>Étudiants</li>
            <li>Candidature</li>
        </ul>
    </nav>
    <div class="header-icons">
        <img src="<?php echo HOST; ?>/public/img/reglage.png" alt="Réglages">
        <img src="<?php echo HOST; ?>/public/img/profile.png" alt="Profil">
    </div>
</header>


<main>
    <?= $content ?>
</main>


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