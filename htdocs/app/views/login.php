<?php
// 1. Iniciamos la sesión para poder guardar quién entró
session_start();

// 2. Conectamos a la base de datos (ajusta la ruta si es necesario)
require_once '../config/conexion.db.php'; 

$mensaje_error = '';

// 3. Verificamos si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (!empty($usuario) && !empty($password)) {
        // Buscamos al empleado en la base de datos
        $stmt = $conexion->prepare("SELECT id_empleado, nombre, id_puesto, contrasena FROM empleados WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $empleado = $resultado->fetch_assoc();
            
            // 4. Verificamos la contraseña (estamos usando texto plano por ahora)
            if ($password === $empleado['contrasena']) { 
                
                // ==========================================================
                // 5. FILTRO DE PUESTOS PERMITIDOS
                // ==========================================================
                // Aquí defines quién puede entrar. 
                // Ej. [3] para solo Gerente, [2, 3] para Recepción y Gerente
                $puestos_permitidos = [2, 3]; 

                if (in_array($empleado['id_puesto'], $puestos_permitidos)) {
                    // ¡Éxito! Guardamos sus datos en la memoria del servidor
                    $_SESSION['id_empleado'] = $empleado['id_empleado'];
                    $_SESSION['nombre_usuario'] = $empleado['nombre'];
                    $_SESSION['id_puesto'] = $empleado['id_puesto'];
                    
                    // ==========================================================
                    // 6. GUARDAR REGISTRO EN LA BITÁCORA
                    // ==========================================================
                    // Atrapamos la dirección IP del usuario (Ej. 192.168.1.5)
                    $direccion_ip = $_SERVER['REMOTE_ADDR']; 
                    
                    // Insertamos el registro. La fecha y hora se ponen solas gracias a tu base de datos
                    $stmt_bitacora = $conexion->prepare("INSERT INTO bitacora_logins (id_empleado, direccion_ip) VALUES (?, ?)");
                    $stmt_bitacora->bind_param("is", $empleado['id_empleado'], $direccion_ip);
                    $stmt_bitacora->execute();
                    $stmt_bitacora->close();
                    
                    // Lo enviamos a la pantalla de administración
                    header("Location: ../../app/views/administracion.php");
                    exit;
                } else {
                    $mensaje_error = "Tu puesto no tiene los permisos para acceder a esta área.";
                }
            } else {
                $mensaje_error = "Contraseña incorrecta.";
            }
        } else {
            $mensaje_error = "El usuario no existe.";
        }
        $stmt->close();
    } else {
        $mensaje_error = "Por favor, llena todos los campos.";
    }
}
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
<div class="pantalla-login">
  <div class="tarjeta-login">
    
    <div class="lado-imagen">
      <a href="../../index.php" style="text-decoration: none;">
        <button type="button" class="boton-regresar">
             <i class="fa-solid fa-arrow-left"></i> Regresar      
        </button>
      </a>
      <img src="../../public/img/1.png" alt="AS TECH Admin">
      <div class="capa-texto"></div>
    </div>

    <div class="lado-formulario">
      <form method="POST" action="">
        <h2>Iniciar Sesión</h2>

        <?php if(!empty($mensaje_error)): ?>
            <div style="background-color: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 14px;">
                <?php echo $mensaje_error; ?>
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
        
        <button type="submit" name="login" class="boton-ingresar">
          Entrar al Sistema
        </button>
        
        <a href="#" class="link-olvido">¿Olvidaste tu contraseña?</a>
      </form>
    </div>

  </div>
</div>
</body>
</html>