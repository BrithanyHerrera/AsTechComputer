

<?php
// ========================================================
//CONTROLADOR DE SETALLE SERVICIO
//VIEW:detalle_servicio_view.php
// mODELO: detalle_servicio_model.php (Página de detalle servicio)
// pagina que muestra informacion especifica de cada servicio en la pagina servicios_view.php
// ========================================================

// ruta que dirige a la ruta inicial de el proyecto
$path_config = realpath(__DIR__ . '/../config/conexion.db.php');
// ruta que conecta a model con controller
$path_model  = realpath(__DIR__ . '/../models/detalle_servicio_model.php');


//muestra toda la informacion de el servicio al hacer click en el servicio en la pagina de servicios principal
//en caso de que no se encuentre nada, da un mensaje de error
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