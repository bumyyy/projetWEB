let tab_donne = [];
ROOT = 'https://stagetier.fr';

document.addEventListener('DOMContentLoaded', function() {


const id_student=window.location.href.split('/').pop();

    function nbStage(){ 
        let URL =`/ApiManager/student/statNbCandidacy/${id_student}`;
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

    function nbLike(){ 
      let URL =`/ApiManager/student/statNbLike/${id_student}`;
      fetch(URL)
      .then(response => {
          if (!response.ok) {
            throw new Error('La requête a échoué avec le code: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
        document.getElementById("nombreL").textContent = data[0].nombre_offres_aimees;
        })
        .catch(error => {
          console.error('Une erreur s\'est produite:', error);
        });
  }
  nbLike(); 



    let tableau_couleurs = ['rgb(246, 100, 100)', 'rgb(230, 190, 117)', 'rgb(125, 180, 125)'];            let couleurs=[];
    
    
    function nbRefusal(){
      let URL =`/ApiManager/student/statNbRefusal/${id_student}`;
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
      let URL =`/ApiManager/student/statNbWaiting/${id_student}`;
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
      let URL =`/ApiManager/student/statNbAdmission/${id_student}`;
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
  let URL_ = `/apiManager/application/allApplicationByStudent/${id_student}`;
            
        fetch(URL_)
        .then(response => {
          if (!response.ok) {
            throw new Error('La requête a échoué avec le code: ' + response.status);
          }
          return response.json();
        })
        .then(data => {
          console.log(data);
          if ((typeof(data) === "object") && Array.isArray(data)) {
            if (data.length > 0) {
              let tabnote = [];
            

            data.forEach ((candidature) => {
                tabnote.push(candidature.etat_candidature);

                let html =
                "<div class='completeEntreprise'>" +
                  "<li class='ligneDroite' id='"+candidature.id_offre+"'>" +
                  "    <div class='carre2' onclick='toggleSubdivision(this)'>" +
                  "        <div class='name2'>" +
                  "            <h1 id='entrepriseName'>"+candidature.nom_offre+"</h1>" +
                  "            <p>"+candidature.nom_entreprise+"</p>" +
                  "        </div>" +
                  "        <div class='localité2'>" +
                  "            <h2>"+candidature.nom_ville+"</h2>" +
                  "            <p title='competences' class='scroll'>"+candidature.competences_requises+"</p>" +
                  "        </div>" +
                  "        <div class='secteur2'>" +
                  "            <h2>"+candidature.nom_promotion+"</h2>" +
                  "            <p title='début stage'>"+candidature.date_debut_offre+"</p>" +
                  "            <p title='fin stage'>"+candidature.date_fin_offre+"</p>" +
                  "        </div>"+
                  "        <div class='localité2'>"+
                  "            <h2 title='rémuneration'>"+Math.round(candidature.remuneration_base)+"€</h2>"+
                  "            <p title='durée stage'>"+candidature.duree_mois_stage+"mois</p>"+
                  "          <p>"+candidature.nombre_places_restantes+" place(s) restante(s)</p>"+
                  "        </div>"+ 
                  "        <div class='localité2'>"+
                  "            <h2 title='places offertes'>"+candidature.nombre_places_offertes+"place(s)</h2>"+
                  "            <p  title='étudiant(s) ayant déja postulé'>"+candidature.nombre_etudiants_postules+" étudiant(s) ayant postulé</p>"+
                  "        </div>"+        
                  "    </div>"+
                  "</li>"+
                "</div>";

                document.getElementById("carre").innerHTML += html;
              });
            } else {
                console.log("Aucune candidature trouvée ou données invalides.");
            }
          } else {
            console.log("données invalides.");
          }
        })
        .catch(error => {
            console.error("Une erreur s'est produite lors de la récupération des données:", error);
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


