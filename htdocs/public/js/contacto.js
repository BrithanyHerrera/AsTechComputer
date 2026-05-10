/**
 * SCRIPT: contacto.js
 * PROPÓSITO: se encarga de los mensajes de exito de la pagina de contacto, al enviar un mensaje
 */
/**
 * SCRIPT: contacto.js
 * PROPÓSITO: Validaciones de seguridad y manejo de mensajes de éxito/error con SweetAlert.
 */
document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.querySelector('form');

    // 1. VALIDACIÓN PRE-ENVÍO (FRONTEND)
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const asunto = document.getElementById('asunto').value.trim();
            const mensaje = document.getElementById('mensaje').value.trim();

            // Validar campos vacíos o solo espacios
            if (!nombre || !email || !asunto || !mensaje) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campo vacío',
                    text: 'No puedes enviar mensajes compuestos solo por espacios.',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            // Validar correos incompletos (ej. @gmail.com sin usuario)
            // La regex asegura que haya caracteres antes del @
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email) || email.startsWith('@')) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Correo inválido',
                    text: 'Por favor, ingresa una dirección de correo real.',
                    confirmButtonColor: '#d33'
                });
                return;
            }

            // Validar que no sean solo signos/símbolos (mínimo 2 letras o números)
            const contenidoValido = /[a-zA-Z0-9]{2,}/;
            if (!contenidoValido.test(mensaje)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Mensaje inválido',
                    text: 'El mensaje es demaciado, corto',
                    confirmButtonColor: '#f39c12'
                });
                return;
            }
        });
    }

    // 2. MANEJO DE RESPUESTA DEL SERVIDOR (BACKEND STATUS)
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
        else {
            // Maneja cualquier otro mensaje de error que venga del controlador
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: formStatus === "error" ? 'No se pudo enviar el mensaje. Intenta más tarde.' : formStatus,
                confirmButtonColor: '#d33'
            });
        }
    }
});