<?php
// ========================================================
//VISTA DE DETALLE SERVICIO
//controlador:detalle_servicio_controller.php
// mODELO: detalle_servicio_model.php (Página de detalle servicio)
// pagina que muestra informacion especifica de cada servicio en la pagina servicios_view.php
// ========================================================
$ruta_prefijo = "../../";
$ruta_img = "../../public/img/servicios/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Integral de Equipo | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/servicios_view.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/detalle_servicio.css">
</head>

<body>

<?php $ruta_prefijo = "../../";   include __DIR__ . '/../controllers/toolbar_controller.php';  $ruta_img = "../../public/img/servicios/";?>
<div class="detalle-container">

    <div class="detalle-header">
        <img src="<?php echo $ruta_img . $servicio['imagen_servicio']; ?>" class="detalle-img">

        <div class="detalle-info">
            <h1><?php echo $servicio['tipo_servicio']; ?></h1>
            <p class="precio">$<?php echo $servicio['precio']; ?></p>
            <p class="descripcion"><?php echo $servicio['descripcion']; ?></p>

            <a href="#" class="btn-agendar">Agendar cita</a>
        </div>
    </div>
<div class="detalle-flex-row"> 
    <div class="detalle-seccion">
        <h2><i class="fa-solid fa-gears"></i> Procedimiento</h2>
        <p><?php echo nl2br($servicio['procedimiento']); ?></p>
    </div>

    <div class="detalle-seccion">
        <h2><i class="fa-solid fa-star"></i> Beneficios</h2>
        <p><?php echo nl2br($servicio['beneficios']); ?></p>
    </div>

    <div class="detalle-seccion">
        <h2><i class="fa-solid fa-circle-info"></i> Indicaciones</h2>
        <p><?php echo nl2br($servicio['indicaciones']); ?></p>
    </div>
    
    <div class="detalle-seccion">
        <h2><i class="fa-solid fa-circle-xmark"></i> Exclusiones</h2>
        <p><?php echo nl2br($servicio['exclusiones']); ?></p>
    </div>

    <div class="detalle-seccion full-width"> <h2><i class="fa-solid fa-credit-card"></i> Métodos de pago disponibles</h2>
        </div>
</div>
        <div class="detalle-seccion">
            <?php if ($metodos_pago && mysqli_num_rows($metodos_pago) > 0): ?>
                <ul>
                <?php while($pago = mysqli_fetch_assoc($metodos_pago)): ?>
                    <li>
                        <strong><?php echo $pago['nombre_metodo']; ?></strong>
                        <?php if(!empty($pago['detalles'])): ?>
                            <small>(<?php echo $pago['detalles']; ?>)</small>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Consultar métodos de pago en sucursal.</p>
            <?php endif; ?>
        </div>
</div>