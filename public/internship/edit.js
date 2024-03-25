let villesSelectionnees = [];
villesSelectionnees[0] = document.getElementById('comboboxSecteur').value;

ROOT = 'http://stagetier.fr';

document.addEventListener("DOMContentLoaded", function() {

    // Récupérer les éléments du DOM
    let id_entreprise = document.getElementById('idCompany').getAttribute('idCompany');

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
            fetch(`${ROOT}/ApiManager/combox/skill`)
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


    // Nouvelle fonction pour ajouter un select en fonction des données de l'entreprise
    function addLocaliteSelectFromData(villes) {
      villes.forEach((ville, index) => {
          if (localiteSelectCount < 5) {
              // Effectuer la requête fetch pour récupérer les données des villes
              fetch(`${ROOT}/ApiManager/combox/skill`)
                  .then(response => response.json())
                  .then(data => {
                      // Créer un nouveau select
                      const newSelect = document.createElement('select');
                      newSelect.name = 'secteur[]'; // Utiliser un tableau dans le nom pour permettre la soumission multiple
                      newSelect.id = localiteSelectCount;
                      newSelect.classList.add('comboboxSecteur');

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

    fetch(`${ROOT}/ApiManager/Internship/selectInternship/${id_entreprise}`)
        .then(response => response.json())
        .then(data => {
            // Remplir le formulaire avec les données de l'entreprise
            console.log(data);
            document.getElementById('nom').value = data[0].nom_offre;
            document.getElementById('promo').value = data[0].type_promotion_concerne;
            document.getElementById('dateDebut').value = data[0].date_debut_offre;
            document.getElementById('dateFin').value = data[0].date_fin_offre;
            document.getElementById('prix').value = data[0].remuneration_base;
            document.getElementById('place').value = data[0].nombre_places_offertes;
            
            // Sélectionner les menu déroulant
            const ville_vrai = document.getElementById('comboboxVille');

            for (let i = 0; i < ville_vrai.options.length; i++) {
                console.log("Option ", i, ": ", ville_vrai.options[i].textContent);
                if (ville_vrai.options[i].textContent.trim() === data[0].nom_ville.trim()) {
                    ville_vrai.selectedIndex = i;
                    break;
                }
            }
            // Utilisation de la fonction `getDataApi` avec une fonction de rappel pour sélectionner l'option désirée
            const villeId = document.getElementById('comboboxVille').value;
            const nomEntreprise = data[0].nom_entreprise;
            getDataApiSelect(`${ROOT}/ApiManager/combox/company/${villeId}`, 'entreprise', 'entreprise', 
                (updatedSelect) => {
                    for (let i = 0; i < updatedSelect.options.length; i++) {
                        console.log('test', updatedSelect.options[i].textContent.trim(), nomEntreprise.trim());
                        if (updatedSelect.options[i].textContent.trim() === nomEntreprise.trim()) {
                            updatedSelect.selectedIndex = i;
                            break;
                        }
                    }
                });
            
          // Récupérer les villes de l'entreprise
          const villes = data[0].competences_requises.split(',').map(ville => ville.trim());
          const localiteSelect = document.getElementById('comboboxSecteur');

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

      })
      .catch(error => {
          console.error('Erreur lors de la récupération des données de l\'entreprise : ', error);
      });

      
  }
  

    document.getElementById('comboboxVille').addEventListener('change', function() {
        idCity = document.getElementById('comboboxVille').value;
        getDataApi(`${ROOT}/ApiManager/combox/company/${idCity}`, 'entreprise', 'entreprise');
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
    
    // Vérifier si aucun secteur n'a été sélectionné
    if (localite == "x", villesSelectionnees[0] == "",  promo == "x") {
        event.preventDefault();
        alert('Erreur: Veuillez sélectionner.');
        return false;
    }

    // Envoyer une requête fetch pour chaque valeur de ville_nom
    fetch(`${ROOT}/ApiManager/internship/edit/${id_entreprise}/${villesSelectionnees}/${nom}/${entreprise}/${localite}/${promo}/${dateDebut}/${dateFin}/${prix}/${place}`)
        .then(response => {
            if (response.ok) {
                // Rediriger l'utilisateur en cas de succès
                //window.location.href = `${ROOT}/internship`;
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

