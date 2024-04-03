let villesSelectionnees = [];

document.addEventListener("DOMContentLoaded", function() {
    
    villesSelectionnees[0] = document.getElementById('comboboxSecteur').value;

    // Récupérer les éléments du DOM
    const localiteContainer = document.getElementById('secteur-container');
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
            fetch(`/ApiManager/combox/skill`)
                .then(response => response.json())
                .then(data => {
                    // Créer un nouveau select
                    const newSelect = document.createElement('select');
                    newSelect.name = 'secteur[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                    newSelect.id = localiteSelectCount;
                    newSelect.classList.add('comboboxSecteur');
    
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
        const selects = document.querySelectorAll('.comboboxSecteur');
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

    document.getElementById('comboboxVille').addEventListener('change', function() {
        idCity = document.getElementById('comboboxVille').value;
        getDataApi(`/ApiManager/combox/company/${idCity}`, 'entreprise', 'entreprise');
    })
    
    document.getElementById('myform').addEventListener('submit', (event) => {
    event.preventDefault();

    // Récupérer les valeurs des champs de formulaire
    let nom = document.getElementById('nom').value;
    let localite = document.getElementById('comboboxVille').value;
    let competence = document.getElementById('comboboxSecteur').value;
    let promo = document.getElementById('promo').value;
    let dateDebut = document.getElementById('dateDebut').value;
    let dateFin = document.getElementById('dateFin').value;
    let prix = document.getElementById('prix').value;
    let entreprise = document.getElementById('entreprise').value;
    let place = document.getElementById('place').value;
    let idUser = document.getElementById('userData').getAttribute('data-user');  
    
    // Vérifier si aucun secteur n'a été sélectionné
    if (localite == "x", villesSelectionnees[0] == "",  promo == "x") {
        event.preventDefault();
        alert('Erreur: Veuillez sélectionner.');
        return false;
    }

    // Envoyer une requête fetch pour chaque valeur de ville_nom
    fetch(`/ApiManager/internship/addInternship/${villesSelectionnees}/${nom}/${entreprise}/${localite}/${promo}/${dateDebut}/${dateFin}/${prix}/${place}`)
        .then(response => {
            if (response.ok) {
                // Rediriger l'utilisateur en cas de succès
                window.location.href = `/internship`;
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
