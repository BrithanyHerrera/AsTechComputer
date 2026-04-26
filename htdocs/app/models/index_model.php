<?php
function obtenerInfoIndex($conexion) {
    $query = "SELECT * FROM informacion_index WHERE id = 1 LIMIT 1";
    $resultado = $conexion->query($query);
    return $resultado->fetch_assoc();
}

function actualizarPortada($conexion, $quienes) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET quienes_somos=? WHERE id=1");
    $stmt->bind_param("s", $quienes);
    return $stmt->execute();
}

function actualizarMisionVision($conexion, $mision, $vision) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET mision=?, vision=? WHERE id=1");
    $stmt->bind_param("ss", $mision, $vision);
    return $stmt->execute();
}

function actualizarCEO($conexion, $frase) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET frase_fundador=? WHERE id=1");
    $stmt->bind_param("s", $frase);
    return $stmt->execute();
}