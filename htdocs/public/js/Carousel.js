/**
 * SCRIPT: carousel.js
 * PROPÓSITO: Controlar el desplazamiento horizontal de un carrusel de elementos en la interfaz. de convenios
 * esto se usa en la pagina index y convenios
 */
window.addEventListener("load", () => {
   //funciones para que el carousel se mueva de manera infinita con sus imagenes 
   // y se pare cuando hagas hover en una imagen
    document.querySelectorAll(".carousel").forEach(carousel => {

        const track = carousel.querySelector(".carousel-track");
        if (!track) return;

        const next = carousel.querySelector(".next");
        const prev = carousel.querySelector(".prev");

        if (!track.dataset.cloned) {
            track.innerHTML += track.innerHTML;
            track.dataset.cloned = "true";
        }

        let position = 0;
        const speed = 1;

        const logosWidth = track.scrollWidth / 2;

        function move() {
            position += speed;

            if (position >= logosWidth) {
                position = 0;
            }

            track.style.transform = `translateX(${-position}px)`;
        }

        let auto = setInterval(move, 20);

        carousel.addEventListener("mouseenter", () => clearInterval(auto));
        carousel.addEventListener("mouseleave", () => {
            auto = setInterval(move, 20);
        });

        next?.addEventListener("click", () => position += 200);
        prev?.addEventListener("click", () => position -= 200);

    });

});
