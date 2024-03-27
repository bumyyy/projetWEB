document.getElementById('login').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêcher la soumission standard du formulaire
    
    ROOT = 'https://stagetier.fr';

    var mail = document.getElementById('mail').value;
    var mdp = document.getElementById('mdp').value;
    
    if (mail && mdp) {
        var mailEncoded = encodeURIComponent(mail);
        var mdpEncoded = encodeURIComponent(mdp);
        
        fetch(`${ROOT}/ApiManager/login/${mailEncoded}/${mdpEncoded}`)
        .then(response => response.json())
        .then(dataResponse => {
            if (dataResponse.success === true) {
                fetch(`${ROOT}/SessionManager/startSession/${dataResponse.id}/${dataResponse.type_}/${dataResponse.nom}/${dataResponse.prenom}/${dataResponse.id_promotion}`)
                window.location.href = `${ROOT}/accueil`;
            } else {
                document.getElementById('errorMessage').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});