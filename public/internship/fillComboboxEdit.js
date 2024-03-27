function getDataApiSelect(URL, id, name, cb) {
    fetch(URL)
        .then(response => response.json())
        .then(dataResponse => {
            let html = `<select class="entreprise" id="${id}" name="${name}[]">`; // Utilisation de backticks pour une meilleure lisibilité
            html += `<option value="x">${name}</option>`; // Utilisation du paramètre `name` pour le texte de l'option placeholder
            dataResponse.forEach(element => {
                html += `<option value="${element.id}">${element.nom}</option>`; // Assurez-vous que `element.nom` correspond à la propriété attendue
            });
            html += `</select>`;
            document.getElementById(id).innerHTML = html;

            // Récupérer à nouveau la référence au <select> après sa mise à jour
            const updatedSelect = document.getElementById(id);
            
            if (typeof(cb) === 'function') {
                cb(updatedSelect); // Appeler la fonction de rappel avec le <select> mis à jour
            }
            return updatedSelect;
        })
        .catch(error => console.error('Error fetching data:', error));
}
