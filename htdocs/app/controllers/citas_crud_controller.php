<?php
// ========================================================
// CONTROLADOR: citas_admin_controller.php
// UBICACIÓN: app/controllers/citas_admin_controller.php
// ========================================================

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/conexion.db.php';

use Google\Client;
use Google\Service\Calendar;

date_default_timezone_set('America/Mexico_City');

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

    // Actualizamos solo el estado en la base de datos
    $stmt = $conexion->prepare("UPDATE citas_web SET estado = ? WHERE id_cita = ?");
    $stmt->bind_param("si", $nuevo_estado, $id_cita);
    
    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "ERROR";
    }
    exit(); 
}
// ==========================================================

// 2. Limpieza de citas expiradas
$sql_buscar_expiradas = "SELECT id_cita, id_google_calendar FROM citas_web WHERE TIMESTAMP(fecha_cita, hora_cita) < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$res_expiradas = $conexion->query($sql_buscar_expiradas);

if ($res_expiradas && $res_expiradas->num_rows > 0) {
    while ($cita_expirada = $res_expiradas->fetch_assoc()) {
        if (!empty($cita_expirada['id_google_calendar'])) {
            try {
                $service->events->delete($calendarId, $cita_expirada['id_google_calendar']);
            } catch (Exception $e) {}
        }
        $stmt_delete = $conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
        $stmt_delete->bind_param("i", $cita_expirada['id_cita']);
        $stmt_delete->execute();
    }
}

// 3. Lógica Eliminar
if (isset($_GET['delete_id'])) {
    try {
        $service->events->delete($calendarId, $_GET['delete_id']);
        if (!empty($_GET['db_id'])) {
            $stmt = $conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
            $stmt->bind_param("i", $_GET['db_id']);
            $stmt->execute();
        }
        echo "<script>alert('Cita eliminada correctamente'); window.location.href='?seccion=citas';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// 4. Lógica Actualizar General (Desde el Modal)
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
        $m_nom = $conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'")->fetch_assoc()['marca'];
        $t_nom = $conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'")->fetch_assoc()['tipo'];

        $nuevo_resumen = "SERVICIO: $nombre $apellido - $t_nom";
        $nueva_desc = "Marca: $m_nom\nModelo: $modelo\nNo. Serie: $n_serie\nFalla: $falla\nWhatsApp: $whatsapp";

        $evento = $service->events->get($calendarId, $id_google);
        $inicio_dt = $fecha . 'T' . $hora . ':00-06:00';
        $fin_dt = date('Y-m-d\TH:i:sP', strtotime($inicio_dt . ' + 1 hour'));

        $evento->setSummary($nuevo_resumen);
        $evento->setDescription($nueva_desc);
        $evento->setStart(new Google\Service\Calendar\EventDateTime(['dateTime' => $inicio_dt, 'timeZone' => 'America/Mexico_City']));
        $evento->setEnd(new Google\Service\Calendar\EventDateTime(['dateTime' => $fin_dt, 'timeZone' => 'America/Mexico_City']));

        $service->events->update($calendarId, $id_google, $evento);

        if (!empty($id_db)) {
            $stmt = $conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, fecha_cita=?, hora_cita=?, whatsapp=? WHERE id_cita=?");
            $stmt->bind_param("ssiissssssi", $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $fecha, $hora, $whatsapp, $id_db);
            $stmt->execute();
        }
        echo "<script>alert('Información actualizada en todo el sistema'); window.location.href='?seccion=citas';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// 5. Consultas para la vista
$marcas_res = $conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
$tipos_res = $conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");

$eventos_google = $service->events->listEvents($calendarId, ['singleEvents' => true, 'orderBy' => 'startTime', 'timeMin' => date('c')])->getItems();

$citas_ocupadas = [];
foreach ($eventos_google as $ev) {
    $dt_start = $ev->start->dateTime ?: $ev->start->date;
    $fecha_ev = date('Y-m-d', strtotime($dt_start));
    $hora_ev = date('H:i', strtotime($dt_start));
    $citas_ocupadas[$fecha_ev][] = $hora_ev;
}
$json_ocupadas = json_encode($citas_ocupadas);

$sql_db = "SELECT c.*, m.marca, t.tipo 
           FROM citas_web c
           LEFT JOIN marcas m ON c.id_marca = m.id_marca
           LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
$res_db = $conexion->query($sql_db);

$mapa_db = [];
while ($f = $res_db->fetch_assoc()) {
    $mapa_db[strtoupper($f['nombre_cliente'] . " " . $f['apellido_cliente'])] = $f;
}
?>