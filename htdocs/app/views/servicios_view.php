<?php
/**
 * PÁGINA: Vista de Catálogo de Servicios - As Tech Computer
 * PROPÓSITO: Mostrar de forma visual y atractiva todos los servicios activos.
 * FUNCIONALIDADES: 
 * - Carrusel informativo de categorías principales.
 * - Filtrado dinámico por tipo de servicio mediante parámetros GET.
 * - Grid de tarjetas interactivas con efecto "hover" para mostrar descripciones.
 * - Redirección detallada para agendar o conocer más sobre cada servicio.
 */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Integral de Equipo | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/servicios.css">
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="icon" href="../../public/img/astech_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    

    <?php
    require_once __DIR__ . "/../config/config.php"; // Carga el config
    $ruta_img = "../../public/img/servicios/";
    $ruta_prefijo = "../../";
    include_once __DIR__ . "/fijos/loader_view.php";
    include __DIR__ . "/../controllers/toolbar_controller.php";
$slides = $slides ?? [];
$max_id = $max_id ?? 0;
$umbral_novedad = $umbral_novedad ?? 0;

    ?>


<!--carousel(imagenes que van cambiando) que muestra informacion de distintas categorias de servicios-->
    <div class="carousel-container">
        <div class="carousel-track">
            <?php foreach ($slides as $index => $slide): ?>
                <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="<?php echo $slide['img']; ?>" alt="Banner">
                    <div class="contenido-imagen">
                        <h1><?php echo $slide['t']; ?></h1>
                        <h2><?php echo $slide['s']; ?></h2>
                        <p><?php echo $slide['p']; ?></p>
                        <a href="citas_cliente_controller.php" class="boton-servicio">
                            Agendar cita
                        </a>
                        <a href="mas_info_controller.php" class="link-info">Más información <i
                                class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="contenedor-servicios">

<?php if (!empty($servicios_agrupados)): ?>

    <?php foreach ($servicios_agrupados as $id_tipo => $grupo):

        $titulo_seccion = $grupo['nombre'];
        $lista_servicios = $grupo['servicios'];

    ?>
      <div class="seccion-header" id="<?php echo strtolower(str_replace(' ', '-', $titulo_seccion)); ?>">
            <h2 class="titulo-categoria"><?php echo $titulo_seccion; ?></h2>
            <hr class="linea-separadora">
        </div>

                <!-- GRID DE TARJETAS -->
                <div class="servicios-grid">
                    <?php foreach ($lista_servicios as $servicio): ?>
                        <div class="card-servicio" onclick="verServicio(<?php echo $servicio['id_servicio']; ?>)">
                            <?php if ($servicio['id_servicio'] > ($max_id - $umbral_novedad)): ?>
                                <span class="badge-nuevo">¡ N u e v o !</span>
                            <?php endif; ?>
                            <!-- IMAGEN (no la tenías en el primero) -->
                            <img src="<?php echo $ruta_img . $servicio['imagen_servicio']; ?>" alt="Servicio" class="imagen-url">

                            <!-- BOTÓN -->
                            <button class="btn-ver-mas">
                                Más información <i class="fa-solid fa-angles-right"></i>
                            </button>

                            <!-- INFO BÁSICA -->
                            <div class="info-basica">

                                <h3><?php echo $servicio['tipo_servicio']; ?></h3>
                                <span class="precio">
                                    <?php
                                    echo ($servicio['precio'] > 0)
                                        ? '$' . number_format($servicio['precio'], 2)
                                        : 'Bajo cotización';
                                    ?>
                                </span>
                                <span class="codigo-tag"><?php echo $servicio['codigo_servicio']; ?></span>
                            </div>

                            <!-- OVERLAY (clave para tu efecto) -->
                            <div class="overlay-descripcion">
                                <h3><?php echo $servicio['tipo_servicio']; ?></h3>
                                <p><?php echo $servicio['descripcion']; ?></p>
                            </div>

                        </div>

                    <?php endforeach; ?>
                </div>

            <?php endforeach; ?>
            
        <?php else: ?>
            <!--en caso de que no se muestre ningun servicio-->
            <p>No se encontraron servicios disponibles.</p>
        <?php endif; ?>
    </div>
    <div id="modalServicio" class="modal">
        <div class="modal-contenido">
            <span class="cerrar">&times;</span>
            <div id="contenidoModal"></div>
        </div>
    </div>

    <?php
    $ruta_prefijo = "";
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>
</body>
<script src="../../public/js/servicios.js"></script>

</html>