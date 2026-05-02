/* INGRESAR_DISPOSITIVO.JS */
/*
 * PÁGINA: Script del Asistente de Ingreso (Ingreso JS) - As Tech Computer
 * PROPÓSITO: Centralizar toda la lógica interactiva del lado del cliente para el formulario de ingreso de equipos.
 * FUNCIONALIDADES: 
 * - Generación automática del Folio de ingreso basado en la fecha y el espacio de almacenamiento seleccionado.
 * - Restricción inteligente de selectores (Cascada): Filtra dinámicamente los espacios disponibles según el tipo de equipo y las marcas asociadas al tipo de dispositivo seleccionado.
 * - Importación mágica de datos: Si el usuario selecciona una cita agendada, el script extrae la información del JSON inyectado y autocompleta el formulario, mostrando una notificación no intrusiva (Toast).
 * - Protección en modo edición: Deshabilita el recálculo del folio si el técnico se encuentra modificando un registro existente.
 * - Alertas y limpieza de URL: Muestra ventanas modales (SweetAlert2) de éxito al finalizar el proceso y limpia los parámetros GET de la URL para evitar reenvíos accidentales.
 */

/* ========================================================
   1. INICIALIZACIÓN Y CONFIGURACIÓN PRINCIPAL
   ======================================================== */
/**
 * El sistema aguarda a que el Document Object Model (DOM) esté completamente
 * cargado antes de inicializar los event listeners.
 */
