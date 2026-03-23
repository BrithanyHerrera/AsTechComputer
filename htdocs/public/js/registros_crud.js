// ========================================================
// SCRIPT: registros_crud.js
// UBICACIÓN: public/js/registros_crud.js
// ========================================================

function filtrarTabla() {
    const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const fecha = document.getElementById('filtroFecha').value;
    const filas = document.querySelectorAll('.fila-registro');

    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre');
        const txtFolio = fila.getAttribute('data-folio');
        const txtEstado = fila.getAttribute('data-estado');
        const txtFecha = fila.getAttribute('data-fecha');

        const coincideBusqueda = txtNombre.includes(busqueda) || txtFolio.includes(busqueda);
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

function verDetalles(datos) {
    document.getElementById('det_folio').innerText = "Folio: " + datos.folio;
    document.getElementById('det_nombre').innerText = datos.nombre + " " + datos.apellido;
    document.getElementById('det_wa').innerText = datos.whatsapp;
    document.getElementById('det_serie').innerText = datos.numero_serie;
    document.getElementById('det_condicion').innerText = datos.condicion_fisica;
    document.getElementById('det_accesorios').innerText = datos.accesorios_entregados;
    document.getElementById('det_observaciones').innerText = datos.observaciones_recepcion;
    document.getElementById('modalDetalles').style.display = 'flex';
}

function cerrarModal() { 
    document.getElementById('modalDetalles').style.display = 'none'; 
}

window.onclick = function(e) { 
    if(e.target == document.getElementById('modalDetalles')) cerrarModal(); 
}