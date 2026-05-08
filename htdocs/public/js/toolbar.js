/* TOOLBAR.JS */
/*
 * PÁGINA: Script de la Barra de Navegación (Toolbar JS) - As Tech Computer
 * PROPÓSITO: Centralizar toda la lógica interactiva del lado del cliente (Frontend) para la barra de navegación principal.
 * FUNCIONALIDADES: 
 * - Control del Menú Móvil: Despliegue lateral del menú tipo "hamburguesa" y transición de su ícono a una "X".
 * - Gestión del Mega Menú: Controla la apertura del menú de servicios en dispositivos móviles previniendo redirecciones accidentales, e incluye rotación animada de íconos.
 * - Motor de Búsqueda Dinámica (AJAX/Fetch): Despliega el contenedor de búsqueda y envía peticiones asíncronas al servidor conforme el usuario escribe, procesando e inyectando los resultados sin recargar la página.
 * - Navegación Integrada: Manejo de clics en los resultados de búsqueda para redirigir directamente al detalle del servicio, utilizando variables globales (APP_BASE_URL) para evitar errores de rutas.
 */

/* ========================================================
   1. ENCAPSULAMIENTO DEL CÓDIGO (IIFE)
   ======================================================== */
/**
 * El sistema encapsula toda la lógica principal dentro de una función 
 * autoejecutable (IIFE) para evitar que las variables colisionen con 
 * otros scripts cargados en la plataforma.
 */
(function () {
    /* ========================================================
       2. CONTROL DEL MENÚ HAMBURGUESA (MÓVILES)
       ======================================================== */
    const mobileMenuBtn = document.getElementById("mobile-menu");
    const navLinks = document.getElementById("nav-links");
    const serviciosHover = document.querySelector(".servicios-hover");

    // El sistema escucha los clics en el botón hamburguesa para deslizar el menú
    // y alterna dinámicamente el ícono entre las barras y la "X" de cierre.
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener("click", function () {
            navLinks.classList.toggle("active");

            const icon = mobileMenuBtn.querySelector("i");
            if (navLinks.classList.contains("active")) {
                icon.classList.remove("fa-bars");
                icon.classList.add("fa-xmark");
            } else {
                icon.classList.remove("fa-xmark");
                icon.classList.add("fa-bars");
            }
        });
    }

    /* ========================================================
       3. INTERACTIVIDAD DEL MEGA MENÚ (MÓVILES)
       ======================================================== */
    // En resoluciones menores a 992px, el sistema previene que el botón "Servicios"
    // recargue la página, transformándolo en un gatillo (trigger) que despliega 
    // el Mega Menú vertical y anima su flecha indicadora.
    if (serviciosHover) {
        const enlaceServicios = serviciosHover.querySelector('.btn-servicios');

        if (enlaceServicios) {
            enlaceServicios.addEventListener("click", function (e) {
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    serviciosHover.classList.toggle("active");

                    const flecha = this.querySelector('.hidden-desktop');
                    if (flecha) {
                        flecha.style.transform = serviciosHover.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
                    }
                }
            });
        }
    }

    /* ========================================================
       4. SISTEMA DEL BUSCADOR GLOBAL Y PETICIONES ASÍNCRONAS
       ======================================================== */
    const buscadorContainer = document.getElementById('contenedorBuscador');
    const inputBusqueda = document.getElementById('inputBuscador');
    const resultadosDiv = document.getElementById('resultadosBusqueda');

    // 4.1. Animación y apertura del contenedor de búsqueda
    // El sistema expone esta función globalmente para que el botón HTML la ejecute.
    // Además, asegura el cierre automático del menú móvil si este se encontraba abierto.
    window.abrirBuscador = function () {
        if (buscadorContainer) {
            buscadorContainer.classList.toggle('active');
            if (buscadorContainer.classList.contains('active')) {
                setTimeout(() => inputBusqueda.focus(), 300);
            }
        }
        if (navLinks && navLinks.classList.contains('active')) {
            mobileMenuBtn.click();
        }
    };

    // 4.2. Motor de búsqueda en tiempo real (Fetch API)
    // El sistema captura cada pulsación de tecla y envía los datos al backend (PHP).
    // Evita sobrecargar el servidor limitando la consulta a un mínimo de 2 caracteres.
    if (inputBusqueda) {
        inputBusqueda.addEventListener("keyup", () => {
            let valor = inputBusqueda.value;
            if (valor.length < 2) {
                resultadosDiv.innerHTML = "";
                return;
            }

            // Se concatena la ruta base segura (inyectada desde la vista PHP) con el término de búsqueda
            fetch(APP_BASE_URL + "app/controllers/buscar_servicio.php?q=" + valor)
                .then(res => res.text())
                .then(data => {
                    resultadosDiv.innerHTML = data;
                })
                .catch(err => console.error("Error en búsqueda:", err));
        });
    }

    /* ========================================================
       5. NAVEGACIÓN Y CIERRE DE ELEMENTOS
       ======================================================== */

// Busca esta parte y déjala exactamente así:
if (resultados) {
    resultados.addEventListener("click", (e) => {
        const item = e.target.closest(".resultado-item");
        if (item) {
            let id = item.getAttribute("data-id");
            if (id && id !== "null") {
                // REDIRECCIÓN DIRECTA A LA PANTALLA COMPLETA
                window.location.href = "../../app/controllers/detalle_servicio_controller.php?id=" + id;
            }
        }
    });
}
    // 5.2. Animación de los submenús (Acordeones del Mega Menú)
    document.querySelectorAll('.titulo-tipo-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const submenu = button.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('active');
            }
            button.classList.toggle('active');

            const icon = button.querySelector('i');
            if (icon) {
                icon.style.transform = button.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
    });

    // 5.3. Cierre del buscador al clicar en el área gris externa (Overlay)
    window.addEventListener('click', (e) => {
        if (e.target == buscadorContainer) {
            buscadorContainer.classList.remove('active');
        }
    });
})();

/* ========================================================
   6. FUNCIONES GLOBALES EXPUESTAS
   ======================================================== */
/**
 * Permite la redirección forzada a los detalles de un servicio desde 
 * elementos HTML que no estén controlados por el sistema de delegación 
 * interno del buscador.
 */
function verServicio(id) {
    window.location.href = APP_BASE_URL + "detalle_servicio.php?id=" + id;
}