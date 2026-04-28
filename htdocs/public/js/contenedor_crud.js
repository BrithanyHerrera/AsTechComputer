function abrirFormulario() {
    document.getElementById('formulario-gabinete').style.display = 'flex';
}
function cerrarFormulario() {
    document.getElementById('formulario-gabinete').style.display = 'none';
}

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará el gabinete " + id,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#52073a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../controllers/contenedor_controller.php?accion=eliminar&id=${id}`;
        }
    })
}

// --- FUNCIONES PARA EDITAR ---
function abrirEditar(datos) {
    document.getElementById('edit-id').value = datos.id_gabinete;
    document.getElementById('display-id').value = datos.id_gabinete;
    document.getElementById('edit-tipo').value = datos.tipo_espacio;
    document.getElementById('edit-estado').value = datos.estado;
    document.getElementById('edit-folio').value = datos.folio ? datos.folio : 'N/A';

    document.getElementById('modal-editar-gabinete').style.display = 'flex';
}
function cerrarModalEditar() {
    document.getElementById('modal-editar-gabinete').style.display = 'none';
}

// Cerrar modales al hacer clic fuera
window.onclick = function(event) {
    if (event.target.className === 'modal-formulario') {
        cerrarFormulario();
        cerrarModalEditar();
    }
}

// --- ALERTAS SWEETALERT ---
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const seccion = urlParams.get('seccion');

    if (status) {
        if (!seccion || seccion === 'contenedor') {
            
            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: 'Los cambios se han guardado correctamente.',
                    confirmButtonColor: '#52073a'
                });
            } 
            else if (status === 'duplicate') {
                Swal.fire({
                    icon: 'error',
                    title: 'Dato Duplicado',
                    text: 'Ese gabinete ya existe.',
                    confirmButtonColor: '#52073a'
                });
            } 
            else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al procesar la solicitud.',
                    confirmButtonColor: '#52073a'
                });
            }
        }
    }

    if (window.location.search) {
        const nuevaUrl = window.location.pathname + (seccion ? "?seccion=" + seccion : "");
        window.history.replaceState({}, document.title, nuevaUrl);
    }
});