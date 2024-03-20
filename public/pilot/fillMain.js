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
            "            <h1 id='entrepriseName'>"+pilote.nom_pilote+"</h1>" +
            "            <p>"+pilote.secteur_activite+"</p>" +
            "        </div>" +
            "        <div class='localité'>" +
            "            <h2>Localité</h2>" +
            "            <p>"+pilote.ville+"</p>" +
            "        </div>" +
            "        <div class='secteur'>" +
            "            <h2>Note</h2>" +
            "            <div class='rating'>"+
            "            <input type='hidden' id='rating-value' name='rating-value' value='0'>"+
            "            <span class='star' data-value='5'>&#9733;</span>" +
            "            <span class='star' data-value='4'>&#9733;</span>" +
            "            <span class='star' data-value='3'>&#9733;</span>" +
            "            <span class='star' data-value='2'>&#9733;</span>" +
            "            <span class='star' data-value='1'>&#9733;</span>" +
            "        </div>"+
            "        <div class='note' id='note'>0</div>"+
            "        </div>"+            
            "        <div class='localité'>"+
            "            <h2>Ont postulé</h2>"+
            "            <p>"+pilote.nb_stagiaires_postules+"</p>"+
            "        </div>"+
            "<div id='myModal' class='popdown'>"+
            "<div class='fermer'><button id='closebtn'>x</button></div>"+
            "<div class='name_popup'>"+
            "<h1>"+pilote.nom_entreprise+"</h1>"+
            "<p>"+pilote.secteur_activite+"</p>"+
            "</div>"+
            "<div class='localité_popup'>"+
            "<h2>Localité</h2>"+
            "<p>"+pilote.centre+"</p>"+
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
            "<a href='http://stagetier.fr/pages/stages'>rechercher entreprise dans stage</a>"+
            "</div>"+
            "</div>"+
        


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
