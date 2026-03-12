/* --- LÓGICA DE CAMPOS DINÁMICOS --- */

// Función para mostrar/ocultar campos de texto al seleccionar "Otro"
function toggleOtro(select, idContenedor) {
    const contenedor = document.getElementById(idContenedor);
    const inputInterno = contenedor.querySelector('input, textarea');

    // Ahora usamos los IDs de tu base de datos (7=Otro equipo, 12=Otra marca)
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

/* --- SELECTS ANIDADOS (FILTRAR MARCAS POR EQUIPO) --- */
const selectTipo = document.querySelector('select[name="tipo_dispositivo"]');
const selectMarca = document.querySelector('select[name="marca"]');

if (selectTipo && selectMarca) {
    // Guardamos una copia en memoria de TODAS las opciones originales de marca
    const opcionesMarcaOriginales = Array.from(selectMarca.options);

    selectTipo.addEventListener('change', function() {
        const idTipoSeleccionado = this.value;

        // Limpiamos el menú de marcas por completo
        selectMarca.innerHTML = '';
        document.getElementById('otra_marca_box').style.display = "none";

        opcionesMarcaOriginales.forEach(opcion => {
            const idMarca = opcion.value;

            // Siempre regresamos la opción "Selecciona..." ("") y "Otra marca..." ("12")
            if (idMarca === "" || idMarca === "12") {
                selectMarca.appendChild(opcion);
                return;
            }

            // Si el diccionario de PHP dice que esta marca pertenece a este equipo, la mostramos
            if (typeof relacionesEquipoMarca !== 'undefined' && relacionesEquipoMarca[idTipoSeleccionado]) {
                // Comparamos como texto por seguridad
                if (relacionesEquipoMarca[idTipoSeleccionado].map(String).includes(String(idMarca))) {
                    selectMarca.appendChild(opcion);
                }
            }
        });
    });
}

/* --- VALIDACIÓN DE MARCA RESTRINGIDA (APPLE) --- */
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

/* --- GESTIÓN DEL MENSAJE DE CONFIRMACIÓN (MODAL) --- */
const formulario = document.querySelector('form');
const modal = document.getElementById('modalConfirmacion');

if (formulario && modal) {
    formulario.addEventListener('submit', function(e) {
        if (modal.style.display !== 'flex') {
            e.preventDefault(); 

            // CAPTURA DE NOMBRES
            const nombre = document.querySelector('input[name="nombre_cliente"]').value;
            const apellido = document.querySelector('input[name="apellido_cliente"]').value;
            const nombreCompleto = `${nombre} ${apellido}`;

            // CAPTURA INTELIGENTE DE TEXTO (Para evitar mostrar los números/IDs)
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
            // Inyectar datos en el Modal con el texto limpio
            document.getElementById('res-nombre').innerText = nombreCompleto;
            document.getElementById('res-equipo').innerText = `${tipoTexto} ${marcaTexto} - ${modelo}`;
            document.getElementById('res-fecha').innerText = fecha;
            document.getElementById('res-hora').innerText = hora;

            modal.style.display = 'flex';
        }
    });
}

// Función que se ejecuta al presionar "Entendido" en el modal
function cerrarYEnviar() {
    const botonModal = document.querySelector('.modal-contenido .boton-agendar');
    botonModal.disabled = true;
    botonModal.innerText = "Procesando...";
    botonModal.style.backgroundColor = "#ccc"; 
    formulario.submit(); 
}

/* --- MEJORA DE ACCESIBILIDAD --- */
document.addEventListener('click', function(e) {
    const ayudaSerie = document.querySelector('.ayuda-serie');
    if (ayudaSerie && !ayudaSerie.contains(e.target)) {
        ayudaSerie.blur();
    }
});

function actualizarHorarios() {
    const selectorHora = document.getElementById('selector_hora');
    const fechaSeleccionada = document.getElementById('fecha_cita').value;

    // Limpiamos las opciones actuales
    selectorHora.innerHTML = '<option value="">Selecciona una hora...</option>';

    if (!fechaSeleccionada) return;

    // Generamos nuestra plantilla base de horarios (10:00 a 16:00)
    const horariosBase = [
        "10:00", "10:20", "10:40",
        "11:00", "11:20", "11:40",
        "12:00", "12:20", "12:40",
        "13:00", "13:20", "13:40",
        "14:00", "14:20", "14:40",
        "15:00", "15:20", "15:40",
        "16:00"
    ];

    // Buscamos si la fecha seleccionada tiene horas ya reservadas en la BD
    const horasOcupadasHoy = citasOcupadas[fechaSeleccionada] || [];

    // Recorremos la plantilla e insertamos solo las horas que NO estén ocupadas
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

    // Si todo se llenó, le avisamos al cliente
    if (horasDisponibles === 0) {
        selectorHora.innerHTML = '<option value="">No hay disponibilidad este día</option>';
    }
}