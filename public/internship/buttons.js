
function update(idEntreprise){
  window.location.href = "/internship/edit/" + idEntreprise
}

function stat() {
    window.location.href = "/internship/stats"
}


async function confirmerSuppression(idEntreprise) {
  ROOT = 'https://stagetier.fr';

  if (confirm("Voulez-vous vraiment supprimer le stage?")) {
    try {
      const url = `${ROOT}/ApiManager/internship/delete/${idEntreprise}`;
      const response = await fetch(url, {
        method: 'POST'
      });
      if (response.ok) {
        console.log('Stage supprimé');
        window.location.reload();
      } else {
        // Si la réponse n'est pas dans la plage 2 00-299, affichez une erreur
        alert("Erreur.");
        throw new Error('Réponse réseau non ok');
      }
    }  catch (error) {
      console.error('Erreur:', error);
      alert("Une erreur s'est produite lors de la suppression.");
    }
  } else {
    console.log('Suppression annulée.');
    alert("Suppression annulée.");
  }
}

