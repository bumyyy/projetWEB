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
                "<div class='completeEntreprise' onclick='toggleSubdivision(this)'>" +
                "<div class='ligne'>" +
                "    <div class='carre'>" +
                "        <div class='name'>" +
                "            <h1 id='entrepriseName'>"+entreprise.nom_entreprise+"</h1>" +
                "            <p>"+entreprise.secteur_activite+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>Localité</h2>" +
                "            <p>"+entreprise.ville+"</p>" +
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
                "            <p>"+entreprise.nb_stagiaires_postules+"</p>"+
                "        </div>"+
                "    </div>";
                if (userType != 1){
                html +=
                "   <div class='mod'>"+
                "       <span class='update'></span>"+
                "       <span onclick=confirmerSuppression("+entreprise.id_entreprise+") class='delete'></span>"+
                "   </div>"+
                "   </div>";
                };
                html +=
                "<div id='myModal' class='popup'>"+
                    "<div class='fermer'><button id='closebtn'>x</button></div>"+
                    "<div class='name_popup'>"+
                    "<h1>Entreprise1</h1>"+
                    "<p>informatique</p>"+
                    "</div>"+
                    "<div class='localité_popup'>"+
                    "<h2>Localité</h2>"+
                    "<p>Paris<br>Lyon<br>Lyon</p>"+
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
                    "<a href='https://google.com'>google</a>"+
                    "</div>"+
                "</div>";
                console.log(html);
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
