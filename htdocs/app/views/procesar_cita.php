<?php
// Carga de librerías y dependencias
require_once __DIR__ . '/../../../vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // RECEPCIÓN DE NOMBRE Y APELLIDO
    $nombre = $_POST['nombre_cliente'];
    $apellido = $_POST['apellido_cliente'];
    $nombreCompleto = $nombre . " " . $apellido;

    $whatsapp = $_POST['whatsapp'];
    $dispositivo = $_POST['tipo_dispositivo'];
    $marca = ($_POST['marca'] == "Otro") ? $_POST['otra_marca_texto'] : $_POST['marca'];
    $modelo = $_POST['modelo'];
    $problema = ($_POST['problema_lista'] == "Otro") ? $_POST['problema_detalle'] : $_POST['problema_lista'];
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];

    try {
        $client = new Client();
        // Ruta a las credenciales en la raíz de htdocs
        $client->setAuthConfig(__DIR__ . '/../../credenciales.json');
        $client->addScope(Calendar::CALENDAR);
        
        $service = new Calendar($client);
        // ID del calendario PruebaAsTechComputer
        $calendarId = '073f18605ef849562a5cefd2c7e615d7a31c89ec5a89903939db694542a6f419@group.calendar.google.com';

        // Formatear tiempos para México (RFC3339)
        $start_time = $fecha . 'T' . $hora . ':00-06:00';
        $end_time = date('Y-m-d\TH:i:sP', strtotime($start_time . ' + 1 hour'));

        $event = new Event([
            'summary' => "SERVICIO: $nombreCompleto - $dispositivo",
            'description' => "Marca: $marca\nModelo: $modelo\nFalla: $problema\nWhatsApp: $whatsapp",
            'start' => ['dateTime' => $start_time, 'timeZone' => 'America/Mexico_City'],
            'end' => ['dateTime' => $end_time, 'timeZone' => 'America/Mexico_City'],
            'colorId' => '6', 
        ]);

        $service->events->insert($calendarId, $event);

        echo "<script>alert('Cita agendada correctamente.'); window.location.href='cita_cliente.php';</script>";

    } catch (Exception $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}