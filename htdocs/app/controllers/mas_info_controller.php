<?php
/* MAS_INFO_CONTROLLER.PHP */
/*
Este archivo es el Controlador (Controller) consolidado para la página de "Más Información" de ASTECH COMPUTER. Combina dos grandes responsabilidades bajo la arquitectura MVC: primero, interactúa con la API de Google Places para extraer las reseñas, la calificación general y el número total de opiniones del negocio. Segundo, gestiona la lógica del formulario de contacto directo, conectándose a la base de datos (mediante ContactoModel) para registrar nuevos mensajes y devolviendo un estado ($status) de éxito o error. Finalmente, pasa toda esta información procesada a una única Vista consolidada (mas_info_view.php).
*/

/* ==========================================
   1. CONFIGURACIÓN DE LA API DE GOOGLE PLACES
   ========================================== */
$api_key = "AIzaSyDOu5r3Nth7bsvBVYr3bwJ8doIH7N6gu24";
$place_id = "ChIJH_STTD9JIYQR0OFlsl6ga24";

// Solicitud de campos específicos: nombre, calificación, reseñas y el total de opiniones
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name,rating,reviews,user_ratings_total&key={$api_key}&language=es";

/* ==========================================
   2. INICIALIZACIÓN DE VARIABLES PARA RESEÑAS
   ========================================== */
$comentarios = [];
$rating_general = 0;
$total_opiniones = 0;

/* ==========================================
   3. EJECUCIÓN DE LA PETICIÓN Y EXTRACCIÓN DE RESEÑAS
   ========================================== */
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
// Se carga una única vista que contendrá tanto la sección de contacto como las reseñas
require_once dirname(__DIR__) . '/views/mas_info_view.php';
?>