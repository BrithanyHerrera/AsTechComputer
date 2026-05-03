/* INDEX.JS */
/*
 * PÁGINA: Script Principal de la Landing Page (Index JS) - As Tech Computer
 * PROPÓSITO: Gestionar la interactividad visual y las animaciones de la página de aterrizaje al momento en que el usuario se desplaza (scroll) por el contenido.
 * FUNCIONALIDADES:
 * - Implementación de un observador de desplazamiento (Scroll Listener) global vinculado a la ventana del navegador.
 * - Cálculo matemático en tiempo real para determinar un punto de activación estratégico (Trigger Bottom), equivalente al 80% de la altura de la pantalla (Viewport).
 * - Inyección dinámica de clases CSS (.reveal) sobre las tarjetas de servicio (.servicio-tarjeta) una vez que estas entran en el rango de visión del usuario, detonando animaciones de aparición fluida.
 */

/* ==========================================
   1. ANIMACIONES DE DESPLAZAMIENTO (SCROLL REVEAL)
   ========================================== */
/**
 * El sistema escucha continuamente el evento de desplazamiento vertical de la ventana. 
 * Por cada iteración, captura la posición de todas las tarjetas y calcula si su 
 * límite superior (cardTop) ha cruzado el umbral visible de la pantalla. Si la 
 * tarjeta es visible, le inyecta la clase de animación.
 */
window.addEventListener('scroll', () => {
    const cards = document.querySelectorAll('.servicio-tarjeta');
    const triggerBottom = window.innerHeight / 5 * 4;

    cards.forEach(card => {
        const cardTop = card.getBoundingClientRect().top;

        if(cardTop < triggerBottom) {
            card.classList.add('reveal');
        }
    });
});