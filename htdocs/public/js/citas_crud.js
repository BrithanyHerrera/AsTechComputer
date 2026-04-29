/* CITAS_CRUD.JS */
/*
Este archivo concentra toda la lógica interactiva del lado del cliente (Frontend) para el panel de administración de citas. Su propósito es dotar a la tabla de registros de capacidades dinámicas sin necesidad de recargar la página. Entre sus responsabilidades destacan: filtrar las citas en tiempo real (por nombre, estado o fecha), gestionar los horarios disponibles para reagendar citas, controlar la apertura y llenado automático de la ventana modal de edición, enviar actualizaciones rápidas de estado mediante peticiones AJAX al servidor, y prevenir el doble envío de formularios para mantener la integridad de los datos.
*/

/* ==========================================
   1. SISTEMA DE FILTRADO DINÁMICO EN TABLA
   ========================================== */
function filtrarTabla() {
    const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const fechaInicio = document.getElementById('filtroFechaInicio').value;
    const fechaFin = document.getElementById('filtroFechaFin').value;
    const filas = document.querySelectorAll('#tablaCitas .fila-registro');

    const tsInicio = fechaInicio ? new Date(fechaInicio + "T00:00:00").getTime() : null;
    const tsFin = fechaFin ? new Date(fechaFin + "T23:59:59").getTime() : null;

    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre') || "";
        const txtEstado = fila.getAttribute('data-estado') || "";
        const txtFecha = fila.getAttribute('data-fecha') || ""; 

        const coincideBusqueda = txtNombre.includes(busqueda);
        const coincideEstado = estado === 'todos' || txtEstado === estado;
        
        let coincideFecha = true;
        if (txtFecha) {
            const tsFila = new Date(txtFecha + "T12:00:00").getTime(); 
            if (tsInicio && tsFin) {
                coincideFecha = (tsFila >= tsInicio && tsFila <= tsFin);
            } else if (tsInicio) {
                coincideFecha = (tsFila >= tsInicio);
            } else if (tsFin) {
                coincideFecha = (tsFila <= tsFin);
            }
        }

        fila.style.display = (coincideBusqueda && coincideEstado && coincideFecha) ? '' : 'none';
    });
}

function limpiarFiltros() {
    document.getElementById('buscadorGlobal').value = '';
    document.getElementById('filtroEstado').value = 'todos';
    document.getElementById('filtroFechaInicio').value = '';
    document.getElementById('filtroFechaFin').value = '';
    filtrarTabla();
}

/* ==========================================
   2. GESTIÓN DINÁMICA DE HORARIOS EN MODAL
   ========================================== */
function generarHorarios(fechaElegida, horaPreseleccionada) {
    const selectorHora = document.getElementById('m_hora');
    selectorHora.innerHTML = '<option value="">Seleccione una hora...</option>';
    if (!fechaElegida) return;

    const todasLasHoras = [
        "10:00", "10:20", "10:40", "11:00", "11:20", "11:40",
        "12:00", "12:20", "12:40", "13:00", "13:20", "13:40",
        "14:00", "14:20", "14:40", "15:00", "15:20", "15:40", "16:00"
    ];

    const ocupadasHoy = horasOcupadas[fechaElegida] || [];

    todasLasHoras.forEach(hora => {
        if (!ocupadasHoy.includes(hora) || hora === horaPreseleccionada) {
            let opt = document.createElement('option');
            opt.value = hora;
            opt.textContent = hora;
            if (hora === horaPreseleccionada) opt.selected = true;
            selectorHora.appendChild(opt);
        }
    });
}

const inputFecha = document.getElementById('m_fecha');
if (inputFecha) {
    inputFecha.addEventListener('change', function() {
        const fechaOriginal = this.getAttribute('data-fecha-orig');
        const horaOriginal = document.getElementById('m_hora').getAttribute('data-hora-orig');
        generarHorarios(this.value, (this.value === fechaOriginal) ? horaOriginal : null);
    });
}

/* ==========================================
   3. CONTROLADOR DE LA VENTANA MODAL (VER DETALLES)
   ========================================== */
function abrirModalVer(boton) {
    try {
        let datos = JSON.parse(boton.getAttribute('data-cita'));
        document.getElementById('modalVer').style.display = 'flex';
        document.getElementById('v_cliente').innerText = `${datos.nombre} ${datos.apellido}`;
        document.getElementById('v_wa').innerText = datos.whatsapp || 'No registrado';
        document.getElementById('v_dispositivo').innerText = datos.tipoTxt || 'N/A';
        document.getElementById('v_marca_modelo').innerText = `${datos.marcaTxt || 'N/A'} - ${datos.modelo || 'N/A'}`;
        document.getElementById('v_serie').innerText = datos.serie || 'N/A';
        document.getElementById('v_falla').innerText = datos.falla || 'N/A';
        document.getElementById('v_detalle').innerText = datos.detalle || 'Ninguno'; 
        document.getElementById('v_estado').textContent = datos.estado || "No definido";
        document.getElementById('v_fecha').innerText = datos.fecha || 'N/A';
        document.getElementById('v_hora').innerText = datos.hora || 'N/A';
    } catch (error) { console.error("Error modal detalles:", error); }
}

