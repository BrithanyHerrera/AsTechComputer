<?php
// ========================================================
// CONTROLADOR: login_controller.php
// UBICACIÓN: app/controllers/login_controller.php
// ========================================================
require_once __DIR__ . "/../config/config.php"; 

// 1. Iniciamos la sesión e importamos la librería
session_start();
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\QRServerProvider;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario'])) {
    
    // Limpiamos espacios y forzamos minúsculas para el usuario
    $usuario = strtolower(trim($_POST['usuario']));
    // La contraseña se recibe cruda y exacta
    $password = $_POST['password'];

    if (!empty($usuario) && !empty($password)) {
        
        $empleado = $modeloLogin->buscarUsuario($usuario);

        if ($empleado) {
            // Verificamos la contraseña (ya sea encriptada o texto plano heredado)
            if (password_verify($password, $empleado['contrasena']) || $password === $empleado['contrasena']) { 
                
                $puestos_permitidos = [1, 2, 3, 4]; 

                if (in_array($empleado['id_puesto'], $puestos_permitidos)) {
                    
                    // 1. Instanciamos el motor que dibujará el QR
                    $motorQR = new QRServerProvider();

                    // 2. Iniciamos la librería pasándole el motor y el nombre de tu empresa
                    $tfa = new TwoFactorAuth($motorQR, 'As Tech Computer');

                    // Verificamos si es un empleado NUEVO (Aún no tiene 2FA configurado)
                    if ($empleado['is_2fa_activo'] == 0) {
                        
                        // 1. Generamos un secreto único para este empleado
                        $secreto = $tfa->createSecret();
                        
                        // 2. Guardamos este secreto temporalmente en la BD
                        $stmt = $conexion->prepare("UPDATE empleados SET secreto_2fa = ? WHERE id_empleado = ?");
                        $stmt->bind_param("si", $secreto, $empleado['id_empleado']);
                        $stmt->execute();
                        $stmt->close();
                        
                        // 3. Generamos el Código QR
                        // Se mostrará: As Tech Computer (nombre_usuario)
                        $qr_image = $tfa->getQRCodeImageAsDataUri($empleado['nombre_usuario'], $secreto);
                        
                        // 4. Guardamos en sesión y mandamos a la vista de configuración
                        $_SESSION['temp_empleado'] = $empleado;
                        $_SESSION['qr_image']      = $qr_image;
                        $_SESSION['secreto_2fa']   = $secreto; 
                        
                        header("Location: configurar_2fa_controller.php");
                        exit;

                    } else {
                        // Si ya es un empleado CONFIGURADO (is_2fa_activo == 1)
                        // Solo lo mandamos a que escriba sus 6 dígitos
                        $_SESSION['temp_empleado'] = $empleado;
                        
                        header("Location: verificar_2fa_controller.php");
                        exit;
                    }

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

// Cargamos la vista del login principal
require_once dirname(__DIR__) . '/views/login_view.php';
?>