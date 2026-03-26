<?php
include __DIR__ . "/../../config/conexion.db.php";

$id_gabinete = $_POST['id_gabinete'];
$tipo = $_POST['tipo_espacio'];
$estado = $_POST['estado'];
$fecha = date("dmY");
$folio = $fecha . "-" . $id_gabinete;

try {

    $sql = "INSERT INTO gabinetes (id_gabinete, tipo_espacio, estado, folio)
            VALUES ('$id_gabinete','$tipo','$estado','$folio')";

    $conexion->query($sql);

    header("Location: ../../views/administracion_view.php?seccion=contenedor&status=success");
    exit();

} catch (mysqli_sql_exception $e) {

    // Error por duplicado (PRIMARY KEY)
    if ($e->getCode() == 1062) {
        header("Location: ../../views/administracion_view.php?seccion=contenedor&status=duplicate");
    } else {
        header("Location: ../../views/administracion_view.php?seccion=contenedor&status=error");
    }

    exit();
}

?>