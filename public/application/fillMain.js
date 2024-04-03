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

    
    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
        document.getElementById('main').innerHTML = ''; // reset la page
    
        let dataFavorite = document.getElementById('checkboxFavorite').checked;
        let dataEtat = document.getElementById('etat').value;
        let dataSearch = document.getElementById('search').value;
        
        let URL_ = dataSearch !== "" 
            ? `/ApiManager/application/applicationBySearch/${dataSearch}` 
            : `/ApiManager/application/allApplication/`;
            
        fetch(URL_)
        .then(response => response.json())
        .then(dataResponse => {
            return fetch(`/FilterSearch/filterApplication/${dataEtat}/${dataFavorite}`, {
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
            let etatCandidatureTexte = '';
            

            finalData.candidatures.forEach ((candidature) => {
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
                        etatCandidatureTexte = "Terminé, à noter";
                        break;
                    case 4:
                        etatCandidatureTexte = "Terminé, note faite";
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
                "<div class='partcomplet'>" +
                "<div class='partie1'>" +
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
                " </div>"+
                "<div class='partie2'>" +
                "        <div class='localité'>"+
                "            <h2 title='rémuneration'> Rémuneration: "+Math.round(candidature.remuneration_base)+"€/mois</h2>"+
                "            <p title='durée stage'> Duree du stage: "+candidature.duree_mois_stage+"mois</p>"+
                "          <p>"+candidature.nombre_places_restantes+" place(s) restante(s)</p>"+
                "        </div>"+ 
                "        <div class='localité'>"+
                "            <h2 title='places offertes'>"+candidature.nombre_places_offertes+"place(s) offertes </h2>"+
                "            <p  title='étudiant(s) ayant déja postulé'>"+candidature.nombre_etudiants_postules+" étudiant(s) ayant postulé</p>"+
                "            <p>"+etatCandidatureTexte+"</p>"+
                "        </div>"+     
                "</div>"+  
                "</div>"+
                "    </div>";
                
                if (userType != 2){
                html +=
                "   <div class='mod'>"+
                "   <div class='bord'>"+
                "       <span class='heart' data-value='" + candidature.id_stage_aimé + "' data-id='" + candidature.id_offre + "'>&#9829;</span>" +
                        "<input type='hidden' id='rating-value' name='rating-value' value='0'>"+
                "       <span onclick=apply("+candidature.id_offre+") class='post'></span>";
                if (candidature.etat_candidature == 3){
                let userId = document.getElementById("idUser").getAttribute("data-iduser");
                console.log(userId);
                html +="<span onclick='rate("+candidature.id_entreprise+","+userId+")' class='pen'></span>";   
                }
                html +="   </div>";
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
                
            })
            

            // Sélectionner tous les cœurs après que le DOM est complètement chargé
            const hearts = document.querySelectorAll('.heart');

            hearts.forEach(heart => {
                heart.addEventListener('click', function () {
                    const internshipId = this.getAttribute('data-id');
                    const internshipLiked = this.getAttribute('data-value');
                    console.log("valeur :" + internshipLiked);

                    if (internshipLiked != "null") {
                        // Si déjà favori, décolorer et supprimer de la table aimer
                        fetch(`/ApiManager/favorite/deleteFavorite/${internshipId}`, { method: 'POST' })
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
                        fetch(`/ApiManager/favorite/addFavorite/${internshipId}`, { method: 'POST' })
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

                        
            console.log(tabnote);
            pagination();
        })
        .catch(error => console.error('Error:', error));
    });
    
    
    });//fin du domloadcontent


function rate(idCompany, idUser) {
    // Demande à l'utilisateur de noter l'entreprise
    let rating = prompt("Veuillez entrer une note entre 1 et 5 pour cette entreprise:", "");
    
    // Convertit la réponse en nombre et vérifie qu'elle est comprise entre 1 et 5
    rating = Number(rating);
    if (!Number.isNaN(rating) && rating >= 1 && rating <= 5) {
        // Construit l'URL de l'API
        const apiUrl = `//stagetier.fr/apiManager/company/rate/${idCompany}/${idUser}/${rating}`;

        // Appel de l'API avec fetch
        fetch(apiUrl)
        
        //reset la page
        location.reload(true);

    } else {
        // Si l'entrée est invalide, affiche un message d'erreur
        alert("Veuillez entrer un nombre valide entre 1 et 5.");
    }
    }