// Fonction pour afficher le popup si success est défini et égal à 1
function showPopupIfSuccess() {
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    if (successParam === '1') {
        showPopup();
    }
}

// Fonction pour afficher le popup
function showPopup() {
    document.getElementById("popup").style.display = "block";
}
  
// Fonction pour fermer le popup
function closePopup() {
    document.getElementById("popup").style.display = "none";
}

// Afficher le popup si success est défini et égal à 1 lorsque la page est chargée
window.onload = function() {
    showPopupIfSuccess();
};
