<?php
/* MAS_INFO_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Más Información y Contacto (Mas Info Controller) - As Tech Computer
 * PROPÓSITO: Actuar como el controlador consolidado para la página de "Más Información", gestionando la extracción de reseñas desde la API de Google Places y procesando el envío de mensajes a través del formulario de contacto directo.
 * FUNCIONALIDADES:
 * - Configuración de credenciales y parámetros de búsqueda para la API de Google Places.
 * - Petición externa y decodificación de respuestas JSON para extraer comentarios, calificación general y total de opiniones.
 * - Carga segura de variables de entorno y dependencias del sistema de base de datos.
 * - Instanciación del modelo de contacto para separar la lógica de base de datos del controlador.
 * - Procesamiento de peticiones POST, validando y guardando los mensajes de los clientes de manera segura.
 * - Gestión de la variable de estado ($status) para disparar notificaciones visuales (alertas) en el Frontend.
 * - Renderización de la vista consolidada inyectando la información procesada.
 */

/* ==========================================
   1. CONFIGURACIÓN DE LA API DE GOOGLE PLACES
   ========================================== */
/**
 * El sistema define las claves de acceso y el identificador único del lugar (Place ID).
 * Posteriormente, construye la URL de petición solicitando campos específicos 
 * como nombre, calificación, reseñas y el total de opiniones en idioma español.
 */
$api_key = "AIzaSyDOu5r3Nth7bsvBVYr3bwJ8doIH7N6gu24";
$place_id = "ChIJH_STTD9JIYQR0OFlsl6ga24";

// Solicitud de campos específicos: nombre, calificación, reseñas y el total de opiniones
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name,rating,reviews,user_ratings_total&key={$api_key}&language=es";

/* ==========================================
   2. INICIALIZACIÓN DE VARIABLES PARA RESEÑAS
   ========================================== */
/**
 * Se inicializan las variables contenedoras por defecto para prevenir
 * errores de variables indefinidas en la Vista en caso de que la 
 * petición a la API de Google falle o no retorne datos.
 */
$comentarios = [];
$rating_general = 0;
$total_opiniones = 0;

/* ==========================================
   3. EJECUCIÓN DE LA PETICIÓN Y EXTRACCIÓN DE RESEÑAS
   ========================================== */
/**
 * El controlador ejecuta la petición HTTP hacia los servidores de Google.
 * Si la respuesta es exitosa, decodifica el formato JSON y extrae la 
 * información asignándola a las variables previamente inicializadas.
 */
$respuesta = @file_get_contents($url);

if ($respuesta !== false) {
   $datos = json_decode($respuesta, true);

   if (isset($datos['result'])) {
      $comentarios = $datos['result']['reviews'] ?? [];
      $rating_general = $datos['result']['rating'] ?? 0;
      $total_opiniones = $datos['result']['user_ratings_total'] ?? 0;
   }
}

/* ==========================================
   4. INTEGRACIÓN DEL MODELO DE CONTACTO Y BASE DE DATOS
   ========================================== */
/**
 * El sistema requiere los archivos de configuración global y de base de datos.
 * Luego, instancia el modelo de contacto, el cual se encargará exclusivamente 
 * de las operaciones de inserción en la base de datos (Patrón MVC).
 */
// 1. Cargamos las variables globales de configuración (BASE_URL)
require_once dirname(__DIR__) . '/config/config.php';

// 2. Se requiere la conexión a la base de datos y el modelo correspondiente
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/contacto_model.php';

// Se instancia el modelo para manejar las inserciones
$modeloContacto = new ContactoModel($conexion);

/* ==========================================
   5. PROCESAMIENTO DEL FORMULARIO DE CONTACTO (POST)
   ========================================== */
/**
 * El controlador intercepta las peticiones de tipo POST provenientes del 
 * formulario de contacto. Recopila los datos ingresados y solicita al 
 * modelo que los guarde, capturando el resultado en una variable de estado 
 * para informar al usuario sobre el éxito o fracaso de la operación.
 */
// Variable para controlar la alerta que se mostrará en la vista
$status = "";

// Lógica de inserción si se detecta un envío mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $nombre = $_POST['nombre'];
   $email = $_POST['email'];
   $asunto = $_POST['asunto'];
   $mensaje = $_POST['mensaje'];

   try {
      if ($modeloContacto->guardarMensaje($nombre, $email, $asunto, $mensaje)) {
         $status = "success";
      } else {
         $status = "error";
      }
   } catch (Exception $e) {
      $status = "error";
   }
}

/* ==========================================
   6. CARGA DE LA VISTA CONSOLIDADA (RENDER)
   ========================================== */
/**
 * Una vez extraída la información de Google y procesados los posibles 
 * envíos de formularios, el sistema incluye el archivo de la vista, 
 * inyectándole de forma transparente todos los datos recolectados.
 */
// Se carga una única vista que contendrá tanto la sección de contacto como las reseñas
require_once dirname(__DIR__) . '/views/mas_info_view.php';
?>