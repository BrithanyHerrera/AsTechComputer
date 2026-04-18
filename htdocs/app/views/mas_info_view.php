<script>
/* MAS_INFO_VIEW.PHP */
/*
Este archivo representa la Vista (View) encargada de mostrar las reseñas obtenidas de Google Maps. Su propósito es procesar las variables ($rating_general, $total_opiniones y $comentarios) generadas por mas_info_controller.php y renderizarlas en un diseño estructurado y profesional. Incluye un resumen general de la calificación, un grid para desplegar los comentarios individuales en formato de tarjeta (estilo minimalista) y un enlace directo al perfil de Google Maps. Además, integra el encabezado (Toolbar) y el pie de página (Footer) para mantener la consistencia con el resto del sitio web de ASTECH COMPUTER.
*/
</script>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Clientes | As Tech Computer</title>
    
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
            
            <?php if ($rating_general > 0): ?>
            <div class="contenedor-resumen-general">
                <div class="puntuacion-numero"><?php echo $rating_general; ?></div>
                <div class="puntuacion-estrellas">
                    <div class="estrellas-grandes">
                        <?php
                        // Dibuja 5 estrellas dinámicamente según el promedio general
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= round($rating_general)) {
                                echo '<i class="fa-solid fa-star"></i>';
                            } else {
                                echo '<i class="fa-regular fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <p class="conteo-opiniones">Basado en <?php echo $total_opiniones; ?> opiniones de Google Maps</p>
                </div>
            </div>
            <?php endif; ?>

            <p class="subtitulo-resenas">Experiencias reales extraídas directamente de Google Maps.</p>
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
                                    // Dibuja las estrellas otorgadas por este usuario específico
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo ($i <= $comentario['rating']) ? '<i class="fa-solid fa-star"></i>' : '<i class="fa-regular fa-star"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <p class="texto-resena">"<?php echo htmlspecialchars($comentario['text']); ?>"</p>
                        <span class="fecha-resena"><?php echo htmlspecialchars($comentario['relative_time_description']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alerta-vacia">
                    <i class="fa-solid fa-info-circle"></i>
                    <p>Reseñas no disponibles por el momento.</p>
                </div>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="https://search.google.com/local/reviews?placeid=<?php echo $place_id; ?>" 
               target="_blank" class="boton-agendar">
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