<?php
// ========================================================
// CONTROLADOR: login_controller.php
// UBICACIÓN: app/controllers/login_controller.php
// ========================================================

// 1. Iniciamos la sesión
session_start();

// Si el usuario ya está logueado, lo mandamos directo al dashboard
if (isset($_SESSION['id_empleado'])) {
    header("Location: administracion_controller.php");
    exit;
}

// 2. Requerimos la base de datos y el modelo
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/login_model.php';

$modeloLogin = new LoginModel($conexion);
$mensaje_error = '';

// 3. Verificamos si el formulario fue enviado
// Ahora PHP solo verifica que se haya enviado el POST con el campo 'usuario'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario'])) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (!empty($usuario) && !empty($password)) {
        
        $empleado = $modeloLogin->buscarUsuario($usuario);

        if ($empleado) {
            // 4. Verificamos la contraseña
            if ($password === $empleado['contrasena']) { 
                
                // 5. FILTRO DE PUESTOS PERMITIDOS
                $puestos_permitidos = [2, 3]; 

                if (in_array($empleado['id_puesto'], $puestos_permitidos)) {
                    // ¡Éxito! Guardamos datos en sesión
                    $_SESSION['id_empleado'] = $empleado['id_empleado'];
                    $_SESSION['nombre_usuario'] = $empleado['nombre'];
                    $_SESSION['id_puesto'] = $empleado['id_puesto'];
                    
                    // 6. GUARDAR REGISTRO EN LA BITÁCORA
                    $direccion_ip = $_SERVER['REMOTE_ADDR']; 
                    $modeloLogin->registrarBitacora($empleado['id_empleado'], $direccion_ip);
                    
                    // Lo enviamos al controlador de administración (misma carpeta)
                    header("Location: administracion_controller.php");
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
    } else {
        $mensaje_error = "Por favor, llena todos los campos.";
    }
}

// 7. Cargamos la vista
require_once dirname(__DIR__) . '/views/login_view.php';
?>