function cerrarModalVer() { document.getElementById('modalVer').style.display = 'none'; }

/* ==========================================
   4. CONTROLADORES DE LA VENTANA MODAL (EDICIÓN)
   ========================================== */
function abrirModalEditar(boton) {
    try {
        let datos = JSON.parse(boton.getAttribute('data-cita'));
        document.getElementById('modalEditar').style.display = 'flex';

        const asignar = (id, val) => { if (document.getElementById(id)) document.getElementById(id).value = val || ''; };
        asignar('m_google_id', datos.googleId);
        asignar('m_db_id', datos.dbId);
        asignar('m_nombre', datos.nombre);
        asignar('m_apellido', datos.apellido);
        asignar('m_wa', datos.whatsapp);
        asignar('m_serie', datos.serie);
        asignar('m_modelo', datos.modelo);
        asignar('m_detalle', datos.detalle);
        asignar('m_estado', datos.estado); 

        let elFecha = document.getElementById('m_fecha');
        if (elFecha) {
            elFecha.value = datos.fecha || '';
            elFecha.setAttribute('data-fecha-orig', datos.fecha || '');
        }
        if (document.getElementById('m_tipo')) document.getElementById('m_tipo').value = datos.idTipo || '';
        if (document.getElementById('m_marca')) document.getElementById('m_marca').value = datos.idMarca || '';

        let selectFalla = document.getElementById('m_falla');
        if (selectFalla && datos.falla) {
            let existe = Array.from(selectFalla.options).some(opt => opt.value === datos.falla);
            selectFalla.value = existe ? datos.falla : 'Otro';
        }

        let selectHora = document.getElementById('m_hora');
        if (selectHora) {
            selectHora.setAttribute('data-hora-orig', datos.hora || '');
            selectHora.innerHTML = `<option value="${datos.hora}" selected>${datos.hora}</option>`;
            generarHorarios(datos.fecha, datos.hora);
        }
    } catch (error) { console.error("Error modal edición:", error); }
}

function cerrarModal() { document.getElementById('modalEditar').style.display = 'none'; }

/* Cierre de modales al dar clic fuera */
window.onclick = function (e) { 
    if (e.target.classList.contains('modal-personalizado')) {
        e.target.style.display = 'none';
    }
}

/* ==========================================
   5. INTERCEPTAR GUARDADO DE EDICIÓN (SWEETALERT)
   ========================================== */
const formEditar = document.getElementById('formEditarCita');
if (formEditar) {
    formEditar.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará la información del cliente y la cita.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#e17203',
            cancelButtonColor: '#52073a',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Regresar',
            backdrop: `rgba(0,0,0,0.5)`,
            
            didOpen: () => {
                document.querySelector('.swal2-container').style.zIndex = '9999999';
            }
            
        }).then((result) => {
            if (result.isConfirmed) {
                formEditar.submit();
            }
        });
    });
}

/* ==========================================
   6. CAMBIO DE ESTADO RÁPIDO (SWEETALERT)
   ========================================== */
function confirmarCambioEstado(selectElement) {
    const estadoAnterior = selectElement.getAttribute('data-estado-anterior');
    const nuevoEstado = selectElement.value;
    const form = selectElement.form;
    
    if (nuevoEstado === 'cancelada') {
        Swal.fire({
            title: 'Motivo de cancelación',
            input: 'textarea',
            inputPlaceholder: 'Explica brevemente por qué se cancela...',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e17203',
            cancelButtonColor: '#52073a',
            confirmButtonText: 'Confirmar Cancelación',
            cancelButtonText: 'Regresar',
            backdrop: `rgba(0,0,0,0.5)`,
            inputValidator: (value) => {
                if (!value) return 'Debes escribir una razón.';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let inputRazon = document.createElement("input");
                inputRazon.type = "hidden"; name = "razon_cancelacion";
                inputRazon.name = "razon_cancelacion"; inputRazon.value = result.value;
                form.appendChild(inputRazon);
                form.submit();
            } else { selectElement.value = estadoAnterior; }
        });
    } else {
        Swal.fire({
            title: '¿Cambiar estado?',
            text: `La cita pasará a estar "${nuevoEstado.toUpperCase()}".`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#e17203',
            cancelButtonColor: '#52073a',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar',
            backdrop: `rgba(0,0,0,0.5)`
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else { selectElement.value = estadoAnterior; }
        });
    }
}

/* ==========================================
   7. ELIMINACIÓN DE CITA (SWEETALERT)
   ========================================== */
function confirmarEliminacion(event, urlDestino) {
    event.preventDefault(); 
    Swal.fire({
        title: '¿Eliminar cita?',
        text: "Esta acción es permanente y no se podrá recuperar.",
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#e17203',
        cancelButtonColor: '#52073a',
        confirmButtonText: 'Sí, eliminar ahora',
        cancelButtonText: 'No, conservar',
        backdrop: `rgba(0,0,0,0.5)`
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = urlDestino;
        }
    });
}