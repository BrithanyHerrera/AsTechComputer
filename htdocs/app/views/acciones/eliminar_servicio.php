<?php
// Usamos la ruta correcta para incluir la conexión desde controllers
include __DIR__ . "/../../config/conexion.db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Preparamos la sentencia (MySQLi)
    $stmt = $conexion->prepare("DELETE FROM servicios WHERE id_servicio = ?");
    
    // 2. Vinculamos el parámetro ("i" para integer)
    $stmt->bind_param("i", $id);
    
    // 3. Ejecutamos
    if ($stmt->execute()) {
        // Redirigimos para que la tabla se actualice y no se reenvíe el formulario
        header("Location: ../../views/administracion_view.php?seccion=servicios");
        exit();
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
}
?>