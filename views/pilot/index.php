<head>
    <link rel="stylesheet" href="<?php echo HOST; ?>/public/pilot/pilotSearch.css">
</head>

<body>
    <?php $utilisateur = 1 ?>

    <form id="form" method="POST">
        <div class="sub">

            <input type="text" id="search" placeholder="Rechercher pilotes">

            <div class="combox">
                <div id="comboboxPromo"></div>

                <div id="comboboxVille"></div>
            </div>

            <div class="wrap">
                <button type="submit" class="search" id="btnsubmit"><img src="<?php echo HOST; ?>/public/img/loupe.png"></button>
    </form>
    <?php if ($utilisateur != 3) { ?>
        <button onclick="window.location.href='<?php echo HOST; ?>/company/create'" class="create">+</button>
    <?php } ?>
    </div>


    </div>


    <ul class="main" id="main">
    </ul>

    <nav class="pagination-container">
        <div id="pagination-numbers"></div>
    </nav>

    <!-- Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <p>L'entreprise a été créée avec succès !</p>
        </div>
    </div>
</body>

<script src="<?php echo HOST; ?>/public/pilot/fillCombobox.js"></script>
<script src="<?php echo HOST; ?>/public/company/pagination.js"></script>
<script src="<?php echo HOST; ?>/public/pilot/fillMain.js"></script>
<script src="<?php echo HOST; ?>/public/company/editPilot.js"></script>
<script src="<?php echo HOST; ?>/public/company/popup.js"></script>
<?php
session_start();
if (isset ($_SESSION["message"]) && $_SESSION["message"] == "Deleted") {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            alert('Entreprise caché avec succès!');
            document.getElementById('btnsubmit').click();
        }, 1000);
    });
    </script>";
    unset($_SESSION["message"]);
}
?>

</html>