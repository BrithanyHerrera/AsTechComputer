/**
 * SCRIPT: carousel.js
 * PROPÓSITO: Controlar el desplazamiento horizontal de un carrusel de elementos en la interfaz. de convenios
 * FUNCIONALIDADES:
 * - Inicialización al cargar el DOM.
 * - Cálculo dinámico del desplazamiento según el tamaño de los elementos.
 * - Navegación mediante botones "next" y "prev".
 * - Implementación de animación suave (scroll) con efecto easing.
 * - Mejora de la experiencia de usuario al desplazar múltiples elementos por interacción.
 */
window.addEventListener("load", () => {

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
