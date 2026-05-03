<?php
/* FOOTER_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador del Pie de Página (Footer Controller) - As Tech Computer
 * PROPÓSITO: Actuar como el controlador parcial encargado de invocar y renderizar el pie de página global de la plataforma, el cual incluye los enlaces corporativos y el sistema de privacidad.
 * FUNCIONALIDADES:
 * - Invocación directa de la Vista parcial del pie de página (footer_view.php) empleando rutas dinámicas absolutas.
 * - Carga de las variables y constantes globales del sistema a través del archivo de configuración principal de la aplicación.
 */

/* ========================================================
   1. RENDERIZACIÓN DE LA VISTA Y CARGA DE CONFIGURACIÓN
   ======================================================== */
/**
 * El sistema ejecuta la inclusión de la vista correspondiente al pie de página. 
 * Posteriormente, incorpora el archivo de configuración global. Se emplean 
 * funciones de enrutamiento dinámico (dirname y __DIR__) para garantizar que 
 * las rutas no se rompan sin importar desde qué nivel de directorio se invoque.
 */
require dirname(__DIR__) . '/views/fijos/footer_view.php';
require_once __DIR__ . "/../config/config.php";
?>