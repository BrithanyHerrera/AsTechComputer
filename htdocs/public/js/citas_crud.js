// ========================================================
// SCRIPT: citas_crud.js
// UBICACIÓN: public/js/citas_crud.js
// ========================================================

function filtrarTabla() {
    const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const fecha = document.getElementById('filtroFecha').value;
    const filas = document.querySelectorAll('#tablaCitas .fila-registro');

    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre');
        const txtEstado = fila.getAttribute('data-estado');
        const txtFecha = fila.getAttribute('data-fecha');

        const coincideBusqueda = txtNombre.includes(busqueda);
        const coincideEstado = estado === 'todos' || txtEstado === estado;
        const coincideFecha = !fecha || txtFecha === fecha;

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
    document.getElementById('filtroFecha').value = '';
    filtrarTabla();
}

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

document.getElementById('m_fecha').addEventListener('change', function() {
    const fechaOriginal = this.getAttribute('data-fecha-orig');
    const horaOriginal = document.getElementById('m_hora').getAttribute('data-hora-orig');
    
    if (this.value === fechaOriginal) {
        generarHorarios(this.value, horaOriginal);
    } else {
        generarHorarios(this.value, null);
    }
});

function abrirModalEditar(boton) {
    try {
        let jsonString = boton.getAttribute('data-cita');
        let datos = JSON.parse(jsonString);

        document.getElementById('modalEditar').style.display = 'flex';

        const asignarValor = (id, valor) => {
            let elemento = document.getElementById(id);
            if (elemento) elemento.value = valor || '';
        };

        asignarValor('m_google_id', datos.googleId);
        asignarValor('m_db_id', datos.dbId);
        asignarValor('m_nombre', datos.nombre);
        asignarValor('m_apellido', datos.apellido);
        asignarValor('m_wa', datos.whatsapp);
        asignarValor('m_serie', datos.serie);
        asignarValor('m_modelo', datos.modelo);
        asignarValor('m_fecha', datos.fecha);

        let elTipo = document.getElementById('m_tipo');
        if (elTipo && datos.idTipo) elTipo.value = datos.idTipo;

        let elMarca = document.getElementById('m_marca');
        if (elMarca && datos.idMarca) elMarca.value = datos.idMarca;

        let selectFalla = document.getElementById('m_falla');
        if (selectFalla && datos.falla) {
            let existeOpcion = Array.from(selectFalla.options).some(opt => opt.value === datos.falla);
            selectFalla.value = existeOpcion ? datos.falla : 'Otro';
        }

        let selectHora = document.getElementById('m_hora');
        if (selectHora) {
            selectHora.innerHTML = `<option value="${datos.hora}" selected>${datos.hora}</option>`;
            generarHorarios(datos.fecha, datos.hora);
        }

    } catch (error) {
        console.error("Error al cargar modal:", error);
    }
}

function cerrarModal() { 
    document.getElementById('modalEditar').style.display = 'none'; 
}

window.onclick = function (e) { 
    if (e.target == document.getElementById('modalEditar')) cerrarModal(); 
}

// --------------------------------------------------------
// FUNCIÓN AJAX PARA CAMBIAR EL ESTADO DIRECTAMENTE
// --------------------------------------------------------
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

// Bloqueo de doble envío
document.addEventListener("DOMContentLoaded", function() {
    let formularios = document.querySelectorAll('form');
    formularios.forEach(formulario => {
        formulario.addEventListener('submit', function() {
            let botonSubmit = this.querySelector('button[type="submit"]');
            if (botonSubmit) {
                botonSubmit.disabled = true;
                botonSubmit.style.opacity = '0.7';
                botonSubmit.style.cursor = 'not-allowed';
                botonSubmit.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Procesando...';
            }
        });
    });
});