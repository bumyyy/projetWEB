document.addEventListener("DOMContentLoaded", function() {

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
      }

    
    
    });