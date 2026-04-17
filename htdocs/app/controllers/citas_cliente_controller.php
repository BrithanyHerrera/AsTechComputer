<?php
// Usamos dirname() para subir niveles en las carpetas. 
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

// Para versiones modernas (v5.x)
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_model.php';

// Solo dejamos las librerías de Google. Meta API funciona nativamente con cURL de PHP.
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
            
            // FASE 1: TRADUCCIÓN PARA CALENDARIO
            $nombre_marca_cal = ($id_marca == "12") ? $marca_otro : $modeloCita->obtenerNombreMarca($id_marca);
            $nombre_tipo_cal = ($id_tipo_equipo == "7") ? $tipo_equipo_otro : $modeloCita->obtenerNombreTipo($id_tipo_equipo);

            // FASE 2: GOOGLE CALENDAR
            $client = new Client();
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
            
            $evento_creado = $service->events->insert($calendarId, $event);
            $id_google_calendar = $evento_creado->getId();

            // FASE 3: GUARDAR EN MYSQL
            $datosDB = compact('id_google_calendar', 'nombre', 'apellido', 'whatsapp', 'id_tipo_equipo', 'tipo_equipo_otro', 'id_marca', 'marca_otro', 'modelo', 'numero_serie', 'problema', 'fecha', 'hora');
            
            $modeloCita->registrarCita($datosDB);

            // FASE 4: WHATSAPP (API OFICIAL META CON PLANTILLA)
            try {
                // Las variables ocultas de tu archivo .env
                $token = $_ENV['META_WA_TOKEN'];
                $phone_id = $_ENV['META_PHONE_ID'];
                
                // Meta requiere el código de país (52 para México) sin el signo de '+'
                $telefono_destino = "52" . ltrim($whatsapp, '+'); 

                // Endpoint de la API Graph v25.0
                $url = "https://graph.facebook.com/v25.0/" . $phone_id . "/messages";

                // Armado del JSON para la plantilla aprobada
                $data = [
                    "messaging_product" => "whatsapp",
                    "to" => $telefono_destino,
                    "type" => "template",
                    "template" => [
                        "name" => "confirmacion_cita_astech", // Nombre exacto de tu plantilla en Meta
                        "language" => [ "code" => "es_MX" ],  // O el que hayas usado, ej. 'es'
                        "components" => [
                            [
                                "type" => "body",
                                "parameters" => [
                                    [ "type" => "text", "text" => $nombre ],      // Valor para {{1}}
                                    [ "type" => "text", "text" => $fecha ],       // Valor para {{2}}
                                    [ "type" => "text", "text" => $hora ]         // Valor para {{3}}
                                ]
                            ]
                        ]
                    ]
                ];

                // Petición cURL hacia los servidores de Facebook
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
                // Si algo falla, el response de Meta te dice por qué (ideal para revisar los logs de InfinityFree)
                curl_close($curl);

            } catch (Exception $e) { /* Silencioso para que no impida agendar la cita */ }

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
$query_servicios = $modeloCita->obtenerServiciosActivos(); // NUEVA LÍNEA: Traemos los servicios
$json_relaciones = json_encode($modeloCita->obtenerRelaciones());
$json_ocupadas = json_encode($modeloCita->obtenerCitasOcupadas());

// CARGAR LA VISTA DEL CLIENTE
require_once dirname(__DIR__) . '/views/citas_cliente_view.php';
?>