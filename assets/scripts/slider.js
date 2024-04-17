document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("slider");
    const slides = slider.children;
    let index = 0;
    
    function showSlide() {
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[index].style.display = "block";
        console.info("Imagen " + index + " mostrada");
        index = (index + 1) % slides.length;
    }

    slides[0].style.display = "block";
    setInterval(showSlide, 2500);
});