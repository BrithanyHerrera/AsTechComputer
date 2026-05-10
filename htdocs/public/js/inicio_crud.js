//pagina:index_crud.js
//se encarga de las funciones de la pagina index_crud_view.php
//  funcion para cambiar el texto de la pagina index
function cambiarSeccion(event, seccion) {
    //para editar el texto de la pagina index
    document.querySelectorAll('.seccion-form').forEach(div => {
        div.classList.remove('activa');
    });

    document.getElementById('seccion-' + seccion)
        .classList.add('activa');

    document.querySelectorAll('.btn-tab').forEach(btn => {
        btn.classList.remove('activo');
    });

    event.target.classList.add('activo');

    document.getElementById('seccion_editada').value = seccion;
}
// 1. Confirmación antes de enviar
function confirmarGuardado() {
    Swal.fire({
        title: '¿Seguro que quieres editarlo?',
        text: "Los cambios se aplicarán en la página principal",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si confirma, enviamos el formulario manualmente
            document.getElementById('form-inicio').submit();
        }
    });
}

// 2. Notificación de éxito (se activa si llega el parámetro 'success' en la URL)
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('success') === '1') {
    Swal.fire({
        title: '¡Editado con éxito!',
        text: 'La información ha sido actualizada.',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
    });
}