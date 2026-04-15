<?php
// =====================================================================
// CONTROLADOR PARCIAL: toolbar_controller.php
// UBICACIÓN: app/controllers/toolbar_controller.php
// =====================================================================

$permitirAnaliticas = false; 

// 1. Buscamos el nombre EXACTO que usa tu JavaScript
if (isset($_COOKIE['astech_preferencias_cookies'])) {
    
    // 2. Decodificamos el JSON
    // (Tu JS usa encodeURIComponent, PHP lo decodifica en automático)
    $cookies_estado = json_decode($_COOKIE['astech_preferencias_cookies'], true);
    
    // 3. Validación de los permisos
    if (
        is_array($cookies_estado) && 
        isset($cookies_estado['analiticas']) && 
        ($cookies_estado['analiticas'] === true || $cookies_estado['analiticas'] === 'true' || $cookies_estado['analiticas'] == 1)
    ) {
        $permitirAnaliticas = true;
    }
}

// 4. Cargamos la vista de la barra de navegación
require dirname(__DIR__) . '/views/fijos/toolbar_view.php';
?>