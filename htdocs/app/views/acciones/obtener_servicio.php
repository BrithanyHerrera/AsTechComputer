<?php
// 1. Conexión a la base de datos
require_once "../../config/conexion.db.php"; 

// 2. Validar que el ID llegó correctamente
if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] !== 'null') {
    $id = intval($_GET['id']);

    // 3. Verificar si el servicio existe realmente
    $query = "SELECT id_servicio FROM servicios WHERE id_servicio = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // 4. ¡AQUÍ ESTÁ EL TRUCO! 
        // En lugar de hacer "echo", redirigimos al controlador que ya tienes
        header("Location: ../../controllers/detalle_servicio_controller.php?id=" . $id);
        exit(); // Detenemos la ejecución después de redirigir
    } else {
        echo "Error: El servicio con ID $id no existe en la base de datos.";
    }
    
    $stmt->close();
} else {
    echo "Error: No se recibió un ID válido para redirigir.";
}
?>