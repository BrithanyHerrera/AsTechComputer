document.addEventListener("DOMContentLoaded", function () {
    const inputFecha = document.getElementById('fecha_ingreso');
    const selectTipo = document.getElementById('tipo_almacenamiento');
    const selectEspacio = document.getElementById('espacio_almacenamiento');
    const inputFolio = document.getElementById('folio_auto');

    // Función para convertir fecha YYYY-MM-DD a DDMMAA
    function formatearFechaFolio(fechaStr) {
        if (!fechaStr) return "";
        const partes = fechaStr.split("-");
        const dia = partes[2];
        const mes = partes[1];
        const anio = partes[0];
        return dia + mes + anio;
    }

    function actualizarFolio() {
        if (!inputFolio) return;
        const prefijo = formatearFechaFolio(inputFecha.value);
        const espacio = selectEspacio.value ? selectEspacio.value : "";
        inputFolio.value = prefijo + "-" + espacio;
    }

    if (inputFecha) {
        inputFecha.addEventListener("change", actualizarFolio);
    }

    if (selectTipo) {
        selectTipo.addEventListener("change", function () {
            let opciones = [];
            if (this.value === "laptop") {
                // Laptops: 01 al 10
                for (let i = 1; i <= 10; i++) opciones.push(("0" + i).slice(-2));
            } else if (this.value === "pc" || this.value === "consola") {
                // PC/Consolas: A a la E
                opciones = ['A', 'B', 'C', 'D', 'E'];
            }

            selectEspacio.innerHTML = '<option value="">Seleccione espacio...</option>';
            opciones.forEach(opt => {
                let el = document.createElement("option");
                el.value = opt;
                el.textContent = "Espacio " + opt;
                selectEspacio.appendChild(el);
            });
            actualizarFolio();
        });
    }

    if (selectEspacio) {
        selectEspacio.addEventListener("change", actualizarFolio);
    }

    if (inputFolio) actualizarFolio();
});