<script>
/* CONTACTO_VIEW.PHP */
/*
Este archivo representa la Vista (View) exclusiva para la sección de contacto de la plataforma. 
Su función es estructurar la interfaz gráfica mediante la cual los usuarios pueden enviar mensajes directos al taller. 
Adicionalmente, despliega la ubicación física a través de un mapa interactivo y muestra los accesos a las redes sociales. 
A nivel técnico, recibe la variable $status desde su respectivo controlador para inicializar los scripts de notificaciones (alertas) en el navegador del cliente, 
integrándose finalmente con las secciones globales de navegación y pie de página.
*/
</script>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Taller</title>
<link rel="icon" href="<?= BASE_URL ?>public/img/astech_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/contacto.css">
</head>

<body>
    <?php 
    include_once __DIR__ . "/fijos/loader_view.php"; 
    require_once __DIR__ . "/../config/config.php"; 
    include __DIR__ . "/../controllers/toolbar_controller.php";
    ?>
    
    <div class="main-container">
        <section class="form-section">
            <center>
                <h1>Contacto directo</h1>
            </center>

            <form action="" method="POST">
                <div class="form-group">
                    <label>NOMBRE COMPLETO</label>
                   <input type="text" name="nombre" id="nombre" required 
               maxlength="100"
               pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$" 
               oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
               placeholder="Ej. Juan Pérez">
                </div>
                <div class="form-group">
        <label>CORREO ELECTRÓNICO</label>
        <input type="email" name="email" id="email" required 
               maxlength="150"
               placeholder="correo@ejemplo.com">
    </div>
                <div class="form-group">
            <label>ASUNTO</label>
            <textarea name="asunto" id="asunto" rows="1" required 
                      maxlength="100"
                      oninput="this.value = this.value.replace(/[<>{}[\];]/g, '')"
                      placeholder="Motivo de tu mensaje"></textarea>
        </div>
                <div class="form-group">
            <label>MENSAJE</label>
            <textarea name="mensaje" id="mensaje" rows="2" required 
                      maxlength="500"
                      oninput="this.value = this.value.replace(/[<>{}[\];]/g, '')"
                      placeholder="Escribe tu mensaje aquí..."></textarea>
        </div>
                <button type="submit" class="boton-submit">EMVIAR MENSAJE</button>
            </form>
        </section>

        <section class="info-section">
            <h3>Nuestra Ubicación</h3>
            <p><i class="fas fa-map-marker-alt"></i> Carlos Marx 362, Paseos Universidad 1, 48280 Ixtapa, Jal.</p>
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.0610839695555!2d-105.2183891!3d20.707743999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8421493f4c93f41f%3A0x6e6ba05eb265e1d0!2sAsTech%20Computer!5e0!3m2!1ses!2smx!4v1773751032385!5m2!1ses!2smx"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
            <h3>Redes Sociales</h3>
         
   
    <div class="social-icons">
        <a href="https://wa.me/523222362505" target="_blank"><i class="fa-brands fa-square-whatsapp"></i></a>
        <a href="https://www.instagram.com/AsTechComputer" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
        <a href="https://www.facebook.com/AstechComputer" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>
        <a href="https://www.tiktok.com/@astechcomputer" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
        <a href="https://www.youtube.com/@Astech_Computer" target="_blank"><i class="fa-brands fa-square-youtube"></i></a>
    </div>
</section>
        </section>
    </div>


    <script>
        const formStatus = "<?php echo $status; ?>";
    </script>
    
    <?php
    $ruta_prefijo = "../../../"; 
    include __DIR__ . "/../controllers/footer_controller.php";
    ?>

</body>

</html>


<script src="../../public/js/contacto.js"></script>