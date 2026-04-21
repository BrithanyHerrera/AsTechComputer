<?php
/* CITAS_CRUD_CONTROLLER.PHP */
/*
Este archivo es el Controlador (Controller) responsable de la gestión interna de citas (CRUD) dentro del panel administrativo de ASTECH COMPUTER. Funciona como el intermediario principal entre la interfaz del administrador, la base de datos local y la API de Google Calendar. Sus tareas incluyen: cargar las librerías necesarias, recibir solicitudes asíncronas (AJAX) para cambiar rápidamente el estado de una cita, limpiar automáticamente los registros que ya han expirado, gestionar la eliminación o edición de citas asegurando que los cambios se reflejen de manera sincronizada tanto en el servidor local como en Google Calendar, y finalmente, preparar todos los datos en crudo (listas de marcas, tipos de equipo y horarios ocupados) que serán renderizados por la Vista.
*/
/* ========================================================
   1. INICIALIZACIÓN Y CARGA DE DEPENDENCIAS
   ======================================================== */

// Inclusión de librerías mediante Composer y conexión a BD
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_crud_model.php'; // <-- INCLUIMOS EL MODELO

use Google\Client;
use Google\Service\Calendar;

date_default_timezone_set('America/Mexico_City');

/* ==========================================================
   2. INSTANCIACIÓN DEL MODELO Y CONFIGURACIÓN DE GOOGLE API
   ========================================================== */
// Se instancia el Modelo para gestionar operaciones de base de datos
$modeloCitas = new CitasAdminModel($conexion);

// Variable para controlar las alertas de la vista (En vez de hacer echo <script>)
$alerta_script = ""; 

// Configuración de credenciales y acceso al cliente de Google Calendar
$client = new Client();
$ruta_credenciales = dirname(__DIR__, 2) . '/credenciales.json';
$client->setAuthConfig($ruta_credenciales);
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);
$calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

/* ==========================================================
   3. ACTUALIZACIÓN DE ESTADO RÁPIDA VÍA AJAX
   ========================================================== */
// Intercepta peticiones POST para actualizar el estado de una cita de forma asíncrona
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar_estado_rapido') {
    $id_cita = $_POST['db_id'] ?? null; 
    $nuevo_estado = $_POST['estado'] ?? 'pendiente';

    if ($id_cita) {
        // Llamamos al modelo para que actualice la base de datos
        $modeloCitas->actualizarEstado($id_cita, $nuevo_estado);
        // Recarga la página para mostrar el nuevo color y estado
        $alerta_script = "Swal.fire('Estado Actualizado', 'El estado de la cita ha sido modificado', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } else {
        $alerta_script = "Swal.fire('Error', 'No se pudo encontrar el ID de la cita en la base de datos local', 'error');";
    }
}

/* ==========================================================
   4. LIMPIEZA AUTOMÁTICA DE CITAS EXPIRADAS
   ========================================================== */
// Extrae y elimina citas cuya vigencia ha expirado, sincronizando BD y Calendar
$citas_expiradas = $modeloCitas->obtenerCitasExpiradas();
foreach ($citas_expiradas as $cita_exp) {
    if (!empty($cita_exp['id_google_calendar'])) {
        try {
            $service->events->delete($calendarId, $cita_exp['id_google_calendar']);
        } catch (Exception $e) {} 
    }
    $modeloCitas->eliminarCitaLocal($cita_exp['id_cita']);
}

/* ==========================================================
   5. LÓGICA PARA ELIMINACIÓN MANUAL DE CITAS
   ========================================================== */
// Elimina una cita específica cuando el administrador acciona el botón de eliminar
if (isset($_GET['delete_id'])) {
    try {
        $service->events->delete($calendarId, $_GET['delete_id']);
        
        if (!empty($_GET['db_id'])) {
            $modeloCitas->eliminarCitaLocal($_GET['db_id']);
        }
        // Se genera el script de alerta para confirmación en la vista
        $alerta_script = "Swal.fire('Eliminada', 'Cita eliminada correctamente', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } catch (Exception $e) {
        $alerta_script = "Swal.fire('Error', 'No se pudo eliminar: " . addslashes($e->getMessage()) . "', 'error');";
    }
}

