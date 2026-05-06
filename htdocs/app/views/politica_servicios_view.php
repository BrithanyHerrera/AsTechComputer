<?php
/* POLITICA_SERVICIOS_VIEW.PHP */
/*
 * PÁGINA: Vista de la Política de Servicios (Service Policy View) - As Tech Computer
 * PROPÓSITO: Desplegar el resumen de las políticas de prestación de servicios, informando a los clientes sobre los lineamientos operativos de la empresa y ofreciendo la descarga del documento legal completo.
 * FUNCIONALIDADES:
 * - Estructuración semántica del contenido normativo mediante un diseño modular y accesible.
 * - Desglose resumido de los pilares del servicio técnico, estableciendo reglas claras sobre diagnóstico, pagos, garantías, responsabilidades del cliente y tiempos de almacenaje.
 * - Integración de un botón interactivo para la descarga directa del documento oficial de políticas en formato PDF.
 * - Inyección dinámica de los componentes fijos de la arquitectura MVC, incluyendo la barra de navegación (Toolbar) y el pie de página (Footer) con sus respectivas rutas relativas.
 */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Servicios - AsTech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../../public/img/astech_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/static.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/info_legal.css">
</head>

<body style="background-color: #f4f4f4;">
    <?php
    // El sistema define la profundidad del directorio actual ($ruta_prefijo)
    // e invoca al controlador del Toolbar para renderizar el menú global de forma dinámica.
    require_once __DIR__ . "/../config/config.php";
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <main>
        <section class="seccion-legal">
            <h1>Política de Prestación de Servicios</h1>
            <span class="fecha-actualizacion">
                Fecha de publicación: 1 de junio de 2026.   
                Vigencia: Hasta su modificación.
            </span>

            <p>En <strong>AsTech Computer</strong>, ofrecemos servicios de diagnóstico, mantenimiento y reparación bajo
                los más altos estándares legales y técnicos. Al solicitar nuestros servicios, usted acepta las
                siguientes condiciones generales basadas en la LFPC y el Código de Comercio:</p>

            <div class="resumen-politicas">
                <h3>Resumen</h3>
                <h3>1. Recepción y Diagnóstico</h3>
                <ul>
                    <li>Todo equipo se registra con una orden de servicio y descripción física.</li>
                    <li>El costo del diagnóstico se informa previamente y es deducible si se autoriza el servicio.</li>
                    <li>No se realizan trabajos ni cargos adicionales sin autorización expresa del cliente.
                    </li>
                </ul>

                <h3>2. Pagos y Facturación</h3>
                <ul>
                    <li>El pago total se realiza al momento de la entrega del equipo.</li>
                    <li>Los precios incluyen IVA y comisiones de terminal (TPV).</li>
                    <li>Las facturas fiscales se emiten dentro de las 48 horas posteriores al pago.</li>
                </ul>

                <h3>3. Garantías y Exclusiones</h3>
                <ul>
                    <li><strong>Mano de obra:</strong> Garantía limitada de 60 días naturales tras la entrega.</li>
                    <li><strong>Refacciones:</strong> Sujetas a los términos del fabricante o proveedor.
                    </li>
                    <li><strong>Exclusiones:</strong> La garantía no aplica por daños físicos, líquidos, variaciones
                        eléctricas, software/malware o manipulación de terceros.</li>
                </ul>

                <h3>4. Responsabilidades del Cliente</h3>
                <ul>
                    <li>El cliente es responsable de realizar un <strong>respaldo de su información</strong> previo al
                        servicio; el Prestador no se hace responsable por pérdida de datos.</li>
                    <li>Debe proporcionar acceso seguro y condiciones adecuadas en servicios a domicilio.</li>
                </ul>

                <h3>5. Almacenaje y Abandono</h3>
                <ul>
                    <li>El cliente tiene 7 días naturales de gracia para recoger su equipo tras la notificación.</li>
                    <li>A partir del día 8, se aplica una tarifa diaria de almacenaje calculada sobre el valor de
                        mercado del equipo.</li>
                    <li>Equipos no reclamados tras 60 días y sin respuesta del cliente se considerarán abandonados.</li>
                </ul>
            </div>

            <div style="margin-top: 30px; text-align: center;">
                <a href="../../public/docs/POLÍTICAS GENERALES DE PRESTACIÓN DE SERVICIOS DE ASTECH COMPUTER.pdf" download="POLÍTICAS GENERALES DE PRESTACIÓN DE SERVICIOS DE ASTECH COMPUTER.pdf" class="btn-descargar-pdf">
                    <i class="fas fa-file-pdf"></i> Descargar Políticas Completas (PDF)
                </a>
            </div>
        </section>
    </main>

    <?php
    // El sistema establece la ruta relativa hacia la raíz y delega 
    // la renderización del pie de página al controlador correspondiente.
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>

</html>