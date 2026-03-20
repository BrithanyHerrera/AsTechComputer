// ========================================================
// SCRIPT: citas_admin.js
// UBICACIÓN: public/js/citas_admin.js
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

function abrirModalEditar(gid, dbid, nom, ape, marca, tipo, mod, serie, falla, wa, fecha, hora) {
    document.getElementById('m_google_id').value = gid;
    document.getElementById('m_db_id').value = dbid;
    document.getElementById('m_nombre').value = nom;
    document.getElementById('m_apellido').value = ape;
    document.getElementById('m_marca').value = marca;
    document.getElementById('m_tipo').value = tipo;
    document.getElementById('m_modelo').value = mod;
    document.getElementById('m_serie').value = serie;
    
    let selectFalla = document.getElementById('m_falla');
    let optionFallaExists = Array.from(selectFalla.options).some(opt => opt.value === falla);
    selectFalla.value = optionFallaExists ? falla : "Otro";

    document.getElementById('m_wa').value = wa;
    
    const inFecha = document.getElementById('m_fecha');
    const selHora = document.getElementById('m_hora');

    inFecha.value = fecha;
    inFecha.setAttribute('data-fecha-orig', fecha);
    selHora.setAttribute('data-hora-orig', hora);

    generarHorarios(fecha, hora);
    
    document.getElementById('modalEditar').style.display = 'flex';
}

function cerrarModal() { document.getElementById('modalEditar').style.display = 'none'; }
window.onclick = function (e) { if (e.target == document.getElementById('modalEditar')) cerrarModal(); }