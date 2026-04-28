function abrirFormulario() {
    document.getElementById('formulario-empleado').style.display = 'flex';
}
function cerrarFormulario() {
    document.getElementById('formulario-empleado').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function (event) {
    if (event.target == document.getElementById('formulario-empleado')) {
        cerrarFormulario();
    }
}

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar empleado?',
        text: "Esta acción es permanente y no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../controllers/empleado_controller.php?accion=eliminar&id=${id}`;
        }
    });
}

function abrirEditar(datos) {
    document.getElementById('edit-id').value = datos.id_empleado;
    document.getElementById('edit-nombre').value = datos.nombre;
    document.getElementById('edit-apellido').value = datos.apellido;
    document.getElementById('edit-telefono').value = datos.telefono;
    document.getElementById('edit-correo').value = datos.correo;
    document.getElementById('edit-usuario').value = datos.nombre_usuario;
    document.getElementById('edit-puesto').value = datos.id_puesto;

    document.getElementById('modal-editar-empleado').style.display = 'flex';
}

function cerrarModalEditar() {
    document.getElementById('modal-editar-empleado').style.display = 'none';
}

// Función interceptora para confirmar antes de enviar cualquier formulario
function confirmarAccion(event, formulario, mensaje) {
    event.preventDefault();

    Swal.fire({
        title: '¿Confirmar acción?',
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#52073a',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            formulario.submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        Swal.fire({
            icon: 'success', title: '¡Actualizado!', text: 'Los datos se guardaron correctamente.', confirmButtonColor: '#52073a'
        });
    } else if (status === 'duplicate') {
        Swal.fire({
            icon: 'error', title: 'Dato Duplicado', text: 'El correo o nombre de usuario ya existe.', confirmButtonColor: '#52073a'
        });
    } else if (status === 'error') {
        Swal.fire({
            icon: 'error', title: 'Error', text: 'Ocurrió un problema al procesar la solicitud.', confirmButtonColor: '#52073a'
        });
    }
    window.history.replaceState({}, document.title, window.location.pathname);
});