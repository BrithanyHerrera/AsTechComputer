<script>
/* POLITICA_SERVICIOS_VIEW.PHP */
/*
Este archivo actúa como la Vista (View) encargada de desplegar la Política de Prestación de Servicios de ASTECH COMPUTER. Su objetivo es informar claramente a los clientes sobre los procesos operativos de la empresa: desde la recepción de los equipos y la emisión de diagnósticos/presupuestos, hasta las reglas sobre garantías, refacciones y abandono de dispositivos. Diseñado con una estructura modular, este archivo incorpora las hojas de estilo corporativas y se integra armónicamente con la barra de navegación (Toolbar) y el pie de página (Footer).
*/
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Servicios - AsTech Computer</title>
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
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <main>
        <section class="seccion-legal">
            <h1>Política de Prestación de Servicios</h1>
            <span class="fecha-actualizacion">Última actualización: [Día] de [Mes] de 2026</span>

            <p>En <strong>AsTech Computer</strong>, nos comprometemos a brindar un servicio técnico de excelencia, transparencia y honestidad. La siguiente política describe los lineamientos bajo los cuales operamos nuestros servicios de reparación, mantenimiento y soporte.</p>

            <h3>1. Recepción y Resguardo de Equipos</h3>
            <p>Al recibir un equipo en nuestras instalaciones o mediante recolección, se realizará una inspección visual rápida. [Ejemplo: Se documentará el estado físico, golpes previos, rayaduras y accesorios entregados (cargadores, fundas, memorias). El cliente recibirá un comprobante digital o físico de recepción].</p>

            <h3>2. Proceso de Diagnóstico y Presupuesto</h3>
            <p>Todo equipo ingresado pasa por un proceso de diagnóstico técnico. [Ejemplo: El tiempo estimado para la entrega del presupuesto es de 24 a 48 horas hábiles. En caso de que el cliente decida no realizar la reparación después del diagnóstico, se aplicará una tarifa de revisión de $XXX MXN].</p>

            <h3>3. Autorización de Reparaciones</h3>
            <p>Ninguna reparación será efectuada sin la autorización expresa del cliente. [Ejemplo: Los presupuestos tienen una vigencia de 5 días hábiles debido a la variabilidad en los costos de componentes electrónicos].</p>

            <h3>4. Uso de Refacciones y Componentes</h3>
            <p>AsTech Computer garantiza el uso de componentes de alta calidad. [Ejemplo: Se informará siempre al cliente si la refacción es Original o de Grado A (Compatible). Las piezas reemplazadas quedan a disposición del cliente al momento de la entrega, a menos que sean piezas de intercambio por garantía].</p>

            <h3>5. Integridad de los Datos</h3>
            <p>Nuestra prioridad es la seguridad de su información. [Ejemplo: Aunque tomamos medidas preventivas, AsTech Computer NO se hace responsable por la pérdida de datos durante el proceso de reparación. Recomendamos encarecidamente que el cliente realice un respaldo antes de entregar su equipo].</p>

            <h3>6. Garantías del Servicio</h3>
            <p>Todas nuestras reparaciones físicas cuentan con garantía. [Ejemplo: Se ofrece una garantía estándar de 30 a 90 días naturales sobre la mano de obra y la pieza sustituida. La garantía no cubre daños por líquidos, caídas, variaciones de voltaje o manipulación por terceros].</p>

            <h3>7. Almacenaje y Abandono</h3>
            <p>Es responsabilidad del cliente recoger su equipo en tiempo y forma. [Ejemplo: Una vez notificada la finalización del servicio, el cliente tiene 15 días naturales para recogerlo. A partir del día 16, se generará un cargo diario por almacenaje de $XX MXN. Equipos con más de 90 días de abandono serán reciclados para recuperar costos operativos].</p>

            <h3>8. Contacto y Soporte</h3>
            <p>Para cualquier duda sobre el estatus de su equipo o nuestras políticas, puede contactarnos directamente a través de nuestro botón de <strong>WhatsApp</strong> en el menú principal.</p>
        </section>
    </main>

    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>
</html>