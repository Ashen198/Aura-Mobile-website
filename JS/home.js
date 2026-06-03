let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  const slides = document.getElementsByClassName("slide");
  const dots = document.getElementsByClassName("dot");
  
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }

  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    

  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";

  setTimeout(showSlides, 4000); // Change slide every 4 seconds
}

/* Arrow navigation */
function plusSlides(n) {
  slideIndex -= 1; // reset to current slide
  slideIndex += n;
  showSlides();
}

/* Dot navigation */
function currentSlide(n) {
  slideIndex = n - 1;
  showSlides();
}



















function toggleMenu() {
    const menu = document.getElementById("profileMenu");
    menu.style.display = 
        menu.style.display === "block" ? "none" : "block";
}

// Close when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.profile-btn')) {
        const menu = document.getElementById("profileMenu");
        if (menu.style.display === "block") {
            menu.style.display = "none";
        }
    }
}