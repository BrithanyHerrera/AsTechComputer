<?php
// PAGINA: CONFIG.PHP

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];

// Detecta solo la raíz del proyecto
$base = dirname($_SERVER['SCRIPT_NAME']);
$base = explode('/app', $base)[0];

// Elimina slash final si existe
$base = rtrim($base, '/');

define('BASE_URL', $protocolo . '://' . $host . $base . '/');
?>