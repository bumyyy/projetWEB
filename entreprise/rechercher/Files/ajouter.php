<script>
function setRating(rate, target) {
  const stars = target.querySelectorAll('.star');
  stars.forEach((star, index) => {
    star.classList.remove('active'); // Réinitialiser toutes les étoiles
    if (index < rate) {
      star.classList.add('active'); // Appliquer la classe active pour "remplir" les étoiles
    }
  });
}
</script>

<?php foreach ($entreprises as $index => $entreprise){  ?>
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
        <script>setRating(<?php echo $entreprise->moyenne_evaluations; ?>, document.getElementById('rating-<?php echo $index; ?>'));</script>
        </div> 
        <div class="localité">
            <h2>Ont postulé</h2>    
            <p><?php echo $entreprise->nb_stagiaires_postules ?></p>
        </div>
        
    </div>

    <div class="mod">
        <span class="update"></span>
        <span class="delete"></span>
    </div>
</div>

<?php } ?>
