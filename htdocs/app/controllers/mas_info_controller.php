<?php
// ========================================================
// CONTROLADOR: convenios_controller.php
// UBICACIÓN: app/controllers/mas_info_view.php
// ========================================================

// 1. Tus credenciales de Google
$api_key = "AIzaSyDOu5r3Nth7bsvBVYr3bwJ8doIH7N6gu24"; // Más abajo te digo cómo obtenerla
$place_id = "ChIJH_STTD9JIYQR0OFlsl6ga24"; // El código único de AsTech Computer en Maps

// 2. URL de la API de Google Places (Pedimos reseñas y en idioma español)
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name,rating,reviews&key={$api_key}&language=es";

$comentarios = [];

// 3. Nos conectamos a Google de forma segura (el @ evita errores si no hay internet)
$respuesta = @file_get_contents($url);

if ($respuesta !== false) {
    $datos = json_decode($respuesta, true);
    // Si Google nos mandó las reseñas, las guardamos
    if (isset($datos['result']['reviews'])) {
        $comentarios = $datos['result']['reviews'];
    }
}

// 4. Cargamos la vista
require_once dirname(__DIR__) . '/views/mas_info_view.php';
?>