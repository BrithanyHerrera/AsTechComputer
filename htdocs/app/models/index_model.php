<?php

/**
 * MÓDULO: index_model.php
 * PROPÓSITO: Gestionar la información principal de la página de inicio almacenada en la base de datos.
 * FUNCIONALIDADES:
 * - Obtener los datos del index (registro único ID = 1).
 * - Actualizar la sección "Quiénes somos".
 * - Modificar Misión y Visión.
 * - Actualizar la frase del fundador (CEO).
 * - Uso de sentencias preparadas para mayor seguridad.
 * - Retorno de resultados para validación desde el controlador.
 */

?>

<?php
//obtiene desde la bd la infromacion de el texto para la pagina de index 

function obtenerInfoIndex(mysqli $conexion) {
    $query = "SELECT * FROM informacion_index WHERE id = 1 LIMIT 1";
    $resultado = $conexion->query($query);
    return $resultado->fetch_assoc();
}
//cambia la infromacion de el index de el apartado quienes somos?
function actualizarPortada(mysqli $conexion, string $quienes) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET quienes_somos=? WHERE id=1");
    $stmt->bind_param("s", $quienes);
    return $stmt->execute();
}
//cambia la infromacion de el index de el apartado mision y vision
function actualizarMisionVision(mysqli $conexion, string $mision, string $vision) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET mision=?, vision=? WHERE id=1");
    $stmt->bind_param("ss", $mision, $vision);
    return $stmt->execute();
}
//cambia la infromacion de el index de el apartado de la frase del fundador
function actualizarCEO(mysqli $conexion, string $frase) {
    $stmt = $conexion->prepare("UPDATE informacion_index SET frase_fundador=? WHERE id=1");
    $stmt->bind_param("s", $frase);
    return $stmt->execute();
}