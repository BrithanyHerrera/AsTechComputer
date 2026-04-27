<script>
    /* MAS_INFO_VIEW.PHP */
    /*
    Este archivo representa la Vista (View) principal encargada de unificar dos secciones clave para el sitio web de ASTECH COMPUTER: el formulario de contacto directo y la exhibición de reseñas obtenidas de Google Maps. Su propósito es procesar las variables (como $rating_general, $total_opiniones, $comentarios y $status) generadas por el controlador respectivo y renderizarlas en un diseño estructurado. Incluye áreas para captura de mensajes, un mapa interactivo de ubicación, enlaces a redes sociales y un grid para desplegar los comentarios de clientes en formato de tarjeta. Se integra fluidamente con el encabezado (Toolbar) y el pie de página (Footer) corporativos.
    */
</script>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Clientes | As Tech Computer</title>
    <link rel="icon" href="../../public/img/Astech ICO.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/mas_info.css">
    <link rel="stylesheet" href="../../public/css/contacto.css">

</head>

<body>
    <?php include_once __DIR__ . "/fijos/loader_view.php"; ?>

    <?php
    $ruta_prefijo = "";

    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>


    <div class="main-container">
        <section class="form-section">
            <center>
                <h1>Contacto directo</h1>
            </center>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Asunto</label>
                    <textarea name="asunto" rows="1" required></textarea>
                </div>
                <div class="form-group">
                    <label>Mensaje</label>
                    <textarea name="mensaje" rows="2" required></textarea>
                </div>
                <button type="submit" class="boton-submit">Enviar Mensaje</button>
            </form>
        </section>

        <section class="info-section">
            <h3>Nuestra Ubicación</h3>
            <p><i class="fas fa-map-marker-alt"></i> Carlos Marx 362, Paseos Universidad 1, 48280 Ixtapa, Jal.</p>
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.0610839695555!2d-105.2183891!3d20.707743999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8421493f4c93f41f%3A0x6e6ba05eb265e1d0!2sAsTech%20Computer!5e0!3m2!1ses!2smx!4v1773751032385!5m2!1ses!2smx"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <h3>Redes Sociales</h3>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-square-whatsapp"></i></a>
                <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-square-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#"><i class="fa-brands fa-square-youtube"></i></a>
            </div>
        </section>
    </div>

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
                        <span
                            class="fecha-resena"><?php echo htmlspecialchars($comentario['relative_time_description']); ?></span>
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
            <a href="https://search.google.com/local/reviews?placeid=<?php echo $place_id; ?>" target="_blank"
                class="boton-agendar">
                Ver todas las reseñas en Google
            </a>
        </div>
    </div>

    <script>
        const formStatus = "<?php echo $status; ?>";
    </script>

    <script src="../../public/js/contacto.js"></script>

    <?php
    $ruta_prefijo = "../../../";
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>
</body>

</html>