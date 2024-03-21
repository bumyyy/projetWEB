// Fonction pour afficher le popup
let profil = document.getElementById('profile');
let infos = document.getElementById('informations');
let deco = document.getElementById("deco");
profil.addEventListener('click', () =>{
    if (infos.style.display == 'block'){
        infos.style.display = "none";
    }
    else{
    infos.style.display = "block";
    deco.focus();
    }
});
deco.addEventListener('blur', () =>{
    infos.style.display = "none";
});



// Fonction pour fermer le popup
//function closeProfil() {
//    document.getElementById("informations").style.display = "none";
//}