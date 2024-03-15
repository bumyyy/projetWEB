<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_tier</title>
    <link rel="stylesheet" href="<?php echo ASSETS ?>home.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>header.css">
    <link rel="stylesheet" href="<?php echo ASSETS ?>footer.css">
</head>
<body>
<?php
require_once(MODEL."UserSessionManager.php");
$sessionManager = new UserSessionManager();
//$sessionManager->verifySession();     
?>

<?php require_once(VIEW."header.php"); ?>


<div class="content">
    <h1>Nous transformons les moments gênants en opportunités de carrière</h1>
</div>


<?php require_once(VIEW."footer.php"); ?>

</body>
</html>