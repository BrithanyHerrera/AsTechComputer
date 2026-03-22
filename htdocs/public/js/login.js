// ========================================================
// SCRIPT: login.js
// UBICACIÓN: public/js/login.js
// ========================================================

document.addEventListener('DOMContentLoaded', function() {
    const formLogin = document.getElementById('formLogin');
    const btnIngresar = document.getElementById('btnIngresar');

    if (formLogin) {
        formLogin.addEventListener('submit', function() {
            // Deshabilitamos el botón y cambiamos el texto
            // mientras el controlador de PHP procesa la solicitud
            btnIngresar.disabled = true;
            btnIngresar.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Verificando...';
            btnIngresar.style.opacity = '0.7';
            btnIngresar.style.cursor = 'wait';
        });
    }
});