<?php
// Detectamos si estamos trabajando en tu computadora (localhost/Laragon)
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    // -----------------------------------------
    // CREDENCIALES LOCALES (LARAGON)
    // -----------------------------------------
    $servidor = "localhost";
    $usuario = "root";
    $password = ""; 
    $base_datos = "astech_bd"; // Pon aquí el nombre de tu base de datos local
} else {
    // -----------------------------------------
    // CREDENCIALES EN VIVO (INFINITYFREE)
    // -----------------------------------------
    $servidor = "sql210.infinityfree.com";
    $usuario = "if0_41265721";
    $password = "iD0gMpRoOozv1"; // ¡No olvides cambiar esto!
    $base_datos = "if0_41265721_astech_computer_bd";
}

// Intentamos conectar
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificamos si hubo un error
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configuramos los caracteres especiales para evitar problemas con las ñ y acentos
$conexion->set_charset("utf8mb4");
?>