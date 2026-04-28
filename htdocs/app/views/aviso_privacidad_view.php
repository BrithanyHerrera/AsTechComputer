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
            <h1>Aviso de Privacidad Sitio web- AsTech Computer</h1>
            <span class="fecha-actualizacion">Última actualización: Abril de 2026</span>

            <p>De acuerdo con lo establecido en el <strong>Artículo 15 de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP)</strong>, se emite el presente documento para informar a los titulares sobre la existencia y características del tratamiento de sus datos:</p>

            <h3>1. Identidad y Domicilio del Responsable</h3>
            <p>De acuerdo con la fracción I del artículo 15 de la LFPDPPP, el responsable de la custodia de su información es Ferdán Alejandro Garrigós Rojas propietario del título de registro de la marca <strong>AsTech Computer ®</strong>, con domicilio físico en Carlos Marx 362, Paseos Universidad 1, 48280, Ixtapa, Jal..</p>
            <ul>
                <li><strong>Correo electrónico:</strong> ferdan.garrigos@astechcomputer.com</li>
                <li><strong>Teléfono:</strong> 322 236 2505</li>
            </ul>

            <h3>2. Datos Personales Recabados</h3>
            <p>En cumplimiento con la fracción II del artículo 15 de la LFPDPPP, recabamos los siguientes datos para la operación del servicio:</p>
            <ul>
                <li><strong>Datos de contacto:</strong> Nombre completo, número de teléfono (WhatsApp) y correo electrónico.</li>
                <li><strong>Información del equipo:</strong> Tipo de dispositivo, marca, modelo y número de serie (SN).</li>
                <li><strong>Información técnica:</strong> Descripción detallada de fallas y evidencia visual (fotografías/videos) del estado del equipo.</li>
                <li><strong>Análisis de mercado:</strong> Origen del contacto, frecuencia de uso y tipo de aplicaciones utilizadas en el equipo.</li>
            </ul>

            <h3>3. Finalidades del Tratamiento de Datos</h3>
            <p>De acuerdo con la fracción III del artículo 15 de la LFPDPPP , sus datos serán utilizados para las siguientes finalidades:</p>
            <ul>
                <li><strong>Primarias (Necesarias):</strong> Agendamiento de citas en <strong>Google Calendar</strong>, gestión de órdenes de servicio, notificaciones de cambios de estatus vía <strong>WhatsApp</strong>, generación de presupuestos y soporte técnico remoto o presencial.</li>
                <li><strong>Secundarias (Opcionales):</strong> Envío de boletines promocionales, recordatorios de mantenimiento y encuestas de satisfacción para análisis de mercado.</li>
            </ul>

            <h3>4. Derechos ARCO</h3>
            <p>De acuerdo con los <strong>Artículos 22, 23, 24 y 26</strong> de la LFPDPPP, usted tiene derecho al <strong>Acceso, Rectificación, Cancelación y Oposición</strong> de sus datos. El procedimiento para ejercer estos derechos se basa en la fracción V del artículo 15 de la ley, enviando su solicitud detallada a nuestro correo electrónico de contacto.</p>

            <h3>5. Seguridad de la Información</h3>
            <p>De acuerdo con el <strong>Artículo 18</strong> de la LFPDPPP, AsTech Computer mantiene medidas de seguridad administrativas, técnicas y físicas para proteger sus datos contra daño o uso no autorizado. Implementamos una <strong>estrategia de seguridad en capas</strong> que incluye capacitación constante del personal en ética digital y protocolos de "privacidad desde el diseño".</p>

            <h3>6. Transferencia de Datos</h3>
            <p>De acuerdo con el <strong>Artículo 36</strong> de la LFPDPPP, sus datos no serán transferidos a terceros con fines comerciales. Únicamente se realizan transferencias técnicas necesarias para la operación (como el uso de infraestructuras de Google y Meta) o aquellas legalmente exigidas por autoridad competente.</p>

            <h3>7. Cambios al Aviso de Privacidad</h3>
            <p>De acuerdo con la fracción VI del artículo 15 de la LFPDPPP, cualquier modificación a este aviso será comunicada a través de nuestro portal web oficial: <strong>astechcomputer.com</strong>.</p>
        </section>
    </main>

    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>
</html>