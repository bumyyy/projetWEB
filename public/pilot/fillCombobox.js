function getDataApi(URL, id, name, fnCallback) {
    fetch(URL)
    .then(response => response.json())
    .then(dataResponse => {
        // Correction ajoutée ici pour l'attribut name
        let html = '<select aria-label="'+name+'" id="'+name+'" name="'+name+'">'; // Ajout d'un guillemet après l'id
        html += '<option value="x">'+name+'</option>';
        dataResponse.forEach(element => {
            html += '<option value="'+element.id+'">'+element.nom+'</option>';
        });
        html += '</select>';
        document.getElementById(id).innerHTML = html;
        if (fnCallback) {
            fnCallback();
        }
    })
    .catch(error => console.error('Error fetching data:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    ROOT = 'https://stagetier.fr';
    getDataApi(`${ROOT}/ApiManager/combox/city`, 'comboboxCentre', 'ville', selectPilot);
});
