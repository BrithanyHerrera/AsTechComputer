<?php
// ========================================================
// CONTROLADOR: citas_admin_controller.php
// UBICACIÓN: app/controllers/citas_admin_controller.php
// ========================================================

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_crud_model.php'; // <-- INCLUIMOS EL MODELO

use Google\Client;
use Google\Service\Calendar;

date_default_timezone_set('America/Mexico_City');

// Instanciamos el Modelo
$modeloCitas = new CitasAdminModel($conexion);

// Variable para controlar las alertas de la vista (En vez de hacer echo <script>)
$alerta_script = ""; 

// 1. Configurar Cliente Google
$client = new Client();
$ruta_credenciales = dirname(__DIR__, 2) . '/credenciales.json';
$client->setAuthConfig($ruta_credenciales);
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);
$calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

// ==========================================================
// ACTUALIZACIÓN DE ESTADO RÁPIDA VÍA AJAX
// ==========================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar_estado_rapido') {
    $id_cita = $_POST['id_cita'];
    $nuevo_estado = $_POST['nuevo_estado'];

    // Le pedimos al modelo que actualice
    if ($modeloCitas->actualizarEstado($id_cita, $nuevo_estado)) {
        echo "OK";
    } else {
        echo "ERROR";
    }
    exit(); 
}

// ==========================================================
// LIMPIEZA DE CITAS EXPIRADAS
// ==========================================================
$citas_expiradas = $modeloCitas->obtenerCitasExpiradas();
foreach ($citas_expiradas as $cita_exp) {
    if (!empty($cita_exp['id_google_calendar'])) {
        try {
            $service->events->delete($calendarId, $cita_exp['id_google_calendar']);
        } catch (Exception $e) {} // Ignoramos si ya no existe en Google
    }
    $modeloCitas->eliminarCitaLocal($cita_exp['id_cita']);
}

// ==========================================================
// LÓGICA ELIMINAR (Vía botón)
// ==========================================================
if (isset($_GET['delete_id'])) {
    try {
        $service->events->delete($calendarId, $_GET['delete_id']);
        
        if (!empty($_GET['db_id'])) {
            $modeloCitas->eliminarCitaLocal($_GET['db_id']);
        }
        // Creamos la alerta para que la vista la dibuje
        $alerta_script = "Swal.fire('Eliminada', 'Cita eliminada correctamente', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } catch (Exception $e) {
        $alerta_script = "Swal.fire('Error', 'No se pudo eliminar: " . addslashes($e->getMessage()) . "', 'error');";
    }
}

// ==========================================================
// LÓGICA ACTUALIZAR GENERAL (Desde el Modal)
// ==========================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id_google = $_POST['modal_google_id'];
    $id_db = $_POST['modal_db_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $id_marca = $_POST['id_marca'];
    $id_tipo = $_POST['id_tipo'];
    $falla = $_POST['falla'];
    $whatsapp = $_POST['whatsapp'];
    $modelo = $_POST['modelo'];
    $n_serie = $_POST['n_serie'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    try {
        // Pedimos los nombres al modelo para el resumen de Google
        $m_nom = $modeloCitas->obtenerNombreMarca($id_marca);
        $t_nom = $modeloCitas->obtenerNombreTipo($id_tipo);

        $nuevo_resumen = "SERVICIO: $nombre $apellido - $t_nom";
        $nueva_desc = "Marca: $m_nom\nModelo: $modelo\nNo. Serie: $n_serie\nFalla: $falla\nWhatsApp: $whatsapp";

        // Actualizamos Google Calendar
        $evento = $service->events->get($calendarId, $id_google);
        $inicio_dt = $fecha . 'T' . $hora . ':00-06:00';
        $fin_dt = date('Y-m-d\TH:i:sP', strtotime($inicio_dt . ' + 1 hour'));

        $evento->setSummary($nuevo_resumen);
        $evento->setDescription($nueva_desc);
        $evento->setStart(new Google\Service\Calendar\EventDateTime(['dateTime' => $inicio_dt, 'timeZone' => 'America/Mexico_City']));
        $evento->setEnd(new Google\Service\Calendar\EventDateTime(['dateTime' => $fin_dt, 'timeZone' => 'America/Mexico_City']));

        $service->events->update($calendarId, $id_google, $evento);

        // Actualizamos BD Local
        if (!empty($id_db)) {
            $modeloCitas->actualizarCitaCompleta($id_db, $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $fecha, $hora, $whatsapp);
        }
        
        $alerta_script = "Swal.fire('Actualizado', 'Información actualizada en todo el sistema', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } catch (Exception $e) {
        $alerta_script = "Swal.fire('Error', 'No se pudo actualizar: " . addslashes($e->getMessage()) . "', 'error');";
    }
}

// ==========================================================
// PREPARAR DATOS PARA LA VISTA
// ==========================================================
$marcas_res = $modeloCitas->obtenerMarcas();
$tipos_res = $modeloCitas->obtenerTiposEquipo();
$mapa_db = $modeloCitas->obtenerCitasCompletas();

// Traer eventos de Google y calcular horas ocupadas
$eventos_google = $service->events->listEvents($calendarId, ['singleEvents' => true, 'orderBy' => 'startTime', 'timeMin' => date('c')])->getItems();

$citas_ocupadas = [];
foreach ($eventos_google as $ev) {
    $dt_start = $ev->start->dateTime ?: $ev->start->date;
    $fecha_ev = date('Y-m-d', strtotime($dt_start));
    $hora_ev = date('H:i', strtotime($dt_start));
    $citas_ocupadas[$fecha_ev][] = $hora_ev;
}
$json_ocupadas = json_encode($citas_ocupadas);

// Nota: La vista será incluida automáticamente por el administracion_controller.php
?>