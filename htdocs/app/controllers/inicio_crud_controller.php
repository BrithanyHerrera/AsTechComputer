<?php
require_once __DIR__ . "/../config/conexion.db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $seccion = $_POST['seccion_editada'];

    // Valores (evitar undefined)
    $quienes = $_POST['titulo'] ?? null;
    $mision = $_POST['mision'] ?? null;
    $vision = $_POST['vision'] ?? null;
    $frase = $_POST['frase'] ?? null;

    // Dependiendo de la sección, actualizas SOLO lo necesario
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

    $stmt->execute();

    // Redirigir para evitar reenvío de formulario
    header("Location: ../../app/views/administracion_view.php?seccion=inicio");
    exit;
}