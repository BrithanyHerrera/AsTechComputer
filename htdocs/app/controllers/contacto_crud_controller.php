<?php
require_once __DIR__ . "/../../config/conexion.db.php";
require_once __DIR__ . "/../models/contacto_crud_model.php";
require_once dirname(__DIR__) . '/config/config.php'; // o como se llame tu archivo

$modelo = new ContactoModel($conexion);

// Lógica para acciones (Eliminar o Actualizar)
if (isset($_GET['action'])) {
    $id = $_GET['id'] ?? null;
    
    if ($_GET['action'] === 'eliminar' && $id) {
        if ($modelo->eliminarMensaje($id)) {
            header("Location: " . BASE_URL . "app/views/contacto_crud_view.php?status=deleted");
        } else {
            header("Location: " . BASE_URL . "app/views/contacto_crud_view.php?status=error");
        }
        exit();
    }

    if ($_GET['action'] === 'actualizar' && $id && isset($_GET['estado'])) {
        if ($modelo->actualizarEstado($id, $_GET['estado'])) {
            header("Location: " . BASE_URL . "app/views/contacto_crud_view.php?status=success");
        } else {
            header("Location: " . BASE_URL . "app/views/contacto_crud_view.php?status=error");
        }
        exit();
    }
}

// Para la vista principal: obtener los datos
$resultado = $modelo->obtenerMensajes();
?>