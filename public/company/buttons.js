async function confirmerSuppression(idEntreprise) {

    ROOT = 'https://stagetier.fr';
  
    if (confirm("Voulez-vous vraiment rendre l'entreprise invisble ?")) {
      try {
        const url = `${ROOT}/ApiManager/company/deleteCompany/${idEntreprise}`;
        const response = await fetch(url, {
          method: 'POST'
        });
        if (response.ok) {
          console.log('Entreprise rendue invisible');
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

  function create(){
    window.location.href = "/company/create/"
  }
  
  
  function update(idEntreprise){
    window.location.href = "/company/edit/" + idEntreprise
  }
  
  function stat() {
      window.location.href = "/company/stats"
  }