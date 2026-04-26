<?php
require_once __DIR__ . "/../../config/conexion.db.php";

function obtenerInformacionIndex($id = 1) {
    global $conexion;
    $query = "SELECT * FROM informacion_index WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function actualizarPortada($conexion, $quienes) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET quienes_somos=? WHERE id=1");
    $stmt->bind_param("s", $quienes);
    return $stmt->execute();
}

function actualizarMision($id, $mision, $vision) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE informacion_index SET mision = ?, vision = ? WHERE id = ?");
    $stmt->bind_param("ssi", $mision, $vision, $id);
    return $stmt->execute();
}

function actualizarCEO($id, $frase) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE informacion_index SET frase_fundador = ? WHERE id = ?");
    $stmt->bind_param("si", $frase, $id);
    return $stmt->execute();
}