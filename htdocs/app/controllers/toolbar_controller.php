<?php
/* TOOLBAR_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de la Barra de Navegación (Toolbar Controller) - As Tech Computer
 * PROPÓSITO: Gestionar la lógica de negocio y preparación de datos antes de renderizar la barra de navegación global en la interfaz del usuario.
 * FUNCIONALIDADES: 
 * - Lectura y validación estructurada de cookies de privacidad para habilitar o deshabilitar éticamente el código de Google Analytics.
 * - Instanciación del modelo (ToolbarModel) para interactuar de forma segura con la base de datos.
 * - Obtención dinámica de categorías de servicios, servicios agrupados y los servicios más recientes para poblar el Mega Menú.
 * - Definición de rutas base para los recursos multimedia (imágenes).
 * - Carga final e inyección de todos los datos procesados en la Vista (toolbar_view.php).
 */

/* =====================================================================
   1. CARGA DE CONFIGURACIONES Y DEPENDENCIAS DEL MODELO
   ===================================================================== */
// El sistema importa las constantes globales, la conexión a la base de datos 
// y el modelo específico encargado de proporcionar los datos de la barra de navegación.
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/toolbar_model.php';

/* =====================================================================
   2. GESTIÓN DE PRIVACIDAD Y COOKIES (GOOGLE ANALYTICS)
   ===================================================================== */
// Se inicializa la variable de control de analíticas en falso por defecto 
// para garantizar la privacidad del visitante desde el primer momento.
$permitirAnaliticas = false;

// El sistema busca el identificador exacto de la cookie administrada por el JavaScript (Frontend).
if (isset($_COOKIE['astech_preferencias_cookies'])) {

    // Se decodifica el objeto JSON almacenado en la cookie convirtiéndolo en un array asociativo nativo de PHP.
    $cookies_estado = json_decode($_COOKIE['astech_preferencias_cookies'], true);

    // Se ejecuta una validación robusta para comprobar los permisos otorgados por el usuario.
    // Esto previene errores de lectura cruzada al evaluar valores booleanos, cadenas de texto o números.
    if (
        is_array($cookies_estado) &&
        isset($cookies_estado['analiticas']) &&
        ($cookies_estado['analiticas'] === true || $cookies_estado['analiticas'] === 'true' || $cookies_estado['analiticas'] == 1)
    ) {
        $permitirAnaliticas = true;
    }
}

/* =====================================================================
   3. INTERACCIÓN CON EL MODELO Y PREPARACIÓN DE DATOS
   ===================================================================== */
// Se instancia el objeto del modelo, manteniendo la lógica de consultas SQL 
// estrictamente separada del controlador y de la vista (Patrón MVC).
$toolbarModel = new ToolbarModel($conexion);

// El sistema extrae y almacena en memoria los datos requeridos por la interfaz, 
// sincronizando perfectamente los nombres de variables con los esperados por la vista.
$tiposServicios = $toolbarModel->obtenerTiposServicios();     // Obtiene las categorías padre.
$serviciosPorTipo = $toolbarModel->obtenerServiciosAgrupados();   // Obtiene los sub-servicios clasificados.
$serviciosRecientes = $toolbarModel->obtenerServiciosRecientes(4);  // Extrae los 4 registros más recientes.

// Se define la ruta base de las imágenes para asegurar que los recursos multimedia 
// se carguen correctamente sin importar la profundidad del directorio actual.
$ruta_img = BASE_URL . "public/img/servicios/";

/* =====================================================================
   4. RENDERIZACIÓN DE LA VISTA
   ===================================================================== */
// Una vez completada la preparación de datos y evaluadas las condiciones de privacidad, 
// el sistema delega la representación visual llamando al archivo de vista correspondiente.
require_once dirname(__DIR__) . '/views/fijos/toolbar_view.php';
?>