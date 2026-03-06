<?php
// ==================================================================
// CONFIGURACIÓN DE LA BASE DE DATOS
// ==================================================================

$host = "localhost"; // En InfinityFree suele ser algo como "sql123.epizy.com" o "sql.infinityfree.com"
$usuario = "if0_41282426"; // Tu usuario de InfinityFree (ejemplo)
$contrasena = "TU_CONTRASEÑA_DEL_CPANEL"; // La contraseña de tu cuenta de hosting
$base_datos = "if0_41282426_astech"; // El nombre exacto de tu base de datos

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error crítico de conexión a la Base de Datos: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>