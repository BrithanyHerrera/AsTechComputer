<?php
// ===============================
// 1. CARGAR AUTOLOAD Y CONEXIÓN
// ===============================
require_once __DIR__ . '/../../vendor/autoload.php';
require_once dirname(__DIR__, 1) . '/config/conexion.db.php';
require_once __DIR__ . '/../models/CitaModel.php';

use Google\Client;
use Google\Service\Calendar;

date_default_timezone_set('America/Mexico_City');

$modeloCita = new CitaModel($conexion);
$modeloCita->limpiarCitasExpiradas();

// ===============================
// 2. CONFIGURAR CLIENTE GOOGLE
// ===============================
$client = new Client();
$ruta_credenciales = dirname(__DIR__, 2) . '/credenciales.json';
$client->setAuthConfig($ruta_credenciales);
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);
$calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

// ===================================
// 3. LÓGICA ELIMINAR (DB + GOOGLE)
// ===================================
if (isset($_GET['delete_id'])) {
    try {
        $service->events->delete($calendarId, $_GET['delete_id']);
        if (!empty($_GET['db_id'])) {
            $modeloCita->eliminarCita($_GET['db_id']);
        }
        echo "<script>alert('Cita eliminada correctamente'); window.location.href='?seccion=citas';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// ===================================
// 4. LÓGICA ACTUALIZAR (DB + GOOGLE)
// ===================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    try {
        $m_nom = $modeloCita->obtenerNombreMarca($_POST['id_marca']);
        $t_nom = $modeloCita->obtenerNombreTipo($_POST['id_tipo']);

        $nuevo_resumen = "SERVICIO: {$_POST['nombre']} {$_POST['apellido']} - $t_nom";
        $nueva_desc = "Marca: $m_nom\nModelo: {$_POST['modelo']}\nNo. Serie: {$_POST['n_serie']}\nFalla: {$_POST['falla']}\nWhatsApp: {$_POST['whatsapp']}";

        $evento = $service->events->get($calendarId, $_POST['modal_google_id']);
        $inicio_dt = $_POST['fecha'] . 'T' . $_POST['hora'] . ':00-06:00';
        $fin_dt = date('Y-m-d\TH:i:sP', strtotime($inicio_dt . ' + 1 hour'));

        $evento->setSummary($nuevo_resumen);
        $evento->setDescription($nueva_desc);
        $evento->setStart(new Google\Service\Calendar\EventDateTime(['dateTime' => $inicio_dt, 'timeZone' => 'America/Mexico_City']));
        $evento->setEnd(new Google\Service\Calendar\EventDateTime(['dateTime' => $fin_dt, 'timeZone' => 'America/Mexico_City']));

        $service->events->update($calendarId, $_POST['modal_google_id'], $evento);

        if (!empty($_POST['modal_db_id'])) {
            $_POST['id_db'] = $_POST['modal_db_id'];
            $modeloCita->actualizarCita($_POST);
        }
        echo "<script>alert('Información actualizada en todo el sistema'); window.location.href='?seccion=citas';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// ===================================
// 5. CONSULTA DE CATÁLOGOS Y CITAS
// ===================================
$marcas_res = $modeloCita->obtenerMarcas();
$tipos_res = $modeloCita->obtenerTipos();
$eventos_google = $service->events->listEvents($calendarId, ['singleEvents' => true, 'orderBy' => 'startTime', 'timeMin' => date('c')])->getItems();
$mapa_db = $modeloCita->obtenerCitasBaseDatos();

// ===================================
// 6. CARGAR LA VISTA
// ===================================
require_once dirname(__DIR__) . '/views/CitasAdminView.php';
?>