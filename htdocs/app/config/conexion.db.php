<?php
// ==================================================================
// CONEXIÓN INTELIGENTE A LA BASE DE DATOS (ASTECH COMPUTER)
// ==================================================================

// Detectamos si estamos en XAMPP/Laragon (localhost) o en InfinityFree
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // --------------------------------------------------------------
    // ENTORNO LOCAL (Tú con Laragon o tus compañeros con XAMPP)
    // --------------------------------------------------------------
    $host = "localhost";
    $usuario = "root";      // Usuario por defecto en Laragon/XAMPP
    $contrasena = "";       // Contraseña vacía por defecto
    $base_datos = "astech_bd"; // ¡Asegúrense de que todos usen este nombre!
} else {
    // --------------------------------------------------------------
    // ENTORNO DE PRODUCCIÓN (InfinityFree)
    // --------------------------------------------------------------
    $host = "sql.infinityfree.com"; // Cambia esto por el host real que te da InfinityFree
    $usuario = "if0_41282426";      // Tu usuario de InfinityFree
    $contrasena = "TU_CONTRASEÑA_DEL_CPANEL"; 
    $base_datos = "if0_41282426_bienhecho"; 
}

// Intentamos conectar usando las credenciales detectadas
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificamos si hubo algún error
if ($conexion->connect_error) {
    die("Error crítico de conexión: " . $conexion->connect_error);
}

// Forzamos el uso de UTF-8 para proteger los acentos y la 'ñ'
$conexion->set_charset("utf8mb4");

?>