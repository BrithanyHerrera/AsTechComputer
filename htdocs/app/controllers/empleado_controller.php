<?php
session_start(); // CRÍTICO: Necesario para validar si es Administrador

require_once __DIR__ . '/../config/conexion.db.php';
require_once __DIR__ . "/../models/empleado_model.php";

$modelo = new EmpleadosModel($conexion);
$accion = $_GET['accion'] ?? '';

// --- AGREGAR EMPLEADO ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'agregar') {
    $datos = [
        'nombre'         => $_POST['nombre'] ?? '',
        'apellido'       => $_POST['apellido'] ?? '',
        'telefono'       => $_POST['telefono'] ?? '',
        'correo'         => $_POST['correo'] ?? '',
        'nombre_usuario' => $_POST['nombre_usuario'] ?? '',
        'contrasena'     => password_hash($_POST['contrasena'], PASSWORD_DEFAULT),
        'id_puesto'      => $_POST['id_puesto'] ?? null
    ];

    if (empty($datos['nombre']) || empty($datos['correo']) || empty($_POST['contrasena'])) {
        header("Location: administracion_controller.php?seccion=empleado&status=error_campos");
        exit();
    }

    if ($modelo->agregarEmpleado($datos)) {
        header("Location: administracion_controller.php?seccion=empleado&status=success");
    } else {
        header("Location: administracion_controller.php?seccion=empleado&status=error_db");
    }
    exit();
}

// --- ELIMINAR EMPLEADO ---
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $id = $_GET['id'];
    $ok = $modelo->eliminarEmpleado($id);

    if ($ok) {
       header("Location: administracion_controller.php?seccion=empleado&status=deleted");
    } else {
       header("Location: administracion_controller.php?seccion=empleado&status=error");
    }
    exit();
}

// --- EDITAR EMPLEADO ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'editar') {
    $id = $_POST['id_empleado'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $usuario = $_POST['nombre_usuario'] ?? '';
    $puesto = $_POST['id_puesto'] ?? '';

    // SEGURIDAD: Solo preparamos la contraseña si la escribieron Y si el usuario activo es Administrador (4)
    $contrasena_hash = null;
    if (!empty($_POST['contrasena']) && isset($_SESSION['id_puesto']) && $_SESSION['id_puesto'] == 4) {
        $contrasena_hash = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    }

    try {
        $resultado = $modelo->actualizarEmpleado($id, $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $contrasena_hash);

        if ($resultado) {
            header("Location: administracion_controller.php?seccion=empleado&status=success");
        } else {
            header("Location: administracion_controller.php?seccion=empleado&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            header("Location: administracion_controller.php?seccion=empleado&status=duplicate");
        } else {
            header("Location: administracion_controller.php?seccion=empleado&status=error");
        }
    }
    exit();
}
?>