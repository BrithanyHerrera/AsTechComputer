<?php

include "../config/conexion.db.php";

$status = ""; // Variable para controlar la alerta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre  = $_POST['nombre'];
    $email   = $_POST['email'];
    $asunto  = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    // 2. Insertar en la tabla 'mensajes_contacto'
    $sql = "INSERT INTO mensajes_contacto (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);

    try {
        if ($stmt->execute()) {
            $status = "success";
            
        } else {
            $status = "error";
        }
    } catch (Exception $e) {
        $status = "error";
    }

    $stmt->close();
    // No cerramos la conexión aquí por si el toolbar la usa después
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Taller</title>
    <link rel="stylesheet" href="../../public/css/toolbar.css">
    <link rel="stylesheet" href="../../public/css/contacto.css">
    <link rel="icon" href="../../public/img/logoATC.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php $ruta_prefijo = "../../"; include "../../toolbar.php"; ?>

<div class="main-container">
    <section class="form-section">
        <center><h1>Contacto directo</h1></center>
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
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.0610839695555!2d-105.2183891!3d20.707743999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8421493f4c93f41f%3A0x6e6ba05eb265e1d0!2sAsTech%20Computer!5e0!3m2!1ses!2smx!4v1773751032385!5m2!1ses!2smx"  width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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

<script>
// Lógica para mostrar la alerta basada en el estado de PHP
document.addEventListener('DOMContentLoaded', function() {
    const res = "<?php echo $status; ?>";
    if (res === "success") {
        Swal.fire({
            icon: 'success',
            title: '¡Mensaje Enviado!',
            text: 'En breve te respondemos 😊 Horario de atención: 10:00 a.m. a 4:00 p.m.',
            confirmButtonColor: '#52073a'
        }).then(() => {
            // Limpiar el formulario al cerrar la alerta
            window.location.href = "contacto.php"; 
        });
    } else if (res === "error") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo guardar el mensaje. Inténtalo más tarde.',
            confirmButtonColor: '#52073a'
        });
    }
});
</script>

</body>
</html>