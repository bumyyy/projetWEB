
<head>
    <link rel="stylesheet" href="<?php echo HOST; ?>/public/company/createCompany.css">
</head>


<div class="content">
    
</div>


<div class="main">
 <form class="create_entrep" id="myform" method="POST" > <!-- action="Entreprises_accueil.php" -->
    <h1>Créer une entreprise</h1>
    <div class="company">
        <h2>Nom de l'entreprise</h2>
        <input type="text" name="nom" id="form_input" required>
    </div>

    <h2>Secteur d'activité</h2>
<div class="activite">
    <div id="secteur-container">
        <select name="secteur[]" class="comboboxSecteur" id="comboboxSecteur" required>
        </select>
    </div>
</div>

<h2>Localité</h2>
<div class="localite">
    <div id="localite-container">
        <select name="localite[]" class="comboboxVille" id="comboboxVille" required>
        </select>
    </div>
    <input type="button" value="+" id="ville">
</div>


<div class="note">
    <h2>Note</h2>
    <div class="rating" data-rating="3">
    <input type="hidden" id="rating-value" name="rating-value" value="0">
  <span class="star" data-value="1">&#9733;</span>
  <span class="star" data-value="2">&#9733;</span>
  <span class="star" data-value="3">&#9733;</span>
  <span class="star" data-value="4">&#9733;</span>
  <span class="star" data-value="5">&#9733;</span>
    </div>
    </div>
    <div class="submit">
        <button type="submit" id="submit_btn">Soumettre</button>
    </div>
</form>
<script src="<?php echo HOST; ?>/public/company/fillCombobox.js"></script>
<script src="<?php echo HOST; ?>/public/company/createCompany.js"></script>

</div>
