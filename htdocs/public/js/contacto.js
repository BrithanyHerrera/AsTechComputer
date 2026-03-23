// ========================================================
// SCRIPT: contacto.js
// UBICACIÓN: public/js/contacto.js
// ========================================================

document.addEventListener('DOMContentLoaded', function() {
    // Leemos la variable 'formStatus' que nos envió la Vista
    if (typeof formStatus !== 'undefined' && formStatus !== "") {
        if (formStatus === "success") {
            Swal.fire({
                icon: 'success',
                title: '¡Mensaje Enviado!',
                text: 'En breve te respondemos 😊 Horario de atención: 10:00 a.m. a 4:00 p.m.',
                confirmButtonColor: '#52073a'
            }).then(() => {
                // Recargamos la página limpiamente
                window.location.href = window.location.href; 
            });
        } else if (formStatus === "error") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar el mensaje. Inténtalo más tarde.',
                confirmButtonColor: '#52073a'
            });
        }
    }
});