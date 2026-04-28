// ========================================================
// SCRIPT: servicios.js
// UBICACIÓN: public/js/servicios.js
// ========================================================

const btn = document.getElementById("btnBuscador");
const contenedor = document.getElementById("contenedorBuscador");
const input = document.getElementById("inputBuscador");
const resultados = document.getElementById("resultadosBusqueda");
const modal = document.getElementById("modalServicio");
const contenidoModal = document.getElementById("contenidoModal");
const cerrar = document.querySelector(".cerrar");

// Abrir buscador
function abrirBuscador() {
    const buscador = document.querySelector('.buscador-oculto');
    if(buscador) {
        buscador.classList.toggle('active');
    }
}

// Búsqueda en tiempo real
if(input) {
    input.addEventListener("keyup", () => {
        let valor = input.value;
        
        // Ajustamos la ruta asumiendo que "acciones" está dentro de app/views/
        fetch("../views/acciones/buscar_servicio.php?q=" + valor)
            .then(res => res.text())
            .then(data => {
                resultados.innerHTML = data;
            })
            .catch(err => console.error("Error en búsqueda:", err));
    });
}

// Clic en los resultados de la búsqueda
if(resultados) {
    resultados.addEventListener("click", (e) => {
        const item = e.target.closest(".resultado-item");

        if(item) {
            let id = item.getAttribute("data-id");

            fetch("../views/acciones/obtener_servicio.php?id=" + id)
                .then(res => res.text())
                .then(data => {
                    contenidoModal.innerHTML = data;
                    modal.style.display = "block";
                })
                .catch(err => console.error("Error obteniendo detalle:", err));
        }
    });
}

// Cerrar modal dando click en la "X"
if(cerrar) {
    cerrar.addEventListener("click", () => {
        modal.style.display = "none";
    });
}

// Cerrar modal dando click afuera del contenido
window.addEventListener("click", (e) => {
    if(e.target === modal) {
        modal.style.display = "none";
    }


    // ... tu código anterior ...

    const resultados = document.getElementById("resultados"); // <-- Asegúrate de obtener la referencia

    if (resultados) { // <-- Validación crucial para evitar el ReferenceError
        resultados.addEventListener("click", (e) => {
            const item = e.target.closest(".resultado-item");
            if (item) {
                let id = item.getAttribute("data-id");
                // Tu lógica de fetch aquí...
                fetch("acciones/obtener_servicio.php?id=" + id)
                    .then(res => res.text())
                    .then(data => {
                        const contenidoModal = document.getElementById("contenidoModal");
                        const modal = document.getElementById("modalServicio");
                        if (contenidoModal && modal) {
                            contenidoModal.innerHTML = data;
                            modal.style.display = "block";
                        }
                    });
            }
        });
    }
});