<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="http://stagetier.fr/assets/searchCompany.css">
    <link rel="stylesheet" href="http://stagetier.fr/assets/header.css">
    <link rel="stylesheet" href="http://stagetier.fr/assets/footer.css">
</head>
<body>
<?php 
require_once("C:/www/projetWEB/config.php");
require_once(MODEL."UserSessionManager.php");
$sessionManager = new UserSessionManager();
$sessionManager->verifySession();
$utilisateur = $sessionManager->getUserType();
?>

<?php require_once(VIEW."header.php"); ?>


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
        <button type="submit" class="search"><img src="<?php echo ASSETS ?>loupe.png"></button>
    </form>
        <?php if($utilisateur != 3){ ?>
        <button onclick="window.location.href='C:\\www\\projetWEB\\view\\company\\create\\createCompany.php'" class="create">+</button>
        <?php } ?>  
    </div>
        

</div>


<ul class="main" id="main">
</ul>

<nav class="pagination-container">
  <div id="pagination-numbers"></div>
</nav>

<?php require_once(VIEW."footer.php"); ?>

<!-- Popup -->
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <p>L'entreprise a été créée avec succès !</p>
    </div>
</div>
</body>
<script src="fillCombobox.js"></script>
<script src="pagination.js"></script>
<script src="fillMain.js"></script>
<script src="editCompany.js"></script>
<script src="popup.js"></script>
</html>