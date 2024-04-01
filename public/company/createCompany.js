let villesSelectionnees = [];
villesSelectionnees[0] = document.getElementById('comboboxVille').value;
ROOT = 'https://stagetier.fr';

document.addEventListener("DOMContentLoaded", function() {
    // Récupérer les éléments du DOM
    const localiteContainer = document.getElementById('localite-container');
    const villeButton = document.getElementById('ville');

    // Variables pour suivre le nombre de sélections
    let localiteSelectCount = 0;

    // Gérer l'événement click sur le bouton + pour la localité
    villeButton.addEventListener('click', () => {
        addLocaliteSelect();
    });

    // Fonction pour ajouter un nouveau select pour la localité
    function addLocaliteSelect() {
        if (localiteSelectCount < 4) {
            fetch(`${ROOT}/ApiManager/combox/city`)
                .then(response => response.json())
                .then(data => {
                    // Créer un nouveau select
                    const newSelect = document.createElement('select');
                    newSelect.name = 'localite[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                    newSelect.id = localiteSelectCount;
                    newSelect.classList.add('comboboxVille');
    
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

                    // Incrémenter le compteur
                    localiteSelectCount++;

                    // Mettre à jour l'affichage du bouton moins
                    updateMoinsButtonDisplay();

    
                })
                .catch(error => {
                    console.error('Erreur lors de la récupération des localités :', error);
                });
        } else {
            alert("Vous avez atteint la limite de 5 villes.");
        }
    }

    localiteContainer.addEventListener('change', () => {
        updateVillesSelectionnees();
    });

    // Fonction pour mettre à jour le tableau des sélections de villes
    function updateVillesSelectionnees() {
        villesSelectionnees = [];
        const selects = document.querySelectorAll('.comboboxVille');
        selects.forEach(select => {
            if (select.value !== "") {
                villesSelectionnees.push(select.value); // Ajouter la valeur du select au tableau si elle est sélectionnée
            }            
        });
        return villesSelectionnees;
    }

    // Afficher le bouton + après le chargement de la page
    villeButton.style.display = 'block';

    const moinsButton = document.getElementById('moins'); // Sélectionnez le bouton moins
    moinsButton.style.display = "none";

    // Gérer l'événement click sur le bouton -
    moinsButton.addEventListener('click', () => {
        localiteSelectCount--; // Décrémentez le compteur
        removeLocaliteSelect(); // Supprimer le select localité
    });

    // Fonction pour supprimer un select de localité
    function removeLocaliteSelect() {
        const selectToRemove = document.getElementById(localiteSelectCount); // Sélectionnez le dernier select ajouté
        if (selectToRemove) {
            console.log("Sélecteur à supprimer : ", selectToRemove);
            selectToRemove.remove(); // Supprimez-le s'il existe

            // Mettre à jour l'affichage du bouton moins
            updateMoinsButtonDisplay();

            // Mettre à jour les villes sélectionnées
            updateVillesSelectionnees();
        }
    }

    // Fonction pour mettre à jour l'affichage du bouton moins
    function updateMoinsButtonDisplay() {
        // Désactiver le bouton - s'il ne reste qu'un seul select (celui de base)
        if (localiteSelectCount < 1) {
            moinsButton.style.display = "none";
        } else {
            moinsButton.style.display = "block";
        }
    }



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
                star.style.color = 'rgb(180, 180, 180 )'; // Change color to gray
            }
        });
        let nom_entreprise = document.getElementById('form_input').value;
    let secteur_id = document.getElementById('comboboxSecteur').value;
    let note = document.getElementById('rating-value').value;
    let idUser = document.getElementById('userData').getAttribute('data-user');  
    console.log("Données :", nom_entreprise, secteur_id, note, villesSelectionnees, idUser);
    }
    
    document.getElementById('myform').addEventListener('submit', (event) => {

    // Récupérer les valeurs des champs de formulaire
    let nom_entreprise = document.getElementById('form_input').value;
    let secteur_id = document.getElementById('comboboxSecteur').value;
    let note = document.getElementById('rating-value').value;
    let idUser = document.getElementById('userData').getAttribute('data-user');  
    console.log("Données :", nom_entreprise, secteur_id, note, villesSelectionnees, idUser);
    const secteurSelect = document.getElementById('comboboxSecteur');
    
    if (!isRatingSelected) {
        event.preventDefault(); // Empêcher la soumission du formulaire si aucune note n'a été sélectionnée
        alert('Veuillez sélectionner une note.'); // Afficher un message d'erreur
        return false;
    } 
    // Vérifier si aucun secteur n'a été sélectionné
    if (secteurSelect.value == "x") {
        event.preventDefault();
        alert('Erreur: Veuillez sélectionner un secteur.');
        return false;
    }
    
    // Vérifier si aucun select de ville n'a été sélectionné
    if (villesSelectionnees[0] == "") {
        event.preventDefault();
        alert('Erreur: Veuillez sélectionner une ville.');
        return false;
    }

    // Envoyer une requête fetch pour chaque valeur de ville_nom
    fetch(`${ROOT}/ApiManager/company/addCompany/${nom_entreprise}/${villesSelectionnees}/${secteur_id}/${note}/${idUser}`)
        .then(response => {
            if (response.ok) {
                // Rediriger l'utilisateur en cas de succès
                window.location.href = `/company`;
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
    