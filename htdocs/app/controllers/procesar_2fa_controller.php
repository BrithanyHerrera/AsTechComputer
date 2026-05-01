<?php
// ========================================================
// CONTROLADOR: procesar_2fa_controller.php
// UBICACIÓN: app/controllers/procesar_2fa_controller.php
// ========================================================
session_start();

// 1. Validar que no entren intrusos
if (!isset($_SESSION['temp_empleado']) || !isset($_POST['codigo_ingresado'])) {
    header("Location: ../../index.php");
    exit;
}

// 2. Importar las librerías necesarias y la base de datos
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/login_model.php'; // Recuperamos tu modelo para la bitácora

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\QRServerProvider;

// 3. Recibir los datos
$empleado = $_SESSION['temp_empleado'];
$codigo_ingresado = trim($_POST['codigo_ingresado']);

// 4. Iniciar el motor matemático
$motorQR = new QRServerProvider();
$tfa = new TwoFactorAuth($motorQR, 'As Tech Computer');

// 5. ¿De dónde sacamos el secreto?
// Si es nuevo, usamos el secreto temporal en Sesión. Si no, el de la BD.
$secreto = isset($_SESSION['secreto_2fa']) ? $_SESSION['secreto_2fa'] : $empleado['secreto_2fa'];

// 6. LA PRUEBA DE FUEGO: Validación Matemática
$es_valido = $tfa->verifyCode($secreto, $codigo_ingresado);

if ($es_valido) {
    
    // Si es un empleado nuevo, activamos su 2FA en la base de datos
    if (isset($_POST['es_nueva_configuracion']) && $_POST['es_nueva_configuracion'] == '1') {
        $stmt = $conexion->prepare("UPDATE empleados SET is_2fa_activo = 1 WHERE id_empleado = ?");
        $stmt->bind_param("i", $empleado['id_empleado']);
        $stmt->execute();
        $stmt->close();
    }

    // A. Creamos las variables de sesión reales del sistema (Manteniendo tus nombres originales)
    $_SESSION['id_empleado'] = $empleado['id_empleado'];
    $_SESSION['nombre_usuario'] = $empleado['nombre'];
    $_SESSION['id_puesto'] = $empleado['id_puesto'];

    // B. ¡Tu excelente detalle de la bitácora! Lo mantenemos intacto
    $modeloLogin = new LoginModel($conexion);
    $direccion_ip = $_SERVER['REMOTE_ADDR'];
    $modeloLogin->registrarBitacora($empleado['id_empleado'], $direccion_ip);

    // C. Destruimos la basura temporal
    unset($_SESSION['temp_empleado']);
    unset($_SESSION['qr_image']);
    unset($_SESSION['secreto_2fa']);
    if (isset($_SESSION['codigo_2fa'])) unset($_SESSION['codigo_2fa']);

    // D. Redirigimos al sistema
    header("Location: administracion_controller.php");
    exit;

} else {
    // Si el código falla, regresamos a la pantalla anterior
    echo "<script>
        alert('Código incorrecto. Intenta de nuevo.');
        window.history.back();
    </script>";
}
?>