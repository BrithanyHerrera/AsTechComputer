<?php
/* POLITICA_SERVICIOS_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Política de Servicios - As Tech Computer
 * PROPÓSITO: Gestionar el acceso a la sección legal de la Política de Servicios, actuando como enlace operativo dentro de la arquitectura MVC.
 * FUNCIONALIDADES:
 * - Invocación directa y segura de la Vista correspondiente a las políticas de servicio.
 * - Implementación de rutas absolutas blindadas mediante dirname(__DIR__) para garantizar el despliegue del contenido legal independientemente de la ubicación del usuario en la estructura de directorios del servidor.
 */

/* ========================================================
   1. RENDERIZACIÓN DE LA VISTA
   ======================================================== */
/**
 * El sistema procesa la carga de la interfaz gráfica correspondiente 
 * utilizando una ruta absoluta dinámica. Esto asegura que el texto 
 * legal se integre de manera segura en la plataforma, manteniendo 
 * la integridad de la estructura de carpetas.
 */
require_once dirname(__DIR__) . '/views/politica_servicios_view.php';
?>