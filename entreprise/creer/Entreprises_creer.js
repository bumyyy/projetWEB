document.addEventListener("DOMContentLoaded", function() {

// Récupérer les éléments du DOM
const selectContainer = document.getElementById('select-container');
const villeButton = document.getElementById('ville');

// Gérer l'événement click sur le bouton +
villeButton.addEventListener('click', () => {
    // Vérifier le nombre d'éléments select déjà présents
    const selects = selectContainer.querySelectorAll('select.localite-select');
    if (selects.length >= 10) {
        alert("Vous avez atteint la limite de 10 villes.");
        return; // Arrêter l'exécution si la limite est atteinte
    }

    // Créer un nouveau select
    const newSelect = document.createElement('select');
    newSelect.name = 'localite[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
    newSelect.classList.add('localite-select');

    // Ajouter le nouveau select au conteneur
    selectContainer.appendChild(newSelect);

    // Créer un nouvel input pour le bouton +
    const newButton = document.createElement('input');
    newButton.type = 'button';
    newButton.value = '+';
    newButton.id = 'ville'; // Garder le même ID pour l'événement click

    // Ajouter un gestionnaire d'événements pour le nouvel input
    newButton.addEventListener('click', () => {
        newSelect.focus(); // Focaliser le nouveau select après avoir ajouté le bouton
    });

    // Ajouter le nouvel input au conteneur
    selectContainer.appendChild(newButton);
});

// Afficher le bouton + après le chargement de la page
villeButton.style.display = 'block';




    const stars = document.querySelectorAll('.star');
      const ratingValue = document.getElementById('rating-value');
    
      stars.forEach(star => {
        star.addEventListener('click', () => {
          const value = parseInt(star.getAttribute('data-value'));
          ratingValue.value = value;
          highlightStars(value);
        });
      });
    
      function highlightStars(value) {
        stars.forEach(star => {
          const starValue = parseInt(star.getAttribute('data-value'));
          if (starValue <= value) {
            star.style.color = '#ffc107'; // Change color to yellow
          } else {
            star.style.color = '#e4e5e9'; // Change color to gray
          }
        });
      }
    
      document.getElementById("myform").addEventListener("submit", function(event) {
        event.preventDefault();
    });
    });




