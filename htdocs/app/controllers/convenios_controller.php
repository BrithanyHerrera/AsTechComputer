<?php
/* CONVENIOS_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Convenios (Convenios Controller) - As Tech Computer
 * PROPÓSITO: Gestionar el acceso a la sección de convenios institucionales, actuando como enlace operativo base dentro de la arquitectura MVC.
 * FUNCIONALIDADES:
 * - Carga segura de las configuraciones y constantes globales del sistema.
 * - Invocación directa de la Vista correspondiente mediante el uso de rutas absolutas dinámicas (dirname).
 * - Preparación estructural para futura escalabilidad (listo para integrar conexión a base de datos y modelos CRUD si se requiere más adelante).
 */

/* ========================================================
   1. CARGA DE CONFIGURACIÓN Y RENDERIZACIÓN DE LA VISTA
   ======================================================== */
/**
 * El sistema importa los parámetros de configuración globales y 
 * posteriormente procesa la carga de la interfaz gráfica (Vista). 
 * Se reserva este espacio estructural para que, en un futuro, 
 * se puedan inyectar modelos de datos si se decide administrar 
 * los convenios dinámicamente desde la base de datos.
 */
require_once __DIR__ . "/../config/config.php"; 
require_once dirname(__DIR__) . '/views/convenios_view.php';

?>