<?php
// ========================================================
// CONTROLADOR: servicios_controller.php
// UBICACIÓN: app/controllers/servicios_controller.php
// ========================================================

// 1. PRIMERO: Cargar los archivos necesarios
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/servicios_model.php'; // Verifica que la ruta sea correcta

// 2. SEGUNDO: Instanciar el modelo (Ahora sí la clase existe)
$modelo = new ServicioModel($conexion); 
$modeloServicios = $modelo; // Mantengo ambos nombres por si los usas abajo

// 3. TERCERO: Capturar variables de control
$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';
$id_tipo = isset($_GET['id_tipo_servicio']) ? $_GET['id_tipo_servicio'] : null;

// --- LÓGICA DE NEGOCIO (HEADER) ---
$datos_header = [
    'titulo' => "Servicios",
    'subtitulo' => "Conoce todas nuestras soluciones tecnológicas",
    'precio' => "Desde: $1000 pesos",
    'imagen' => "../../public/img/TodoGranFond.png"
];

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
}
// --- CARGA DE VISTA ---
// Si no hay acción (carga normal de la página de servicios al público)
$lista_servicios = $modeloServicios->obtenerServicios($id_tipo);
require_once dirname(__DIR__) . '/views/servicios_view.php';
?>