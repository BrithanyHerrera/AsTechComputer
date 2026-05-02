<?php
/* ADMINISTRACION_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador Maestro de Administración (Front Controller) - As Tech Computer
 * PROPÓSITO: Centralizar el enrutamiento del sistema para el panel de administración, gestionando qué submódulo debe ejecutarse y renderizarse.
 * FUNCIONALIDADES:
 * - Carga inicial de las configuraciones y constantes globales del sistema.
 * - Captura y validación de parámetros de la URL (método GET) para determinar la sección solicitada ('citas', 'ingreso', o 'dashboard' por defecto).
 * - Ejecución condicional y dinámica de los controladores secundarios correspondientes a cada submódulo, permitiendo la preparación de datos y operaciones de base de datos previas a la vista.
 * - Renderización de la vista maestra, integrando de forma limpia toda la lógica de negocio procesada en segundo plano.
 */


/* ========================================================
   1. CARGA DE CONFIGURACIÓN GLOBAL
   ======================================================== */
// El sistema incluye el archivo principal de configuración para asegurar
// el acceso a constantes y parámetros de entorno definidos globalmente.
require_once __DIR__ . "/../config/config.php"; 

/* ========================================================
   2. GESTIÓN DE ENRUTAMIENTO PRINCIPAL (GET)
   ======================================================== */
/**
 * El sistema captura el parámetro 'seccion' a través de la URL.
 * Si el usuario no especifica ninguna ruta concreta, el controlador 
 * establece automáticamente 'dashboard' como valor predeterminado 
 * para garantizar la carga correcta de la pantalla inicial.
 */
$seccion_actual = isset($_GET['seccion']) ? $_GET['seccion'] : 'dashboard';

/* ========================================================
   3. EJECUCIÓN DINÁMICA DE CONTROLADORES SECUNDARIOS
   ======================================================== */
/**
 * Actuando como un gestor de tráfico, el controlador maestro delega 
 * las responsabilidades hacia controladores secundarios específicos. 
 * Estos archivos se ejecutan en segundo plano para procesar lógica de 
 * negocio, consultas a la base de datos o preparación de variables vitales 
 * (como $paso) que las vistas consumirán posteriormente.
 */
if ($seccion_actual === 'citas') {
    require_once 'citas_crud_controller.php';
} elseif ($seccion_actual === 'ingreso') {
    require_once 'ingresar_dispositivo_controller.php'; 
}

/* ========================================================
   4. RENDERIZACIÓN DE LA VISTA MAESTRA
   ======================================================== */
/**
 * Una vez completada toda la preparación lógica en segundo plano, 
 * el sistema invoca e integra la interfaz gráfica principal. Se emplea 
 * dirname() para garantizar una construcción de rutas absoluta y segura.
 */
require_once dirname(__DIR__) . '/views/administracion_view.php';
?>