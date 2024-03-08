function submitLogin() {
    var mail = document.getElementById('mail').value;
    var mdp = document.getElementById('mdp').value;
    
    if (mail && mdp) {
        var mailEncoded = encodeURIComponent(mail);
        var mdpEncoded = encodeURIComponent(mdp);

        fetch(`http://localhost/projetWEB/api/index.php?demande=authentification&mail=${mailEncoded}&mdp=${mdpEncoded}`)
        .then(dataResponse => {
            if (dataResponse.success === true) {
                fetch(`CookieSession.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ typeUtilisateur: dataResponse.type_ }),
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
}