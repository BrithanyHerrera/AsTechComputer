<?php
/* POLITICA_COOKIES_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Política de Cookies - As Tech Computer
 * PROPÓSITO: Gestionar el acceso a la sección legal e informativa sobre el uso de cookies y rastreadores, actuando como enlace operativo base dentro de la arquitectura MVC.
 * FUNCIONALIDADES:
 * - Invocación directa y segura de la Vista correspondiente a las políticas de privacidad y cookies.
 * - Implementación de rutas absolutas blindadas mediante dirname(__DIR__) para garantizar el despliegue del contenido independientemente de la ubicación del usuario en la estructura de directorios del servidor.
 * - Preparación estructural (Controlador pasivo) lista para escalar e integrar llamadas a un Modelo en caso de que, en el futuro, la información legal deba ser extraída dinámicamente desde la base de datos.
 */

/* ========================================================
   1. RENDERIZACIÓN DE LA VISTA
   ======================================================== */
/**
 * El sistema intercepta la petición del usuario y procesa la carga 
 * de la interfaz gráfica correspondiente utilizando una ruta absoluta 
 * dinámica. Por el momento, la carga es directa, pero la estructura 
 * permite futuras integraciones de lógica de negocio o bases de datos.
 */
require_once dirname(__DIR__) . '/views/politica_cookies_view.php';
?>