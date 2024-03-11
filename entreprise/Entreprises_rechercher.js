document.addEventListener("DOMContentLoaded", function() {
/*
function highlightStars(value) {
    const stars = document.querySelectorAll('.star');
    stars.forEach(star => {
      const starValue = parseInt(star.getAttribute('data-value'));
      if (starValue <= value) {
        star.style.color = '#ffc107'; // Change color to yellow
      } else {
        star.style.color = 'rgb(160, 160, 160)'; // Change color to gray
      }

    });
    let note = document.getElementById("note");
    note.textContent=value;
  }
*/




//coloris les etoiles en fonction du nom des entreprises et du tableau de note
function highlightStars(note) {
  const stars = document.querySelectorAll('.star');
  for(let a = 1;a<(stars.length/10)+1;a++){
    let idebut = 0;
    let ifin = 10;
    if (a !=1){
      let b=a-1;
      idebut+=stars.length-(10*b);
      ifin+=stars.length-(10*b);
    }
    for(let i= idebut;i<ifin;i++){
        const starValue = parseInt(stars[i].getAttribute('data-value'));
        if (starValue <= parseInt(tabnote[a-1])) {
          stars[i].style.color = '#ffc107'; // Change color to yellow
        } else {
          stars[i].style.color = 'rgb(160, 160, 160)'; // Change color to gray
        }
      }
    }

    let elements = document.querySelectorAll('[id="note"]');

  for(let i=0;i<elements.length+1;i+=2){
    let c = i/2;
    elements[i].textContent=tabnote[c];
    elements[i+1].textContent=tabnote[c];
  }

}
  
  
  


// Ouvrir la popup
let carre = document.getElementById("carre").addEventListener("click", ()=>{
  document.getElementById("myModal").style.display = "block";
});

// fermer la popup
let btn = document.getElementById("closebtn").addEventListener("click", ()=>{
  document.getElementById("myModal").style.display ="none";
});
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//test tableau de notes !!!!!!!! PRENDS DES ENTIERS UNIQUEMENTS!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

//recuperer le nom des entreprise
function entrepriseName(){
let elements = document.querySelectorAll('h1#entrepriseName');
let tab = [];
elements.forEach(element =>{
  let tabs = element.textContent.trim();
  tab.push(tabs);
})


}
let tabnote = ['2,6','3,4'];
highlightStars();

});

