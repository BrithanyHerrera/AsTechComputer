<?php
session_start();

// Si alguien intenta entrar aquí de colado sin haber pasado por el login, lo pateamos fuera
if (!isset($_SESSION['temp_empleado']) || !isset($_SESSION['qr_image'])) {
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Seguridad | As Tech Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .instrucciones { text-align: left; font-size: 14px; color: #555; margin-bottom: 20px; line-height: 1.5; }
        .qr-contenedor { background: #fff; padding: 10px; border-radius: 10px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 15px; }
        .qr-contenedor img { width: 180px; height: 180px; }
        .secreto-manual { font-family: monospace; font-size: 16px; background: #f4f4f9; padding: 8px; border-radius: 5px; letter-spacing: 2px; color: #333; margin-bottom: 20px; word-break: break-all; }
    </style>
</head>
<body>
<div class="pantalla-login">
    <div class="tarjeta-login" style="width: 450px; padding: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
        
        <h2><i class="fa-solid fa-shield-halved" style="color: #2c3e50;"></i> Activar Seguridad</h2>

        <!-- BOTÓN DE REGRESAR (Enviando al logout para limpiar la sesión temporal) -->
        <a href="../../controllers/logout_controller.php" style="position: absolute; top: 20px; left: 20px; text-decoration: none; color: #888; font-size: 15px; font-weight: bold; transition: color 0.3s;" onmouseover="this.style.color='#c0392b'" onmouseout="this.style.color='#888'">
            <i class="fa-solid fa-arrow-left"></i> Regresar
        </a>
        
        <div class="instrucciones">
            <b>Paso 1:</b> Descarga la app <b>Google Authenticator</b> en tu celular.<br>
            <b>Paso 2:</b> Escanea este Código QR con la aplicación.
        </div>
        
        <!-- Aquí imprimimos la imagen en Base64 que generó la librería -->
        <div class="qr-contenedor">
            <img src="<?php echo $_SESSION['qr_image']; ?>" alt="Código QR As Tech Computer">
        </div>

        <div class="instrucciones" style="font-size: 12px; text-align: center;">
            ¿No puedes escanear el código? Ingresa esta clave manualmente:
        </div>
        <div class="secreto-manual">
            <?php echo $_SESSION['secreto_2fa']; ?>
        </div>

        <div class="instrucciones" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
            <b>Paso 3:</b> Ingresa el código de 6 dígitos que te da la app para confirmar.
        </div>
        
        <!-- Mandamos el código al procesador final -->
        <form action="../../controllers/procesar_2fa_controller.php" method="POST">
            <div class="grupo-entrada">
                <input type="text" name="codigo_ingresado" placeholder="000 000" maxlength="6" required style="font-size: 24px; text-align: center; letter-spacing: 10px;">
            </div>
            
            <!-- Campo oculto para decirle al controlador que venimos de configurarlo por primera vez -->
            <input type="hidden" name="es_nueva_configuracion" value="1">

            <button type="submit" class="boton-ingresar" style="margin-top: 10px;">
                <i class="fa-solid fa-check"></i> Confirmar y Entrar
            </button>
        </form>

    </div>
</div>
</body>
</html>