<?php
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// Detecta automáticamente la carpeta del proyecto
$script = $_SERVER['SCRIPT_NAME']; 
$path = str_replace(basename($script), '', $script);

define('BASE_URL', $protocolo . '://' . $host . $path);
?>