document.addEventListener("DOMContentLoaded", function () {
    const inputFecha = document.getElementById('fecha_ingreso');
    const selectTipo = document.getElementById('tipo_almacenamiento');
    const selectEspacio = document.getElementById('espacio_almacenamiento');
    const inputFolio = document.getElementById('folio_auto');

    /* ========================================================
       2. GENERACIÓN Y ACTUALIZACIÓN DEL FOLIO
       ======================================================== */
    /**
     * Convierte una fecha estándar (YYYY-MM-DD) al formato continuo 
     * utilizado por AsTech (DDMMAAAA) para el prefijo del folio.
     */
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

    /**
     * Construye el folio final uniendo la fecha formateada y el espacio físico.
     * Incluye un escudo de seguridad que bloquea la alteración del folio si 
     * se detecta que el usuario está en el modo de edición de un registro.
     */
    function actualizarFolio() {
        if (!inputFolio || !inputFecha) return;
        
        // ESCUDO: Si estamos editando, el folio es sagrado y no se recalcula
        if (typeof modoEdicion !== 'undefined' && modoEdicion) return; 

        const prefijo = formatearFechaFolio(inputFecha.value);
        const espacio = selectEspacio ? selectEspacio.value : "";
        
        if (prefijo && espacio) {
            inputFolio.value = prefijo + "-" + espacio;
        } else {
            inputFolio.value = ""; 
        }
    }

    /* ========================================================
       3. LÓGICA DE ALMACENAJE (CASCADA TIPO -> ESPACIO)
       ======================================================== */
    /**
     * Lee la variable global `espaciosDB` (generada por PHP) que contiene 
     * únicamente los gabinetes libres en la base de datos.
     * Rellena el selector secundario basándose en el tipo de equipo seleccionado.
     */
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

    // Suscripción de eventos a los campos principales de almacenaje
    if (inputFecha) {
        inputFecha.addEventListener("change", actualizarFolio);
    }

    if (selectTipo) {
        selectTipo.addEventListener("change", function () {
            poblarEspacios(this.value);
            actualizarFolio();
        });
    }

    if (selectEspacio) {
        selectEspacio.addEventListener("change", actualizarFolio);
    }

    /* ========================================================
       4. RESTAURACIÓN DE ESTADO (PERSISTENCIA DE DATOS)
       ======================================================== */
    /**
     * Al retroceder o avanzar de página, esta rutina verifica si PHP devolvió
     * selecciones previas guardadas en sesión. Si el gabinete seleccionado
     * sigue libre, reconstruye los menús sin intervención del usuario.
     */
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

    /* ========================================================
       5. SELECTS ANIDADOS: FILTRAR MARCAS SEGÚN EL TIPO DE EQUIPO
       ======================================================== */
    /**
     * Utilizando la matriz bidimensional `relacionesEquipoMarca` inyectada 
     * por PHP, este bloque oculta las marcas que no corresponden al tipo 
     * de dispositivo elegido (Por ejemplo, oculta "Asus" si se eligió "Laptop").
     */
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

    /* ========================================================
       6. IMPORTADOR DE CITAS (AUTOCOMPLETADO MÁGICO)
       ======================================================== */
    /**
     * Cuando el técnico selecciona una cita del menú desplegable superior, 
     * el sistema lee el objeto `citasDB` (previamente cargado en memoria RAM por PHP) 
     * y distribuye automáticamente los valores en los campos correspondientes,
     * disparando los eventos necesarios para que los selects anidados reaccionen.
     */
    const selectImportar = document.getElementById('importar_cita');
    
    if (selectImportar && typeof citasDB !== 'undefined') {
        selectImportar.addEventListener('change', function() {
            const idCita = this.value;
            
            if (idCita && citasDB[idCita]) {
                const cita = citasDB[idCita];
                
                // Autocompletado del Paso 1: Información Personal
                document.querySelector('input[name="nombre_cliente"]').value = cita.nombre_cliente || '';
                document.querySelector('input[name="apellido_cliente"]').value = cita.apellido_cliente || '';
                document.querySelector('input[name="telefono_cliente"]').value = cita.whatsapp || '';
                
                // Autocompletado del Paso 2: Motivo y detalle unidos
                let problemaCompleto = cita.problema_reportado || '';
                if(cita.detalle_falla) {
                    problemaCompleto += " - " + cita.detalle_falla;
                }
                const campoMotivo = document.querySelector('textarea[name="motivo_ingreso"]');
                if(campoMotivo) campoMotivo.value = problemaCompleto;

                // Autocompletado del Paso 5: Tipo de Equipo
                const selectTipoObj = document.querySelector('select[name="tipo_equipo"]');
                if(selectTipoObj && cita.id_tipo_equipo) {
                    selectTipoObj.value = cita.id_tipo_equipo;
                    // Forzamos el evento 'change' para obligar a que las marcas se filtren
                    selectTipoObj.dispatchEvent(new Event('change'));
                }

                // Autocompletado del Paso 5: Marca (con retraso deliberado)
                // Se otorga un margen de tiempo para que la función actualizarMarcas() 
                // termine de dibujar las opciones en el DOM antes de seleccionar el valor.
                setTimeout(() => {
                    const selectMarcaObj = document.querySelector('select[name="marca"]');
                    if(selectMarcaObj && cita.id_marca) {
                        selectMarcaObj.value = cita.id_marca;
                    }
                }, 100);

                // Autocompletado del Paso 5: Modelo y Serie
                const campoModelo = document.querySelector('input[name="modelo"]');
                if(campoModelo) campoModelo.value = cita.modelo || '';
                
                const campoSerie = document.querySelector('input[name="numero_serie"]');
                if(campoSerie) campoSerie.value = cita.numero_serie || '';
                
                // Notificación visual de éxito (Toast no obstructivo)
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

/* ========================================================
   7. GESTOR DE ALERTAS GLOBALES Y LIMPIEZA DE URL
   ======================================================== */
/**
 * Un segundo listener independiente se encarga exclusivamente de las notificaciones
 * de estado (Registro exitoso o Modo edición activado), y de purificar 
 * la URL del navegador utilizando la API de History para prevenir que 
 * el usuario reenvíe el formulario accidentalmente al recargar la página.
 */
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);

    // 7.1 Validación de mensaje de éxito final
    if (urlParams.get('status') === 'success' || (typeof registroExitoso !== 'undefined' && registroExitoso)) {
        Swal.fire({
            icon: 'success',
            title: '¡Registro Exitoso!',
            text: 'El equipo y el cliente han sido registrados correctamente en el sistema.',
            confirmButtonColor: '#4f46e5',
            allowOutsideClick: false
        }).then(() => {
            // Limpia la URL eliminando parámetros expuestos
            window.history.replaceState({}, document.title, window.location.pathname + "?seccion=ingreso");
        });
    }

    // 7.2 Ocultamiento silencioso del parámetro de edición en la barra de direcciones
    if (urlParams.has('editar')) {
        window.history.replaceState({}, document.title, window.location.pathname + "?seccion=ingreso");
    }
    
    // 7.3 Redundancia de seguridad para el selector de espacios
    const selectTipoGlobal = document.getElementById('tipo_almacenamiento');
    const selectEspacioGlobal = document.getElementById('espacio_almacenamiento');
    
    if(selectTipoGlobal && selectEspacioGlobal){
       selectTipoGlobal.addEventListener('change', function() {
            const tipo = this.value;
            selectEspacioGlobal.innerHTML = '<option value="">Seleccione espacio...</option>';
            
            if (typeof espaciosDB !== 'undefined' && espaciosDB[tipo]) {
                espaciosDB[tipo].forEach(id => {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = id;
                    selectEspacioGlobal.appendChild(option);
                });
            }
        });
    }
});