<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Más Información y Reseñas | As Tech Computer</title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="../../public/img/Astech ICO.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/mas_info.css">
</head>

<body>
    <?php
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>

    <div class="contenedor-principal-resenas">
        <div class="encabezado">
            <h1 class="titulo-seccion">Lo que dicen nuestros clientes</h1>
            <div class="separador"></div>
            <p class="subtitulo-resenas">Conoce las experiencias reales en AsTech Computer extraídas directamente de
                Google Maps.</p>
        </div>

        <div class="grid-resenas">
            <?php if (!empty($comentarios)): ?>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="tarjeta-resena xiaomi-card">
                        <div class="perfil-resena">
                            <img src="<?php echo htmlspecialchars($comentario['profile_photo_url']); ?>"
                                alt="<?php echo htmlspecialchars($comentario['author_name']); ?>" referrerpolicy="no-referrer">
                            <div>
                                <h4><?php echo htmlspecialchars($comentario['author_name']); ?></h4>
                                <div class="estrellas">
                                    <?php
                                    // Bucle para dibujar las 5 estrellas
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $comentario['rating']) {
                                            echo '<i class="fa-solid fa-star"></i>'; // Estrella llena
                                        } else {
                                            echo '<i class="fa-regular fa-star"></i>'; // Estrella vacía
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <p class="texto-resena">"<?php echo htmlspecialchars($comentario['text']); ?>"</p>
                        <span
                            class="fecha-resena"><?php echo htmlspecialchars($comentario['relative_time_description']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alerta-vacia">
                    <i class="fa-solid fa-info-circle"></i>
                    <p>Las reseñas no están disponibles en este momento. Vuelve más tarde.</p>
                </div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="https://search.google.com/local/reviews?placeid=<?php echo htmlspecialchars($place_id); ?>"
                target="_blank" class="boton-agendar" style="text-decoration: none; display: inline-block;">
                Ver todas las reseñas en Google
            </a>
        </div>
    </div>

    <?php
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>
</body>

</html>