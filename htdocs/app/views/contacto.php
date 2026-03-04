<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $para = "tu-correo@gmail.com";
    $asunto = "Nuevo mensaje de contacto";
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];
    
    $cuerpo = "Nombre: $nombre \n";
    $cuerpo .= "Correo: $email \n";
    $cuerpo .= "Mensaje: $mensaje";
    
    $headers = "From: $email";
    
    mail($para, $asunto, $cuerpo, $headers);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Taller</title>
    <link rel="stylesheet" href="../../public/css/contacto.css">
    <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="main-container">
    <section class="form-section">
        <div class="logo-box">
            <img src="../../public/img/logoATC.png" alt="Logo Empresa">
        </div>
        
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
                <label>Mensaje</label>
                <textarea name="mensaje" rows="4" required></textarea>
            </div>
            <button type="submit">Enviar Mensaje</button>
        </form>
    </section>

    <section class="info-section">
        <h3>Nuestra Ubicación</h3>
        <p><i class="fas fa-map-marker-alt"></i> Carlos Marx 362, Paseos Universidad 1, 48280 Ixtapa, Jal.</p>
        
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.0610839695555!2d-105.2183891!3d20.707743999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8421493f4c93f41f%3A0x6e6ba05eb265e1d0!2sAsTech%20Computer!5e0!3m2!1ses!2smx!4v1772590825265!5m2!1ses!2smx" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            
        </div>

        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
        </div>
    </section>
</div>

</body>
</html>