/* ==========================================================
   6. LÓGICA DE EDICIÓN Y ACTUALIZACIÓN GENERAL (MODAL)
   ========================================================== */
// Procesa los datos enviados desde la ventana modal de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id_google     = $_POST['modal_google_id'];
    $id_db         = $_POST['modal_db_id'];
    $nombre        = $_POST['nombre'];
    $apellido      = $_POST['apellido'];
    $id_marca      = $_POST['id_marca'];
    $id_tipo       = $_POST['id_tipo'];
    $falla         = $_POST['falla'];
    $detalle_falla = $_POST['detalle_falla'] ?? '';
    $whatsapp      = $_POST['whatsapp'];
    $modelo        = $_POST['modelo'];
    $n_serie       = $_POST['n_serie'];
    $fecha         = $_POST['fecha'];
    $hora          = $_POST['hora'];
    $estado        = $_POST['estado'] ?? ''; 

    try {
        // Se solicitan los nombres textuales al modelo para armar el resumen en Google
        $m_nom = $modeloCitas->obtenerNombreMarca($id_marca);
        $t_nom = $modeloCitas->obtenerNombreTipo($id_tipo);

        $nuevo_resumen = "SERVICIO: $nombre $apellido - $t_nom";
        
        // Agregamos el detalle de la falla al evento de Google Calendar
        $nueva_desc = "Marca: $m_nom\nModelo: $modelo\nNo. Serie: $n_serie\nFalla: $falla\nDetalles: $detalle_falla\nWhatsApp: $whatsapp";

        // Sincronización de los nuevos datos hacia Google Calendar
        $evento = $service->events->get($calendarId, $id_google);
        $inicio_dt = $fecha . 'T' . $hora . ':00-06:00';
        $fin_dt = date('Y-m-d\TH:i:sP', strtotime($inicio_dt . ' + 1 hour'));

        $evento->setSummary($nuevo_resumen);
        $evento->setDescription($nueva_desc);
        $evento->setStart(new Google\Service\Calendar\EventDateTime(['dateTime' => $inicio_dt, 'timeZone' => 'America/Mexico_City']));
        $evento->setEnd(new Google\Service\Calendar\EventDateTime(['dateTime' => $fin_dt, 'timeZone' => 'America/Mexico_City']));

        $service->events->update($calendarId, $id_google, $evento);

        if (!empty($id_db)) {
            $modeloCitas->actualizarCitaCompleta($id_db, $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $detalle_falla, $fecha, $hora, $whatsapp, $estado);
        }
        
        $alerta_script = "Swal.fire('Actualizado', 'Información actualizada en todo el sistema', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } catch (Exception $e) {
        $alerta_script = "Swal.fire('Error', 'No se pudo actualizar: " . addslashes($e->getMessage()) . "', 'error');";
    }
}

/* ==========================================================
   7. PREPARACIÓN Y EXTRACCIÓN DE DATOS PARA LA VISTA
   ========================================================== */
// Se solicitan al modelo los catálogos y el mapa completo de citas
$marcas_res = $modeloCitas->obtenerMarcas();
$tipos_res = $modeloCitas->obtenerTiposEquipo();
$mapa_db = $modeloCitas->obtenerCitasCompletas();

$servicios_res = $modeloCitas->obtenerServiciosConfigurados();

// Extracción de eventos directamente desde Google Calendar para sincronizar horarios ocupados
$eventos_google = $service->events->listEvents($calendarId, ['singleEvents' => true, 'orderBy' => 'startTime', 'timeMin' => date('c')])->getItems();

$citas_ocupadas = [];
foreach ($eventos_google as $ev) {
    $dt_start = $ev->start->dateTime ?: $ev->start->date;
    $fecha_ev = date('Y-m-d', strtotime($dt_start));
    $hora_ev = date('H:i', strtotime($dt_start));
    $citas_ocupadas[$fecha_ev][] = $hora_ev;
}
$json_ocupadas = json_encode($citas_ocupadas);
?>