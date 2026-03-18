<?php
include __DIR__ . "/../../config/conexion.db.php";

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];

    // Validamos que el estado sea uno de los permitidos
    $estados_validos = ['nuevo', 'pendiente', 'respondido', 'finalizado'];
    
    if (in_array($estado, $estados_validos)) {
        $sql = "UPDATE mensajes_contacto SET estado = ? WHERE id_mensaje = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $estado, $id);

        if ($stmt->execute()) {
            // Regresamos a la tabla con mensaje de éxito
            header("Location: ../../views/administración.php?seccion=contacto&status=success");
        } else {
            header("Location: ../../views/administración.php?seccion=contacto&status=error");
        }
        $stmt->close();
    }
}
$conexion->close();
?>