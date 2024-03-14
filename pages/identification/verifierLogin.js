document.getElementById('login').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêcher la soumission standard du formulaire

    var mail = document.getElementById('mail').value;
    var mdp = document.getElementById('mdp').value;
    
    if (mail && mdp) {
        var mailEncoded = encodeURIComponent(mail);
        var mdpEncoded = encodeURIComponent(mdp);
        
        fetch(`http://localhost/api/index.php?demande=authentification/${mailEncoded}/${mdpEncoded}`)
        .then(response => response.json())
        .then(dataResponse => {
            if (dataResponse.success === true) {
                fetch(`CookieSession.php`, {
                    method: 'POST',
                    headers: { // indique au serveur que les données envoyées dans le corps de la requête (body) sont au format JSON
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ userType: dataResponse.type_, 
                        userFirstName: dataResponse.prenom, 
                        userLastName: dataResponse.nom, 
                        userPromo: dataResponse.id_promotion}),
                })
                window.location.href = 'http://stagetier.fr/pages/accueil';
            } else {
                document.getElementById('errorMessage').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});