
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById("slider");
    const speed = 4;
    let index = 0;
    let timer1;
    let timer2;

    if (!slider) return;

    slider.appendChild(slider.children[0].cloneNode(false));

    function show(element) {
        slider.style.transition = "transform 0.5s ease";
        slider.style.transform = `translateX(${-index * slider.offsetWidth}px)`;
        index = element;
    }

    function next() {
        index++;
        show(index);
        if (index >= slider.children.length - 1)  {
            index = 0;
            timer2 = setTimeout(() => {
                slider.style.transition = 'none';
                slider.style.transform = `translateX(${+index * slider.offsetWidth}px)`;
            }, 500)
        }
    }

    // computadora
    slider.addEventListener("mouseenter", () => {
        clearInterval(timer1);
        clearInterval(timer2);
    });

    slider.addEventListener("mouseleave", () => {
        timer1 = setInterval(next, speed * 1000);
    });

    // celular 
    slider.addEventListener("touchstart", () => {
        clearInterval(timer1);
        clearInterval(timer2);
    });

    slider.addEventListener("touchend", () => {
        timer1 = setInterval(next, speed * 1000);
    })

    timer1 = setInterval(next, speed * 1000);
    show(index);
    
});
