<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones - AsTech Computer</title>
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
            <h1>Términos y Condiciones del Servicio</h1>
            <span class="fecha-actualizacion">Última actualización: [Día] de [Mes] de [Año]</span>

            <p>Bienvenido a AsTech Computer. Los siguientes términos y condiciones rigen el uso de nuestro sitio web y los servicios de soporte, mantenimiento y reparación de equipos informáticos que ofrecemos. Al agendar una cita, dejar su equipo en nuestras instalaciones o utilizar nuestros servicios, usted acepta estos términos en su totalidad.</p>

            <h3>1. Condiciones de Diagnóstico y Presupuestos</h3>
            <p>[Aquí puedes redactar cómo funciona tu fase de revisión. Ejemplo: AsTech Computer se compromete a realizar un diagnóstico profesional del equipo. El diagnóstico tiene un costo de $XXX MXN, el cual será descontado del precio final si el cliente aprueba la reparación. Los presupuestos entregados tienen una vigencia de "X" días hábiles debido a la fluctuación en el costo de las piezas de reemplazo...]</p>

            <h3>2. Aprobación y Pagos</h3>
            <p>[Aquí va la información sobre cómo te pagan. Ejemplo: Todo servicio de reparación que requiera la compra de refacciones externas necesita un anticipo del 50% del valor total presupuestado. El saldo restante deberá liquidarse al momento de la entrega del equipo. Aceptamos pagos en efectivo, transferencias y tarjetas bancarias...]</p>

            <h3>3. Responsabilidad sobre la Información (Copias de Seguridad)</h3>
            <p>[Súper importante para protegerte legalmente. Ejemplo: Aunque el equipo de AsTech Computer trata su dispositivo con el máximo cuidado y bajo estrictos protocolos de ciberseguridad, <strong>es responsabilidad exclusiva del cliente</strong> realizar un respaldo (backup) de toda su información antes de entregar el equipo. AsTech Computer no se hace responsable por la pérdida de datos, software, archivos o información confidencial durante el proceso de reparación o formateo...]</p>

            <h3>4. Garantía de Servicios y Piezas</h3>
            <p>[Detalla qué cubre tu trabajo. Ejemplo: Todos nuestros servicios de reparación física y reemplazo de componentes cuentan con una garantía de "X" días/meses a partir de la fecha de entrega. La garantía cubre únicamente la falla reparada y las piezas instaladas por AsTech. Esta garantía queda automáticamente anulada si el equipo presenta daños por líquidos, caídas, variaciones de voltaje, o si es abierto/manipulado por terceros después de nuestra entrega...]</p>
            <ul>
                <li>[Punto a rellenar: Qué pasa con las garantías de software/virus].</li>
                <li>[Punto a rellenar: Condiciones para hacer válida la garantía (ej. presentar ticket/nota)].</li>
            </ul>

            <h3>5. Abandono de Equipos</h3>
            <p>[Ejemplo para evitar que usen tu taller de bodega: Una vez notificado el cliente sobre la finalización del servicio (reparado o no reparado), cuenta con "X" días naturales para recoger su equipo. Pasado este periodo, se cobrará una tarifa de almacenaje de $XX MXN por día. Si el equipo no es reclamado después de "Y" días, será considerado legalmente abandonado y AsTech Computer podrá disponer de él, desarmarlo o reciclarlo para cubrir los costos de diagnóstico, almacenamiento y reparación generados...]</p>

            <h3>6. Tiempos de Entrega</h3>
            <p>[Ejemplo: Los tiempos de entrega son aproximados y dependen de la disponibilidad de refacciones con nuestros proveedores. AsTech Computer mantendrá comunicación constante con el cliente a través de WhatsApp o correo electrónico para informar sobre el estatus de su equipo...]</p>

            <h3>7. Modificaciones a los Términos</h3>
            <p>AsTech Computer se reserva el derecho de actualizar o modificar estos Términos y Condiciones en cualquier momento para reflejar cambios en nuestros procesos operativos o adaptarnos a nuevas legislaciones. Cualquier actualización entrará en vigor de inmediato tras su publicación en este sitio web.</p>
        </section>
    </main>

    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>
</html>