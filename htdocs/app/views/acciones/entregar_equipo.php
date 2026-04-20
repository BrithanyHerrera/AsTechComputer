<?php
session_start();
// Ajusta la ruta a tu conexión si es necesario
require_once dirname(__DIR__, 2) . '/config/conexion.db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['folio']) && !empty($_POST['id_gabinete'])) {
    $folio = $_POST['folio'];
    $id_gabinete = $_POST['id_gabinete'];

    // Iniciamos una transacción segura
    $conexion->begin_transaction();

    try {
        // ACCIÓN 1: Actualizamos la orden a 'entregado' y sellamos la fecha/hora actual
        $stmt_orden = $conexion->prepare("UPDATE ordenes_ingreso SET estado = 'entregado', fecha_entrega = NOW() WHERE folio = ?");
        $stmt_orden->bind_param("s", $folio);
        $stmt_orden->execute();

        // ACCIÓN 2: Liberamos el gabinete en la otra tabla
        $stmt_gabinete = $conexion->prepare("UPDATE gabinetes SET estado = 'disponible' WHERE id_gabinete = ?");
        $stmt_gabinete->bind_param("s", $id_gabinete);
        $stmt_gabinete->execute();

        // Si ambas acciones fueron exitosas, guardamos los cambios definitivamente
        $conexion->commit();

        // Regresamos a la tabla principal con un mensaje de éxito
        header("Location: ../administracion_view.php?seccion=registros_ingresados_crud_view&status=success_entrega");
        exit;

    } catch (Exception $e) {
        // Si algo falla, deshacemos todo para no corromper la base de datos
        $conexion->rollback();
        die("Error en la base de datos: " . $e->getMessage());
    }
} else {
    header("Location: ../administracion_view.php?seccion=registros_ingresados_crud_view");
    exit;
}
?>