<?php
/* CITAS_CIENTE_CONTROLLER.PHP */
/*
Este archivo actúa como el Controlador (Controller) principal para el proceso de agendamiento de citas del cliente.
*/

// Usamos dirname() para subir niveles en las carpetas y cargar Composer
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_model.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

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
    
    // AQUÍ ESTÁ LA MAGIA: Ya no concatenamos, los guardamos limpios
    $falla_lista = $_POST['problema_lista'];
    $falla_detalle = $_POST['problema_detalle'];
    
    $problema = $falla_lista; 
    $detalle_falla = $falla_detalle; // NUEVA VARIABLE
    
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];

    try {
        if ($modeloCita->verificarDisponibilidad($fecha, $hora)) {
            $horario_ocupado = true;
        } else {
            
            $nombre_marca_cal = ($id_marca == "12") ? $marca_otro : $modeloCita->obtenerNombreMarca($id_marca);
            $nombre_tipo_cal = ($id_tipo_equipo == "7") ? $tipo_equipo_otro : $modeloCita->obtenerNombreTipo($id_tipo_equipo);

            $client = new Client();
            $client->setAuthConfig(dirname(__DIR__, 2) . '/credenciales.json');
            $client->addScope(Calendar::CALENDAR);
            $service = new Calendar($client);
            $calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

            $start_time = $fecha . 'T' . $hora . ':00-06:00';
            $end_time = date('Y-m-d\TH:i:sP', strtotime($start_time . ' + 1 hour'));

            $event = new Event([
                'summary' => "SERVICIO: $nombreCompleto - $nombre_tipo_cal",
                // NUEVO: Se agrega el detalle a la descripción de Google Calendar
                'description' => "Marca: $nombre_marca_cal\nModelo: $modelo\nFalla: $problema\nDetalle: $detalle_falla\nWhatsApp: $whatsapp",
                'start' => ['dateTime' => $start_time, 'timeZone' => 'America/Mexico_City'],
                'end' => ['dateTime' => $end_time, 'timeZone' => 'America/Mexico_City'],
                'colorId' => '6', 
            ]);
            
            $evento_creado = $service->events->insert($calendarId, $event);
            $id_google_calendar = $evento_creado->getId();

            // NUEVO: Agregamos detalle_falla al compact para enviarlo al modelo
            $datosDB = compact('id_google_calendar', 'nombre', 'apellido', 'whatsapp', 'id_tipo_equipo', 'tipo_equipo_otro', 'id_marca', 'marca_otro', 'modelo', 'numero_serie', 'problema', 'detalle_falla', 'fecha', 'hora');
            
            $modeloCita->registrarCita($datosDB);

            try {
                $token = $_ENV['META_WA_TOKEN'];
                $phone_id = $_ENV['META_PHONE_ID'];
                
                $telefono_destino = "52" . ltrim($whatsapp, '+'); 

                $url = "https://graph.facebook.com/v25.0/" . $phone_id . "/messages";

                $data = [
                    "messaging_product" => "whatsapp",
                    "to" => $telefono_destino,
                    "type" => "template",
                    "template" => [
                        "name" => "confirmacion_cita_astech", 
                        "language" => [ "code" => "es_MX" ],  
                        "components" => [
                            [
                                "type" => "body",
                                "parameters" => [
                                    [ "type" => "text", "text" => $nombre ],      
                                    [ "type" => "text", "text" => $fecha ],       
                                    [ "type" => "text", "text" => $hora ]         
                                ]
                            ]
                        ]
                    ]
                ];

                $options = [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => [
                        "Authorization: Bearer " . $token,
                        "Content-Type: application/json"
                    ]
                ];

                $curl = curl_init();
                curl_setopt_array($curl, $options);
                $response = curl_exec($curl);
                curl_close($curl);

            } catch (Exception $e) { }

            $exito = true;
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

$query_tipos = $modeloCita->obtenerTiposFormulario();
$query_marcas = $modeloCita->obtenerMarcasFormulario();
$query_servicios = $modeloCita->obtenerServiciosActivos(); 
$json_relaciones = json_encode($modeloCita->obtenerRelaciones());
$json_ocupadas = json_encode($modeloCita->obtenerCitasOcupadas());

require_once dirname(__DIR__) . '/views/citas_cliente_view.php';
?>