<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Integral de Equipo | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/servicios.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
</head>
<body>
<?php $ruta_prefijo = "../../"; include "../../toolbar.php"; ?>
<div class="imagen-principal">
    <img src="../../public/img/principalAdv.png" alt="Imagen de servicios" class="img-p">

    <div class="contenido-imagen">
        <h1>Mantenimiento preventivo</h1>
        <h2>para equipos portátiles de alto rendimiento</h2>
        <p>Desde: $1350* pesos</p>
        <button class="boton-servicio">Agendar cita</button>
        <a href="#" class="link-info">Más información     <i class="fa-solid fa-angle-right"></i></a>
    </div>
</div>
<h1 class="titulo-servicios"></h1>
<?php
// Incluir la conexión
require_once('../../app/config/conexion.db.php');

// Consulta a la base de datos
$query = "SELECT tipo_servicio, descripcion, precio, imagen_servicio
          FROM servicios 
          WHERE estado = 'activo'";

$resultado = mysqli_query($conexion, $query);
?>

<div class="contenedor-servicios">
    <?php while($row = mysqli_fetch_assoc($resultado)): ?>
        <div class="card-servicio">
            <img src="<?php echo $row['imagen_servicio']; ?>" alt="Servicio" class="imagen-url">
            
            <div class="info-basica">
                <h3><?php echo $row['tipo_servicio']; ?></h3>
                <span class="precio">$<?php echo number_format($row['precio'], 2); ?></span>
            </div>

            <div class="overlay-descripcion">
                <h3><?php echo $row['tipo_servicio']; ?></h3>
                <p><?php echo $row['descripcion']; ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>