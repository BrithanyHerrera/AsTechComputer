<?php
include __DIR__ . "/../../config/conexion.db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_empleado'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $usuario = $_POST['nombre_usuario'];
    $puesto = $_POST['id_puesto'];

    $sql = "UPDATE empleados SET 
            nombre = ?, 
            apellido = ?, 
            telefono = ?, 
            correo = ?, 
            nombre_usuario = ?, 
            id_puesto = ? 
            WHERE id_empleado = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssii", $nombre, $apellido, $telefono, $correo, $usuario, $puesto, $id);

   try {
        if ($stmt->execute()) {
           // Por esto (si estás dentro de la carpeta 'acciones'):
          header("Location: ../../views/administración.php?seccion=empleado&status=success");
        } else {
            header("Location: ../../views/secciones/empleado.php?status=error");
        }
    } catch (mysqli_sql_exception $e) {
        // Error 1062 es "Duplicate entry"
        if ($e->getCode() == 1062) {
            header("Location: ../../views/secciones/empleado.php?status=duplicate");
        } else {
            header("Location: ../../views/secciones/empleado.php?status=error");
        }
    }
    exit();
}

?>