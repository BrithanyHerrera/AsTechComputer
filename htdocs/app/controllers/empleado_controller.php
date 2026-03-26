<?php
require_once __DIR__ . '/../config/conexion.db.php';
require_once __DIR__ . "/../models/empleado_model.php";

$modelo = new EmpleadosModel($conexion);
//AGREGAR EMPLEADO
$accion = $_GET['accion'] ?? '';

// --- AGREGAR EMPLEADO ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'agregar') {

    $datos = [
        'nombre'         => $_POST['nombre'] ?? '',
        'apellido'       => $_POST['apellido'] ?? '',
        'telefono'       => $_POST['telefono'] ?? '',
        'correo'         => $_POST['correo'] ?? '',
        'nombre_usuario' => $_POST['nombre_usuario'] ?? '',
        // ENCRIPTAR CONTRASEÑA: Muy importante por seguridad
        'contrasena'     => password_hash($_POST['contrasena'], PASSWORD_DEFAULT),
        'id_puesto'      => $_POST['id_puesto'] ?? null
    ];

    // Validación básica
    if (empty($datos['nombre']) || empty($datos['correo']) || empty($_POST['contrasena'])) {
        header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=error_campos");
        exit();
    }

    if ($modelo->agregarEmpleado($datos)) {
        header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=success");
    } else {
        header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=error_db");
    }
    exit();
}
// ELIMINAR
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {

    $id = $_GET['id'];

    $ok = $modelo->eliminarEmpleado($id);

    if ($ok) {
       header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=deleted");
    } else {
       header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=error");
    }

    exit();
}

//EDITAR EMPLEADO

// --- AGREGAR EMPLEADO ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'editar') {
$modelo = new EmpleadosModel($conexion);

    // Recoger datos
    $id = $_POST['id_empleado'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $usuario = $_POST['nombre_usuario'] ?? '';
    $puesto = $_POST['id_puesto'] ?? '';

    try {
        $resultado = $modelo->actualizarEmpleado($id, $nombre, $apellido, $telefono, $correo, $usuario, $puesto);

        if ($resultado) {
            header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=success");
        } else {
            header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=duplicate");
        } else {
            header("Location: ../controllers/administracion_controller.php?seccion=empleado&status=error");
        }
    }
    exit();
}
?>