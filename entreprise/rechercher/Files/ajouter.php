<script src="http://stagetier.fr/entreprise/rechercher/Files/ajouter.js"></script>

<?php 
header('Access-Control-Allow-Origin: http://stagetier.fr');
foreach ($entreprises as $index => $entreprise){  ?>
<div class="ligne">
    <div class="carre">
        <div class="name">
            <h1><?php echo $entreprise->nom_entreprise?></h1>
            <p><?php echo $entreprise->secteur_activite?></p>
        </div>
        <div class="localité">
            <h2>Localité</h2>
            <p><?php echo $entreprise->ville?></p>
        </div>
        <div class="localité">
            <h2>Note</h2>
            <div class="rating" id="rating-<?php echo $index; ?>">
            <span data-value="5" class="star"></span>
            <span data-value="4" class="star"></span>
            <span data-value="3" class="star"></span>
            <span data-value="2" class="star"></span>
            <span data-value="1" class="star"></span>
        </div>
        </div> 
        <script>highlightStars(<?php $entreprise->moyenne_evaluations?>);</script>
        <div class="localité">
            <h2>Ont postulé</h2>    
            <p><?php echo $entreprise->nb_stagiaires_postules ?></p>
        </div>
        
    </div>

    <?php
    if ($_SESSION['loggedin'][2] != 1){ ?>
    <div class="mod">
        <span class="update"></span>
        <span onclick="confirmerSuppression('<?php echo $entreprise->id_entreprise; ?>');" class="delete"></span>
    </div>
    <?php }?>

</div>
<?php } ?>
