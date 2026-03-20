<?php
// Usamos dirname() para subir niveles en las carpetas. 
// El controlador está en htdocs/app/controllers/

// Subimos 3 niveles para llegar a la raíz de AsTechComputer y entrar a vendor
require_once dirname(__DIR__, 3) . '/vendor/autoload.php';

// Subimos 3 niveles para salir de controllers -> app -> htdocs y llegar a AsTechComputer
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3));
$dotenv->load();

// Subimos 1 nivel (a la carpeta app) y entramos a config y models
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_model.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Twilio\Rest\Client as TwilioClient;

$modeloCita = new CitaModel($conexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre_cliente'];
    $apellido = $_POST['apellido_cliente'];
    $nombreCompleto = $nombre . " " . $apellido;
    $whatsapp = $_POST['whatsapp'];

    $id_tipo_equipo = $_POST['tipo_dispositivo'];
    $tipo_equipo_otro = ($_POST['tipo_dispositivo'] == "7") ? $_POST['otro_tipo_texto'] : null;

    $id_marca = $_POST['marca'];
    $marca_otro = ($_POST['marca'] == "12") ? $_POST['otra_marca_texto'] : null;

    $modelo = $_POST['modelo'];
    $numero_serie = !empty($_POST['numero_serie']) ? $_POST['numero_serie'] : null;
    
    $falla_lista = $_POST['problema_lista'];
    $falla_detalle = $_POST['problema_detalle'];
    $problema = (!empty($falla_lista)) ? strtoupper($falla_lista) . ": " . $falla_detalle : $falla_detalle;
    
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];

    try {
        // FASE 0: VALIDAR DISPONIBILIDAD
        if ($modeloCita->verificarDisponibilidad($fecha, $hora)) {
            $horario_ocupado = true;
        } else {
            // FASE 1: GUARDAR EN MYSQL
            $datosDB = compact('nombre', 'apellido', 'whatsapp', 'id_tipo_equipo', 'tipo_equipo_otro', 'id_marca', 'marca_otro', 'modelo', 'numero_serie', 'problema', 'fecha', 'hora');
            $modeloCita->registrarCita($datosDB);

            // FASE 2: TRADUCCIÓN PARA CALENDARIO
            $nombre_marca_cal = ($id_marca == "12") ? $marca_otro : $modeloCita->obtenerNombreMarca($id_marca);
            $nombre_tipo_cal = ($id_tipo_equipo == "7") ? $tipo_equipo_otro : $modeloCita->obtenerNombreTipo($id_tipo_equipo);

            // FASE 3: GOOGLE CALENDAR
            $client = new Client();
            // Subimos 2 niveles (hasta htdocs) para encontrar el JSON
            $client->setAuthConfig(dirname(__DIR__, 2) . '/credenciales.json');
            $client->addScope(Calendar::CALENDAR);
            $service = new Calendar($client);
            $calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

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

            // FASE 4: WHATSAPP (TWILIO)
            try {
                $twilio = new TwilioClient($_ENV['TWILIO_SID'], $_ENV['TWILIO_TOKEN']);
                $twilio->messages->create('whatsapp:+521' . $whatsapp, [
                    "from" => $_ENV['TWILIO_NUMBER'],
                    "body" => "¡Hola $nombre! Tu cita en As Tech Computer para el $fecha a las $hora ha sido agendada con éxito."
                ]);
            } catch (Exception $e) { /* Silencioso */ }

            $exito = true;
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

// ==========================================
// OBTENER CATÁLOGOS PARA LA VISTA
// ==========================================
$query_tipos = $modeloCita->obtenerTiposFormulario();
$query_marcas = $modeloCita->obtenerMarcasFormulario();
$json_relaciones = json_encode($modeloCita->obtenerRelaciones());
$json_ocupadas = json_encode($modeloCita->obtenerCitasOcupadas());

// CARGAR LA VISTA DEL CLIENTE
require_once dirname(__DIR__) . '/views/citas_cliente_view.php';
?>
?>