<?php
// 1. Detectar si es http o https
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// 2. Detectar el host dinámicamente
$host = $_SERVER['HTTP_HOST'];

// 3. RUTA EXACTA 
$carpeta_proyecto = '/'; 

define('BASE_URL', $protocolo . '://' . $host . $carpeta_proyecto);
?>