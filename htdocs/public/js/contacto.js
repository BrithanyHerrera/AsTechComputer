document.addEventListener('DOMContentLoaded', function() {
    // Verificamos si la variable existe y tiene contenido
    if (typeof formStatus !== 'undefined' && formStatus !== "") {
        
        if (formStatus === "success") {
            Swal.fire({
                icon: 'success',
                title: '¡Enviado!',
                text: 'Tu mensaje ha sido recibido con éxito.',
                confirmButtonColor: '#3085d6'
            });
        } 
        else if (formStatus === "wait") {
            Swal.fire({
                icon: 'warning',
                title: 'Espera un momento',
                text: 'Ya enviaste un mensaje recientemente. Por favor, espera 5 minutos.',
                confirmButtonColor: '#f39c12'
            });
        } 
        else if (formStatus === "error") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo enviar el mensaje. Intenta más tarde.',
                confirmButtonColor: '#d33'
            });
        }
    }
});