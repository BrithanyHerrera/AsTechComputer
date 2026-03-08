<?php
// Carga de librerías y dependencias de Google
require_once __DIR__ . '/../../../vendor/autoload.php';

// 1. INCLUIR TU CONEXIÓN A LA BASE DE DATOS
// Ajusta esta ruta si tu archivo conexion.db.php está en otra carpeta
require_once '../config/conexion.db.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ====================================================================
    // RECEPCIÓN DE DATOS DEL FORMULARIO
    // ====================================================================
    $nombre = $_POST['nombre_cliente'];
    $apellido = $_POST['apellido_cliente'];
    $nombreCompleto = $nombre . " " . $apellido;
    $whatsapp = $_POST['whatsapp'];

    // Recepción de IDs de catálogo
    $id_tipo_equipo = $_POST['tipo_dispositivo'];
    $tipo_equipo_otro = ($_POST['tipo_dispositivo'] == "7") ? $_POST['otro_tipo_texto'] : null;

    $id_marca = $_POST['marca'];
    $marca_otro = ($_POST['marca'] == "12") ? $_POST['otra_marca_texto'] : null;

    $modelo = $_POST['modelo'];
    $numero_serie = !empty($_POST['numero_serie']) ? $_POST['numero_serie'] : null;
    $problema = ($_POST['problema_lista'] == "Otro") ? $_POST['problema_detalle'] : $_POST['problema_lista'];
    
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];

    try {
        // ====================================================================
        // FASE 1: GUARDAR EN LA BASE DE DATOS LOCAL (MySQL) Segurizado
        // ====================================================================
        $sql = "INSERT INTO citas_web (nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, tipo_equipo_otro, id_marca, marca_otro, modelo, numero_serie, problema_reportado, fecha_cita, hora_cita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        // "sssisissssss" indica: string, string, string, int, string, int, string, string, string, string, string, string
        $stmt->bind_param("sssisissssss", $nombre, $apellido, $whatsapp, $id_tipo_equipo, $tipo_equipo_otro, $id_marca, $marca_otro, $modelo, $numero_serie, $problema, $fecha, $hora);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar en la Base de Datos: " . $stmt->error);
        }
        $stmt->close();

        // ====================================================================
        // FASE 2: TRADUCIR LOS IDs A TEXTO PARA EL CALENDARIO DE GOOGLE
        // ====================================================================
        // Obtenemos el nombre real de la marca para el calendario
        $query_marca = $conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        $nombre_marca_cal = ($query_marca->num_rows > 0) ? $query_marca->fetch_assoc()['marca'] : $marca_otro;

        // Obtenemos el nombre real del tipo de equipo para el calendario
        $query_tipo = $conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo_equipo'");
        $nombre_tipo_cal = ($query_tipo->num_rows > 0) ? $query_tipo->fetch_assoc()['tipo'] : $tipo_equipo_otro;

        // ====================================================================
        // FASE 3: ENVIAR A GOOGLE CALENDAR
        // ====================================================================
        $client = new Client();
        $client->setAuthConfig(__DIR__ . '/../../credenciales.json');
        $client->addScope(Calendar::CALENDAR);
        
        $service = new Calendar($client);
        $calendarId = '073f18605ef849562a5cefd2c7e615d7a31c89ec5a89903939db694542a6f419@group.calendar.google.com';

        $start_time = $fecha . 'T' . $hora . ':00-06:00';
        $end_time = date('Y-m-d\TH:i:sP', strtotime($start_time . ' + 1 hour'));

        $event = new Event([
            'summary' => "SERVICIO: $nombreCompleto - $nombre_tipo_cal",
            'description' => "Marca: $nombre_marca_cal\nModelo: $modelo\nFalla: $problema\nWhatsApp: $whatsapp",
            'start' => ['dateTime' => $start_time, 'timeZone' => 'America/Mexico_City'],
            'end' => ['dateTime' => $end_time, 'timeZone' => 'America/Mexico_City'],
            'colorId' => '6', 
        ]);

        $service->events->insert($calendarId, $event);

        // Si todo sale bien, mostramos alerta y redirigimos
        echo "<script>alert('Cita agendada correctamente.'); window.location.href='cita_cliente.php';</script>";

    } catch (Exception $e) {
        // En caso de error, muestra qué falló para poder arreglarlo
        echo "Error del sistema: " . $e->getMessage();
    }
}
?>