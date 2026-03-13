document.addEventListener("DOMContentLoaded", function () {
    const inputFecha = document.getElementById('fecha_ingreso');
    const selectTipo = document.getElementById('tipo_almacenamiento');
    const selectEspacio = document.getElementById('espacio_almacenamiento');
    const inputFolio = document.getElementById('folio_auto');

    // Función para convertir fecha YYYY-MM-DD a DDMMAAAA (Ej. 2026-03-13 -> 13032026)
    function formatearFechaFolio(fechaStr) {
        if (!fechaStr) return "";
        const partes = fechaStr.split("-");
        if (partes.length === 3) {
            const dia = partes[2];
            const mes = partes[1];
            const anio = partes[0]; 
            return dia + mes + anio;
        }
        return "";
    }

    // Función para unir la fecha con el espacio
    function actualizarFolio() {
        if (!inputFolio || !inputFecha) return;
        const prefijo = formatearFechaFolio(inputFecha.value);
        const espacio = selectEspacio.value ? selectEspacio.value : "";
        
        if (prefijo && espacio) {
            inputFolio.value = prefijo + "-" + espacio;
        } else {
            inputFolio.value = ""; 
        }
    }

    // Escuchar cuando cambie la fecha
    if (inputFecha) {
        inputFecha.addEventListener("change", actualizarFolio);
    }

    // Escuchar cuando cambie el Tipo de Almacenamiento (Laptop, PC, Consola)
    if (selectTipo) {
        selectTipo.addEventListener("change", function () {
            selectEspacio.innerHTML = '<option value="">Seleccione un espacio...</option>';
            const tipoSeleccionado = this.value;

            if (typeof espaciosDB !== 'undefined' && tipoSeleccionado && espaciosDB[tipoSeleccionado]) {
                const lugaresDisponibles = espaciosDB[tipoSeleccionado];
                
                if (lugaresDisponibles.length === 0) {
                    selectEspacio.innerHTML = '<option value="">¡Bodega Llena!</option>';
                } else {
                    lugaresDisponibles.forEach(idGabinete => {
                        let el = document.createElement("option");
                        el.value = idGabinete;
                        el.textContent = "Espacio " + idGabinete;
                        selectEspacio.appendChild(el);
                    });
                }
            }
            actualizarFolio();
        });
    }

    // Escuchar cuando cambie el Espacio seleccionado
    if (selectEspacio) {
        selectEspacio.addEventListener("change", actualizarFolio);
    }

    if (inputFolio) actualizarFolio();

    /* =========================================================
       SELECTS ANIDADOS: FILTRAR MARCAS SEGÚN EL TIPO DE EQUIPO
       ========================================================= */
    const selectTipoEquipo = document.getElementById('selector_tipo_equipo');
    const selectMarca = document.getElementById('selector_marca');

    if (selectTipoEquipo && selectMarca) {
        const opcionesMarcaOriginales = Array.from(selectMarca.options);

        function actualizarMarcas() {
            const idTipoSeleccionado = selectTipoEquipo.value;
            
            selectMarca.innerHTML = '';

            opcionesMarcaOriginales.forEach(opcion => {
                const idMarca = opcion.value;

                if (idMarca === "") {
                    selectMarca.appendChild(opcion);
                    return;
                }

                if (typeof relacionesEquipoMarca !== 'undefined' && relacionesEquipoMarca[idTipoSeleccionado]) {
                    if (relacionesEquipoMarca[idTipoSeleccionado].map(String).includes(String(idMarca))) {
                        selectMarca.appendChild(opcion);
                    }
                }
            });
        }

        selectTipoEquipo.addEventListener('change', actualizarMarcas);
        
        if (selectTipoEquipo.value !== "") {
            actualizarMarcas();
        }
    }
});