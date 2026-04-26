/**
 * ARCHIVO: servicios_crud.js - Gestión de Catálogo y CRUD de Servicios
 * PROPÓSITO: Controlar la interactividad de la interfaz de servicios y la comunicación con el backend.
 * FUNCIONALIDADES: 
 * - Gestión de Modales: Apertura y cierre de formularios para crear, editar y visualizar detalles.
 * - Confirmación de Eliminación: Integración con SweetAlert2 para prevenir borrados accidentales mediante advertencias.
 * - Carga Dinámica de Datos: Mapeo de objetos JSON hacia los campos de los formularios de edición y vista previa.
 * - Sistema de Notificaciones: Detección de parámetros en la URL (status) para mostrar alertas de éxito o error.
 * - Limpieza de Estado: Reset de la barra de direcciones del navegador tras procesar acciones del CRUD.
 * - Cierre Inteligente: Listener global para cerrar cualquier modal activo al hacer clic fuera del área de contenido.
 */

function abrirFormulario() {
    document.getElementById('formulario-servicio').style.display = 'block';
}
function cerrarFormulario() {
    document.getElementById('formulario-servicio').style.display = 'none';
}
// Cerrar modal al hacer clic fuera


function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar servicio?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#52073a',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviamos la petición al controlador unificado
            window.location.href = `../controllers/servicios_crud_controller.php?accion=eliminar&id=${id}`;
        }
    });
}


function abrirEditarServicio(event, datos) {
    const modal = document.getElementById('modal-editar-servicio');

    document.getElementById('edit-id').value = datos.id_servicio;
    document.getElementById('edit-tipo').value = datos.tipo_servicio;
    document.getElementById('edit-descripcion').value = datos.descripcion;
    document.getElementById('edit-procedimiento').value = datos.procedimiento;
    document.getElementById('edit-beneficios').value = datos.beneficios;
    document.getElementById('edit-indicaciones').value = datos.indicaciones;
    document.getElementById('edit-exclusiones').value = datos.exclusiones;
    document.getElementById('edit-descripcion').value = datos.descripcion;
    document.getElementById('edit-precio').value = datos.precio;
    document.getElementById('edit-tiempo').value = datos.tiempo_estimado;
    document.getElementById('edit-estado').value = datos.estado;
    document.getElementById('edit-tipo-servicio').value = datos.id_tipo_servicio;
    
    // CAMBIO CLAVE: Asignar el nombre del archivo al input de texto
    document.getElementById('edit-imagen').value = datos.imagen_servicio;

    modal.style.display = 'block';
}
function cerrarModalEditar() {
    document.getElementById('modal-editar-servicio').style.display = 'none';
}

// Detectar parámetros en la URL al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        Swal.fire({
            icon: 'success',
            title: '¡Actualizado!',
            text: 'Los datos del servicio se guardaron correctamente.',
            confirmButtonColor: '#52073a' // Tu color púrpura
        });
    } 
    else if (status === 'duplicate') {
        Swal.fire({
            icon: 'error',
            title: 'Dato Duplicado',
            text: 'El correo o nombre de usuario ya está registrado por otro servicio.',
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
    

    // Limpiar la URL para que no repita la alerta al recargar
    window.history.replaceState({}, document.title, window.location.pathname);
});
function abrirModalVerServicio(datos) {
    const modal = document.getElementById('modalVerServicio');
    const rutaImg = "../../public/img/servicios/";

    document.getElementById('v_imagen').src = rutaImg + (datos.imagen_servicio || 'default.png');
    document.getElementById('v_descripcion').textContent = datos.descripcion || 'N/A';
    document.getElementById('v_procedimiento').textContent = datos.procedimiento || 'No especificado';
    document.getElementById('v_beneficios').textContent = datos.beneficios || 'No especificado';
    document.getElementById('v_indicaciones').textContent = datos.indicaciones || 'No especificado';
    document.getElementById('v_exclusiones').textContent = datos.exclusiones || 'No especificado';

    modal.style.display = 'block';
}

function cerrarModalVerServicio() {
    document.getElementById('modalVerServicio').style.display = 'none';
}
window.onclick = function(event) {
    const modalVer = document.getElementById('modalVerServicio');
    const modalForm = document.getElementById('formulario-servicio');
    const modalEdit = document.getElementById('modal-editar-servicio');

    if (event.target == modalVer) cerrarModalVerServicio();
    if (event.target == modalForm) cerrarFormulario();
    if (event.target == modalEdit) cerrarModalEditar();
};