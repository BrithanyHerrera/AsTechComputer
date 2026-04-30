document.addEventListener("DOMContentLoaded", function () {

    const overlay = document.getElementById("overlay-bloqueo");
    const banner = document.getElementById("banner-cookies");
    const modalAjustes = document.getElementById("modal-ajustes-cookies");

    // Botones del Banner
    const btnAceptarBanner = document.getElementById("btn-aceptar-cookies");
    const btnRechazarBanner = document.getElementById("btn-rechazar-cookies");
    const btnConfigurar = document.getElementById("btn-configurar-cookies");

    // Botones del Modal
    const btnCerrarModal = document.getElementById("btn-cerrar-ajustes");
    const btnModalAceptar = document.getElementById("btn-modal-aceptar");
    const btnModalRechazar = document.getElementById("btn-modal-rechazar");

    // NOTA: Se eliminaron los selectores de "switches" (tgFuncionales, tgAnaliticas, etc.) 
    // y el botón "btnModalEnviar" porque ya no se usan en la nueva vista informativa.

    function obtenerCookie(nombre) {
        let match = document.cookie.match(new RegExp('(^| )' + nombre + '=([^;]+)'));
        if (match) return decodeURIComponent(match[2]);
        return null;
    }

// 1. Leemos en qué página estamos actualmente
    const rutaActual = window.location.pathname;

    // 2. Verificamos si la ruta contiene el nombre de tus archivos legales
    const esPaginaLegal = rutaActual.includes('aviso_privacidad') || rutaActual.includes('politica_cookies');

    // 3. Condición: Si NO hay cookie Y NO es una página legal, mostramos el banner
    if (!obtenerCookie('astech_preferencias_cookies') && !esPaginaLegal) {
        banner.style.display = "flex";
        overlay.style.display = "block";
        document.body.classList.add("bloquear-scroll");
    }

    function guardarPreferencias(preferencias) {
        preferencias.necesarias = true;
        let fechaExpiracion = new Date();
        fechaExpiracion.setTime(fechaExpiracion.getTime() + (365 * 24 * 60 * 60 * 1000));
        document.cookie = "astech_preferencias_cookies=" + encodeURIComponent(JSON.stringify(preferencias)) + "; expires=" + fechaExpiracion.toUTCString() + "; path=/";

        banner.style.display = "none";
        modalAjustes.style.display = "none";
        overlay.style.display = "none";
        document.body.classList.remove("bloquear-scroll");
    }

    // Eventos Banner
    if (btnAceptarBanner) {
        btnAceptarBanner.addEventListener("click", function () {
            // Guardamos analíticas en TRUE, el resto se ignora por el nuevo modelo
            guardarPreferencias({ analiticas: true });
        });
    }

    if (btnRechazarBanner) {
        btnRechazarBanner.addEventListener("click", function () {
            // Guardamos analíticas en FALSE
            guardarPreferencias({ analiticas: false });
        });
    }

    if (btnConfigurar) {
        btnConfigurar.addEventListener("click", function () {
            banner.style.display = "none";
            modalAjustes.style.display = "flex";
        });
    }

    // Eventos Modal
    if (btnCerrarModal) {
        btnCerrarModal.addEventListener("click", function () {
            modalAjustes.style.display = "none";
            banner.style.display = "flex";
        });
    }

    if (btnModalAceptar) {
        btnModalAceptar.addEventListener("click", function () {
            guardarPreferencias({ analiticas: true });
        });
    }

    if (btnModalRechazar) {
        btnModalRechazar.addEventListener("click", function () {
            guardarPreferencias({ analiticas: false });
        });
    }
});