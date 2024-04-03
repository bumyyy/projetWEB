document.addEventListener('DOMContentLoaded', function() {

  let id_entreprise = document.getElementById('idCompany').getAttribute('idCompany');
  let bouton = document.getElementById("submit_btn");
  let cvInput = document.getElementById('cv');
  let cvFileName = document.getElementById('cvFileName');


  // Récupérer les éléments du DOM


  // Vérifier si id_entreprise est un nombre valide
  if (isNaN(id_entreprise) || id_entreprise <= 0) {
      console.error('ID d\'entreprise invalide.');
      return;
  }
  fetch(`/ApiManager/application/selectApplication/${id_entreprise}`)
  .then(response => response.json())
  .then(data => {
      // Remplir le formulaire avec les données de l'entreprise
      console.log(data);
      console.log("id_offre : " + id_entreprise);

    document.getElementById('offerName').innerHTML = data[0].nom_offre + ' - ' + data[0].nom_entreprise;
    document.getElementById('details').innerHTML = 'Compétences : ' + data[0].competences_requises;
    document.getElementById('notabene').innerHTML = 'Promotion : ' + data[0].nom_promotion + '  /   Ville : ' + data[0].nom_ville;
    document.getElementById('duration').innerHTML = 'Début : ' + data[0].date_debut_offre + '  /  Fin : ' + data[0].date_fin_offre + '  /  Durée : ' + data[0].duree_mois_stage + ' mois';
    document.getElementById('numbers').innerHTML = 'Rémunération : ' + data[0].remuneration_base + ' €  /  Places restantes : ' + data[0].nombre_places_restantes;
    document.getElementById('lettre').innerHTML = data[0].lettre_motivation;

    if (data[0].etat_candidature == null) {
      bouton.style.display = "block";
    } else {
      bouton.style.display = "none";

      // Si un CV est présent, affiche le nom du fichier dans un élément séparé
      if (data[0].cv === "CV contenu ici") {
        cvInput.style.display = "none";
        cvFileName.setAttribute('href', 'https://c.tenor.com/yEG23sxXIVQAAAAC/tenor.gif' + data[0].cv);
        cvFileName.textContent = data[0].cv; // Affiche le nom du fichier CV
      } else if (data[0].cv !== "") {
        cvInput.style.display = "none";
        cvFileName.setAttribute('href', '/uploads/' + data[0].cv);
        cvFileName.textContent = data[0].cv; // Affiche le nom du fichier CV
      }

  
    }   
  
  })
  .catch(error => console.error('Error:', error));

  
  document.getElementById('myform').addEventListener('submit', function(e) {
      e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire

      // envoi en js du formulaire
      let cv_input = document.querySelector('input[type="file"]');
      let lettre_input = document.getElementById('lettre');
      if (typeof(cv_input.files[0]) === "undefined") {
        alert("Un CV doit être fourni pour pouvoir envoyer votre CV");
        return false;
      }
   
      let data = new FormData();
      data.append('cv', cv_input.files[0]);
      data.append('lettre', lettre_input.value);
      console.log(data);

      fetch(`/ApiManager/application/submitApplication/${id_entreprise}/${cv_input.files[0].name}/${lettre_input.value}`, {
        method: 'POST',
        body: data
      })
      alert("Votre candidature a bien été envoyé");
      window.location.href = "/application/";
      return false;
  });

  
  });//fin du domloadcontent


function apply(idOffre){
    window.location.href = "/application/apply/" + idOffre
  }