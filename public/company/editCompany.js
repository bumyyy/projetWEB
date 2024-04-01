// Définition d'une fonction asynchrone pour permettre l'utilisation de await à l'intérieur
/*
Le navigateur envoie une requête POST à l'URL spécifiée.
Le navigateur attend la réponse du serveur.
Pendant ce temps, le code JavaScript est suspendu, ce qui signifie qu'il attend également la réponse du serveur.
Une fois que le serveur a répondu, le navigateur reprend l'exécution du code JavaScript.
Si la requête est réussie, elle renvoie un objet Response contenant les données de la réponse. Si la requête échoue, elle lance une erreur.
*/
let villesSelectionnees = [];
villesSelectionnees[0] = document.getElementById('comboboxVille').value;
ROOT = 'https://stagetier.fr';

document.addEventListener("DOMContentLoaded", function() {

    // Récupérer les éléments du DOM
    let id_entreprise = document.getElementById('idCompany').getAttribute('idCompany');

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


    // Nouvelle fonction pour ajouter un select en fonction des données de l'entreprise
    function addLocaliteSelectFromData(villes) {
      villes.forEach((ville, index) => {
          if (localiteSelectCount < 5) {
              // Effectuer la requête fetch pour récupérer les données des villes
              fetch(`${ROOT}/ApiManager/combox/city`)
                  .then(response => response.json())
                  .then(data => {
                      // Créer un nouveau select
                      const newSelect = document.createElement('select');
                      newSelect.name = 'localite[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                      newSelect.id = localiteSelectCount;
                      newSelect.classList.add('comboboxVille');

                      // Ajouter chaque localité comme option au nouveau select
                      data.forEach(v => {
                          const option = document.createElement('option');
                          option.value = v.id;
                          option.textContent = v.nom;
                          newSelect.appendChild(option);
                      });

                      // Sélectionner la ville correspondant à l'ID de l'entreprise
                      if (index === 0) {
                          const villeIndex = data.findIndex(v => v.nom.trim() === ville.trim());
                          if (villeIndex !== -1) {
                              newSelect.selectedIndex = villeIndex;
                          }
                      }

                      // Ajouter l'événement change pour mettre à jour le tableau de sélection de villes
                      newSelect.addEventListener('change', () => {
                          updateVillesSelectionnees();
                      });

                      // Ajouter le nouveau select au conteneur
                      localiteContainer.appendChild(newSelect);

                      localiteSelectCount++; // Incrémenter le compteur

                      updateVillesSelectionnees();

                       // Mettre à jour l'affichage du bouton moins
                      updateMoinsButtonDisplay(); // Ajoutez cette ligne pour mettre à jour le bouton "-"
                  })
                  .catch(error => {
                      console.error('Erreur lors de la récupération des données de ville :', error);
                  });
          } else {
              alert("Vous avez atteint la limite de 5 villes.");
          }
      });
  }

  // Appeler la fonction pour récupérer et remplir les données du formulaire
  fetchDataAndPopulateForm(id_entreprise);

  function fetchDataAndPopulateForm(id_entreprise) {

  // Vérifier si id_entreprise est un nombre valide
  if (isNaN(id_entreprise) || id_entreprise <= 0) {
      console.error('ID d\'entreprise invalide.');
      return;
  }

  fetch(`${ROOT}/ApiManager/Company/selectCompany/${id_entreprise}`)
      .then(response => response.json())
      .then(data => {
          // Remplir le formulaire avec les données de l'entreprise
          console.log(data);
          document.getElementById('form_input').value = data[0].nom_entreprise;
          
          // Sélectionner le secteur d'activité dans le menu déroulant
          const secteurSelect = document.getElementById('comboboxSecteur');
          const secteurNom = data[0].secteur_activite;

          console.log("Secteur récupéré : ", secteurNom);
          for (let i = 0; i < secteurSelect.options.length; i++) {
              console.log("Option ", i, ": ", secteurSelect.options[i].textContent);
              if (secteurSelect.options[i].textContent.trim() === secteurNom.trim()) {
                  secteurSelect.selectedIndex = i;
                  console.log("Option sélectionnée : ", secteurSelect.options[i].textContent);
                  break;
              }
          }

          // Récupérer les villes de l'entreprise
          const villes = data[0].ville.split(',').map(ville => ville.trim());
          const localiteSelect = document.getElementById('comboboxVille');

          if (villes.length === 1) {
              // Cas où il y a une seule ville
              console.log("Ville récupérée : ", villes[0]);
              for (let i = 0; i < localiteSelect.options.length; i++) {
                  console.log("Option ", i, ": ", localiteSelect.options[i].textContent);
                  if (localiteSelect.options[i].textContent.trim() === villes[0].trim()) {
                      localiteSelect.selectedIndex = i;
                      console.log("Option sélectionnée : ", localiteSelect.options[i].textContent);
                      // Ajouter la seule ville à villesSelectionnees
                      updateVillesSelectionnees();
                  }
              }
          } else {
              // Cas où il y a plusieurs villes
              // Remplir le premier select avec la première ville
              for (let i = 0; i < localiteSelect.options.length; i++) {
                  if (localiteSelect.options[i].textContent.trim() === villes[0].trim()) {
                      localiteSelect.selectedIndex = i;
                      break;
                  }
              }

              // Ajouter des selects supplémentaires pour les villes restantes
              for (let i = 1; i < villes.length; i++) {
                  addLocaliteSelectFromData([villes[i]]); // Envoyer une liste avec une seule ville
              }
          }

          // Mettre à jour la moyenne des évaluations et colorer les étoiles
          const moyenneEvaluations = parseFloat(data[0].moyenne_evaluations);
          document.getElementById('rating-value').value = moyenneEvaluations;
          highlightStars(moyenneEvaluations);
          isRatingSelected = true;

      })
      .catch(error => {
          console.error('Erreur lors de la récupération des données de l\'entreprise : ', error);
      });
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
                star.style.color = '#e4e5e9'; // Change color to gray
            }
        });
    }
    
    document.getElementById('myform').addEventListener('submit', (event) => {

    // Récupérer les valeurs des champs de formulaire
    let nom_entreprise = document.getElementById('form_input').value;
    let secteur_id = document.getElementById('comboboxSecteur').value;
    let note = document.getElementById('rating-value').value;
    console.log(secteur_id, note, villesSelectionnees);

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
    fetch(`${ROOT}/ApiManager/company/editCompany/${id_entreprise}/${nom_entreprise}/${villesSelectionnees}/${secteur_id}/${note}`)
        .then(response => {
            if (response.ok) {

                // Rediriger l'utilisateur en cas de succès
                window.location.href = `/company/`;
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


