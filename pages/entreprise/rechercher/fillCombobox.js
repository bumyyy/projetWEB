function getDataApi(URL, id, name) {
    fetch(URL)
    .then(response => response.json())
    .then(dataResponse => {
        // Correction ajoutée ici pour l'attribut name
        let html = '<select id="'+name+'" name="'+name+'">'; // Ajout d'un guillemet après l'id
        html += '<option value="x">'+name+'</option>';
        dataResponse.forEach(element => {
            html += '<option value="'+element.nom+'">'+element.nom+'</option>';
        });
        html += '</select>';
        document.getElementById(id).innerHTML = html;
    })
    .catch(error => console.error('Error fetching data:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    getDataApi('http://localhost/api/index.php?demande=combox/secteur', 'comboboxSecteur', 'secteur');
    getDataApi('http://localhost/api/index.php?demande=combox/ville', 'comboboxVille', 'ville');
});
