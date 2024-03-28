    /*
function toggleSubdivision(division) {
    let subdivision = division.querySelector('.popdown');
    let computedStyle = window.getComputedStyle(subdivision);

    if (computedStyle.display === 'none' || subdivision.style.display === 'none') {
        subdivision.style.display = 'block';
        document.body.classList.add('no-scroll');
    } else {
        subdivision.style.display = 'none';
        document.body.classList.remove('no-scroll');
    }
}
*/

document.addEventListener('DOMContentLoaded', function() {

ROOT = 'https://stagetier.fr';


document.getElementById('form').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
    document.getElementById('main').innerHTML = ''; // reset la page

    
    let dataSecteur = 'x';
    let dataVille = 'x';
    if (companyName == null || companyName == "") {
        let dataSecteur = document.getElementById('competence').value;
        let dataVille = document.getElementById('ville').value;
    }
    console.log(dataSecteur);

    let dataPromo = document.getElementById('promo').value;
    let dataNote = document.getElementById('rate').value;
    let dataDate = document.getElementById('date').value;
    let dataSearch = document.getElementById('search').value;

    let URL_ = dataSearch !== "" 
        ? `${ROOT}/ApiManager/internship/internshipBySearch/${dataSearch}` 
        : `${ROOT}/ApiManager/internship/allInternship/`;
        console.log(URL_);
    fetch(URL_)
    .then(response => response.json())
    .then(dataResponse => {
        return fetch(`${ROOT}/FilterSearch/filterInternship/${dataSecteur}/${dataVille}/${dataPromo}/${dataNote}/${dataDate}`, {
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
        finalData.pilotes.forEach ((stage) => {
            //tabnote.push(stage.moyenne_evaluations);
            let html =
            "<div class='completeEntreprise'>" +
            "<li class='ligne' id='"+stage.id_offre      +"'>" +
            "    <div class='carre' onclick='toggleSubdivision(this)'>" +
            "        <div class='name'>" +
            "            <h1 id='entrepriseName'>"+stage.nom_offre+"</h1>" +
            "            <p>"+stage.nom_entreprise+"</p>" +
            "        </div>" +
            "        <div class='localité'>" +
            "            <h2>"+stage.localites+"</h2>" +
            "            <p class='scroll' title='competences'>"+stage.competences_requises+"</p>" +
            "        </div>" +
            "        <div class='secteur'>" +
            "            <h2>"+stage.type_promotion_concerne+"</h2>" +
            "            <p title='début stage'>"+stage.date_debut_offre+"</p>" +
            "            <p title='fin stage'>"+stage.date_fin_offre+"</p>" +
            "        </div>"+
            "        <div class='localité'>"+
            "            <h2 title='rémuneration'>"+stage.remuneration_base+" € </h2>"+
            "            <p title='durée stage'>"+stage.duree_mois_stage+" mois</p>"+
             "          <p>"+stage.nombre_places_restantes+" place(s) restante(s)</p>"+
            
            "        </div>"+ 
            "        <div class='localité'>"+
            "            <h2 title='places offertes'>"+stage.nombre_places_offertes+" place(s)</h2>"+
            "            <p title='étudiant(s) ayant déja postulé'>"+stage.nombre_etudiants_postules+" étudiant(s) ayant postulé</p>"+
            "        </div>"+        
            "<div id='myModal' class='popdown'>"+
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
            "    </div>";
            
            if (userType != 3){
            html +=
            "   <div class='mod'>"+
            "   <div class='bord'>"+
            "       <span class='heart' data-value='" + stage.id_stage_aimé + "' data-id='" + stage.id_offre + "'>&#9829;</span>" +
            "       <span onclick=update("+stage.id_offre+") class='update'></span>"+
            "       <span onclick=confirmerSuppression("+stage.id_offre+") class='delete'></span>"+
            "   </div>";
            "   </div>";
            };
            html +=
            "</div>"+
            "</div>";
            
            document.getElementById('main').innerHTML += html;

            // Trouver le dernier cœur ajouté qui correspond à cette candidature et le colorier
            let favorite = document.querySelector('.heart[data-id="' + stage.id_offre + '"]');
            if (stage.id_stage_aimé != null) {
                favorite.style.color = '#fe8bb2'; // Colorier en rose si l'offre est dans 'aimer'
            } else {
                favorite.style.color = '#e4e5e9'; // Sinon, colorier en gris
            }
        })
        pagination();
        
        // Sélectionner tous les cœurs après que le DOM est complètement chargé
        const hearts = document.querySelectorAll('.heart');

        hearts.forEach(heart => {
            heart.addEventListener('click', function () {
                const internshipId = this.getAttribute('data-id');
                const internshipLiked = this.getAttribute('data-value');
                console.log("valeur :" + internshipLiked);

                if (internshipLiked != "null") {
                    // Si déjà favori, décolorer et supprimer de la table aimer
                    fetch(`${ROOT}/ApiManager/favorite/deleteFavorite/${internshipId}`, { method: 'POST' })
                        .then(data => {
                            if (!data.ok) {
                                throw new Error('Network response was not ok');
                            }
                            console.log('Removed from favorites', data);
                            this.style.color = '#e4e5e9'; // Gris
                            this.setAttribute('data-value', "null"); // Mettre à jour l'état du cœur
                            console.log("nouvelle valeur :" + internshipLiked);
                        })
                        .catch(error => alert('Error:', error));
                } else {
                    // Sinon, colorier et ajouter à la table aimer
                    fetch(`${ROOT}/ApiManager/favorite/addFavorite/${internshipId}`, { method: 'POST' })
                        .then(data => {
                            if (!data.ok) {
                                throw new Error('Network response was not ok');
                            }
                            console.log('Added to favorites', data);
                            this.style.color = '#fe8bb2'; // Rose
                            this.setAttribute('data-value', internshipId); // Mettre à jour l'état du cœur
                            console.log("nouvelle valeur :" + internshipLiked);
                        })
                        .catch(error => alert('Error:', error));
                    }
                });
            });


        //highlightStars(tabnote);
    })
    .catch(error => console.error('Error:', error));
});


});//fin du domloadcontent
