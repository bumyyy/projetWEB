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
      const url = `http://stagetier.fr/api/index.php?demande=company/delete/${idEntreprise}`;
      console.log(url);
      const response = await fetch(url, {
        method: 'POST'
      });
      if (response.ok) {
        window.location.reload();

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

