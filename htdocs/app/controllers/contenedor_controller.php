<?php
require_once __DIR__ . '/../config/conexion.db.php';
require_once __DIR__ . "/../models/contenedor_model.php";

$modelo = new ContenedorModel($conexion);
$accion = $_GET['accion'] ?? $_POST['accion'] ?? ''; // Captura acción de ambos métodos

// --- AGREGAR CONTENEDOR ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'agregar') {
    $id_gabinete = $_POST['id_gabinete'] ?? '';
    $tipo = $_POST['tipo_espacio'] ?? '';
    $estado = $_POST['estado'] ?? '';
    
    // Quitamos la lógica del folio ya que no tienes la columna en la BD

    try {
        // Llamamos al método desde el objeto $modelo y quitamos el parámetro $folio
        $resultado = $modelo->agregarContenedor($id_gabinete, $tipo, $estado);

        if ($resultado) {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=success");
        } else {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=duplicate");
        } else {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=error&msg=" . urlencode($e->getMessage()));
        }
    }
    exit();
}

// --- ELIMINAR ---
if (isset($_GET['accion']) && $_GET['accion'] == "eliminar") {
    if (isset($_GET['id'])) {
        $id = $_GET['id']; // Quité intval por si tu ID es texto (gabinete A1, etc)

        // IMPORTANTE: Se usa el objeto $modelo->
        if ($modelo->eliminarGabinete($id)) {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=success");
        } else {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=error");
        }
        exit();
    }
}

// --- EDITAR ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && $accion == 'editar') {
    $id_gabinete = $_POST['id_gabinete'];
    $tipo_espacio = $_POST['tipo_espacio'];
    $estado = $_POST['estado'];

    try {
        // IMPORTANTE: Se usa el objeto $modelo-> y sin folio
        if ($modelo->editarGabinete($id_gabinete, $tipo_espacio, $estado)) {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=success");
        } else {
            header("Location: ../views/administracion_view.php?seccion=contenedor&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        header("Location: ../views/administracion_view.php?seccion=contenedor&status=error");
    }
    exit();
}

?>