<?php
/*  CITAS_CIENTE_CONTROLLER.PHP */
/*
Este archivo actúa como el Controlador (Controller) principal para el proceso de agendamiento de citas del cliente dentro de tu arquitectura MVC. Su trabajo es ser el "director de orquesta": primero, carga las librerías necesarias y tu modelo de base de datos. Si el cliente envía el formulario (POST), el controlador atrapa los datos, verifica que el horario no esté ocupado, crea el evento directamente en tu Google Calendar, guarda la copia en tu base de datos local y, finalmente, dispara un mensaje automático de confirmación vía WhatsApp usando la API de Meta. Al terminar, le pasa toda la información necesaria (marcas, servicios, horarios) a la Vista para que se dibuje en la pantalla.
*/

/* ==========================================
   1. IMPORTACIÓN DE DEPENDENCIAS Y CONFIGURACIONES
   ========================================== */
// Usamos dirname() para subir niveles en las carpetas y cargar Composer
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

// Carga de variables de entorno (Para versiones modernas v5.x)
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

// Conexión a la base de datos y modelo MVC
require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_model.php';

// Librerías exclusivas de Google Calendar (Meta API usa cURL nativo)
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

/* ==========================================
   2. INICIALIZACIÓN DEL MODELO
   ========================================== */
$modeloCita = new CitaModel($conexion);

/* ==========================================
   3. RECEPCIÓN Y PROCESAMIENTO DEL FORMULARIO (POST)
   ========================================== */
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
        /* ==========================================
           4. FASE 0: VALIDACIÓN DE DISPONIBILIDAD
           ========================================== */
        if ($modeloCita->verificarDisponibilidad($fecha, $hora)) {
            $horario_ocupado = true;
        } else {
            
            /* ==========================================
               5. FASE 1: TRADUCCIÓN DE DATOS PARA CALENDARIO
               ========================================== */
            $nombre_marca_cal = ($id_marca == "12") ? $marca_otro : $modeloCita->obtenerNombreMarca($id_marca);
            $nombre_tipo_cal = ($id_tipo_equipo == "7") ? $tipo_equipo_otro : $modeloCita->obtenerNombreTipo($id_tipo_equipo);

            /* ==========================================
               6. FASE 2: CREACIÓN DE EVENTO EN GOOGLE CALENDAR
               ========================================== */
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

            /* ==========================================
               7. FASE 3: GUARDAR REGISTRO EN BASE DE DATOS LOCAL
               ========================================== */
            $datosDB = compact('id_google_calendar', 'nombre', 'apellido', 'whatsapp', 'id_tipo_equipo', 'tipo_equipo_otro', 'id_marca', 'marca_otro', 'modelo', 'numero_serie', 'problema', 'fecha', 'hora');
            
            $modeloCita->registrarCita($datosDB);

            /* ==========================================
               8. FASE 4: ENVÍO DE CONFIRMACIÓN VÍA WHATSAPP (API META)
               ========================================== */
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

            } catch (Exception $e) { 
                /* Error silencioso para no impedir el registro de la cita si falla WhatsApp */ 
            }

            $exito = true;
        }
    } catch (Exception $e) {
        /* ==========================================
           9. MANEJO DE ERRORES GENERALES
           ========================================== */
        $error_msg = $e->getMessage();
    }
}

/* ==========================================
   10. OBTENER CATÁLOGOS Y DATOS PARA LA VISTA
   ========================================== */
$query_tipos = $modeloCita->obtenerTiposFormulario();
$query_marcas = $modeloCita->obtenerMarcasFormulario();
$query_servicios = $modeloCita->obtenerServiciosActivos(); 
$json_relaciones = json_encode($modeloCita->obtenerRelaciones());
$json_ocupadas = json_encode($modeloCita->obtenerCitasOcupadas());

/* ==========================================
   11. CARGAR LA VISTA DEL CLIENTE (RENDER)
   ========================================== */
require_once dirname(__DIR__) . '/views/citas_cliente_view.php';
?>