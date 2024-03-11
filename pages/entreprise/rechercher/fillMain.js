document.addEventListener('DOMContentLoaded', function() {

    let currentPage = getCurrentPage();
    // Modifier l'URL pour inclure la pagination
    window.location.hash = `page=${currentPage}`;

    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
        document.getElementById('main').innerHTML = ''; // reset la page

        let dataSecteur = document.getElementById('secteur').value;
        let dataVille = document.getElementById('ville').value;
        let dataNote = document.getElementById('rate').value;
        let dataSearch = document.getElementById('search').value;
        let URL_ = dataSearch !== "" 
            ? `http://localhost/projetWEB/api/index.php?demande=entreprise/recherche/${dataSearch}` 
            : "http://localhost/projetWEB/api/index.php?demande=entreprise";
        fetch(URL_)
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
            updatePage(finalData.entreprises.length);
        })
        .catch(error => console.error('Error:', error));
    });
});


function getCurrentPage() {
    const hashParams = new URLSearchParams(window.location.hash.slice(1)); // Retire le '#' et parse
    return parseInt(hashParams.get('page') || '1', 10);
}

function updatePage(dataLength) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = ''; // Nettoyez les boutons précédents
    let currentPage = getCurrentPage();
    
    // Bouton de page précédente
    if (currentPage > 1) {
        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Précédent';
        prevBtn.onclick = () => {
            window.location.search = `?page=${currentPage - 1}`;
        };
        paginationContainer.appendChild(prevBtn);
    }
    
    // Bouton de page suivante
    if (dataLength === 5) { // Supposons que moins de 5 signifie qu'il n'y a pas de page suivante
        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Suivant';
        nextBtn.onclick = () => {
            window.location.search = `?page=${currentPage + 1}`;
        };
        paginationContainer.appendChild(nextBtn);
    }
}


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
