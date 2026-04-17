<?php
session_start();
// Si no hay sesión temporal, lo regresamos al login
if (!isset($_SESSION['temp_empleado'])) {
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Seguridad</title>
    <link rel="stylesheet" href="../../public/css/login.css">
</head>
<body>
<div class="pantalla-login">
    <div class="tarjeta-login" style="width: 400px; padding: 40px; text-align: center;">
        <h2>Código de Seguridad</h2>
        <p>Hemos enviado un código de 6 dígitos a tu WhatsApp.</p>
        
        <div style="background: #ffeeba; border: 1px solid #ffe8a1; padding: 10px; border-radius: 5px; margin-bottom: 20px; color: #856404; font-size: 14px;">
           <i class="fas fa-tools"></i> <b>Modo Pruebas Activo:</b><br>
           Como Meta aún no aprueba el mensaje, tu código es: 
           <strong style="font-size: 18px; display: block; margin-top: 5px; letter-spacing: 2px;">
               <?php echo $_SESSION['codigo_2fa']; ?>
           </strong>
        </div>
        
        <form action="../../controllers/procesar_2fa_controller.php" method="POST">
            <div class="grupo-entrada">
                <input type="text" name="codigo_ingresado" placeholder="123456" maxlength="6" required style="font-size: 24px; text-align: center; letter-spacing: 5px;">
            </div>
            <button type="submit" class="boton-ingresar" style="margin-top: 20px;">Verificar e Ingresar</button>
        </form>
    </div>
</div>
</body>
</html>