document.addEventListener('DOMContentLoaded', function() {

  ROOT = 'https://stagetier.fr';

  let id_entreprise = document.getElementById('idCompany').getAttribute('idCompany');
  let bouton = document.getElementById("submit_btn");


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
    }

    let lettre = document.getElementById('lettre').value;
    console.log("caca : " + lettre);
    
  
  })
  .catch(error => console.error('Error:', error));




  
  document.getElementById('form').addEventListener('submit', function(e) {
      e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire

      
  });

  
  });//fin du domloadcontent






function apply(idOffre){
    window.location.href = "/application/apply/" + idOffre
  }