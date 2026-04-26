<?php
// ========================================================
// CONTROLADOR: administracion_controller.php
// UBICACIÓN: app/controllers/administracion_controller.php
// ========================================================

// 1. Recibimos la sección actual por GET (lógica de enrutamiento)
// Si no hay ninguna sección definida, por defecto cargamos 'dashboard'
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';


// =======================================================
// 2. EJECUTAR LOS CONTROLADORES SECUNDARIOS (LÓGICA ANTES DEL HTML)
// =======================================================
if ($seccion_actual === 'citas') {
    require_once 'citas_crud_controller.php';
} elseif ($seccion_actual === 'ingreso') {
    // ¡AQUÍ ESTÁ LA MAGIA! 
    // Esto ejecuta las consultas de BD y crea la variable $paso
    require_once 'ingreso_controller.php'; 
}


// 3. Aquí a futuro puedes agregar validaciones de sesión 
// (ej. si el usuario no está logueado, redirigirlo al login)


// =======================================================
// 4. CARGAMOS LA VISTA PRINCIPAL
// =======================================================
// Cuando esta vista se dibuje y mande a llamar a 'ingresar_dispositivo_view.php', 
// la variable $paso ya existirá en la memoria.
require_once dirname(__DIR__) . '/views/administracion_view.php';
?>