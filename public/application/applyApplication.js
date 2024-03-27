document.addEventListener('DOMContentLoaded', function() {

  ROOT = 'https://stagetier.fr';

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
  fetch(`${ROOT}/ApiManager/application/selectApplication/${id_entreprise}`)
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
      if (data[0].cv !== null) {
        cvInput.style.display = "none";

        cvFileName.setAttribute('href', 'https://www.youtube.com/watch?v=izGwDsrQ1eQ' + data[0].cv);
        cvFileName.textContent = data[0].cv; // Affiche le nom du fichier CV
      }

      // Gestionnaire d'événements pour détecter la sélection d'un fichier CV
    cvInput.addEventListener('onchange', function() {
      // Vérifie si un fichier a été sélectionné
      if (cvInput.files.length > 0) {
          // Récupère le nom du fichier
          let fileName = cvInput.files[0].name;
          // Affiche le nom du fichier dans le lien hypertexte
          cvFileName.textContent = fileName;
          // Définit le chemin du fichier CV comme href pour le lien hypertexte
          cvFileName.setAttribute('href', 'https://www.youtube.com/watch?v=izGwDsrQ1eQ'); // Vous pouvez définir un lien valide si nécessaire
          // Affiche le lien hypertexte
          cvFileName.style.display = "inline"; 
          alert(fileName);
      } else {
          // Si aucun fichier n'est sélectionné, masque le lien hypertexte
          cvFileName.style.display = "none";
      }
  });

    }



    let lettre = document.getElementById('lettre').value;
    console.log("lettre : " + lettre);
    
  
  })
  .catch(error => console.error('Error:', error));




  
  document.getElementById('form').addEventListener('submit', function(e) {
      e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire

      
  });

  
  });//fin du domloadcontent






function apply(idOffre){
    window.location.href = "/application/apply/" + idOffre
  }