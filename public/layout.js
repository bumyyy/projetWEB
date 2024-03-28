// Fonction pour afficher le popup
let infos = document.getElementById('informations');


let profil = document.getElementById('profile').addEventListener('click', () =>{
    if (infos.style.display == 'block'){
        infos.style.display = "none";
    }
    else{
    infos.style.display = "block";
    }
});



// let deco = document.getElementById("deco").addEventListener('click', () =>{
//     session_destroy();
//     window.location.href = "/index.php";
// });





// Fonction pour fermer le popup
//function closeProfil() {
//    document.getElementById("informations").style.display = "none";
//}