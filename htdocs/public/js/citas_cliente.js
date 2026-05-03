/* CITAS_CLIENTE.JS */
/*
 * PÁGINA: Script de Interacción del Cliente (Client Interaction JS) - As Tech Computer
 * PROPÓSITO: Gestionar la interactividad del lado del cliente para el formulario de agendamiento de citas, mejorando la experiencia del usuario (UX) mediante validaciones dinámicas y manipulación del DOM en tiempo real.
 * FUNCIONALIDADES:
 * - Control dinámico de la visibilidad de campos de texto auxiliares cuando el usuario selecciona opciones personalizadas (ej. "Otro").
 * - Filtrado en cascada de selectores: ajusta las opciones de "Marca" disponibles basándose estrictamente en el "Tipo de Dispositivo" seleccionado previamente.
 * - Validación en tiempo real para bloquear entradas manuales de marcas restringidas por política operativa de la empresa (ej. Apple/Mac), alertando al usuario de forma inmediata.
 * - Interceptación del evento de envío del formulario (submit) para recolectar los datos ingresados y renderizarlos en una ventana modal de confirmación.
 * - Despliegue dinámico de horarios disponibles, excluyendo en tiempo real las horas que ya se encuentran agendadas para la fecha seleccionada (cruzando datos con un arreglo inyectado desde el backend).
 */

/* ==========================================
   1. LÓGICA DE CAMPOS DINÁMICOS (MOSTRAR/OCULTAR "OTRO")
   ========================================== */
/**
 * El sistema evalúa el valor seleccionado en un elemento <select>. 
 * Si el usuario elige un identificador personalizado de servicios, 
 * despliega un campo de texto oculto y lo marca como obligatorio (required).
 */
function toggleOtro(select, idContenedor) {
    const contenedor = document.getElementById(idContenedor);
    const inputInterno = contenedor.querySelector('input, textarea');

    if (select.value === "7" || select.value === "12" || select.value === "Otro") {
        contenedor.style.display = "block";
        inputInterno.required = true;
        inputInterno.focus();
    } else {
        contenedor.style.display = "none";
        inputInterno.required = false;
        inputInterno.value = ""; 
    }
}

/* ==========================================
   2. SELECTS ANIDADOS (FILTRAR MARCAS POR EQUIPO)
   ========================================== */
/**
 * El script detecta cambios en el selector de "Tipo de Dispositivo" y 
 * reconstruye las opciones del selector de "Marca" basándose en el 
 * objeto de relaciones (relacionesEquipoMarca) pre-cargado desde el servidor.
 */
const selectTipo = document.querySelector('select[name="tipo_dispositivo"]');
const selectMarca = document.querySelector('select[name="marca"]');

if (selectTipo && selectMarca) {
    const opcionesMarcaOriginales = Array.from(selectMarca.options);

    selectTipo.addEventListener('change', function() {
        const idTipoSeleccionado = this.value;

        selectMarca.innerHTML = '';
        document.getElementById('otra_marca_box').style.display = "none";

        opcionesMarcaOriginales.forEach(opcion => {
            const idMarca = opcion.value;

            // Conserva siempre las opciones vacías o genéricas (ej. 12 = "Otra")
            if (idMarca === "" || idMarca === "12") {
                selectMarca.appendChild(opcion);
                return;
            }

            // Filtra y añade solo las marcas compatibles con el equipo seleccionado
            if (typeof relacionesEquipoMarca !== 'undefined' && relacionesEquipoMarca[idTipoSeleccionado]) {
                if (relacionesEquipoMarca[idTipoSeleccionado].map(String).includes(String(idMarca))) {
                    selectMarca.appendChild(opcion);
                }
            }
        });
    });
}

/* ==========================================
   3. VALIDACIÓN DE MARCA RESTRINGIDA (APPLE)
   ========================================== */
/**
 * El sistema previene que el usuario ingrese texto relacionado con 
 * el ecosistema de Apple en el campo de entrada manual, lanzando 
 * una alerta de política técnica y limpiando la cadena de texto ingresada.
 */
const inputOtraMarca = document.querySelector('input[name="otra_marca_texto"]');

if (inputOtraMarca) {
    inputOtraMarca.addEventListener('input', function (e) {
        const valor = e.target.value.toLowerCase();
        if (valor.includes('apple') || valor.includes('mac')) {
            alert('Lo sentimos, por normatividad técnica de As Tech Computer, no trabajamos con la arquitectura de Apple.');
            e.target.value = '';
        }
    });
}

