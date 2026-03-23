<?php
// 1. Incluir la conexión
require_once('../../app/config/conexion.db.php');

// 2. Obtener el ID de la URL y validar que existe
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // 3. Consultar los datos del servicio (incluyendo las nuevas columnas)
    $query = "SELECT * FROM servicios WHERE id_servicio = $id AND estado = 'activo'";
    $resultado = mysqli_query($conexion, $query);
    $query_pagos = "SELECT nombre_metodo, detalles FROM metodos_pago WHERE estado = 'activo'";
    $resultado_pagos = mysqli_query($conexion, $query_pagos);
    // 4. Guardar el resultado en la variable $servicio
    $servicio = mysqli_fetch_assoc($resultado);
}
//http://localhost:3000/htdocs/app/controllers/servicios_controller.php?id_tipo_servicio=1
//htdocs/app//htdocs/app/views/servicios_view.php?id_tipo_servicio=1
// 5. Si el servicio no existe, redirigir o mostrar error
if (!$servicio) {
    echo "Servicio no encontrado.";
    exit;
}
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
<?php $ruta_prefijo = "../../"; include "../../toolbarServicios.php"; ?>
<div class="detalle-container">

    <div class="detalle-header">
        <img src="<?php echo $servicio['imagen_servicio']; ?>" class="detalle-img">

        <div class="detalle-info">
            <h1><?php echo $servicio['tipo_servicio']; ?></h1>
            <p class="precio">$<?php echo $servicio['precio']; ?></p>
            <p class="descripcion"><?php echo $servicio['descripcion']; ?></p>

            <a href="#" class="btn-agendar">Agendar cita</a>
        </div>
    </div>
<div class="detalle-flex-row"> <div class="detalle-seccion">
        <h2>Procedimiento</h2>
        <p><?php echo nl2br($servicio['procedimiento']); ?></p>
    </div>

    <div class="detalle-seccion">
        <h2>Beneficios</h2>
        <p><?php echo nl2br($servicio['beneficios']); ?></p>
    </div>

    <div class="detalle-seccion indicaciones">
        <h2>Indicaciones</h2>
        <p><?php echo $servicio['indicaciones']; ?></p>
    </div>
  </div>  
    <div class="detalle-seccion">
        <h2>Exclusiones</h2>
        <p><?php echo $servicio['exclusiones']; ?></p>
    </div>
    

    <div class="detalle-seccion">
        <h2><i class="fa-solid fa-credit-card"> </i>     Métodos de pago disponibles</h2>
        <div class="detalle-seccion">
            <?php if (mysqli_num_rows($resultado_pagos) > 0): ?>
                <ul>
                <?php while($pago = mysqli_fetch_assoc($resultado_pagos)): ?>
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