

<?php
// ========================================================
//CONTROLADOR DE SETALLE SERVICIO
//VIEW:detalle_servicio_view.php
// mODELO: detalle_servicio_model.php (Página de detalle servicio)
// pagina que muestra informacion especifica de cada servicio en la pagina servicios_view.php
// ========================================================
// Esto crea la ruta absoluta limpia eliminando los "/../"
$path_config = realpath(__DIR__ . '/../config/conexion.db.php');
$path_model  = realpath(__DIR__ . '/../models/detalle_servicio_model.php');

if (!$path_config || !$path_model) {
    die("Error crítico: No se encontró el archivo de Configuración o el Modelo. 
         Revisa que 'app/models/ServicioModel.php' exista exactamente con ese nombre.");
}

require_once $path_config;
require_once $path_model;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$servicio = null;
$metodos_pago = null;

if ($id > 0) {
    $servicio = ServicioModel::obtenerServicioPorId($id);

    if ($servicio) {
        $metodos_pago = ServicioModel::obtenerMetodosPago();
    }
}

// ... después de obtener $servicio y $metodos_pago ...

if (!$servicio) {
    echo "Servicio no encontrado";
    exit;
}

// AL FINAL DEL CONTROLADOR, LLAMA A LA VISTA
include __DIR__ . '/../views/detalle_servicio_view.php';