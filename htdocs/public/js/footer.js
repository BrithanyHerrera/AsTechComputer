/* FOOTER.CSS */
/*
Este archivo concentra la lógica del lado del cliente (Frontend) para la gestión del consentimiento de privacidad y uso de cookies. Su función principal es evaluar si el usuario ya ha registrado una preferencia en el sistema; de no ser así, despliega el banner de advertencia (bloqueando el desplazamiento de la página para captar la atención), a menos que el usuario se encuentre visitando documentos legales donde el banner sería intrusivo. Finalmente, captura la decisión del cliente (aceptar o rechazar analíticas) y almacena esta preferencia en una cookie con vigencia de un año, ocultando la interfaz de manera fluida.
*/

/* ========================================================
   1. INICIALIZACIÓN Y SELECCIÓN DE ELEMENTOS DEL DOM
   ======================================================== */
// El script guarda todo el contenido HTML que haya sido cargado antes de ejecutarse.
document.addEventListener("DOMContentLoaded", function () {

    // Contenedores principales de la interfaz de privacidad
    const overlay = document.getElementById("overlay-bloqueo");
    const banner = document.getElementById("banner-cookies");
    const modalAjustes = document.getElementById("modal-ajustes-cookies");

    // Botones de acción directa en el Banner inicial
    const btnAceptarBanner = document.getElementById("btn-aceptar-cookies");
    const btnRechazarBanner = document.getElementById("btn-rechazar-cookies");
    const btnConfigurar = document.getElementById("btn-configurar-cookies");

    // Botones de acción dentro del Modal de configuración detallada
    const btnCerrarModal = document.getElementById("btn-cerrar-ajustes");
    const btnModalAceptar = document.getElementById("btn-modal-aceptar");
    const btnModalRechazar = document.getElementById("btn-modal-rechazar");

    // NOTA OPERATIVA: Se eliminaron los selectores de "switches" (tgFuncionales, tgAnaliticas, etc.) 
    // y el botón "btnModalEnviar" debido a la optimización hacia un modelo informativo más directo.

    /* ========================================================
       2. FUNCIONES AUXILIARES (LECTURA DE COOKIES)
       ======================================================== */
    /**
     * Busca y recupera el valor de una cookie específica en el navegador del usuario.
     * @param {string} nombre - El identificador de la cookie a buscar.
     * @returns {string|null} - El valor decodificado de la cookie, o null si no existe.
     */
    function obtenerCookie(nombre) {
        let match = document.cookie.match(new RegExp('(^| )' + nombre + '=([^;]+)'));
        if (match) return decodeURIComponent(match[2]);
        return null;
    }

    /* ========================================================
       3. LÓGICA DE VISUALIZACIÓN CONDICIONAL
       ======================================================== */
    // Identifica la URL actual para evitar interrupciones en páginas informativas.
    const rutaActual = window.location.pathname;

    // Determina si el usuario se encuentra leyendo documentos normativos.
    const esPaginaLegal = rutaActual.includes('aviso_privacidad') || rutaActual.includes('politica_cookies');

    // Despliega el banner únicamente si no hay preferencias previas guardadas y no es una página legal.
    if (!obtenerCookie('astech_preferencias_cookies') && !esPaginaLegal) {
        banner.style.display = "flex";
        overlay.style.display = "block";
        document.body.classList.add("bloquear-scroll"); // Fija la pantalla para exigir una acción
    }

    /* ========================================================
       4. MOTOR DE ALMACENAMIENTO DE PREFERENCIAS
       ======================================================== */
    /**
     * Procesa la decisión del usuario, la codifica en formato JSON y la almacena 
     * en el navegador con un tiempo de expiración de 1 año (365 días).
     * Posteriormente, limpia y oculta los elementos visuales invasivos.
     */
    function guardarPreferencias(preferencias) {
        preferencias.necesarias = true; // Las cookies técnicas siempre son requeridas por el sistema
        let fechaExpiracion = new Date();
        fechaExpiracion.setTime(fechaExpiracion.getTime() + (365 * 24 * 60 * 60 * 1000));
        
        document.cookie = "astech_preferencias_cookies=" + encodeURIComponent(JSON.stringify(preferencias)) + "; expires=" + fechaExpiracion.toUTCString() + "; path=/";

        // Cierre de la interfaz de privacidad
        banner.style.display = "none";
        modalAjustes.style.display = "none";
        overlay.style.display = "none";
        document.body.classList.remove("bloquear-scroll");
    }

    /* ========================================================
       5. CONTROLADORES DE EVENTOS: BANNER INICIAL
       ======================================================== */
    if (btnAceptarBanner) {
        btnAceptarBanner.addEventListener("click", function () {
            // Activa el rastreo estadístico (Analytics)
            guardarPreferencias({ analiticas: true });
        });
    }

    if (btnRechazarBanner) {
        btnRechazarBanner.addEventListener("click", function () {
            // Bloquea el rastreo estadístico (Analytics)
            guardarPreferencias({ analiticas: false });
        });
    }

    if (btnConfigurar) {
        btnConfigurar.addEventListener("click", function () {
            // Transiciona del banner básico al modal detallado
            banner.style.display = "none";
            modalAjustes.style.display = "flex";
        });
    }

    /* ========================================================
       6. CONTROLADORES DE EVENTOS: MODAL DE AJUSTES
       ======================================================== */
    if (btnCerrarModal) {
        btnCerrarModal.addEventListener("click", function () {
            // Regresa al banner inicial si el usuario decide no configurar nada
            modalAjustes.style.display = "none";
            banner.style.display = "flex";
        });
    }

    if (btnModalAceptar) {
        btnModalAceptar.addEventListener("click", function () {
            // Acepta todas las políticas desde el modal
            guardarPreferencias({ analiticas: true });
        });
    }

    if (btnModalRechazar) {
        btnModalRechazar.addEventListener("click", function () {
            // Rechaza explícitamente el rastreo desde el modal
            guardarPreferencias({ analiticas: false });
        });
    }
});