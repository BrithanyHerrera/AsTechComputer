<?php
/* CITAS_CRUD_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Gestión de Citas (Citas CRUD Controller) - As Tech Computer
 * PROPÓSITO: Servir como el intermediario (Controller) principal para la gestión interna de citas dentro del panel administrativo, orquestando la comunicación entre la interfaz de usuario, la base de datos local y la API de Google Calendar.
 * FUNCIONALIDADES:
 * - Carga de dependencias mediante Composer y establecimiento de la zona horaria del sistema.
 * - Configuración y autenticación segura con la API de Google Calendar mediante credenciales JSON.
 * - Procesamiento de solicitudes asíncronas (AJAX) para realizar cambios rápidos de estado en las citas registradas.
 * - Mantenimiento automatizado que detecta, extrae y elimina registros de citas cuya vigencia ha expirado en ambos sistemas.
 * - Ejecución controlada de la eliminación manual de registros por parte del administrador.
 * - Orquestación de la edición integral de citas desde ventanas modales, reestructurando las descripciones y sincronizando los cambios con Google.
 * - Extracción y preparación de catálogos crudos (marcas, tipos de equipo) y mapeo de horarios ocupados para alimentar la Vista.
 */

/* ========================================================
   1. INICIALIZACIÓN Y CARGA DE DEPENDENCIAS
   ======================================================== */
/**
 * El sistema importa las librerías necesarias gestionadas por Composer,
 * incluye los parámetros de conexión a la base de datos y llama al 
 * modelo correspondiente para estructurar el patrón MVC.
 */
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_crud_model.php';

use Google\Client;
use Google\Service\Calendar;

// Se establece la zona horaria oficial de la operación para evitar desfases en los agendamientos.
date_default_timezone_set('America/Mexico_City');

/* ==========================================================
   2. INSTANCIACIÓN DEL MODELO Y CONFIGURACIÓN DE GOOGLE API
   ========================================================== */
/**
 * Se instancia el objeto del modelo que concentrará las operaciones de base de datos.
 * Posteriormente, el sistema inicializa el cliente de Google y le inyecta las 
 * credenciales de la cuenta de servicio para habilitar la lectura y escritura en el calendario.
 */
$modeloCitas = new CitasAdminModel($conexion);

// Variable global inicializada para controlar y almacenar las alertas de éxito/error hacia la Vista.
$alerta_script = ""; 

$client = new Client();
$ruta_credenciales = dirname(__DIR__, 2) . '/credenciales.json';
$client->setAuthConfig($ruta_credenciales);
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);
$calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

/* ==========================================================
   3. ACTUALIZACIÓN DE ESTADO RÁPIDA VÍA AJAX
   ========================================================== */
/**
 * El controlador intercepta las peticiones POST generadas en segundo plano (AJAX).
 * Valida la existencia del identificador y solicita al modelo que modifique 
 * exclusivamente la columna de estado, preparando una alerta de recarga exitosa.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar_estado_rapido') {
    $id_cita = $_POST['db_id'] ?? null; 
    $nuevo_estado = $_POST['estado'] ?? 'pendiente';

    if ($id_cita) {
        $modeloCitas->actualizarEstado($id_cita, $nuevo_estado);
        $alerta_script = "Swal.fire('Estado Actualizado', 'El estado de la cita ha sido modificado', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } else {
        $alerta_script = "Swal.fire('Error', 'No se pudo encontrar el ID de la cita en la base de datos local', 'error');";
    }
}

/* ==========================================================
   4. LIMPIEZA AUTOMÁTICA DE CITAS EXPIRADAS
   ========================================================== */
/**
 * Rutina de auto-mantenimiento: El sistema detecta las citas que ya pasaron
 * de su fecha y hora límite, procediendo a eliminarlas primero en la nube
 * (Google Calendar) mitigando errores, y finalmente borrándolas de la base local.
 */
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
/**
 * El controlador captura el parámetro GET de eliminación. Ejecuta el borrado 
 * atómico en el servicio de Google y, de ser exitoso, delega al modelo la 
 * destrucción del registro en MySQL, devolviendo la confirmación visual.
 */
if (isset($_GET['delete_id'])) {
    try {
        $service->events->delete($calendarId, $_GET['delete_id']);
        
        if (!empty($_GET['db_id'])) {
            $modeloCitas->eliminarCitaLocal($_GET['db_id']);
        }
        $alerta_script = "Swal.fire('Eliminada', 'Cita eliminada correctamente', 'success').then(() => { window.location.href='?seccion=citas'; });";
    } catch (Exception $e) {
        $alerta_script = "Swal.fire('Error', 'No se pudo eliminar: " . addslashes($e->getMessage()) . "', 'error');";
    }
}

/* ==========================================================
   6. LÓGICA DE EDICIÓN Y ACTUALIZACIÓN GENERAL (MODAL)
   ========================================================== */
/**
 * Cuando el administrador envía el formulario modal completo, el sistema 
 * recolecta la data, re-calcula las conversiones textuales de los catálogos 
 * (marcas, tipos) para mantener la descripción humana del evento de Google 
 * actualizada, y finalmente impacta ambas bases de datos.
 */
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
        $m_nom = $modeloCitas->obtenerNombreMarca($id_marca);
        $t_nom = $modeloCitas->obtenerNombreTipo($id_tipo);

        $nuevo_resumen = "SERVICIO: $nombre $apellido - $t_nom";
        
        $nueva_desc = "Marca: $m_nom\nModelo: $modelo\nNo. Serie: $n_serie\nFalla: $falla\nDetalles: $detalle_falla\nWhatsApp: $whatsapp";

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
/**
 * Concluida la lógica de transacciones, el controlador extrae de la base 
 * de datos todos los catálogos y registros que necesita la Vista para 
 * rellenar los selects y tablas. Además, consulta la API en vivo para 
 * crear un mapa JSON de los horarios ocupados.
 */
$marcas_res = $modeloCitas->obtenerMarcas();
$tipos_res = $modeloCitas->obtenerTiposEquipo();
$mapa_db = $modeloCitas->obtenerCitasCompletas();

$servicios_res = $modeloCitas->obtenerServiciosConfigurados();

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