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
    
    // Capturamos ambas fechas
    const fechaInicio = document.getElementById('filtroFechaInicio').value;
    const fechaFin = document.getElementById('filtroFechaFin').value;
    
    const filas = document.querySelectorAll('#tablaCitas .fila-registro');

    // Convertimos las fechas ingresadas a timestamps (milisegundos) para una comparación matemática exacta
    const tsInicio = fechaInicio ? new Date(fechaInicio + "T00:00:00").getTime() : null;
    const tsFin = fechaFin ? new Date(fechaFin + "T23:59:59").getTime() : null;

    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre') || "";
        const txtEstado = fila.getAttribute('data-estado') || "";
        const txtFecha = fila.getAttribute('data-fecha') || ""; // Formato: YYYY-MM-DD

        const coincideBusqueda = txtNombre.includes(busqueda);
        const coincideEstado = estado === 'todos' || txtEstado === estado;
        
        // Lógica matemática infalible para el rango de fechas
        let coincideFecha = true;
        if (txtFecha) {
            // Creamos una fecha al mediodía para evitar problemas de zonas horarias
            const tsFila = new Date(txtFecha + "T12:00:00").getTime(); 
            
            if (tsInicio && tsFin) {
                coincideFecha = (tsFila >= tsInicio && tsFila <= tsFin);
            } else if (tsInicio) {
                coincideFecha = (tsFila >= tsInicio);
            } else if (tsFin) {
                coincideFecha = (tsFila <= tsFin);
            }
        }

        if (coincideBusqueda && coincideEstado && coincideFecha) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

function limpiarFiltros() {
    document.getElementById('buscadorGlobal').value = '';
    document.getElementById('filtroEstado').value = 'todos';
    document.getElementById('filtroFechaInicio').value = '';
    document.getElementById('filtroFechaFin').value = '';
    
    // Ejecutamos la función para que la tabla vuelva a mostrar todo
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
            if (hora === horaPreseleccionada) {
                opt.selected = true;
            }
            selectorHora.appendChild(opt);
        }
    });
}

// Oyente para cuando el usuario cambia la fecha en el modal de edición
const inputFecha = document.getElementById('m_fecha');
if (inputFecha) {
    inputFecha.addEventListener('change', function() {
        const fechaOriginal = this.getAttribute('data-fecha-orig');
        const horaOriginal = document.getElementById('m_hora').getAttribute('data-hora-orig');
        
        if (this.value === fechaOriginal) {
            generarHorarios(this.value, horaOriginal);
        } else {
            generarHorarios(this.value, null);
        }
    });
}

/* ==========================================
   3. CONTROLADOR DE LA VENTANA MODAL (VER DETALLES)
   ========================================== */
function abrirModalVer(boton) {
    try {
        let jsonString = boton.getAttribute('data-cita');
        let datos = JSON.parse(jsonString);

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

    } catch (error) {
        console.error("Error al cargar modal de detalles:", error);
    }
}

function cerrarModalVer() {
    document.getElementById('modalVer').style.display = 'none';
}

/* ==========================================
   4. CONTROLADORES DE LA VENTANA MODAL (EDICIÓN)
   ========================================== */
function abrirModalEditar(boton) {
    try {
        // Obtenemos los datos en formato JSON desde el botón
        let jsonString = boton.getAttribute('data-cita');
        let datos = JSON.parse(jsonString);

        // Mostramos el modal de edición
        document.getElementById('modalEditar').style.display = 'flex';

        // Función auxiliar para acortar la escritura
        const asignarValor = (id, valor) => {
            let elemento = document.getElementById(id);
            if (elemento) elemento.value = valor || '';
        };

        // Asignamos los valores de texto simples
        asignarValor('m_google_id', datos.googleId);
        asignarValor('m_db_id', datos.dbId);
        asignarValor('m_nombre', datos.nombre);
        asignarValor('m_apellido', datos.apellido);
        asignarValor('m_wa', datos.whatsapp);
        asignarValor('m_serie', datos.serie);
        asignarValor('m_modelo', datos.modelo);
        asignarValor('m_detalle', datos.detalle); 

        // Asignamos la fecha y guardamos registro de cuál era la original
        let elFecha = document.getElementById('m_fecha');
        if (elFecha) {
            elFecha.value = datos.fecha || '';
            elFecha.setAttribute('data-fecha-orig', datos.fecha || '');
        }

        // Select: Estado
        let elEstado = document.getElementById('m_estado');
        if (elEstado && datos.estado) elEstado.value = datos.estado;

        // Select: Tipo de equipo
        let elTipo = document.getElementById('m_tipo');
        if (elTipo && datos.idTipo) elTipo.value = datos.idTipo;

        // Select: Marca
        let elMarca = document.getElementById('m_marca');
        if (elMarca && datos.idMarca) elMarca.value = datos.idMarca;

        // Select: Falla
        let selectFalla = document.getElementById('m_falla');
        if (selectFalla && datos.falla) {
            let existeOpcion = Array.from(selectFalla.options).some(opt => opt.value === datos.falla);
            selectFalla.value = existeOpcion ? datos.falla : 'Otro';
        }

        // Select: Hora (Generamos las horas disponibles y pre-seleccionamos la actual)
        let selectHora = document.getElementById('m_hora');
        if (selectHora) {
            selectHora.setAttribute('data-hora-orig', datos.hora || '');
            selectHora.innerHTML = `<option value="${datos.hora}" selected>${datos.hora}</option>`;
            generarHorarios(datos.fecha, datos.hora);
        }

    } catch (error) {
        console.error("Error al procesar JSON para edición:", error);
    }
}

