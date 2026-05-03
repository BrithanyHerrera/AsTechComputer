// ========================================================
// registros_crud.js
// UBICACIÓN: public/js/registros_crud.js
//
// Maneja toda la interactividad del CRUD de dispositivos:
//   - Modales de ver, editar y confirmar entrega
//   - Motor de filtrado por nombre, folio, estado y fecha
//   - Paginación dinámica del lado del cliente
// ========================================================


// ----------------------------------------------------------
// INICIALIZACIÓN: Mover los modales al <body> para evitar
// problemas de z-index cuando están anidados dentro de
// contenedores con overflow o position relativo.
// ----------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    ['modalDetalles', 'modalEditar', 'modalEntregar'].forEach(function(id) {
        var modal = document.getElementById(id);
        if (modal) document.body.appendChild(modal);
    });
});


// ----------------------------------------------------------
// MODAL: CONFIRMAR ENTREGA
// Se abre al hacer clic en el checkbox de "Entregado".
// Si el usuario cancela, el checkbox regresa a sin marcar.
// ----------------------------------------------------------
function abrirModalEntregar(folio, gabinete, checkbox) {
    if (checkbox.checked) {
        // Llenar el modal con los datos del registro seleccionado
        document.getElementById('txt_folio_entregar').innerText = folio;
        document.getElementById('input_folio_entregar').value   = folio;
        document.getElementById('input_gabinete_entregar').value = gabinete;
        document.getElementById('modalEntregar').style.display  = 'flex';
    }
}

function cerrarModalEntregar() {
    document.getElementById('modalEntregar').style.display = 'none';
    // Desmarcar todos los checkboxes por si el usuario canceló
    document.querySelectorAll('.check-finalizar').forEach(cb => cb.checked = false);
}


// ----------------------------------------------------------
// MODAL: VER DETALLES (solo lectura)
// Recibe el objeto JSON con todos los datos de la fila
// y los distribuye en los spans del modal.
// ----------------------------------------------------------
function verDetalles(datos) {
    document.getElementById('det_folio').innerText        = "Folio: " + datos.folio;
    document.getElementById('det_nombre').innerText       = datos.nombre + " " + datos.apellido;
    document.getElementById('det_wa').innerText           = datos.whatsapp;
    document.getElementById('det_equipo').innerText       = datos.marca + " " + datos.modelo;
    document.getElementById('det_serie').innerText        = datos.numero_serie;
    document.getElementById('det_falla').innerText        = datos.descripcion_problema;
    document.getElementById('det_condicion').innerText    = datos.condicion_fisica;
    document.getElementById('det_accesorios').innerText   = datos.accesorios_entregados;
    document.getElementById('det_observaciones').innerText = datos.observaciones_recepcion;
    document.getElementById('modalDetalles').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modalDetalles').style.display = 'none';
}


// ----------------------------------------------------------
// MODAL: EDITAR REGISTRO
// Pre-llena el formulario de edición con los datos actuales
// del registro para que el usuario solo corrija lo necesario.
// ----------------------------------------------------------
function editarRegistro(datos) {
    // Campos ocultos de referencia (no los ve el usuario)
    document.getElementById('edit_folio').value      = datos.folio;
    document.getElementById('edit_id_cliente').value = datos.id_cliente;

    // Datos del cliente (editables por si se capturaron mal)
    document.getElementById('edit_nombre').value    = datos.nombre;
    document.getElementById('edit_apellido').value  = datos.apellido;
    document.getElementById('edit_telefono').value  = datos.whatsapp;

    // Datos de la orden de ingreso
    document.getElementById('edit_estado').value        = datos.estado;
    document.getElementById('edit_condicion').value     = datos.condicion_fisica;
    document.getElementById('edit_accesorios').value    = datos.accesorios_entregados;
    document.getElementById('edit_observaciones').value = datos.observaciones_recepcion;

    document.getElementById('modalEditar').style.display = 'flex';
}

function cerrarModalEditar() {
    document.getElementById('modalEditar').style.display = 'none';
}


// ----------------------------------------------------------
// CERRAR MODALES AL HACER CLIC FUERA DEL CONTENIDO
// Detectamos si el clic fue sobre el fondo oscuro del modal
// (el elemento raíz) y no sobre el contenido interior.
// ----------------------------------------------------------
window.onclick = function(e) {
    if (e.target == document.getElementById('modalDetalles'))  cerrarModal();
    if (e.target == document.getElementById('modalEditar'))    cerrarModalEditar();
    if (e.target == document.getElementById('modalEntregar'))  cerrarModalEntregar();
}


// ==========================================
// PAGINACIÓN: VARIABLES GLOBALES
// Se recalculan cada vez que el usuario
// cambia los filtros o el número de filas.
// ==========================================
let paginaActual   = 1;
let filasPorPagina = 10; // Valor por defecto al cargar la página

// El usuario cambió el select de "Mostrar X registros"
function cambiarFilasPorPagina() {
    const val = document.getElementById('filtroPaginacion').value;
    // 'todos' es un valor especial: usamos un número muy grande para no paginar
    filasPorPagina = val === 'todos' ? 999999 : parseInt(val);
    paginaActual = 1; // Regresar a la primera página al cambiar la cantidad
    filtrarTabla();
}

// Llamado desde los botones de número de página
function cambiarPagina(nuevaPagina) {
    paginaActual = nuevaPagina;
    filtrarTabla();
}