/* ==========================================
   4. GESTIÓN DEL MENSAJE DE CONFIRMACIÓN (MODAL)
   ========================================== */
/**
 * El script intercepta el envío predeterminado del formulario, recopila 
 * la información ingresada por el cliente y la imprime en una ventana 
 * modal para forzar una última revisión visual antes de escribir en la base de datos.
 */
const formulario = document.querySelector('form');
const modal = document.getElementById('modalConfirmacion');

if (formulario && modal) {
    formulario.addEventListener('submit', function(e) {
        if (modal.style.display !== 'flex') {
            e.preventDefault(); 

            const nombre = document.querySelector('input[name="nombre_cliente"]').value;
            const apellido = document.querySelector('input[name="apellido_cliente"]').value;
            const nombreCompleto = `${nombre} ${apellido}`;

            const tipoSelect = document.querySelector('select[name="tipo_dispositivo"]');
            const tipoTexto = (tipoSelect.value === "7") 
                ? document.querySelector('input[name="otro_tipo_texto"]').value 
                : tipoSelect.options[tipoSelect.selectedIndex].text;

            const marcaSelect = document.querySelector('select[name="marca"]');
            const marcaTexto = (marcaSelect.value === "12") 
                ? inputOtraMarca.value 
                : marcaSelect.options[marcaSelect.selectedIndex].text;

            const modelo = document.querySelector('input[name="modelo"]').value;
            const fecha = document.querySelector('input[name="fecha_cita"]').value;
            const hora = document.querySelector('select[name="hora_cita"]').value;
            
            document.getElementById('res-nombre').innerText = nombreCompleto;
            document.getElementById('res-equipo').innerText = `${tipoTexto} ${marcaTexto} - ${modelo}`;
            document.getElementById('res-fecha').innerText = fecha;
            document.getElementById('res-hora').innerText = hora;

            modal.style.display = 'flex';
        }
    });
}

/* ==========================================
   5. FUNCIÓN DE ENVÍO FINAL (DESDE EL MODAL)
   ========================================== */
/**
 * Esta función es gatillada desde el botón de "Confirmar" dentro de la modal. 
 * Desactiva el botón para evitar múltiples envíos (Double Submit) y 
 * ejecuta programáticamente el envío final de los datos al servidor.
 */
function cerrarYEnviar() {
    const botonModal = document.querySelector('.modal-contenido .boton-agendar');
    botonModal.disabled = true;
    botonModal.innerText = "Procesando...";
    botonModal.style.backgroundColor = "#ccc"; 
    formulario.submit(); 
}

/* ==========================================
   6. MEJORA DE ACCESIBILIDAD (CERRAR TOOLTIPS)
   ========================================== */
/**
 * El sistema mejora la accesibilidad y usabilidad general permitiendo 
 * que cualquier clic fuera del área del icono de ayuda (Tooltip) 
 * cierre inmediatamente su caja de texto.
 */
document.addEventListener('click', function(e) {
    const ayudaSerie = document.querySelector('.ayuda-serie');
    if (ayudaSerie && !ayudaSerie.contains(e.target)) {
        ayudaSerie.blur();
    }
});

/* ==========================================
   7. ACTUALIZACIÓN DINÁMICA DE HORARIOS DISPONIBLES
   ========================================== */
/**
 * El script evalúa la fecha seleccionada por el cliente y cruza una matriz 
 * de horarios base predefinidos contra el objeto global (citasOcupadas) 
 * renderizado por PHP. Solo imprime como <option> las horas que están libres.
 */
function actualizarHorarios() {
    const selectorHora = document.getElementById('selector_hora');
    const fechaSeleccionada = document.getElementById('fecha_cita').value;

    selectorHora.innerHTML = '<option value="">Selecciona una hora...</option>';

    if (!fechaSeleccionada) return;

    const horariosBase = [
        "10:00", "10:20", "10:40",
        "11:00", "11:20", "11:40",
        "12:00", "12:20", "12:40",
        "13:00", "13:20", "13:40",
        "14:00", "14:20", "14:40",
        "15:00", "15:20", "15:40",
        "16:00"
    ];

    const horasOcupadasHoy = citasOcupadas[fechaSeleccionada] || [];

    let horasDisponibles = 0;
    horariosBase.forEach(hora => {
        if (!horasOcupadasHoy.includes(hora)) {
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = hora;
            selectorHora.appendChild(option);
            horasDisponibles++;
        }
    });

    if (horasDisponibles === 0) {
        selectorHora.innerHTML = '<option value="">No hay disponibilidad este día</option>';
    }
}