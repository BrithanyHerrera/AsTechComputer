document.addEventListener("DOMContentLoaded", function () {
    const banner = document.getElementById("banner-cookies");
    const overlay = document.getElementById("overlay-bloqueo");
    const btnAceptar = document.getElementById("btn-aceptar-cookies");
    const btnRechazar = document.getElementById("btn-rechazar-cookies");

    if (!document.cookie.split('; ').find(row => row.startsWith('astech_cookies_estado='))) {
        banner.style.display = "flex";
        overlay.style.display = "block";
        document.body.classList.add("bloquear-scroll");
    }

    function procesarDecision(decision) {
        banner.style.display = "none";
        overlay.style.display = "none";
        document.body.classList.remove("bloquear-scroll");
        let fechaExpiracion = new Date();
        fechaExpiracion.setTime(fechaExpiracion.getTime() + (365 * 24 * 60 * 60 * 1000));
        document.cookie = "astech_cookies_estado=" + decision + "; expires=" + fechaExpiracion.toUTCString() + "; path=/";
    }

    btnAceptar.addEventListener("click", function () { procesarDecision("aceptadas"); });
    btnRechazar.addEventListener("click", function () { procesarDecision("rechazadas"); });
});