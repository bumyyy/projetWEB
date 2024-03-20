document.addEventListener('DOMContentLoaded', function() {

ROOT = 'http://stagetier.fr';

document.getElementById('form').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
    document.getElementById('main').innerHTML = ''; // reset la page

    let dataPromo = document.getElementById('promotion').value;
    let dataVille = document.getElementById('ville').value;
    let dataSearch = document.getElementById('search').value;
    
    let URL_ = dataSearch !== "" 
        ? `${ROOT}/ApiManager/pilot/pilotBySearch/${dataSearch}` 
        : `${ROOT}/ApiManager/pilot/allPilot/`;
    fetch(URL_)
    .then(response => response.json())
    .then(dataResponse => {
        return fetch(`${ROOT}/FilterSearch/filterPilot/${encodeURIComponent(dataPromo)}/${encodeURIComponent(dataVille)}/`, {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json', 
            },
            body: JSON.stringify({
                data: dataResponse, 
            })
        });
    })
    .then(finalData => finalData.json()) 
    .then(finalData => {
        let userType = finalData.userType;

        finalData.pilotes.forEach ((pilote) => { 
            let html =
            "<div class='completeEntreprise'>" +
            "<li class='ligne' id='"+pilote.id_pilote   +"'>" +
            "    <div class='carre' onclick='toggleSubdivision(this)'>" +
            "        <div class='name'>" +
            "            <h1 id='entrepriseName'>Nom</h1>" +
            "            <p>"+pilote.nom_pilote+"</p>" +
            "        </div>" +
            "        <div class='localité'>" +
            "            <h2>Prénom</h2>" +
            "            <p>"+pilote.prenom_pilote+"</p>" +
            "        </div>" +
            "        <div class='localité'>" +
            "            <h2>Centre</h2>" +
            "            <p>"+pilote.nom_centre+"</p>" +
            "        </div>"+          
            "        <div class='localité'>"+
            "            <h2>Promotion</h2>"+
            "            <p>"+pilote.nom_promotion+"</p>"+
            "        </div>"+
            "    </div>";
            if (userType != 3){
            html +=
            "   <div class='mod'>"+
            "       <span onclick=update("+pilote.id_pilote+") class='update'></span>"+
            "       <span onclick=confirmerSuppression("+pilote.id_pilote+") class='delete'></span>"+
            "   </div>";
            };
            html +=
            "</div>"+
            "</div>";
            
            document.getElementById('main').innerHTML += html;
        })
        pagination();
    })
    .catch(error => console.error('Error:', error));
});









});//fin du domloadcontent
