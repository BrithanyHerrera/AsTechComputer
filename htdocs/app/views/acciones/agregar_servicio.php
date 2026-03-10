<?php
include __DIR__ . "/../../config/conexion.db.php";

$exito = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Usamos el operador null coalescing (??) para evitar el error de "Undefined array key"
    $tipo_servicio = $_POST['tipo_servicio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? ''; // Corregido: descripción con 's'
    $imagen_url = $_POST['imagen_url'] ?? '';
    $tiempo_estimado = $_POST['tiempo_estimado'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $estado = $_POST['estado'] ?? 'activo';

    // Validación básica corregida
    if(empty($descripcion) || empty($tipo_servicio) || empty($precio)){
        $error = "Por favor, completa los campos obligatorios (Tipo, Descripción y Precio).";
    } else {
        $sql = "INSERT INTO servicios 
                (tipo_servicio, descripcion, imagen_url, tiempo_estimado, precio, estado)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        
        // s = string, d = double/decimal
        // Ajustado a: tipo(s), desc(s), img(s), tiempo(s), precio(d), estado(s)
        $stmt->bind_param("ssssds", 
            $tipo_servicio,
            $descripcion,
            $imagen_url,
            $tiempo_estimado,
            $precio,
            $estado
        );

        if ($stmt->execute()) {
            $exito = true;
        } else {
            $error = "Error en la base de datos: " . $conexion->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; }
    </style>
</head>
<body>

<?php if($exito){ ?>
<script>
Swal.fire({
    icon: 'success',
    title: '¡Servicio Registrado!',
    text: 'El servicio se guardó correctamente.',
    confirmButtonColor: '#52073a',
    confirmButtonText: 'Aceptar'
}).then(() => {
    // Redirección corregida (sin tilde si renombraste el archivo)
    window.location.href = "../../views/administración.php?seccion=servicios&status=success";
});
</script>
<?php } ?>

<?php if($error){ ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?php echo $error; ?>',
    confirmButtonColor: '#52073a'
}).then(() => {
    window.history.back(); // Regresa al formulario para corregir
});
</script>
<?php } ?>

</body>
</html>