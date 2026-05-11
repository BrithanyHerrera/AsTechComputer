/**
 * Funciones para el CRUD de Contacto
 */
function verMensaje(datos) {
    Swal.fire({
        title: 'Asunto: ' + datos.asunto,
        html: `
            <div style="text-align: left;">
                <p><strong>De:</strong> ${datos.nombre} (${datos.correo})</p>
                <p><strong>Mensaje:</strong></p>
                <p style="background: #f9f9f9; padding: 10px; border-radius: 5px;">${datos.mensaje}</p>
            </div>
        `,
        confirmButtonColor: '#52073a'
    });
}
function enviarCorreo(datos) {

    const correo = datos.correo;
    const asunto = "Respuesta a tu mensaje: " + datos.asunto;

    const mensaje = `Hola ${datos.nombre},

Gracias por contactarnos.

Respecto a tu mensaje:
"${datos.mensaje}"

Aquí puedes escribir tu respuesta...

Saludos.`;

    const url = `https://mail.google.com/mail/?view=cm&to=${encodeURIComponent(correo)}&su=${encodeURIComponent(asunto)}&body=${encodeURIComponent(mensaje)}`;


    window.open(url, '_blank');
}



// 1. Abrir Gmail con respuesta predefinida
function enviarCorreo(datos) {
    const correo = datos.correo;
    const asunto = "Respuesta a tu mensaje: " + datos.asunto;
    const cuerpo = `Hola ${datos.nombre},\n\nGracias por contactarnos.\n\nRespecto a tu mensaje:\n"${datos.mensaje}"\n\nSaludos.`;

    const url = `https://mail.google.com/mail/?view=cm&to=${encodeURIComponent(correo)}&su=${encodeURIComponent(asunto)}&body=${encodeURIComponent(cuerpo)}`;
    window.open(url, '_blank');
}
function verMensaje(datos) {
    Swal.fire({
        title: 'Asunto: ' + datos.asunto,
        html: `
            <div style="text-align: left;">
                <p><strong>De:</strong> ${datos.nombre} (${datos.correo})</p>
                <p><strong>Mensaje:</strong></p>
                <p style="background: #f9f9f9; padding: 10px; border-radius: 5px;">${datos.mensaje}</p>
            </div>
        `,
        confirmButtonColor: '#52073a'
    });
}

// 2. Confirmación para eliminar con SweetAlert2
function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar mensaje?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirige al controlador con la acción de eliminar
            window.location.href = `../controllers/contacto_crud_controller.php?action=eliminar&id=${id}`;
        }
    });
}

function enviarCorreo(datos) {
    const correo = datos.correo;
    const asunto = "Respuesta a tu mensaje: " + datos.asunto;

    const mensaje = `Hola ${datos.nombre},

Gracias por contactarnos.

Respecto a tu mensaje:
"${datos.mensaje}"

Aquí puedes escribir tu respuesta...

Saludos.`;

    const url = `https://mail.google.com/mail/?view=cm&to=${encodeURIComponent(correo)}&su=${encodeURIComponent(asunto)}&body=${encodeURIComponent(mensaje)}`;

    window.open(url, '_blank');
}




// 3. Modal dinámico para cambiar estado
function cambiarEstado(id, estadoActual) {
    Swal.fire({
        title: 'Actualizar Estado del Mensaje',
        icon: 'info',
        html: `
            <select id="nuevo-estado-select" class="swal2-input" style="width: 80%;">
                <option value="nuevo" ${estadoActual === 'nuevo' ? 'selected' : ''}>Nuevo</option>
                <option value="pendiente" ${estadoActual === 'pendiente' ? 'selected' : ''}>Pendiente</option>
                <option value="respondido" ${estadoActual === 'respondido' ? 'selected' : ''}>Respondido</option>
                <option value="finalizado" ${estadoActual === 'finalizado' ? 'selected' : ''}>Finalizado</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar Cambios',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#52073a',
        preConfirm: () => {
            return document.getElementById('nuevo-estado-select').value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const nuevoEstado = result.value;
            window.location.href = `../controllers/contacto_crud_controller.php?action=actualizar&id=${id}&estado=${nuevoEstado}`;
        }
    });
}

// 4. Manejo de alertas de éxito/error al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        const config = {
            success: { icon: 'success', title: '¡Éxito!', text: 'Estado actualizado correctamente' },
            deleted: { icon: 'success', title: 'Eliminado', text: 'El mensaje ha sido borrado' },
            error: { icon: 'error', title: 'Error', text: 'No se pudo completar la operación' }
        };

        if (config[status]) {
            Swal.fire({
                ...config[status],
                confirmButtonColor: "#52073a"
            });
            
            // Limpia la URL para que no vuelva a salir la alerta al recargar
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
});