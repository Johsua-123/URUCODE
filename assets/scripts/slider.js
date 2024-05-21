
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("slider");
    const slides = document.getElementById("slides");
    const time = 2800;
    let index = 0;

    function show(){
        index++;
        if (index >= slides.children.length) {
            index = -1;
            slides.style.transform = "translateX(0)";
        } else {
            slides.style.transform = `translateX(${-index * slides.children[0].offsetWidth}px)`;
        }
    }

    let timer = setInterval(show, time);

    slides.addEventListener("mouseenter", () => {
        clearInterval(timer);
     });

    slides.addEventListener("mouseleave", () => {
        timer = setInterval(show, time);
    });

});

