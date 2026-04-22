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
        const espacio = selectEspacio ? selectEspacio.value : "";
        
        if (prefijo && espacio) {
            inputFolio.value = prefijo + "-" + espacio;
        } else {
            inputFolio.value = ""; 
        }
    }

    // Función reutilizable para poblar el select de espacios.
    // Lee SOLO de espaciosDB, que PHP construye con WHERE estado='disponible'.
    // Por lo tanto, este select nunca puede mostrar gabinetes ocupados.
    function poblarEspacios(tipoSeleccionado) {
        if (!selectEspacio) return false;
        selectEspacio.innerHTML = '<option value="">Seleccione un espacio...</option>';

        if (typeof espaciosDB !== 'undefined' && tipoSeleccionado && espaciosDB[tipoSeleccionado]) {
            const lugaresDisponibles = espaciosDB[tipoSeleccionado];
            if (lugaresDisponibles.length === 0) {
                selectEspacio.innerHTML = '<option value="">¡Bodega Llena!</option>';
                return false;
            }
            lugaresDisponibles.forEach(idGabinete => {
                const el = document.createElement("option");
                el.value = idGabinete;
                el.textContent = "Espacio " + idGabinete;
                selectEspacio.appendChild(el);
            });
            return true;
        }
        return false;
    }

    // Escuchar cuando cambie la fecha
    if (inputFecha) {
        inputFecha.addEventListener("change", actualizarFolio);
    }

    // Escuchar cuando cambie el Tipo de Almacenamiento
    if (selectTipo) {
        selectTipo.addEventListener("change", function () {
            poblarEspacios(this.value);
            actualizarFolio();
        });
    }

    // Escuchar cuando cambie el Espacio seleccionado
    if (selectEspacio) {
        selectEspacio.addEventListener("change", actualizarFolio);
    }

    // =========================================================
    // RESTAURAR SELECT DINÁMICO AL VOLVER AL PASO 2
    // PHP ya verificó que savedEspacioAlmacenamiento sigue siendo
    // un gabinete disponible. Si ya no lo era, PHP lo dejó vacío
    // y mostró un mensaje de error al usuario.
    // =========================================================
    if (selectTipo &&
        typeof savedTipoAlmacenamiento !== 'undefined' &&
        savedTipoAlmacenamiento !== '') {

        const pudoPoblar = poblarEspacios(savedTipoAlmacenamiento);

        if (pudoPoblar &&
            typeof savedEspacioAlmacenamiento !== 'undefined' &&
            savedEspacioAlmacenamiento !== '') {
            selectEspacio.value = savedEspacioAlmacenamiento;
        }
        actualizarFolio();

    } else if (inputFolio) {
        actualizarFolio();
    }

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

    /* =========================================================
       IMPORTADOR MÁGICO DE CITAS AL FORMULARIO DE INGRESO
       ========================================================= */
    const selectImportar = document.getElementById('importar_cita');
    
    // Recuperamos el JSON de citas que PHP imprimió en la página
    // Nota: Necesitas asegurarte de imprimir const citasDB = <?php echo $json_citas; ?>; en tu ingreso.php dentro del <script>
    
    if (selectImportar && typeof citasDB !== 'undefined') {
        selectImportar.addEventListener('change', function() {
            const idCita = this.value;
            
            if (idCita && citasDB[idCita]) {
                const cita = citasDB[idCita];
                
                // Llenar PASO 1: Cliente
                document.querySelector('input[name="nombre_cliente"]').value = cita.nombre_cliente || '';
                document.querySelector('input[name="apellido_cliente"]').value = cita.apellido_cliente || '';
                document.querySelector('input[name="telefono_cliente"]').value = cita.whatsapp || '';
                
                // Llenar PASO 2: Motivo de ingreso
                let problemaCompleto = cita.problema_reportado || '';
                if(cita.detalle_falla) {
                    problemaCompleto += " - " + cita.detalle_falla;
                }
                const campoMotivo = document.querySelector('textarea[name="motivo_ingreso"]');
                if(campoMotivo) campoMotivo.value = problemaCompleto;

                // Llenar PASO 5: Equipo (El reto de los selects anidados)
                const selectTipo = document.querySelector('select[name="tipo_equipo"]');
                if(selectTipo && cita.id_tipo_equipo) {
                    selectTipo.value = cita.id_tipo_equipo;
                    // Forzamos el evento 'change' para que se actualicen las marcas
                    selectTipo.dispatchEvent(new Event('change'));
                }

                // Le damos 100 milisegundos a la computadora para que cargue las marcas, y luego seleccionamos la correcta
                setTimeout(() => {
                    const selectMarca = document.querySelector('select[name="marca"]');
                    if(selectMarca && cita.id_marca) {
                        selectMarca.value = cita.id_marca;
                    }
                }, 100);

                const campoModelo = document.querySelector('input[name="modelo"]');
                if(campoModelo) campoModelo.value = cita.modelo || '';
                
                const campoSerie = document.querySelector('input[name="numero_serie"]');
                if(campoSerie) campoSerie.value = cita.numero_serie || '';
                
                // Lanzamos una alerta elegante para avisar al técnico
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Datos de la cita importados',
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            }
        });
    }
});