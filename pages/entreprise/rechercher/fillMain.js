document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
        document.getElementById('main').innerHTML = ''; // reset la page

        let dataSecteur = document.getElementById('secteur').value;
        let dataVille = document.getElementById('ville').value;
        let dataNote = document.getElementById('rate').value;
        let dataSearch = document.getElementById('search').value;
        let URL = dataSearch !== "" 
            ? `http://localhost/projetWEB/api/index.php?demande=entreprise/recherche/${dataSearch}` 
            : "http://localhost/projetWEB/api/index.php?demande=entreprise";
        fetch(URL)
        .then(response => response.json())
        .then(dataResponse => {
            return fetch(`filterSearch.php`, {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json', 
                },
                body: JSON.stringify({
                    data: dataResponse, 
                    secteur: dataSecteur,
                    ville: dataVille,
                    rate: dataNote
                })
            });
        })
        .then(response => response.json()) 
        .then(finalData => {
            console.log(finalData);
            let userType = finalData.userType;
            finalData.entreprises.forEach ((entreprise, index) => {  
                let html = 
                "<div class='ligne'>" +
                "    <div class='carre'>" +
                "        <div class='name'>" +
                "            <h1>"+entreprise.nom_entreprise+"</h1>" +
                "            <p>"+entreprise.secteur_activite+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>Localité</h2>" +
                "            <p>"+entreprise.ville+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>Note</h2>" +
                "            <div class='rating' id='rating-'"+index+">" +
                "            <span data-value='5' class='star'></span>" +
                "            <span data-value='4' class='star'></span>" +
                "            <span data-value='3' class='star'></span>" +
                "            <span data-value='2' class='star'></span>" +
                "            <span data-value='1' class='star'></span>" +
                "        </div>"+
                "        </div>"+
                "        <div class='localité'>"+
                "            <h2>Ont postulé</h2>"    +
                "            <p>"+entreprise.nb_stagiaires_postules+"</p>"+
                "        </div>"+
                "    </div>";
                if (userType != 1){
                html +=
                "   <div class='mod'>"+
                "       <span class='update'></span>"+
                "       <span onclick=confirmerSuppression("+entreprise.id_entreprise+") class='delete'></span>"+
                "   </div>";
                };
                html +=
                "</div>";
                highlightStars(entreprise.moyenne_evaluations);
                document.getElementById('main').innerHTML += html;
            })
            
        })
        .catch(error => console.error('Error:', error));
    });
});

function highlightStars(value) {
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
      const starValue = parseInt(star.getAttribute('data-value'));
      if (starValue <= value) {
        star.style.color = '#ffc107'; // Change color to yellow
      } else {
        star.style.color = 'rgb(160, 160, 160)'; // Change color to gray
      }
    });
  };
