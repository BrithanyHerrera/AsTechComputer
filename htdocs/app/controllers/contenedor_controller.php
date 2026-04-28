<?php
require_once __DIR__ . '/../config/conexion.db.php';
require_once __DIR__ . "/../models/contenedor_model.php";

$modelo = new ContenedorModel($conexion);
$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

// --- PREPARAR DATOS PARA LA VISTA ---
$resultado = $modelo->listarContenedores();

// --- AGREGAR CONTENEDOR ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'agregar') {
    $id_gabinete = $_POST['id_gabinete'] ?? '';
    $tipo        = $_POST['tipo_espacio'] ?? '';
    $estado      = $_POST['estado'] ?? '';

    try {
        $res = $modelo->agregarContenedor($id_gabinete, $tipo, $estado);

        if ($res) {
            header("Location: administracion_controller.php?seccion=contenedor&status=success");
        } else {
            header("Location: administracion_controller.php?seccion=contenedor&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            header("Location: administracion_controller.php?seccion=contenedor&status=duplicate");
        } else {
            header("Location: administracion_controller.php?seccion=contenedor&status=error&msg=" . urlencode($e->getMessage()));
        }
    }
    exit();
}

// --- ELIMINAR ---
if (isset($_GET['accion']) && $_GET['accion'] == "eliminar") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if ($modelo->eliminarGabinete($id)) {
            header("Location: administracion_controller.php?seccion=contenedor&status=success");
        } else {
            header("Location: administracion_controller.php?seccion=contenedor&status=error");
        }
        exit();
    }
}

// --- EDITAR ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'editar') {
    $id_gabinete  = $_POST['id_gabinete'];
    $tipo_espacio = $_POST['tipo_espacio'];
    $estado       = $_POST['estado'];

    try {
        if ($modelo->editarGabinete($id_gabinete, $tipo_espacio, $estado)) {
            header("Location: administracion_controller.php?seccion=contenedor&status=success");
        } else {
            header("Location: administracion_controller.php?seccion=contenedor&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        header("Location: administracion_controller.php?seccion=contenedor&status=error");
    }
    exit();
}
?>