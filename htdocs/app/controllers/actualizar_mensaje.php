<?php
require_once __DIR__ . '/../config/conexion.db.php';
require_once __DIR__ . "/../models/modelo_mensajes.php";

$modelo = new MensajesModel($conexion);

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];

    $estados_validos = ['nuevo', 'pendiente', 'respondido', 'finalizado'];

    if (in_array($estado, $estados_validos)) {

       if ($modelo->actualizarEstado($id, $estado)) {
    header("Location: ../controllers/administracion_controller.php?seccion=contacto&status=success");
} else {
    header("Location: ../controllers/administracion_controller.php?seccion=contacto&status=error");
}

    }
}

$conexion->close();
?>