document.addEventListener('DOMContentLoaded', function() {

    function statnote(){
        let URL ='https://stagetier.fr/ApiManager/company/statop3';
        fetch(URL)
        .then(response => {
            if (!response.ok) {
              throw new Error('La requête a échoué avec le code: ' + response.status);
            }
            return response.json();
          })
          .then(data => {
            let entreprise = document.querySelectorAll(".entreprise");
            let secteur = document.querySelectorAll(".sech1");
            let localité = document.querySelectorAll(".localh1");
            let tabnote=[];
            for(let i=0;i<data.length;i++){
                entreprise[i].textContent = data[i].nom_entrprise;
                secteur[i].textContent = data[i].secteur_activite;
                localité[i].textContent = data[i].ville;
                tabnote.push(data[i].moyenne_evaluations);
            }
            highlightStars(tabnote);
          })
          .catch(error => {
            console.error('Une erreur s\'est produite:', error);
          });
    }

    statnote(); 



    function statsecteur(){
        let URL ='https://stagetier.fr/ApiManager/company/statSector';
        fetch(URL)
        .then(response => {
            if (!response.ok) {
              throw new Error('La requête a échoué avec le code: ' + response.status);
            }
            return response.json();
          })
          .then(data => {
            let diagtab=[];
            let html = "";
            let sectittre;
            let tableau_couleurs = ['#842d73', '#8451a7', '#9b81dd', '#8da3e7', '#7cdeed', '#7cd7b3', '#3cd476', '#caf266', '#e5f037', '#eac85f', '#e58b58', '#ff7f50', '#f26767', '#f4769c', '#d776f4', '#a376c9'];            
            let couleurs=[];
            for(let i=0;i<data.length;i++){
                diagtab.push(data[i].nombre_apparition);
                couleurs.push(tableau_couleurs[i]);
                html = "";
                html += "<p class='sec"+i+"' id='sec"+i+"'>"+data[i].nom_secteur+"</p>";
                document.getElementById("diagsect").innerHTML+= html;
                sectittre = document.getElementById(`sec${i}`);
                sectittre.style.color = `${tableau_couleurs[i]}`;
            }
            Secteur(diagtab,couleurs);
          })
          .catch(error => {
            console.error('Une erreur s\'est produite:', error);
          });
    }
statsecteur();

function statville(){
  let URL ='https://stagetier.fr/ApiManager/company/statCity';
  fetch(URL)
  .then(response => {
      if (!response.ok) {
        throw new Error('La requête a échoué avec le code: ' + response.status);
      }
      return response.json();
    })
    .then(data => {
      let diagtab=[];
      let html = "";
      let villetittre;
      let tableau_couleurs = ['#842d73', '#8451a7', '#9b81dd', '#8da3e7', '#7cdeed', '#7cd7b3', '#3cd476', '#caf266', '#e5f037', '#eac85f', '#e58b58', '#ff7f50', '#f26767', '#f4769c', '#d776f4', '#a376c9'];            
      let couleurs=[];
      for(let i=0;i<data.length;i++){
          diagtab.push(data[i].nombre_entreprise);
          couleurs.push(tableau_couleurs[i]);
          html = "";
          html += "<p class='loc"+i+"' id='loc"+i+"'>"+data[i].nom_ville+"</p>";
          document.getElementById("diagloc").innerHTML+= html;
          villetittre = document.getElementById(`loc${i}`);
          villetittre.style.color = `${tableau_couleurs[i]}`;
    
      }
      console.log(diagtab);
      Localité(diagtab,couleurs);
    })
    .catch(error => {
      console.error('Une erreur s\'est produite:', error);
    });
}
statville();
    function highlightStars(tabnote) {
        const stars = document.querySelectorAll('.star');
        let idebut = 0;
        let ifin = 5;
        for (let a = 0; a < tabnote.length; a++) {
          for(let i= idebut;i<ifin;i++){
              const starValue = parseInt(stars[i].getAttribute('data-value'));
              if (starValue <= parseInt(tabnote[a])) {
                stars[i].style.color = '#ffc107'; // Change color to yellow
              } else {
                stars[i].style.color = 'rgb(179,179,179)'; // Change color to gray
              }
            }
            idebut+=5;
            ifin+=5;
          }
      
          let elements = document.querySelectorAll('[id="note"]');
        
        for(let i=0;i<elements.length/2;i++){
          let c = i*2;
          elements[c].textContent=parseFloat(tabnote[i]).toFixed(1);
          elements[c+1].textContent=parseFloat(tabnote[i]).toFixed(1);
        }
      
      }






})//fin du DOM





function Secteur(valeurs, couleurs){ 
  if (valeurs.length !== couleurs.length) {
    throw new Error('valeurs and couleurs must have the same length');
  }
  
  if (valeurs.length === 0) {
    throw new Error('valeurs array is empty');
  }
  
  let camembert = document.getElementById('Secteur');
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
