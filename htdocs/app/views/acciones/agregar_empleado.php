<?php
include __DIR__ . "/../../config/conexion.db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];
    $id_puesto = $_POST['id_puesto'];

    // Validación básica
    if(empty($nombre) || empty($apellido) || empty($correo)){
        echo "Todos los campos obligatorios deben llenarse";
        exit();
    }

    // Encriptar contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO empleados 
            (nombre, apellido, telefono, correo, nombre_usuario, contrasena, id_puesto)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("ssssssi", 
        $nombre,
        $apellido,
        $telefono,
        $correo,
        $nombre_usuario,
        $contrasena_hash,
        $id_puesto
    );

    if ($stmt->execute()) {
        $exito = true;
    } else {
        $error = $conexion->error;
    }

}
?>

<!DOCTYPE html>
<html>
<head>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<?php if(isset($exito)){ ?>

<script>
   

Swal.fire({
    icon: 'success',
    title: 'Empleado registrado',
    text: 'El empleado se guardó correctamente',
    confirmButtonText: 'Aceptar'
}).then(() => {
    window.location.href = "../../views/administracion_view.php?seccion=empleado";
});

</script>

<?php } ?>

<?php if(isset($error)){ ?>

<script>

Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'No se pudo guardar el empleado'
});

</script>

<?php } ?>

</body>
</html>