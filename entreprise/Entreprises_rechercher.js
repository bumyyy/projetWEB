document.addEventListener("DOMContentLoaded", function() {



//coloris les etoiles en fonction du nom des entreprises et du tableau de note
function highlightStars() {
  const stars = document.querySelectorAll('.star');
  console.log(stars);
  for(let a = 1;a<(stars.length/10)+1;a++){
    let idebut = 0;
    let ifin = 10;
    if (a !=1){
      let b=a-1;
      idebut+=(10*b);
      ifin+=(10*b);
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
  
  for(let i=0;i<elements.length/2;i++){
    let c = i*2;
    console.log(tabnote[i]);
    elements[c].textContent=tabnote[i];
    elements[c+1].textContent=tabnote[i];
  }

}
  
  
  


// Ouvrir la popup








// fermer la popup
/*
function fermerpopup(){
let btn = document.getElementById("closebtn").addEventListener("click", ()=>{
  document.getElementById("myModal").style.display ="none";
});
}
*/
//recuperer le nom des entreprise
function entrepriseName(){
let elements = document.querySelectorAll('h1#entrepriseName');
let tab = [];
elements.forEach(element =>{
  let tabs = element.textContent.trim();
  tab.push(tabs);
})


}
let tabnote = ['2,6','3,4','1,6','4,2','5'];
highlightStars();

});

function toggleSubdivision(division) {
  let subdivision = division.querySelector('.popup');
  if (subdivision.style.display === 'none') {
      subdivision.style.display = 'block';
  } else {
      subdivision.style.display = 'none';
  }
}