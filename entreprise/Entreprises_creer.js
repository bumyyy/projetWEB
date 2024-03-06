document.addEventListener("DOMContentLoaded", function() {

document.getElementById("ville").addEventListener("click", ()=>{
    alert("afafga")
})
const stars = document.querySelectorAll('.star');
  const ratingValue = document.getElementById('rating-value');

  stars.forEach(star => {
    star.addEventListener('click', () => {
      const value = parseInt(star.getAttribute('data-value'));
      ratingValue.value = value;
      highlightStars(value);
    });
  });

  function highlightStars(value) {
    stars.forEach(star => {
      const starValue = parseInt(star.getAttribute('data-value'));
      if (starValue <= value) {
        star.style.color = '#ffc107'; // Change color to yellow
      } else {
        star.style.color = '#e4e5e9'; // Change color to gray
      }
    });
  }

  document.getElementById("myform").addEventListener("submit", function(event) {
    event.preventDefault();
});
});