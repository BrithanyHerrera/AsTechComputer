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

// ==========================================
// VARIABLES GLOBALES DE PAGINACIÓN
// ==========================================
let paginaActual = 1;
let filasPorPagina = 10;

function cambiarFilasPorPagina() {
    const val = document.getElementById('filtroPaginacion').value;
    filasPorPagina = val === 'todos' ? 999999 : parseInt(val);
    paginaActual = 1; // Si cambia la cantidad, regresamos a la hoja 1
    filtrarTabla();
}

function cambiarPagina(nuevaPagina) {
    paginaActual = nuevaPagina;
    filtrarTabla();
}

// ==========================================
// EL MOTOR DE FILTRADO Y PAGINACIÓN
// ==========================================
function filtrarTabla() {
    const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const fecha = document.getElementById('filtroFecha').value;
    const filas = document.querySelectorAll('.fila-registro');

    let filasFiltradas = [];

    // 1. Primero filtramos quiénes cumplen las condiciones (Búsqueda, Estado, Fecha)
    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre');
        const txtFolio = fila.getAttribute('data-folio');
        const txtEstado = fila.getAttribute('data-estado');
        const txtFecha = fila.getAttribute('data-fecha');
        
        const coincideBusqueda = txtNombre.includes(busqueda) || txtFolio.includes(busqueda);
        const coincideEstado = estado === 'todos' || txtEstado === estado;
        const coincideFecha = !fecha || txtFecha === fecha;

        if (coincideBusqueda && coincideEstado && coincideFecha) {
            filasFiltradas.push(fila); // La guardamos en la lista de aprobadas
        } else {
            fila.style.display = 'none'; // La ocultamos definitivamente
        }
    });

    // 2. Calculamos la Paginación sobre las filas aprobadas
    const totalPaginas = Math.ceil(filasFiltradas.length / filasPorPagina);
    
    // Escudo: Si buscamos algo y el total de páginas baja, ajustamos la página actual
    if (paginaActual > totalPaginas && totalPaginas > 0) paginaActual = totalPaginas;

    const indiceInicio = (paginaActual - 1) * filasPorPagina;
    const indiceFin = indiceInicio + filasPorPagina;

    // 3. Mostramos solo las filas de la página actual
    filasFiltradas.forEach((fila, index) => {
        if (index >= indiceInicio && index < indiceFin) {
            fila.style.display = ''; // Mostrar
        } else {
            fila.style.display = 'none'; // Ocultar por paginación
        }
    });

    // 4. Dibujamos los botones
    dibujarPaginacion(totalPaginas);
}

function dibujarPaginacion(totalPaginas) {
    const contenedor = document.getElementById('controlesPaginacion');
    if (!contenedor) return;
    contenedor.innerHTML = ''; // Limpiamos controles anteriores

    if (totalPaginas <= 1) return; // Si todo cabe en una hoja, no hay botones

    // Botón Anterior
    const btnAnterior = document.createElement('button');
    btnAnterior.innerText = '« Anterior';
    btnAnterior.className = paginaActual === 1 ? 'btn-pag disabled' : 'btn-pag';
    btnAnterior.onclick = () => { if (paginaActual > 1) cambiarPagina(paginaActual - 1); };
    contenedor.appendChild(btnAnterior);

    // Botones de Número (1, 2, 3...)
    for (let i = 1; i <= totalPaginas; i++) {
        const btnNum = document.createElement('button');
        btnNum.innerText = i;
        btnNum.className = i === paginaActual ? 'btn-pag active' : 'btn-pag';
        btnNum.onclick = () => cambiarPagina(i);
        contenedor.appendChild(btnNum);
    }

    // Botón Siguiente
    const btnSiguiente = document.createElement('button');
    btnSiguiente.innerText = 'Siguiente »';
    btnSiguiente.className = paginaActual === totalPaginas ? 'btn-pag disabled' : 'btn-pag';
    btnSiguiente.onclick = () => { if (paginaActual < totalPaginas) cambiarPagina(paginaActual + 1); };
    contenedor.appendChild(btnSiguiente);
}

function limpiarFiltros() {
    document.getElementById('buscadorGlobal').value = '';
    document.getElementById('filtroEstado').value = 'todos';
    document.getElementById('filtroFecha').value = '';
    document.getElementById('filtroPaginacion').value = '10'; // Reseteamos selector
    paginaActual = 1;
    filasPorPagina = 10;
    filtrarTabla();
}

// MAGIA FINAL: Forzar la tabla a paginarse apenas carga la página
document.addEventListener('DOMContentLoaded', function () {
    filtrarTabla(); 
});

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get('status') === 'success_edit') {
        Swal.fire({
            icon: 'success',
            title: '¡Registro Actualizado!',
            text: 'Los datos del equipo han sido modificados correctamente.',
            confirmButtonColor: '#4f46e5',
            allowOutsideClick: false
        }).then(() => {
            window.history.replaceState({}, document.title,
                window.location.pathname + '?seccion=registros_ingresados_crud_view');
        });
    }
});