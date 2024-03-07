
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



// Définition d'une fonction asynchrone pour permettre l'utilisation de await à l'intérieur
/*
Le navigateur envoie une requête POST à l'URL spécifiée.
Le navigateur attend la réponse du serveur.
Pendant ce temps, le code JavaScript est suspendu, ce qui signifie qu'il attend également la réponse du serveur.
Une fois que le serveur a répondu, le navigateur reprend l'exécution du code JavaScript.
Si la requête est réussie, elle renvoie un objet Response contenant les données de la réponse. Si la requête échoue, elle lance une erreur.
*/

async function confirmerSuppression(idEntreprise) {
  if (confirm("Voulez-vous vraiment supprimer ?")) {
    try {
      const url = `http://localhost/projetWEB/api/index.php?demande=supprimer/entreprise/${idEntreprise}`;
      const response = await fetch(url, {
        method: 'POST'
      });
      if (response.ok) {
        console.log('Suppression réussie');
        alert("Suppression réussie !");
      } else {
        // Si la réponse n'est pas dans la plage 200-299, affichez une erreur
        alert("Erreur.");
        throw new Error('Réponse réseau non ok');
      }
    } catch (error) {
      console.error('Erreur:', error);
      alert("Une erreur s'est produite lors de la suppression.");
    }
  } else {
    console.log('Suppression annulée.');
    alert("Suppression annulée.");
  }
}

