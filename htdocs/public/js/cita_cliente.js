/* --- LÓGICA DE CAMPOS DINÁMICOS --- */

// Función para mostrar/ocultar campos de texto al seleccionar "Otro"
function toggleOtro(select, idContenedor) {
    const contenedor = document.getElementById(idContenedor);
    const inputInterno = contenedor.querySelector('input, textarea');

    if (select.value === "Otro" || select.value === "otra_marca") {
        contenedor.style.display = "block";
        inputInterno.required = true;
        inputInterno.focus();
    } else {
        contenedor.style.display = "none";
        inputInterno.required = false;
        inputInterno.value = ""; // Limpia el campo si el usuario cambia de opinión
    }
}

/* --- VALIDACIÓN DE MARCA RESTRINGIDA (APPLE) --- */

// Prevenir que escriban marcas no permitidas en el campo de texto libre
const inputOtraMarca = document.querySelector('input[name="otra_marca_texto"]');
if (inputOtraMarca) {
    inputOtraMarca.addEventListener('input', function (e) {
        const valor = e.target.value.toLowerCase();
        if (valor.includes('apple') || valor.includes('mac')) {
            alert('Lo sentimos, por normatividad técnica de As Tech Computer, no trabajamos con la arquitectura de Apple.');
            e.target.value = '';
        }
    });
}

/* --- GESTIÓN DEL MENSAJE DE CONFIRMACIÓN (MODAL) --- */

const formulario = document.querySelector('form');
const modal = document.getElementById('modalConfirmacion');

if (formulario && modal) {
    formulario.addEventListener('submit', function(e) {
        if (modal.style.display !== 'flex') {
            e.preventDefault(); 

            // CAPTURA DE NOMBRE Y APELLIDO POR SEPARADO
            const nombre = document.querySelector('input[name="nombre_cliente"]').value;
            const apellido = document.querySelector('input[name="apellido_cliente"]').value;
            
            // CONCATENACIÓN PARA EL RESUMEN
            const nombreCompleto = `${nombre} ${apellido}`;

            const marcaSelect = document.querySelector('select[name="marca"]');
            const marca = (marcaSelect.value === "Otro") ? inputOtraMarca.value : marcaSelect.value;
            const modelo = document.querySelector('input[name="modelo"]').value;
            const fecha = document.querySelector('input[name="fecha_cita"]').value;
            const hora = document.querySelector('input[name="hora_cita"]').value;

            // Inyectar datos en el Modal
            document.getElementById('res-nombre').innerText = nombreCompleto;
            document.getElementById('res-equipo').innerText = marca + " " + modelo;
            document.getElementById('res-fecha').innerText = fecha;
            document.getElementById('res-hora').innerText = hora;

            modal.style.display = 'flex';
        }
    });
}

// Función que se ejecuta al presionar "Entendido" en el modal
function cerrarYEnviar() {
    modal.style.display = 'none';
    formulario.submit(); // Envío físico hacia procesar_cita.php para agendar en Google
}

/* --- MEJORA DE ACCESIBILIDAD PARA EL TOOLTIP (?) --- */
// Permite que en móviles se pueda cerrar el tooltip al tocar fuera
document.addEventListener('click', function(e) {
    const ayudaSerie = document.querySelector('.ayuda-serie');
    if (ayudaSerie && !ayudaSerie.contains(e.target)) {
        ayudaSerie.blur();
    }
});