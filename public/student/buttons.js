function update(idEntreprise){
  window.location.href = "/student/edit/" + idEntreprise
}

function create() {
  window.location.href = "/student/create"
}

function stats(id_student) {
  window.location.href = `/student/stats/${id_student}`
}


async function confirmerSuppression(idEntreprise) {

  
    if (confirm("Voulez-vous vraiment rendre l'étudiant invisble ?")) {
      try {
        const url = `/ApiManager/student/deleteStudent/${idEntreprise}`;
        const response = await fetch(url);
        if (response.ok) {
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
      alert("Suppression annulée.");
    }
  }