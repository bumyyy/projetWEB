ROOT = 'http://stagetier.fr';

document.addEventListener("DOMContentLoaded", function() {
let tab_promo=[];
function selectPilot(){

    id_pilot=window.location.href.split('/')[window.location.href.split('/').length-1];

    fetch(`${ROOT}/ApiManager/pilot/selectPilot/${id_pilot}`)
    .then(response => response.json())
    .then(data => {

            //remplir les input
            console.log(data);
            document.getElementById("form_input1").value = data[0].prenom_pilote;
            document.getElementById("form_input2").value = data[0].nom_pilote;
            document.getElementById("pilotMail").value = data[0].mail_pilote;

            var select = document.getElementById('comboboxCentre');
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].text === `${data[0].nom_centre}`) {
                    select.selectedIndex = i;
                    break;
    }
}
    for(let i = 0; i < data.length; i++){
       tab_promo.push(data[i].nom_promotion);
       if (i==0){

       }else{
        ajoutplus();
       }
    }
    for(let i = 0; i < data.length; i++){
        obtenirEtChangerValeurSelect(i,tab_promo[i]);
     }
    console.log(tab_promo);


    document.getElementById("plus").addEventListener("click", () => {
        ajoutplus();
});


    })
    .catch(error => {
        console.error('Erreur lors de la requête fetch : ', error);
    });

}

selectPilot();

function obtenirEtChangerValeurSelect(i, nouvelleValeur) {
    const container = document.getElementById("localite-container");
    // Assurez-vous que 'i' est dans la plage du nombre de 'select' disponibles
    if (i < container.childElementCount) {
        // Obtient le 'select' à l'indice spécifié
        const select = container.querySelectorAll("select")[i];
        // Récupère la valeur actuelle
        const valeurActuelle = select.value;
        
        // Change la valeur du 'select' à 'nouvelleValeur'
        // Assurez-vous que 'nouvelleValeur' existe comme 'option' dans ce 'select'
        select.value = nouvelleValeur;
        
        // Pour vérifier si la valeur a été changée
    }
}

function ajoutplus(){
    const container = document.getElementById("localite-container");
        // Compte le nombre de 'div' (qui contiennent des 'select') dans le conteneur
        const numberOfSelects = container.childElementCount;
        
        // Vérifie si le nombre de 'select' est inférieur à 5
        if (numberOfSelects < 5) {
            // Si oui, permet d'ajouter un autre 'select'
            const selectHTML = "<select name='localite[]' class='comboboxPromo' required>"+
                 "<option value='A1'>A1</option>"+
                 "<option value='A2'>A2</option>"+
                 "<option value='A3'>A3</option>"+
                 "<option value='A4'>A4</option>"+
                 "<option value='A5'>A5</option>"+
                 "</select>";
            const wrapper = document.createElement("div");
            wrapper.innerHTML = selectHTML;
            container.appendChild(wrapper);
        } else {
            // Sinon, affiche un message d'alerte ou ne fait rien
            alert("Limite de 5 sélecteurs atteinte.");
        }
}
document.getElementById("moins").addEventListener("click", () => {
    const container = document.getElementById("localite-container");
    // Compte le nombre d'éléments 'div' dans le conteneur
    const numberOfSelects = container.childElementCount;
    
    // Vérifie si le nombre d'éléments 'select' est supérieur à 1
    if (numberOfSelects > 1) {
        // Si oui, supprime le dernier élément
        container.removeChild(container.lastElementChild);
    }
});



document.getElementById('myform').addEventListener('submit', (event) => {
    let namePilot = document.getElementById("form_input1").value;
    let surnamePilot = document.getElementById("form_input2").value;
    let id_ville = document.getElementById("comboboxCentre").value;
    let pilotMail = document.getElementById("pilotMail").value;
    const container = document.getElementById("localite-container");
    tab_promo = [];
    for(let i = 0; i < container.querySelectorAll("select").length; i++){
    tab_promo.push(container.querySelectorAll("select")[i].value);
    }
    let promo = tab_promo.join(",");

/*
// Vérifier si aucun secteur n'a été sélectionné
if (select.options[0].text == "x") {
    event.preventDefault();
    alert('Erreur: Veuillez sélectionner un centre.');
    return false;
}
*/

// Envoyer une requête fetch pour chaque valeur de ville_nom

alert(`${ROOT}/ApiManager/pilot/editPilot/${id_pilot}/${namePilot}/${surnamePilot}/${pilotMail}/${id_ville}/${promo}`)

fetch(`${ROOT}/ApiManager/pilot/editPilot/${id_pilot}/${namePilot}/${surnamePilot}/${pilotMail}/${id_ville}/${promo}`)
    .then(response => {
        if (response.ok) {
        } else {
            console.error('Erreur lors de la requête fetch : ', response.statusText);
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête fetch : ', error);
    });
});


});

async function confirmerSuppression(idEntreprise) {

  ROOT = 'http://stagetier.fr';

  if (confirm("Voulez-vous vraiment rendre l'entreprise invisble ?")) {
    try {
      const url = `${ROOT}/ApiManager/company/deleteCompany/${idEntreprise}`;
      const response = await fetch(url, {
        method: 'POST'
      });
      if (response.ok) {
        console.log('Entreprise rendue invisible');
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

function update(idPilot){
  window.location.href = "/pilot/edit/" + idPilot;
}

function stat() {
    window.location.href = "/company/stats";
}
