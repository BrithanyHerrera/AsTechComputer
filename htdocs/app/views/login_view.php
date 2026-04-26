<?php
/**
 * PÁGINA: Login - Panel de Control As Tech Computer
 * PROPÓSITO: Permitir el acceso seguro de usuarios al sistema administrativo mediante autenticación.
 * FUNCIONALIDADES:
 * - Estructura HTML responsive con integración de estilos personalizados (login.css, toolbar.css).
 * - Uso de recursos externos:
 *      • Google Fonts (tipografía Lato).
 *      • Font Awesome (iconos).
 * - Inclusión de loader inicial para mejorar la experiencia de carga.
 * - Diseño dividido en dos secciones:
 *      • Lado visual con imagen representativa, overlay y botón de regreso al inicio.
 *      • Lado formulario para autenticación del usuario.
 * - Formulario de inicio de sesión con método POST:
 *      • Campo de usuario.
 *      • Campo de contraseña.
 *      • Botón de envío para ingresar al sistema.
 * - Validación básica mediante atributos HTML (required).
 * - Visualización dinámica de mensajes de error provenientes de PHP.
 * - Protección contra XSS mediante uso de htmlspecialchars en mensajes.
 * - Integración de archivo JavaScript (login.js) para manejo de interacciones adicionales.
 */
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Panel de control</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/login.css">
  <link rel="stylesheet" href="../../public/css/toolbar.css">
  <link rel="icon" href="../../public/img/Astech ICO.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <?php include_once __DIR__ . "/fijos/loader_view.php"; ?>
  
<div class="pantalla-login">
  <div class="tarjeta-login">
    
    <div class="lado-imagen">
      <a href="index_controller.php" style="text-decoration: none;">
        <button type="button" class="boton-regresar">
             <i class="fa-solid fa-arrow-left"></i> Regresar      
        </button>
      </a>
      <img src="../../public/img/1.png" alt="AS TECH Admin">
      <div class="capa-texto"></div>
    </div>

    <div class="lado-formulario">
      <form id="formLogin" method="POST" action="">
        <h2>Iniciar Sesión</h2>

        <?php if(!empty($mensaje_error)): ?>
            <div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px;">
                <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
        <?php endif; ?>

        <div class="grupo-entrada">
          <label>Usuario</label>
          <input type="text" name="usuario" placeholder="Ingresa tu usuario" required>
        </div>
        <div class="grupo-entrada">
          <label>Contraseña</label>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>
        
        <button type="submit" name="login" id="btnIngresar" class="boton-ingresar">
          Entrar al Sistema
        </button>
        
      </form>
    </div>

  </div>
</div>

<script src="../../public/js/login.js"></script>
</body>
</html>