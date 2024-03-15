let villesSelectionnees = [];
villesSelectionnees[0] = document.getElementById('localite-select').value;  

document.addEventListener("DOMContentLoaded", function() {
    // Récupérer les éléments du DOM
    const secteurContainer = document.getElementById('secteur-container');
    const secteurButton = document.getElementById('secteur');
    const localiteContainer = document.getElementById('localite-container');
    const villeButton = document.getElementById('ville');

    // Variables pour suivre le nombre de sélections
    let localiteSelectCount = 0;

    // Gérer l'événement click sur le bouton + pour la localité
    villeButton.addEventListener('click', () => {
        // Incrémenter le compteur
        localiteSelectCount++;
        addLocaliteSelect();
    });

    // Fonction pour ajouter un nouveau select pour la localité
    function addLocaliteSelect() {
        if (localiteSelectCount < 4) {
            fetch('/api/index.php?demande=combox/country')
                .then(response => response.json())
                .then(data => {
                    // Créer un nouveau select
                    const newSelect = document.createElement('select');
                    newSelect.name = 'localite[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                    newSelect.id = localiteSelectCount;
                    newSelect.classList.add('localite-select');
    
                    // Ajouter chaque localité comme option au nouveau select
                    data.forEach(ville => {
                        const option = document.createElement('option');
                        option.value = ville.id;
                        option.textContent = ville.nom;
                        newSelect.appendChild(option);
                    });

                    // Ajouter l'événement change pour mettre à jour le tableau de sélection de villes
                    newSelect.addEventListener('change', () => {
                        updateVillesSelectionnees();
                    });
    
                    // Ajouter le nouveau select au conteneur
                    localiteContainer.appendChild(newSelect);

                    updateVillesSelectionnees();
    
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des localités :', error);
                });
        } else {
            alert("Vous avez atteint la limite de 5 villes.");
        }
    }

    // Fonction pour mettre à jour le tableau des sélections de villes
    function updateVillesSelectionnees() {
        villesSelectionnees = [];
        const selects = document.querySelectorAll('.localite-select');
        selects.forEach(select => {
            if (select.value !== "") {
                villesSelectionnees.push(select.value); // Ajouter la valeur du select au tableau si elle est sélectionnée
            }            
        });
        return villesSelectionnees;
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
    
        document.getElementById('myform').addEventListener('submit', (event) => {
        if (!isRatingSelected) {
            event.preventDefault(); // Empêcher la soumission du formulaire si aucune note n'a été sélectionnée
            alert('Veuillez sélectionner une note.'); // Afficher un message d'erreur
            return false;
        } 

        event.preventDefault();

        // Récupérer les valeurs des champs de formulaire
        let nom_entreprise = document.getElementById('form_input').value;
        let secteur_nom = document.getElementById('secteur-select').value;
        let note = document.getElementById('rating-value').value;

        // Envoyer une requête fetch pour chaque valeur de ville_nom
        fetch(`/api/index.php?demande=company/create/${nom_entreprise}/${villesSelectionnees}/${secteur_nom}/${note}`)
            .then(response => {
                if (response.ok) {
                    // Rediriger l'utilisateur en cas de succès
                    window.location.href = "/pages/entreprise/rechercher/Entreprises_rechercher.php?success=1";
                } else {
                    // Traiter les erreurs éventuelles
                    console.error('Erreur lors de la requête fetch : ', response.statusText);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la requête fetch : ', error);
            });
    });
});