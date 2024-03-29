// Définition d'une fonction asynchrone pour permettre l'utilisation de await à l'intérieur
/*
Le navigateur envoie une requête POST à l'URL spécifiée.
Le navigateur attend la réponse du serveur.
Pendant ce temps, le code JavaScript est suspendu, ce qui signifie qu'il attend également la réponse du serveur.
Une fois que le serveur a répondu, le navigateur reprend l'exécution du code JavaScript.
Si la requête est réussie, elle renvoie un objet Response contenant les données de la réponse. Si la requête échoue, elle lance une erreur.
*/

ROOT = 'https://stagetier.fr';

document.addEventListener("DOMContentLoaded", function() {

    // Récupérer les éléments du DOM
    let id_entreprise = document.getElementById('idStudent').getAttribute('idStudent');

    // Récupérer les éléments du DOM
    const nom = document.getElementById('nom');
    const prenom = document.getElementById('prenom');
    const mail = document.getElementById('mail');
    const centre = document.getElementById('comboboxVille');
    const promotion = document.getElementById('comboboxPromo');

    // Vérifier si id_entreprise est un nombre valide
    if (isNaN(id_entreprise) || id_entreprise <= 0) {
        console.error('ID d\'élève invalide.');
        return;
    }

    fetch(`${ROOT}/ApiManager/student/selectStudent/${id_entreprise}`)
        .then(response => response.json())
        .then(data => {
          // Remplir le formulaire avec les données de l'entreprise
          console.log(data);
          nom.value = data[0].nom_student;
          mail.value = data[0].mail_student;
          prenom.value = data[0].prenom_student;
          centre.value = data[0].id_centre;
          promotion.value = data[0].nom_promotion;
            
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données de l\'étudiant : ', error);
        });

    document.getElementById('myform').addEventListener('submit', (event) => {
        event.preventDefault();

        // Récupérer les valeurs des champs de formulaire
        let newNom = nom.value;
        let newMail = mail.value ;
        let newPrenom = prenom.value;
        let newCentre = centre.value ;
        let newPromotion = promotion.value;

        // Vérifier si aucun secteur n'a été sélectionné
        if (newCentre == "x" || newPromotion == 'x') {
            event.preventDefault();
            alert('Erreur: Veuillez sélectionner un secteur.');
            return false;
        }
        
        // Envoyer une requête fetch pour chaque valeur de ville_nom
        fetch(`${ROOT}/ApiManager/student/editStudent/${id_entreprise}/${newNom}/${newPrenom}/${newMail}/${newCentre}/${newPromotion}`)
            .then(response => {
                if (response.ok) {
                    // Rediriger l'utilisateur en cas de succès
                    window.location.href = `${ROOT}/student/`;
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


// -------------------------bouton.js-------------------------//
async function confirmerSuppression(idEntreprise) {

    ROOT = 'http://stagetier.fr';
  
    if (confirm("Voulez-vous vraiment rendre l'étudiant invisble ?")) {
      try {
        const url = `${ROOT}/ApiManager/student/deleteStudent/${idEntreprise}`;
        const response = await fetch(url);
        if (response.ok) {
          console.log('Etudiant rendue invisible');
          window.location.reload();
        } else {
          // Si la réponse n'est pas dans la plage 2 00-299, affichez une erreur
          alert("Erreur.");
          throw new Error('Réponse réseau non ok');
        }
      } catch (error) {
        console.error('Erreur:', error);
        alert("Une erreur s'est produite lors de la suppression.");
      }
    } else {
      console.log('Suppression annulée.');
      alert("Suppression annulée.");
    }
  }

  function update(idEntreprise){
    window.location.href = "/student/edit/" + idEntreprise
}

function create() {
    window.location.href = "/student/create"
}

function stats(id_student) {
  window.location.href = `/student/stats/${id_student}`
}