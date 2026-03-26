<?php
// Incluimos la conexión desde la carpeta config
include __DIR__ . "/../../config/conexion.db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario de gabinete
    $id_gabinete = $_POST['id_gabinete'];
    $tipo_espacio = $_POST['tipo_espacio'];
    $estado = $_POST['estado'];
    $folio = !empty($_POST['folio']) ? $_POST['folio'] : NULL; // El folio puede ser nulo si está disponible

    // Preparamos la consulta para la tabla 'gabinetes'
    // IMPORTANTE: El WHERE usa el id_gabinete para identificar qué registro actualizar
    $sql = "UPDATE gabinetes SET 
            tipo_espacio = ?, 
            estado = ?, 
            folio = ? 
            WHERE id_gabinete = ?";
    
    $stmt = $conexion->prepare($sql);

    // Explicación de "ssss":
    // tipo_espacio (string), estado (string), folio (string/null), id_gabinete (string)
    $stmt->bind_param("ssss", $tipo_espacio, $estado, $folio, $id_gabinete);

    try {
        if ($stmt->execute()) {
            // Redirección exitosa con los parámetros solicitados
            header("Location: ../../views/administracion_view.php?seccion=contenedor&status=success");
        } else {
            // Error en la ejecución
            header("Location: ../../views/secciones/crud_contenedores.php?status=error");
        }
    } catch (mysqli_sql_exception $e) {
        // Manejo de errores de base de datos (como duplicados)
        if ($e->getCode() == 1062) {
            header("Location: ../../views/secciones/crud_contenedores.php?status=duplicate");
        } else {
            header("Location: ../../views/secciones/crud_contenedores.php?status=error");
        }
    }
    
    $stmt->close();
    $conexion->close();
    exit();
}
?>