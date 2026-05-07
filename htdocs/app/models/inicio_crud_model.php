<?php
// ========================================================
// MODELO: inicio_crud_model.php
// UBICACIÓN: app/models/inicio_crud__model.php
// CONTROLADOR: inicio_crud_controller.php
// pagina que se encarga de controlar en el panel administrativo los formularios
// para poder actualizar la pagina de inicio
// ========================================================

require_once __DIR__ . "/../../config/conexion.db.php";
//toma la informacion de el index desde la bd
function obtenerInformacionIndex($id = 1) {
    global $conexion;
    $query = "SELECT * FROM informacion_index WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
//actualiza la seccion de quienes somos
function actualizarPortada(mysqli $conexion, string $quienes) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET quienes_somos=? WHERE id=1");
    $stmt->bind_param("s", $quienes);
    return $stmt->execute();
}
//actualiza la seccion de mision
function actualizarMision(int $id, string $mision, string $vision) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE informacion_index SET mision = ?, vision = ? WHERE id = ?");
    $stmt->bind_param("ssi", $mision, $vision, $id);
    return $stmt->execute();
}
//actualiza la seccion de ceo
function actualizarCEO(int $id, string $frase) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE informacion_index SET frase_fundador = ? WHERE id = ?");
    $stmt->bind_param("si", $frase, $id);
    return $stmt->execute();
}