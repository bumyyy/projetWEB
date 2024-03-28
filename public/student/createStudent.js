// Définition d'une fonction asynchrone pour permettre l'utilisation de await à l'intérieur
/*
Le navigateur envoie une requête POST à l'URL spécifiée.
Le navigateur attend la réponse du serveur.
Pendant ce temps, le code JavaScript est suspendu, ce qui signifie qu'il attend également la réponse du serveur.
Une fois que le serveur a répondu, le navigateur reprend l'exécution du code JavaScript.
Si la requête est réussie, elle renvoie un objet Response contenant les données de la réponse. Si la requête échoue, elle lance une erreur.
*/


ROOT = 'https://stagetier.fr';

document.addEventListener("DOMContentLoaded", function() {
    
    document.getElementById('myform').addEventListener('submit', (event) => {
    event.preventDefault();

    // Récupérer les valeurs des champs de formulaire
    let nom = document.getElementById('nom').value;
    let prenom = document.getElementById('prenom').value;
    let mail = document.getElementById('mail').value;
    let mdp = document.getElementById('mdp').value;
    let centre = document.getElementById('comboboxVille').value;
    let promo = document.getElementById('comboboxPromo').value;
    
    // Vérifier si aucun secteur n'a été sélectionné
    if (centre == 'x' && promo == 'x') {
        alert('Erreur: Veuillez sélectionner un centre et une promotion.');
        return false;
    }
 
    // Envoyer une requête fetch pour chaque valeur de ville_nom
    fetch(`${ROOT}/ApiManager/student/addStudent/${nom}/${prenom}/${mail}/${mdp}/${centre}/${promo}`)
        .then(response => {
            if (response.ok) {
                // Rediriger l'utilisateur en cas de succès
                window.location.href = `${ROOT}/student/`;
            } else {
                // Traiter les erreurs éventuelles
                console.error('Erreur lors de la requête fetch : ', response.statusText);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête fetch : ', error);
        });
    });
});





