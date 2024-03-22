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

    ROOT = 'http://stagetier.fr';
    
    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
        document.getElementById('main').innerHTML = ''; // reset la page
    
        
        let dataEtat = document.getElementById('etat').value;
        let dataSearch = document.getElementById('search').value;
        
        let URL_ = dataSearch !== "" 
            ? `${ROOT}/ApiManager/application/applicationBySearch/${dataSearch}` 
            : `${ROOT}/ApiManager/application/allApplication/`;
        fetch(URL_)
        .then(response => response.json())
        .then(dataResponse => {
            return fetch(`${ROOT}/FilterSearch/filterApplication/${dataEtat}`, {
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
            let tabnote = [];
            finalData.candidatures.forEach ((candidature) => {
                tabnote.push(candidature.etat_candidature);
                let html =
                "<div class='completeEntreprise'>" +
                "<li class='ligne' id='"+candidature.id_offre      +"'>" +
                "    <div class='carre' onclick='toggleSubdivision(this)'>" +
                "        <div class='name'>" +
                "            <h1 id='entrepriseName'>"+candidature.nom_offre+"</h1>" +
                "            <p>"+candidature.nom_entreprise+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>"+candidature.ville+"</h2>" +
                "            <p>"+candidature.competences_requises+"</p>" +
                "        </div>" +
                "        <div class='secteur'>" +
                "            <h2>"+candidature.nom_promotion+"</h2>" +
                "            <p>"+candidature.date_debut_offre+"</p>" +
                "            <p>"+candidature.date_fin_offre+"</p>" +
                "        </div>"+
                "        <div class='localité'>"+
                "            <h2>"+candidature.remuneration_base+"</h2>"+
                "            <p>"+candidature.duree_mois_stage+"</p>"+
                "        </div>"+ 
                "        <div class='localité'>"+
                "            <h2>"+candidature.nombre_places_offertes+"</h2>"+
                "            <p>"+candidature.nombre_etudiants_postules+"</p>"+
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
                "<a href='http://stagetier.fr/pages/stages'>rechercher entreprise dans stage</a>"+
                "</div>"+
                "</div>"+


                */
                "    </div>";
                
                if (userType != 3){
                html +=
                "   <div class='mod'>"+
                "       <span onclick=favorite("+candidature.id_offre+") class='heart' data-value="+candidature.etat_candidature+">&#9829;</span>"+
                        "<input type='hidden' id='rating-value' name='rating-value' value='0'>"+
                "       <span onclick=update("+candidature.id_offre+") class='update'></span>"+
                "       <span onclick=confirmerSuppression("+candidature.id_offre+") class='delete'></span>"+
                "   </div>";
                };
                html +=
                "</div>"+
                "</div>";
                
                document.getElementById('main').innerHTML += html;
                
            })

            // Gérer le cœur de notation
            let isHeartSelected = false; // Variable pour vérifier si une note a été sélectionnée
            const hearts = document.querySelectorAll('.heart');
            const heartValue = document.getElementById('rating-value');

            hearts.forEach(heart => {
                heart.addEventListener('click', () => {
                    const id_offre = heart.parentElement.parentElement.parentElement.id;
                    const value = parseInt(heart.getAttribute('data-value'));
                    
                    // Mettre à jour la valeur de data-value à 1
                    heart.setAttribute('data-value', '1');
                    
                    // Mettre à jour la couleur du cœur
                    highlightHeart(1); // Mettre à jour la couleur en fonction de la nouvelle valeur
                    
                    // Appeler la fonction favorite avec l'ID de l'offre
                    favorite(id_offre);
                    
                    // Mettre à jour la variable pour indiquer qu'une note a été sélectionnée
                    isHeartSelected = true;
                    
                    // Vous pouvez maintenant envoyer la valeur sélectionnée au serveur ou effectuer d'autres actions nécessaires
                });
            });


            function highlightHeart(value) {
                hearts.forEach(heart => {
                    const heartValue = parseInt(heart.getAttribute('data-value'));
                    if (heartValue <= value) {
                        heart.style.color = '#fe8bb2'; // Changer la couleur en jaune
                    } else {
                        heart.style.color = '#e4e5e9'; // Changer la couleur en gris
                    }
                });
            }
            
            highlightHeart(tabnote);
            console.log(tabnote);
            //highlightStars(tabnote);
            pagination();
        })
        .catch(error => console.error('Error:', error));
    });
    
    
    });//fin du domloadcontent

    function favorite(id_offre) {
        // Ici, vous pouvez ajouter la logique pour marquer l'offre avec l'ID spécifié comme favori
        console.log("Offre avec l'ID " + id_offre + " ajoutée aux favoris.");
    }

