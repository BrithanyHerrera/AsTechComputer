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

<?php 
    // Mantenemos tu toolbar original
    $ruta_prefijo = "../../"; 
    @include "../../toolbar_servicios.php"; 
?>

<div id="contenedorBuscador" class="buscador-oculto">
    <input type="text" id="inputBuscador" placeholder="Buscar servicios...">
    <div id="resultadosBusqueda"></div>
</div>

<div class="imagen-principal">
    <img src="<?php echo $datos_header['imagen']; ?>" alt="Imagen de servicios" class="img-p">

    <div class="contenido-imagen">
        <h1><?php echo $datos_header['titulo']; ?></h1>
        <h2><?php echo $datos_header['subtitulo']; ?></h2>
        <p><?php echo $datos_header['precio']; ?></p>
        <button class="boton-servicio">Agendar cita</button>
        <a href="#" class="link-info">Más información     <i class="fa-solid fa-angle-right"></i></a>
    </div>
</div>

<h1 class="titulo-servicios"></h1>

<div class="contenedor-servicios">
    <?php foreach($lista_servicios as $row): ?>
        <div class="card-servicio">
            <img src="<?php echo $row['imagen_servicio']; ?>" alt="Servicio" class="imagen-url">
            
            <div class="info-basica">
                <h3><?php echo htmlspecialchars($row['tipo_servicio']); ?></h3>
                <span class="precio">$<?php echo number_format($row['precio'], 2); ?></span>
            </div>

            <div class="overlay-descripcion">
                <h3><?php echo htmlspecialchars($row['tipo_servicio']); ?></h3>
                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="modalServicio" class="modal">
    <div class="modal-contenido">
        <span class="cerrar">&times;</span>
        <div id="contenidoModal"></div>
    </div>
</div>

<script src="../../public/js/servicios.js"></script>
</body>
</html>