function cerrarModal() { 
    document.getElementById('modalEditar').style.display = 'none'; 
}

/* ==========================================
   5. OYENTE DE CLIC EN EL ÁREA EXTERIOR DE MODALES
   ========================================== */
window.onclick = function (e) { 
    const modalEdicion = document.getElementById('modalEditar');
    const modalVisualizacion = document.getElementById('modalVer');
    const modalConfirmacion = document.getElementById('modalConfirmacion');

    if (e.target === modalEdicion) {
        cerrarModal(); 
    } else if (e.target === modalVisualizacion) {
        cerrarModalVer();
    } else if (e.target === modalConfirmacion) {
        modalConfirmacion.style.display = 'none';
    }
}

/* ==========================================
   6. ACTUALIZACIÓN RÁPIDA DE ESTADOS MEDIANTE AJAX
   ========================================== */
function cambiarEstadoCita(idCitaDB, selectElement) {
    const nuevoEstado = selectElement.value;
    
    selectElement.className = 'status-pill ' + nuevoEstado.toLowerCase().replace(' ', '-');
    selectElement.closest('tr').setAttribute('data-estado', nuevoEstado.toLowerCase().replace(' ', '-'));
    
    fetch('?seccion=citas', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `accion=actualizar_estado_rapido&id_cita=${idCitaDB}&nuevo_estado=${encodeURIComponent(nuevoEstado)}`
    })
    .then(response => response.text())
    .then(data => {
        console.log("Estado actualizado en BD:", data);
    })
    .catch(error => {
        alert("Hubo un error al actualizar el estado. Revisa tu conexión.");
        console.error(error);
    });
}

/* ==========================================
   7. PREVENCIÓN DE DUPLICIDAD EN ENVÍO DE FORMULARIOS
   ========================================== */
document.addEventListener("DOMContentLoaded", function() {
    let formularios = document.querySelectorAll('form');
    formularios.forEach(formulario => {
        formulario.addEventListener('submit', function() {
            let botonSubmit = this.querySelector('button[type="submit"]');
            if (botonSubmit && botonSubmit.innerText.trim() !== '') {
                botonSubmit.disabled = true;
                botonSubmit.style.opacity = '0.7';
                botonSubmit.style.cursor = 'not-allowed';
                botonSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Procesando...';
            }
        });
    });
});

/* ==========================================
   8. SISTEMA DE CONFIRMACIÓN (MODALES)
   ========================================== */
function abrirModalConfirmacion(mensaje, callbackAceptar, callbackCancelar) {
    document.getElementById('textoConfirmacion').innerText = mensaje;
    document.getElementById('modalConfirmacion').style.display = 'flex';
    
    const btnAceptar = document.getElementById('btnAceptarConfirmacion');
    const btnCancelar = document.getElementById('btnCancelarConfirmacion');
    
    // Limpiamos eventos previos clonando los botones
    let nuevoBtnAceptar = btnAceptar.cloneNode(true);
    let nuevoBtnCancelar = btnCancelar.cloneNode(true);
    btnAceptar.parentNode.replaceChild(nuevoBtnAceptar, btnAceptar);
    btnCancelar.parentNode.replaceChild(nuevoBtnCancelar, btnCancelar);
    
    nuevoBtnAceptar.addEventListener('click', function() {
        document.getElementById('modalConfirmacion').style.display = 'none';
        if(callbackAceptar) callbackAceptar();
    });
    
    nuevoBtnCancelar.addEventListener('click', function() {
        document.getElementById('modalConfirmacion').style.display = 'none';
        if(callbackCancelar) callbackCancelar();
    });
}

// 8.1 Interceptar el guardado del Modal de Edición
const formEditar = document.getElementById('formEditarCita');
if (formEditar) {
    formEditar.addEventListener('submit', function(e) {
        e.preventDefault(); // Detenemos el envío automático
        abrirModalConfirmacion(
            "¿Estás seguro de guardar los cambios en esta cita?", 
            function() {
                formEditar.submit(); // Si acepta, se envía
            }
        );
    });
}

// 8.2 Interceptar el cambio de estado rápido en la tabla
function confirmarCambioEstado(selectElement) {
    const estadoAnterior = selectElement.getAttribute('data-estado-anterior');
    const nuevoEstado = selectElement.value;
    const form = selectElement.form;
    
    abrirModalConfirmacion(
        `¿Deseas cambiar el estado de la cita a "${nuevoEstado.toUpperCase()}"?`,
        function() {
            // Confirmado: enviamos el formulario y actualizamos la clase visual
            selectElement.className = 'status-pill ' + nuevoEstado.replace(' ', '-');
            selectElement.setAttribute('data-estado-anterior', nuevoEstado);
            form.submit();
        },
        function() {
            // Cancelado: regresamos el select a como estaba
            selectElement.value = estadoAnterior;
        }
    );
}