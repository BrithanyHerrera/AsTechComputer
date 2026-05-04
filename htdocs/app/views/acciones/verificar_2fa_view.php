<!-- UBICACIÓN: app/views/acciones/verificar_2fa_view.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Seguridad</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Ruta CSS ajustada -->
    <link rel="stylesheet" href="../../public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="pantalla-login">
    
    <div class="tarjeta-login" style="position: relative; width: 450px; padding: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
        
        <!-- BOTÓN DE REGRESAR ajustado -->
        <a href="logout_controller.php" style="position: absolute; top: 20px; left: 20px; text-decoration: none; color: #888; font-size: 15px; font-weight: bold; transition: color 0.3s;" onmouseover="this.style.color='#c0392b'" onmouseout="this.style.color='#888'">
            <i class="fa-solid fa-arrow-left"></i> Regresar
        </a>

        <h2 style="margin-bottom: 15px; margin-top: 15px;"><i class="fa-solid fa-shield-halved" style="color: #2c3e50;"></i> Código de Seguridad</h2>
        <p style="margin-bottom: 25px; color: #555; line-height: 1.5;">Abre tu aplicación de <b>Google Authenticator</b> e ingresa el código de 6 dígitos para acceder.</p>
        
        <!-- Acción del formulario ajustada -->
        <form action="procesar_2fa_controller.php" method="POST" style="width: 100%;">
            <div class="grupo-entrada" style="margin-bottom: 20px;">
                <input type="text" name="codigo_ingresado" placeholder="000 000" maxlength="6" required style="font-size: 24px; text-align: center; letter-spacing: 10px; width: 100%; box-sizing: border-box;">
            </div>
            <button type="submit" class="boton-ingresar" style="width: 100%; margin-top: 10px;">
                <i class="fa-solid fa-lock"></i> Verificar e Ingresar
            </button>
        </form>
        
    </div>
</div>
</body>
</html>