<?php
/* MAS_INFO_CONTROLLER.PHP */
/*
Este archivo es un Controlador (Controller) dentro de la arquitectura MVC. Su tarea principal es actuar como el "cerebro" que se conecta a los servidores de Google utilizando la API Key y el Place ID de AsTech Computer. Realiza una petición directa a la API de Google Places para extraer información vital: las reseñas más útiles, la calificación general (ej. 4.9) y el total de opiniones. Una vez que obtiene y decodifica estos datos, se los prepara y envía a la Vista (mas_info_view.php) para que sean dibujados en la pantalla de forma dinámica.
*/

/* ==========================================
   1. CONFIGURACIÓN DE LA API DE GOOGLE PLACES
   ========================================== */
$api_key = "AIzaSyDOu5r3Nth7bsvBVYr3bwJ8doIH7N6gu24"; 
$place_id = "ChIJH_STTD9JIYQR0OFlsl6ga24"; 

/* ==========================================
   2. PREPARACIÓN DE LA CONSULTA (URL Y CAMPOS)
   ========================================== */
// Solicitamos los campos específicos: nombre, calificación, reseñas y el total de opiniones
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name,rating,reviews,user_ratings_total&key={$api_key}&language=es";

/* ==========================================
   3. INICIALIZACIÓN DE VARIABLES POR DEFECTO
   ========================================== */
$comentarios = [];
$rating_general = 0;
$total_opiniones = 0;

/* ==========================================
   4. EJECUCIÓN DE LA PETICIÓN Y EXTRACCIÓN DE DATOS
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
   5. CARGA DE LA VISTA (RENDER)
   ========================================== */
require_once dirname(__DIR__) . '/views/mas_info_view.php';
?>