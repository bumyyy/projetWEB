function Secteur(valeurs){
let camembert = document.getElementById('Secteur');
let total = valeurs.reduce((a,b) => a+b,0);
let gradientString = 'conic-gradient(';
let percentage = 0;
let endpercentage=0;
let couleurs = ['green','orange','red'];
for (let i=0; i<valeurs.length; i++){
    endpercentage += (valeurs[i]/total)*100;
    gradientString+=`${couleurs[i]} ${percentage}% ${endpercentage}%, `;
    percentage=endpercentage;
}
gradientString= gradientString.slice(0, -2);
gradientString+=')';
console.log(gradientString);

camembert.style.background = gradientString;
console.log(camembert.style.background);
}
function Localité(valeurs){
    let camembert = document.getElementById('Localité');
    let total = valeurs.reduce((a,b) => a+b,0);
    let gradientString = 'conic-gradient(';
    let percentage = 0;
    let endpercentage=0;
    let couleurs = ['green','orange','red'];
    for (let i=0; i<valeurs.length; i++){
        endpercentage += (valeurs[i]/total)*100;
        gradientString+=`${couleurs[i]} ${percentage}% ${endpercentage}%, `;
        percentage=endpercentage;
    }
    gradientString= gradientString.slice(0, -2);
    gradientString+=')';
    console.log(gradientString);
    
    camembert.style.background = gradientString;
    console.log(camembert.style.background);
    }
Localité([50,78,25]);
Secteur([40,36,55]);
