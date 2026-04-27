<?php
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// Detecta solo la raíz del proyecto (htdocs)
$base = dirname($_SERVER['SCRIPT_NAME']);
$base = explode('/app', $base)[0]; // corta en /app

define('BASE_URL', $protocolo . '://' . $host . $base . '/');
?>