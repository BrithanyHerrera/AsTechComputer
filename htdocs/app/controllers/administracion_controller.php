<?php
// ========================================================
// CONTROLADOR: administracion_controller.php
// UBICACIÓN: app/controllers/administracion_controller.php
// ========================================================

// 1. Recibimos la sección actual por GET (lógica de enrutamiento)
// Si no hay ninguna sección definida, por defecto cargamos 'dashboard'
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';

// 2. Aquí a futuro puedes agregar validaciones de sesión 
// (ej. si el usuario no está logueado, redirigirlo al login)

// 3. Cargamos la vista principal y le pasamos la variable $seccion_actual
require_once dirname(__DIR__) . '/views/administracion_view.php';
?>