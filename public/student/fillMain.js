document.addEventListener('DOMContentLoaded', function() {

    
    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêcher l'envoi traditionnel du formulaire
        document.getElementById('main').innerHTML = ''; // reset la page
    
        let dataPromo = document.getElementById('promo').value;
        let dataVille = document.getElementById('ville').value;
        let dataSearch = document.getElementById('search').value;
        
        let URL_ = dataSearch !== ""
            ? `/ApiManager/student/studentBySearch/${dataSearch}` 
            : `/ApiManager/student/allStudent/`;
        fetch(URL_)
        .then(response => response.json())
        .then(dataResponse => {
            return fetch(`/FilterSearch/filterPilot/${encodeURIComponent(dataPromo)}/${encodeURIComponent(dataVille)}/`, {
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
    
            finalData.pilotes.forEach ((student) => { 
                let html =
                "<div class='completeEntreprise'>" +
                "<li class='ligne' id='"+student.id_student   +"'>" +
                "    <div class='carre' onclick='toggleSubdivision(this)'>" +
                "        <div class='name'>" +
                "            <h1 id='entrepriseName'>Nom</h1>" +
                "            <p>"+student.nom_student+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>Prénom</h2>" +
                "            <p>"+student.prenom_student+"</p>" +
                "        </div>" +
                "        <div class='localité'>" +
                "            <h2>Centre</h2>" +
                "            <p>"+student.nom_centre+"</p>" +
                "        </div>"+          
                "        <div class='localité'>"+
                "            <h2>Promotion</h2>"+
                "            <p>"+student.nom_promotion+"</p>"+
                "        </div>"+
                "    </div>";
                if (userType != 3){
                html +=
                "   <div class='mod'>"+
                "       <div class='btn-img'>"+
                    "       <span onclick=stats("+student.id_student+") class='stats'></span>"+
                    "       <span onclick=update("+student.id_student+") class='update'></span>"+
                    "       <span onclick=confirmerSuppression("+student.id_student+") class='delete'></span>"+
                        "</div>"+
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

    

    