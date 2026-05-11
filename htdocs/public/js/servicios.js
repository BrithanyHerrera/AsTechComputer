// ========================================================
// SCRIPT: servicios.js
// UBICACIÓN: public/js/servicios.js
// ========================================================

document.addEventListener("DOMContentLoaded", () => {

    /* =========================================
       VARIABLES
    ========================================= */
    const input = document.getElementById("inputBuscador");
    const resultados = document.getElementById("resultadosBusqueda");
const btnCerrar = document.getElementById("cerrarBuscador");
    const contenedor = document.getElementById("contenedorBuscador");
    const modal = document.getElementById("modalServicio");
    const contenidoModal = document.getElementById("contenidoModal");
    const cerrar = document.querySelector(".cerrar");

    /* =========================================
       CAROUSEL
    ========================================= */
    const slides = document.querySelectorAll(".carousel-slide");
// LÓGICA PARA CERRAR EL BUSCADOR

if (btnCerrar && contenedorBuscador) {
        btnCerrar.onclick = function() {
            contenedorBuscador.classList.remove("active");
            // Limpieza opcional
            if(input) input.value = "";
            if(resultados) resultados.innerHTML = "";
        };
    }

    // 3. Cerrar con Escape
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && contenedorBuscador.classList.contains("active")) {
            contenedorBuscador.classList.remove("active");
        }
    });

    // Cerrar también si se presiona la tecla Escape
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && contenedorBuscador.classList.contains("active")) {
            contenedorBuscador.classList.remove("active");
        }
    });
    let currentSlide = 0;

    function nextSlide() {

        if (slides.length === 0) return;

        slides[currentSlide].classList.remove("active");

        currentSlide = (currentSlide + 1) % slides.length;

        slides[currentSlide].classList.add("active");
    }

    setInterval(nextSlide, 4000);

    /* =========================================
       BUSCADOR
    ========================================= */

    if (input) {

        input.addEventListener("keyup", () => {

            let valor = input.value;

            fetch("../controllers/buscar_servicio.php?q=" + valor)

                .then(res => res.text())

                .then(data => {

                    resultados.innerHTML = data;

                })

                .catch(err => console.error("Error en búsqueda:", err));

        });

    }

    /* =========================================
       CLICK EN RESULTADOS
    ========================================= */

    if (resultados) {

        resultados.addEventListener("click", (e) => {

            const item = e.target.closest(".resultado-item");

            if (item) {

                let id = item.getAttribute("data-id");

                if (id) {

                    verServicio(id);

                }

            }

        });

    }

    /* =========================================
       CERRAR MODAL
    ========================================= */

    if (cerrar) {

        cerrar.addEventListener("click", () => {

            modal.style.display = "none";

        });

    }

    window.addEventListener("click", (e) => {

        if (e.target === modal) {

            modal.style.display = "none";

        }

    });

});

/* =========================================
   ABRIR BUSCADOR
========================================= */

function abrirBuscador() {

    const buscador = document.querySelector(".buscador-oculto");

    if (buscador) {

        buscador.classList.toggle("active");

    }

}

/* =========================================
   REDIRECCIÓN
========================================= */

function verServicio(id) {

    if (id) {

        window.location.href =
            "../../app/controllers/detalle_servicio_controller.php?id=" + id;

    }

}