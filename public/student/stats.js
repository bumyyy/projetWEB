let tab_donne = [];

document.addEventListener('DOMContentLoaded', function() {


const id_student=window.location.href.split('/').pop();

    function nbStage(){ 
        let URL =`http://stagetier.fr/ApiManager/student/statNbCandidacy/${id_student}`;
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
      let URL =`http://stagetier.fr/ApiManager/student/statNbRefusal/${id_student}`;
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
      let URL =`http://stagetier.fr/ApiManager/student/statNbWaiting/${id_student}`;
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
      let URL =`http://stagetier.fr/ApiManager/student/statNbAdmission/${id_student}`;
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




}
candidatures();


})//fin du DOM




