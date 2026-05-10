<?php
require_once __DIR__ . "/../config/conexion.db.php";
require_once __DIR__ . "/../config/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validar que la sección exista
    $seccion = $_POST['seccion_editada'] ?? '';

    // 2. Limpiar entradas
    $quienes = trim($_POST['titulo'] ?? '');
    $mision  = trim($_POST['mision'] ?? '');
    $vision  = trim($_POST['vision'] ?? '');
    $frase   = trim($_POST['frase'] ?? '');

    $stmt = null;

    // 3. Preparar la consulta según la sección
    switch ($seccion) {
        case 'portada':
            $stmt = $conexion->prepare("UPDATE informacion_index SET quienes_somos=? WHERE id=1");
            $stmt->bind_param("s", $quienes);
            break;

        case 'mision':
            $stmt = $conexion->prepare("UPDATE informacion_index SET mision=?, vision=? WHERE id=1");
            $stmt->bind_param("ss", $mision, $vision);
            break;

        case 'ceo':
            $stmt = $conexion->prepare("UPDATE informacion_index SET frase_fundador=? WHERE id=1");
            $stmt->bind_param("s", $frase);
            break;
    }

    // 4. EJECUCIÓN CRÍTICA: Solo si se preparó un statement válido
    if ($stmt) {
        if ($stmt->execute()) {
            $status = "1"; // Éxito
        } else {
            $status = "error"; // Error en ejecución
        }
        $stmt->close();
    } else {
        $status = "invalid_section";
    }

    // 5. Redirigir con el parámetro success para activar el SweetAlert
    header("Location: " . BASE_URL . "app/views/administracion_view.php?seccion=inicio&success=" . $status);
    exit;
}