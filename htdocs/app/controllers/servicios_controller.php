<?php
// ========================================================
// CONTROLADOR: servicios_controller.php
// UBICACIÓN: app/controllers/servicios_controller.php
// MODELO:servicios_model.php
// VISTA:servicios_view.php
//pagina que controla el funcionamiento de la pagina de servicios,cambia el texto en las seccinens 
//de el primer modulo de la pagina servicios y ahce que se muestren los servicios agrupados segun su tipo
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


// ... (código anterior de carga de modelos)

// Obtener todos los servicios

$servicios_agrupados = $modelo->obtenerServiciosAgrupados();

 $slides = [
        ["img" => "../../public/img/ReparacionGranFond.png", "t" => "Reparación y reemplazo", "s" => "Soluciones rápidas para tu equipo", "p" => "Desde: $800 pesos"],
        ["img" => "../../public/img/principalAdv.png", "t" => "Mantenimiento preventivo", "s" => "Para equipos portátiles de alto rendimiento", "p" => "Desde: $1350 pesos"],
        ["img" => "../../public/img/SoftwareGranFond.png", "t" => "Instalación de software", "s" => "Optimiza el rendimiento de tu equipo", "p" => "Desde: $300 pesos"],
        ["img" => "../../public/img/EspecialGranFond.png", "t" => "Servicios especializados", "s" => "Soluciones avanzadas para casos complejos", "p" => "Desde: $300 pesos"],
        ["img" => "../../public/img/DomicilioGranFond.png", "t" => "Servicios a domicilio", "s" => "Atención profesional en tu hogar", "p" => "Desde: $500 pesos"]
    ];

$max_id = 0;

foreach ($servicios_agrupados as $grupo) {

    foreach ($grupo['servicios'] as $servicio) {

        if ($servicio['id_servicio'] > $max_id) {

            $max_id = $servicio['id_servicio'];
        }
    }
}

$umbral_novedad = 4;
 $query = "SELECT 
            s.id_servicio,
            s.codigo_servicio,
            s.id_tipo_servicio,
            s.tipo_servicio,
            ts.nombre_tipo,
            s.descripcion,
            s.precio,
            s.imagen_servicio
          FROM servicios s
          INNER JOIN tipos_servicios ts
              ON s.id_tipo_servicio = ts.id_tipo_servicio
          WHERE s.estado = 'activo'";

    $resultado = mysqli_query($conexion, $query);
    $servicios_agrupados = [];

while ($fila = mysqli_fetch_assoc($resultado)) {

    $id_categoria = $fila['id_tipo_servicio'];

    // Crear grupo si no existe
    if (!isset($servicios_agrupados[$id_categoria])) {

        $servicios_agrupados[$id_categoria] = [
            'nombre' => $fila['nombre_tipo'],
            'servicios' => []
        ];
    }

    // Agregar servicio al grupo
    $servicios_agrupados[$id_categoria]['servicios'][] = $fila;
}

// Ahora pasamos $servicios_agrupados a la vista
require_once dirname(__DIR__) . '../views/servicios_view.php';
?>