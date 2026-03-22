<?php
// ========================================================
// CONTROLADOR: servicios_controller.php
// UBICACIÓN: app/controllers/servicios_controller.php
// ========================================================

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/servicios_model.php';

$modeloServicios = new ServiciosModel($conexion);

// 1. Obtenemos el ID de la URL
$id_tipo = isset($_GET['id_tipo_servicio']) ? $_GET['id_tipo_servicio'] : null;

// 2. Definimos los textos e imágenes por defecto
$datos_header = [
    'titulo' => "Servicios",
    'subtitulo' => "Conoce todas nuestras soluciones tecnológicas",
    'precio' => "Desde: $1000 pesos",
    'imagen' => "../../public/img/TodoGranFond.png"
];

// 3. Modificamos según la selección (Lógica de negocio)
if ($id_tipo == 1) {
    $datos_header['titulo'] = "Reparación y reemplazo";
    $datos_header['subtitulo'] = "Soluciones rápidas para tu equipo";
    $datos_header['precio'] = "Desde: $800 pesos";
    $datos_header['imagen'] = "../../public/img/ReparacionGranFond.png";
} elseif ($id_tipo == 2) {
    $datos_header['titulo'] = "Mantenimiento preventivo";
    $datos_header['subtitulo'] = "para equipos portátiles de alto rendimiento";
    $datos_header['precio'] = "Desde: $1350 pesos";
    $datos_header['imagen'] = "../../public/img/principalAdv.png";
} elseif ($id_tipo == 3) {
    $datos_header['titulo'] = "Instalación de software";
    $datos_header['subtitulo'] = "Optimiza el rendimiento de tu equipo";
    $datos_header['precio'] = "Desde: $300 pesos";
    $datos_header['imagen'] = "../../public/img/SoftwareGranFond.png";
} elseif ($id_tipo == 4) {
    $datos_header['titulo'] = "Servicios especializados";
    $datos_header['subtitulo'] = "Soluciones avanzadas para casos complejos";
    $datos_header['precio'] = "Desde: $300 pesos";
    $datos_header['imagen'] = "../../public/img/EspecialGranFond.png";
} elseif ($id_tipo == 5) {
    $datos_header['titulo'] = "Servicios a domicilio";
    $datos_header['subtitulo'] = "Atención profesional en la comodidad de tu hogar";
    $datos_header['precio'] = "Desde: $500 pesos";
    $datos_header['imagen'] = "../../public/img/DomicilioGranFond.png";
} elseif ($id_tipo == "") {
    $datos_header['imagen'] = "../../public/img/TodoGranFond.png"; // Se mantiene el default
}

// 4. Obtenemos las tarjetas desde la base de datos
$lista_servicios = $modeloServicios->obtenerServicios($id_tipo);

// 5. Cargamos la vista pasándole los datos
require_once dirname(__DIR__) . '/views/servicios_view.php';
?>