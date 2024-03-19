<head>
    <link rel="stylesheet" href="<?php echo HOST; ?>/public/company/companySearch.css">
</head>

<body>
    <?php $utilisateur = 1 ?>

    <form id="form" method="POST">
        <div class="sub">

            <input type="text" id="search" placeholder="Rechercher entreprises">

            <div class="combox">
                <div id="comboboxSecteur"></div>

                <div id="comboboxVille"></div>

                <select id="rate">
                    <option value="x">note</option>
                    <option value="1">1 étoile</option>
                    <option value="2">2 étoiles</option>
                    <option value="3">3 étoiles</option>
                    <option value="4">4 étoiles</option>
                    <option value="5">5 étoiles</option>
                </select>
            </div>

            <div class="wrap">
                <button type="submit" class="search"><img src="<?php echo HOST; ?>/public/img/loupe.png"></button>
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

<script src="<?php echo HOST; ?>/public/company/fillCombobox.js"></script>
<script src="<?php echo HOST; ?>/public/company/pagination.js"></script>
<script src="<?php echo HOST; ?>/public/company/fillMain.js"></script>
<script src="<?php echo HOST; ?>/public/company/editCompany.js"></script>
<script src="<?php echo HOST; ?>/public/company/popup.js"></script>
<?php
session_start();
if (isset ($_SESSION["message"]) && $_SESSION["message"] == "Deleted") {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('btnsubmit').click();
        }, 600);
    });
    </script>";
    unset($_SESSION["message"]);
}
?>

</html>