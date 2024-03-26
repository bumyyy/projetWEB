function update(idEntreprise){
    window.location.href = "/student/edit/" + idEntreprise
}

function stat() {
    window.location.href = "/company/stats"
}


async function confirmerSuppression(idEntreprise) {

    ROOT = 'https://stagetier.fr';
  
    if (confirm("Voulez-vous vraiment rendre l'étudiant invisble ?")) {
      try {
        const url = `${ROOT}/ApiManager/student/deleteStudent/${idEntreprise}`;
        const response = await fetch(url);
        if (response.ok) {
          console.log('Etudiant rendue invisible');
          window.location.reload();
        } else {
          // Si la réponse n'est pas dans la plage 2 00-299, affichez une erreur
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