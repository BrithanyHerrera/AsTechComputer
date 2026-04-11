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
    const btnModalEnviar = document.getElementById("btn-modal-enviar");
    const btnModalAceptar = document.getElementById("btn-modal-aceptar");
    const btnModalRechazar = document.getElementById("btn-modal-rechazar");

    // Switches
    const tgFuncionales = document.getElementById("toggle-funcionales");
    const tgAnaliticas = document.getElementById("toggle-analiticas");
    const tgPublicidad = document.getElementById("toggle-publicidad");

    function obtenerCookie(nombre) {
        let match = document.cookie.match(new RegExp('(^| )' + nombre + '=([^;]+)'));
        if (match) return decodeURIComponent(match[2]);
        return null;
    }

    if (!obtenerCookie('astech_preferencias_cookies')) {
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
    btnAceptarBanner.addEventListener("click", function () {
        guardarPreferencias({ funcionales: true, analiticas: true, publicidad: true });
    });
    btnRechazarBanner.addEventListener("click", function () {
        guardarPreferencias({ funcionales: false, analiticas: false, publicidad: false });
    });
    btnConfigurar.addEventListener("click", function () {
        banner.style.display = "none";
        modalAjustes.style.display = "flex";
    });

    // Eventos Modal
    btnCerrarModal.addEventListener("click", function () {
        modalAjustes.style.display = "none";
        banner.style.display = "flex";
    });
    btnModalEnviar.addEventListener("click", function () {
        guardarPreferencias({ funcionales: tgFuncionales.checked, analiticas: tgAnaliticas.checked, publicidad: tgPublicidad.checked });
    });
    btnModalAceptar.addEventListener("click", function () {
        guardarPreferencias({ funcionales: true, analiticas: true, publicidad: true });
    });
    btnModalRechazar.addEventListener("click", function () {
        guardarPreferencias({ funcionales: false, analiticas: false, publicidad: false });
    });
});