// ==========================================
// MOTOR PRINCIPAL: FILTRADO + PAGINACIÓN
// Se ejecuta cada vez que cambia cualquier
// filtro (búsqueda, estado, fecha, límite).
// ==========================================
function filtrarTabla() {
    const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
    const estado   = document.getElementById('filtroEstado').value;
    const fecha    = document.getElementById('filtroFecha').value;
    const filas    = document.querySelectorAll('.fila-registro');

    let filasFiltradas = []; // Acumula solo las filas que pasan el filtro

    // PASO 1: Separar filas que cumplen los criterios de las que no
    filas.forEach(fila => {
        const txtNombre = fila.getAttribute('data-nombre');
        const txtFolio  = fila.getAttribute('data-folio');
        const txtEstado = fila.getAttribute('data-estado');
        const txtFecha  = fila.getAttribute('data-fecha');

        const coincideBusqueda = txtNombre.includes(busqueda) || txtFolio.includes(busqueda);
        const coincideEstado   = estado === 'todos' || txtEstado === estado;
        const coincideFecha    = !fecha || txtFecha === fecha;

        if (coincideBusqueda && coincideEstado && coincideFecha) {
            filasFiltradas.push(fila); // Candidata a mostrarse
        } else {
            fila.style.display = 'none'; // Descartada por los filtros
        }
    });

    // PASO 2: Calcular cuántas páginas necesitamos con las filas filtradas
    const totalPaginas = Math.ceil(filasFiltradas.length / filasPorPagina);

    // Ajustar página actual si quedó fuera de rango después de filtrar
    if (paginaActual > totalPaginas && totalPaginas > 0) {
        paginaActual = totalPaginas;
    }

    // Índices de inicio y fin de la página actual
    const indiceInicio = (paginaActual - 1) * filasPorPagina;
    const indiceFin    = indiceInicio + filasPorPagina;

    // PASO 3: Mostrar solo las filas que pertenecen a la página actual
    filasFiltradas.forEach((fila, index) => {
        fila.style.display = (index >= indiceInicio && index < indiceFin) ? '' : 'none';
    });

    // PASO 4: Redibujar los botones de paginación
    dibujarPaginacion(totalPaginas);
}


// ----------------------------------------------------------
// PAGINACIÓN: Dibuja los botones Anterior, números y Siguiente
// Se llama cada vez que cambia el filtro o la página.
// ----------------------------------------------------------
function dibujarPaginacion(totalPaginas) {
    const contenedor = document.getElementById('controlesPaginacion');
    if (!contenedor) return;
    contenedor.innerHTML = ''; // Limpiar botones anteriores

    // No necesitamos paginación si todo cabe en una sola pantalla
    if (totalPaginas <= 1) return;

    // Botón "Anterior"
    const btnAnterior = document.createElement('button');
    btnAnterior.innerText = '« Anterior';
    btnAnterior.className = paginaActual === 1 ? 'btn-pag disabled' : 'btn-pag';
    btnAnterior.onclick = () => { if (paginaActual > 1) cambiarPagina(paginaActual - 1); };
    contenedor.appendChild(btnAnterior);

    // Botones numéricos (1, 2, 3...)
    for (let i = 1; i <= totalPaginas; i++) {
        const btnNum = document.createElement('button');
        btnNum.innerText  = i;
        btnNum.className  = i === paginaActual ? 'btn-pag active' : 'btn-pag';
        btnNum.onclick    = () => cambiarPagina(i);
        contenedor.appendChild(btnNum);
    }

    // Botón "Siguiente"
    const btnSiguiente = document.createElement('button');
    btnSiguiente.innerText = 'Siguiente »';
    btnSiguiente.className = paginaActual === totalPaginas ? 'btn-pag disabled' : 'btn-pag';
    btnSiguiente.onclick = () => { if (paginaActual < totalPaginas) cambiarPagina(paginaActual + 1); };
    contenedor.appendChild(btnSiguiente);
}


// ----------------------------------------------------------
// LIMPIAR FILTROS: Resetea todos los campos a su valor
// inicial y vuelve a la primera página.
// ----------------------------------------------------------
function limpiarFiltros() {
    document.getElementById('buscadorGlobal').value  = '';
    document.getElementById('filtroEstado').value    = 'todos';
    document.getElementById('filtroFecha').value     = '';
    document.getElementById('filtroPaginacion').value = '10';
    paginaActual   = 1;
    filasPorPagina = 10;
    filtrarTabla();
}


// ----------------------------------------------------------
// INICIALIZACIÓN: Aplicar paginación desde el primer render
// para que la tabla no muestre todos los registros de golpe.
// ----------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    filtrarTabla();
});


// ----------------------------------------------------------
// ALERTAS: Detectar parámetros de status en la URL
// y mostrar notificaciones SweetAlert al volver de una acción.
// ----------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);

    // Alerta de edición exitosa (viene del controlador tras guardar cambios)
    if (urlParams.get('status') === 'success_edit') {
        Swal.fire({
            icon: 'success',
            title: '¡Registro Actualizado!',
            text: 'Los datos del equipo han sido modificados correctamente.',
            confirmButtonColor: '#4f46e5',
            allowOutsideClick: false
        }).then(() => {
            // Limpiar el parámetro ?status de la URL para no repetir la alerta al recargar
            window.history.replaceState(
                {}, document.title,
                window.location.pathname + '?seccion=registros_ingresados_crud_view'
            );
        });
    }
});