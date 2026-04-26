<script>
/* POLITICA_PRIVACIDAD.PHP */
/*
Este archivo representa la Vista (View) destinada a exhibir el Aviso de Privacidad oficial de ASTECH COMPUTER. Su propósito principal es transparentar y comunicar a los usuarios las políticas de recopilación, uso, protección y transferencia de datos personales, así como los lineamientos de confidencialidad en el acceso a los equipos y el proceso para ejercer los derechos ARCO. Se estructura mediante un formato de lectura accesible y modular, integrando los controladores globales de navegación (Toolbar) y pie de página (Footer) para asegurar la homogeneidad visual de la plataforma corporativa.
*/
</script>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad - AsTech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../../public/img/Astech%20ICO.ico" type="image/x-icon">    
    <link rel="stylesheet" href="../../public/css/static.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/info_legal.css">
</head>

<body style="background-color: #f4f4f4;">

    <?php
    $ruta_prefijo = "../../../"; 
    require_once __DIR__ . "/../config/config.php"; 
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <main>
        <section class="seccion-legal">
            <h1>Aviso de Privacidad</h1>
            <span class="fecha-actualizacion">Última actualización: [Día] de [Mes] de 2026</span>

            <p>En <strong>AsTech Computer</strong>, con domicilio en [Dirección Física de la Empresa], la privacidad y seguridad de sus datos personales son nuestra prioridad. Este aviso explica cómo recopilamos, usamos y protegemos su información de acuerdo con las leyes de protección de datos vigentes.</p>

            <h3>1. Datos personales que recabamos</h3>
            <p>Para brindarle nuestros servicios de reparación y soporte técnico, solicitamos los siguientes datos:</p>
            <ul>
                <li><strong>Identificación:</strong> Nombre completo.</li>
                <li><strong>Contacto:</strong> Número de teléfono (WhatsApp) y correo electrónico.</li>
                <li><strong>Información Técnica:</strong> Marca, modelo, número de serie y contraseñas de acceso al equipo (únicamente si es estrictamente necesario para la reparación).</li>
            </ul>

            <h3>2. Finalidad del tratamiento de datos</h3>
            <p>Su información será utilizada exclusivamente para:</p>
            <ul>
                <li>Gestionar y confirmar sus citas de servicio.</li>
                <li>Informarle sobre el estatus de la reparación de su equipo.</li>
                <li>Emitir presupuestos y comprobantes de pago.</li>
                <li>Brindar soporte post-venta y hacer válidas las garantías.</li>
            </ul>

            <h3>3. Confidencialidad y Acceso a Equipos</h3>
            <p>Al dejar su equipo en AsTech Computer, nuestro personal técnico podría tener acceso a sus archivos para realizar pruebas de rendimiento. Nos comprometemos bajo contrato de confidencialidad a <strong>no copiar, distribuir ni visualizar</strong> archivos personales (fotos, documentos, videos) que no sean necesarios para el diagnóstico técnico.</p>

            <h3>4. Derechos ARCO</h3>
            <p>Usted tiene derecho a conocer qué datos tenemos de usted (Acceso), solicitar correcciones (Rectificación), pedir que los eliminemos de nuestra base de datos (Cancelación) u oponerse a un uso específico (Oposición). Para ejercer estos derechos, puede enviar un correo a: <strong>[correo-electronico@astech.com]</strong>.</p>

            <h3>5. Transferencia de datos</h3>
            <p>AsTech Computer <strong>no vende ni alquila</strong> sus datos personales a terceros. Solo compartiremos información si es requerido por una orden judicial o para procesar pagos a través de plataformas bancarias seguras.</p>

            <h3>6. Uso de Cookies</h3>
            <p>Este sitio web utiliza cookies para mejorar su experiencia. Puede gestionar sus preferencias en cualquier momento a través de nuestro <a href="app/controllers/politica_cookies_controller.php" style="color: var(--naranja-principal); font-weight: bold;">Panel de Ajustes de Cookies</a>.</p>

            <h3>7. Cambios en el Aviso</h3>
            <p>Nos reservamos el derecho de modificar este aviso de privacidad en cualquier momento. Cualquier cambio será publicado en esta misma página.</p>
        </section>
    </main>

    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>
</html>