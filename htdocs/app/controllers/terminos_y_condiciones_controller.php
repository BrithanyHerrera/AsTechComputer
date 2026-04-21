<?php
/**
 * =========================================================================
 * CONTROLADOR: TÉRMINOS Y CONDICIONES
 * =========================================================================
 * Este controlador se encarga de gestionar la vista de los términos legales
 * de AsTech Computer. Aunque por ahora es un texto estático, mantenerlo en 
 * controlador respeta la arquitectura MVC de todo el sistema.
 */

// 1. (Espacio reservado) 
// Aquí en el futuro podrías hacer una consulta a la BD si decides que 
// los términos se editen desde un panel administrativo.

// 2. Invocamos (cargamos) la Vista visual
// Subimos una carpeta (a 'app') y entramos a 'views'
require_once dirname(__DIR__) . '/views/terminos_y_condiciones_view.php';
?>