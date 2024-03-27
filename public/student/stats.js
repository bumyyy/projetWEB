let tab_donne = [];
ROOT = 'https://stagetier.fr';

document.addEventListener('DOMContentLoaded', function() {


const id_student=window.location.href.split('/').pop();

    function nbStage(){ 
        let URL =`https://stagetier.fr/ApiManager/student/statNbCandidacy/${id_student}`;
        fetch(URL)
        .then(response => {
            if (!response.ok) {
              throw new Error('La requête a échoué avec le code: ' + response.status);
            }
            return response.json();
          })
          .then(data => {
          document.getElementById("nombreC").textContent = data[0].nombre_de_candidatures;
          })
          .catch(error => {
            console.error('Une erreur s\'est produite:', error);
          });
    }
    nbStage(); 

    let tableau_couleurs = ['rgb(246, 100, 100)', 'rgb(230, 190, 117)', 'rgb(125, 180, 125)'];            let couleurs=[];
    
    
    function nbRefusal(){
      let URL =`https://stagetier.fr/ApiManager/student/statNbRefusal/${id_student}`;
      fetch(URL)
      .then(response => {
          if (!response.ok) {
            throw new Error('La requête a échoué avec le code: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          let table = [];
          if(data == null || data == ""){
            table.push(0);
          } else {
            table.push(data[0].nombre);
          }
        nbWaiting(table);
        })
        .catch(error => {
          console.error('Une erreur s\'est produite:', error);
        });
    }
    nbRefusal();


    function nbWaiting(table){
      let URL =`https://stagetier.fr/ApiManager/student/statNbWaiting/${id_student}`;
      fetch(URL)
      .then(response => {
          if (!response.ok) {
            throw new Error('La requête a échoué avec le code: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          
          if(data == null || data == ""){
            table.push(0);
          } else {
            table.push(data[0].nombre);
          }
          
        nbAdmission(table);
        })
        .catch(error => {
          console.error('Une erreur s\'est produite:', error);
        });
    }


    function nbAdmission(table){
      let URL =`https://stagetier.fr/ApiManager/student/statNbAdmission/${id_student}`;
      fetch(URL)
      .then(response => {
          if (!response.ok) {
            throw new Error('La requête a échoué avec le code: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          
          if(data == null || data == ""){
            table.push(0);
          } else {
            table.push(data[0].nombre);
          }
          Localité(table, tableau_couleurs);
        })
        .catch(error => {
          console.error('Une erreur s\'est produite:', error);
        });
    }

function candidatures(){
  let URL_ = `${ROOT}/ApiManager/application/allApplication/`;
            
        fetch(URL_)
        .then(response => response.json())
        .then(data => {
            let userType = data.userType;
            let tabnote = [];
            let etatCandidatureTexte = '';
            

            data.forEach ((candidature) => {
                tabnote.push(candidature.etat_candidature);

                switch (candidature.etat_candidature) {
                    case 0:
                        etatCandidatureTexte = "En attente";
                        break;
                    case 1:
                        etatCandidatureTexte = "Accepté / En cours";
                        break;
                    case 2:
                        etatCandidatureTexte = "Refusé";
                        break;
                    case 3:
                        etatCandidatureTexte = "Terminé";
                        break;
                    case null:
                        etatCandidatureTexte = "Pas candidaté";
                        break;
                    default:
                        etatCandidatureTexte = "État inconnu";
                        break;
                }


                let html =
                "<div class='completeEntreprise'>" +
                "<li class='ligne' id='"+candidature.id_offre+"'>" +
                "    <div class='carre' onclick='toggleSubdivision(this)'>" +
                "        <div class='name'>" +
                "            <h1 id='entrepriseName'>"+candidature.nom_offre+"</h1>" +
                "            <p>"+candidature.nom_entreprise+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>"+candidature.nom_ville+"</h2>" +
                "            <p title='competences' class='scroll'>"+candidature.competences_requises+"</p>" +
                "        </div>" +
                "        <div class='secteur'>" +
                "            <h2>"+candidature.nom_promotion+"</h2>" +
                "            <p title='début stage'>"+candidature.date_debut_offre+"</p>" +
                "            <p title='fin stage'>"+candidature.date_fin_offre+"</p>" +
                "        </div>"+
                "        <div class='localité'>"+
                "            <h2 title='rémuneration'>"+Math.round(candidature.remuneration_base)+"€</h2>"+
                "            <p title='durée stage'>"+candidature.duree_mois_stage+"mois</p>"+
                "          <p>"+candidature.nombre_places_restantes+" place(s) restante(s)</p>"+
                "        </div>"+ 
                "        <div class='localité'>"+
                "            <h2 title='places offertes'>"+candidature.nombre_places_offertes+"place(s)</h2>"+
                "            <p  title='étudiant(s) ayant déja postulé'>"+candidature.nombre_etudiants_postules+" étudiant(s) ayant postulé</p>"+
                "            <p>"+etatCandidatureTexte+"</p>"+
                "        </div>"+        
       /*         "<div id='myModal' class='popdown'>"+
                "<div class='fermer'><button id='closebtn'>x</button></div>"+
                "<div class='name_popup'>"+
                "<h1>"+stage.nom_entreprise+"</h1>"+
                "<p>"+stage.secteur_activite+"</p>"+
                "</div>"+
                "<div class='localité_popup'>"+
                "<h2>Localité</h2>"+
                "<p>"+stage.ville+"</p>"+
                "</div>"+
                "<div class='secteur_popup'>"+
                "<h2>Note</h2>"+
                "<div class='rating' data-rating='3'>"+
                    "<input type='hidden' id='rating-value' name='rating-value' value='0'>"+
                    "<span class='star' data-value='5'>&#9733;</span>"+
                    "<span class='star' data-value='4'>&#9733;</span>"+
                    "<span class='star' data-value='3'>&#9733;</span>"+
                    "<span class='star' data-value='2'>&#9733;</span>"+
                    "<span class='star'' data-value='1'>&#9733;</span>"+
                "</div>"+
                "<div class='note' id='note'>0</div>"+
                "</div>"+
                "<p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam fermentum urna ac metus varius, sit amet auctor nulla mollis. Integer eu elit velit.</p>"+
                "<div class='lien_popup'>"+
                "<a href='https://stagetier.fr/pages/stages'>rechercher entreprise dans stage</a>"+
                "</div>"+
                "</div>"+


                */
                "    </div>";
                
                if (userType != 2){
                html +=
                "   <div class='mod'>"+
                "   <div class='bord'>"+
                "       <span class='heart' data-value='" + candidature.id_stage_aimé + "' data-id='" + candidature.id_offre + "'>&#9829;</span>" +
                        "<input type='hidden' id='rating-value' name='rating-value' value='0'>"+
                "       <span onclick=apply("+candidature.id_offre+") class='post'></span>"+      
                "   </div>";
                "   </div>";
                };
                html +=
                "</div>"+
                "</div>";

                
                document.getElementById('main').innerHTML += html;

                // Trouver le dernier cœur ajouté qui correspond à cette candidature et le colorier
                let favorite = document.querySelector('.heart[data-id="' + candidature.id_offre + '"]');
                if (candidature.id_stage_aimé != null) {
                    favorite.style.color = '#fe8bb2'; // Colorier en rose si l'offre est dans 'aimer'
                } else {
                    favorite.style.color = '#e4e5e9'; // Sinon, colorier en gris
                }
              });
                
            });
}
candidatures();




})//fin du DOM





function Localité(valeurs, couleurs){ 
  let camembert = document.getElementById('Localité');
  let total = valeurs.reduce((a,b) => a+b,0);
  let gradientString = 'conic-gradient(';
  let percentage = 0;
  let endpercentage = 0;
  
  for (let i = 0; i < valeurs.length; i++){
      endpercentage += (valeurs[i] / total) * 100;
      gradientString += `${couleurs[i]} ${percentage}% ${endpercentage}%, `;
      percentage = endpercentage;
  }
  
  gradientString = gradientString.slice(0, -2);
  gradientString += ')';
  camembert.style.background = gradientString;

}


