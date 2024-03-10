document.addEventListener("DOMContentLoaded", function() {
    // Récupérer les éléments du DOM
    const secteurContainer = document.getElementById('secteur-container');
    const secteurButton = document.getElementById('secteur');
    const localiteContainer = document.getElementById('localite-container');
    const villeButton = document.getElementById('ville');

    // Gérer l'événement click sur le bouton + pour le secteur d'activité
    secteurButton.addEventListener('click', () => {
        addSecteurSelect();
    });

    // Gérer l'événement click sur le bouton + pour la localité
    villeButton.addEventListener('click', () => {
        addLocaliteSelect();
    });

    // Fonction pour ajouter un nouveau select pour le secteur d'activité
    function addSecteurSelect() {
        // Appeler votre API pour obtenir les données des secteurs d'activité
        fetch('/api/index.php?demande=combox/secteur')
            .then(response => response.json())
            .then(data => {
                // Créer un nouveau select
                const newSelect = document.createElement('select');
                newSelect.name = 'secteur[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                newSelect.classList.add('secteur-select');

                // Ajouter chaque secteur d'activité comme option au nouveau select
                data.forEach(secteur => {
                    const option = document.createElement('option');
                    option.value = secteur.id;
                    option.textContent = secteur.nom;
                    newSelect.appendChild(option);
                });

                // Ajouter le nouveau select au conteneur
                secteurContainer.appendChild(newSelect);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des secteurs d\'activité :', error);
            });
    }

    // Fonction pour ajouter un nouveau select pour la localité
    function addLocaliteSelect() {
        // Appeler votre API pour obtenir les données des localités
        fetch('/api/index.php?demande=combox/ville')
            .then(response => response.json())
            .then(data => {
                // Créer un nouveau select
                const newSelect = document.createElement('select');
                newSelect.name = 'localite[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                newSelect.classList.add('localite-select');

                // Ajouter chaque localité comme option au nouveau select
                data.forEach(ville => {
                    const option = document.createElement('option');
                    option.value = ville.id;
                    option.textContent = ville.nom;
                    newSelect.appendChild(option);
                });

                // Ajouter le nouveau select au conteneur
                localiteContainer.appendChild(newSelect);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des localités :', error);
            });
    }

    // Afficher le bouton + après le chargement de la page
    villeButton.style.display = 'block';

    // Gérer les étoiles de notation
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('rating-value');
    let isRatingSelected = false; // Variable pour vérifier si une note a été sélectionnée

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));
            ratingValue.value = value;
            highlightStars(value);
            isRatingSelected = true; // Mettre à jour la variable pour indiquer qu'une note a été sélectionnée
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

    // Gérer la soumission du formulaire
    const form = document.querySelector('form');

    form.addEventListener('submit', (event) => {
        if (!isRatingSelected) {
            event.preventDefault(); // Empêcher la soumission du formulaire si aucune note n'a été sélectionnée
            alert('Veuillez sélectionner une note.'); // Afficher un message d'erreur
        }
    });

});

