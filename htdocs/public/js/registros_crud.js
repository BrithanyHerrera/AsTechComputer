function abrirModalEntregar(folio, gabinete, checkbox) {
    if (checkbox.checked) {
        document.getElementById('txt_folio_entregar').innerText = folio;
        document.getElementById('input_folio_entregar').value = folio;
        document.getElementById('input_gabinete_entregar').value = gabinete;
        document.getElementById('modalEntregar').style.display = 'flex';
    }
}

function cerrarModalEntregar() {
    document.getElementById('modalEntregar').style.display = 'none';
    document.querySelectorAll('.check-finalizar').forEach(cb => cb.checked = false);
}

function verDetalles(datos) {
    document.getElementById('det_folio').innerText = "Folio: " + datos.folio;
    document.getElementById('det_nombre').innerText = datos.nombre + " " + datos.apellido;
    document.getElementById('det_wa').innerText = datos.whatsapp;
    document.getElementById('det_equipo').innerText = datos.marca + " " + datos.modelo;
    document.getElementById('det_serie').innerText = datos.numero_serie;
    document.getElementById('det_falla').innerText = datos.descripcion_problema;
    document.getElementById('det_condicion').innerText = datos.condicion_fisica;
    document.getElementById('det_accesorios').innerText = datos.accesorios_entregados;
    document.getElementById('det_observaciones').innerText = datos.observaciones_recepcion;
    document.getElementById('modalDetalles').style.display = 'flex';
}

function editarRegistro(datos) {
    // 1. Datos ocultos de referencia
    document.getElementById('edit_folio').value = datos.folio;
    document.getElementById('edit_id_cliente').value = datos.id_cliente; // AGREGADO

    // 2. Datos del Cliente (¡Para que puedan corregir si se equivocaron!)
    document.getElementById('edit_nombre').value = datos.nombre;
    document.getElementById('edit_apellido').value = datos.apellido;
    document.getElementById('edit_telefono').value = datos.whatsapp;

    // 3. Datos de la Orden
    document.getElementById('edit_estado').value = datos.estado;
    document.getElementById('edit_condicion').value = datos.condicion_fisica;
    document.getElementById('edit_accesorios').value = datos.accesorios_entregados;
    document.getElementById('edit_observaciones').value = datos.observaciones_recepcion;
    
    document.getElementById('modalEditar').style.display = 'flex';
}

function cerrarModal() { document.getElementById('modalDetalles').style.display = 'none'; }
function cerrarModalEditar() { document.getElementById('modalEditar').style.display = 'none'; }

window.onclick = function(e) { 
    if(e.target == document.getElementById('modalDetalles')) cerrarModal(); 
    if(e.target == document.getElementById('modalEditar')) cerrarModalEditar(); 
    if(e.target == document.getElementById('modalEntregar')) cerrarModalEntregar(); 
}

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

        fila.style.display = (coincideBusqueda && coincideEstado && coincideFecha) ? '' : 'none';
    });
}

function limpiarFiltros() {
    document.getElementById('buscadorGlobal').value = '';
    document.getElementById('filtroEstado').value = 'todos';
    document.getElementById('filtroFecha').value = '';
    filtrarTabla();
}