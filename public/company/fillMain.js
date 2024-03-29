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
    
document.addEventListener('DOMContentLoaded', function() {

    ROOT = 'https://stagetier.fr';
    
    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
        document.getElementById('main').innerHTML = ''; // reset la page

        let dataSecteur = document.getElementById('secteur').value;
        let dataVille = document.getElementById('ville').value;
        let dataNote = document.getElementById('rate').value;
        let dataSearch = document.getElementById('search').value;
        
        let URL_ = dataSearch !== "" 
            ? `${ROOT}/ApiManager/company/companyBySearch/${dataSearch}` 
            : `${ROOT}/ApiManager/company/allCompany/`;
        fetch(URL_)
        .then(response => response.json())
        .then(dataResponse => {
            return fetch(`${ROOT}/FilterSearch/filter/${encodeURIComponent(dataSecteur)}/${encodeURIComponent(dataVille)}/${encodeURIComponent(dataNote)}`, {
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

            finalData.entreprises.forEach ((entreprise) => { 
                tabnote.push(entreprise.moyenne_evaluations);
                let html =
                "<div class='completeEntreprise'>" +
                "<li class='ligne' id='"+entreprise.id_entreprise   +"'>" +
                "    <div class='carre' onclick='toggleSubdivision(this)'>" +
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
                
                "<div id='myModal' class='popdown'>"+
                "<div class='fermer'><button id='closebtn'>x</button></div>"+
                "<div class='name_popup'>"+
                "<h1>"+entreprise.nom_entreprise+"</h1>"+
                "<p>"+entreprise.secteur_activite+"</p>"+
                "</div>"+
                "<div class='localité_popup'>"+
                "<h2>Localité</h2>"+
                "<p>"+entreprise.ville+"</p>"+
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
                "<a href='https://stagetier.fr/internship/index/"+entreprise.nom_entreprise+"'>rechercher entreprise dans stage</a>"+
                "</div>"+
                "</div>"+
            


                "    </div>";
                if (userType != 3){
                html +=
                "   <div class='mod'>"+
                "       <span onclick=update("+entreprise.id_entreprise+") class='update'></span>"+
                "       <span onclick=confirmerSuppression("+entreprise.id_entreprise+") class='delete'></span>"+
                "   </div>";
                };
                html +=
                "</div>"+
                "</div>";
                
                document.getElementById('main').innerHTML += html;
            })
            highlightStars(tabnote);
            pagination();
        })
        .catch(error => console.error('Error:', error));
    });





//coloris les etoiles en fonction du nom des entreprises et du tableau de note
function highlightStars(tabnote) {
    const stars = document.querySelectorAll('.star');
    
    for (let a = 1; a <= stars.length / 10; a++) {
        let idebut = (a - 1) * 10;
        let ifin = (a * 10);
        if (ifin > stars.length) {
            ifin = stars.length;
        }
      for(let i= idebut;i<ifin;i++){
          const starValue = parseInt(stars[i].getAttribute('data-value'));
          if (starValue <= parseInt(tabnote[a-1])) {
            stars[i].style.color = '#ffc107'; // Change color to yellow
          } else {
            stars[i].style.color = 'rgb(179,179,179)'; // Change color to gray
          }
        }
      }
  
      let elements = document.querySelectorAll('[id="note"]');
    
    for(let i=0;i<elements.length/2;i++){
      let c = i*2;
      elements[c].textContent=parseFloat(tabnote[i]).toFixed(1);
      elements[c+1].textContent=parseFloat(tabnote[i]).toFixed(1);
    }
  
  }

  

});//fin du domloadcontent
