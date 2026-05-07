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
            window.location.href = `../controllers/empleado_crud_controller.php?accion=eliminar&id=${id}`;
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

function confirmarResetQR(id) {
    Swal.fire({
        title: '¿Restablecer QR de este empleado?',
        text: "Esto borrará su configuración de 2FA. En su próximo inicio de sesión, el sistema le pedirá escanear un código nuevo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f39c12',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, restablecer',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../controllers/empleado_crud_controller.php?accion=reset_qr&id=${id}`;
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
    } else if (status === 'qr_reset') {
        Swal.fire({
            icon: 'success', title: '¡QR Restablecido!', text: 'El empleado deberá configurar su Autenticador nuevamente.', confirmButtonColor: '#52073a'
        });
    } else if (status === 'error') {
        Swal.fire({
            icon: 'error', title: 'Error', text: 'Ocurrió un problema al procesar la solicitud.', confirmButtonColor: '#52073a'
        });
    }
    window.history.replaceState({}, document.title, window.location.pathname);

    const formularios = ['form-agregar', 'form-editar'];
    
    formularios.forEach(id => {
        const form = document.getElementById(id);
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Detiene el envío
                
                Swal.fire({
                    title: '¿Confirmar cambios?',
                    text: "¿Deseas realizar esta acción?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#52073a',
                    cancelButtonText: 'No, revisar',
                    confirmButtonText: 'Sí, continuar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Envía el formulario si acepta
                    }
                });
            });
        }
    });

});