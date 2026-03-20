<?php

include __DIR__ . "/../../config/conexion.db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_servicio = $_POST['id_servicio'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tiempo_estimado = $_POST['tiempo_estimado'];
    $estado = $_POST['estado'];
    $imagen_nueva = !empty($_POST['imagen_servicio']) ? $_POST['imagen_servicio'] : NULL;


    if ($imagen_nueva) {
        $sql = "UPDATE servicios SET 
                tipo_servicio = ?, 
                descripcion = ?, 
                precio = ?, 
                tiempo_estimado = ?, 
                estado = ?, 
                imagen_servicio = ?
                WHERE id_servicio = ?";
        
        $stmt = $conexion->prepare($sql);
        
        $stmt->bind_param("ssdsssi", $tipo_servicio, $descripcion, $precio, $tiempo_estimado, $estado, $imagen_nueva, $id_servicio);
    } else {
     
        $sql = "UPDATE servicios SET 
                tipo_servicio = ?, 
                descripcion = ?, 
                precio = ?, 
                tiempo_estimado = ?, 
                estado = ?
                WHERE id_servicio = ?";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdssi", $tipo_servicio, $descripcion, $precio, $tiempo_estimado, $estado, $id_servicio);
    }

    try {
        if ($stmt->execute()) {
          
            header("Location: ../../views/administracion_view.php?seccion=servicios&status=success");
        } else {
            header("Location: ../../views/administracion_view.php?seccion=servicios&status=error");
        }
    } catch (mysqli_sql_exception $e) {
        // Manejo de errores (por ejemplo, si el tipo_servicio debe ser único)
        if ($e->getCode() == 1062) {
            header("Location: ../../views/administracion_view.php?seccion=servicios&status=duplicate");
        } else {
            header("Location: ../../views/administracion_view.php?seccion=servicios&status=error");
        }
    }
    
    $stmt->close();
    $conexion->close();
    exit();
}
?>