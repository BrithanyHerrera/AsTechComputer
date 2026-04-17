<?php
session_start();
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/login_model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['codigo_ingresado'])) {
    
    $codigo_ingresado = trim($_POST['codigo_ingresado']);
    
    if ($codigo_ingresado == $_SESSION['codigo_2fa']) {
        $empleado = $_SESSION['temp_empleado'];
        
        $_SESSION['id_empleado'] = $empleado['id_empleado'];
        $_SESSION['nombre_usuario'] = $empleado['nombre'];
        $_SESSION['id_puesto'] = $empleado['id_puesto'];
        
        $modeloLogin = new LoginModel($conexion);
        $direccion_ip = $_SERVER['REMOTE_ADDR']; 
        $modeloLogin->registrarBitacora($empleado['id_empleado'], $direccion_ip);
        
        unset($_SESSION['temp_empleado']);
        unset($_SESSION['codigo_2fa']);
        
        // Al estar en la misma carpeta 'controllers', la ruta es directa
        header("Location: administracion_controller.php");
        exit;
        
    } else {
        // Si el código falla, regresamos a la vista dentro de 'acciones'
        echo "<script>alert('Código incorrecto. Intenta de nuevo.'); window.location.href='../views/acciones/verificar_2fa.php';</script>";
    }
}
?>