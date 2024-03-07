document.getElementById("create").addEventListener("click", function(){
    window.location.href = "Entreprises_creer.php";
})

document.getElementById("sub").addEventListener("change", function(){
})

function highlightStars(value) {
    const stars = document.querySelectorAll('.star');
    alert(star);
    stars.forEach(star => {
      const starValue = parseInt(star.getAttribute('data-value'));
      if (starValue <= value) {
        star.style.color = '#ffc107'; // Change color to yellow
      } else {
        star.style.color = '#e4e5e9'; // Change color to gray
      }
    });
  }
highlightStars(2);