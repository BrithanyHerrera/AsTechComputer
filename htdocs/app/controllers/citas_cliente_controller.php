<?php
/* CITAS_CLIENTE_CONTROLLER.PHP */
/*
Este archivo opera como el Controlador (Controller) principal para el flujo de agendamiento desde la perspectiva del usuario. Su labor consiste en recibir los datos del formulario (POST), validar la disponibilidad de horarios a través del modelo de la base de datos, insertar el registro sincronizado en la API de Google Calendar (incluyendo ahora el campo de detalle de la falla), guardar la información en la base de datos local y, finalmente, accionar el envío automático de un mensaje de confirmación mediante la API de WhatsApp de Meta. Por último, inyecta los datos de catálogos necesarios para que la Vista (interfaz gráfica) se dibuje correctamente.
*/

/* ========================================================
   CARGA DE DEPENDENCIAS Y VARIABLES DE ENTORNO (APIs)
   ======================================================== */
// Se utiliza dirname() para establecer una ruta absoluta hacia las librerías de Composer.
// Esto permite utilizar las APIs de Google y la lectura de variables de entorno (.env) de forma segura.
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_model.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

/* ========================================================
   INSTANCIACIÓN DEL MODELO DE BASE DE DATOS
   ======================================================== */
// Se crea una instancia del modelo para manejar las consultas SQL relacionadas con las citas.
$modeloCita = new CitaModel($conexion);

/* ========================================================
   RECEPCIÓN Y LIMPIEZA DE DATOS (MÉTODO POST)
   ======================================================== */
// El sistema detecta si se ha enviado el formulario e inicia la captura de variables.
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
    
    // Se extraen y separan correctamente los datos de la falla técnica sin concatenarlos
    $falla_lista = $_POST['problema_lista'];
    $falla_detalle = $_POST['problema_detalle'];
    
    $problema = $falla_lista; 
    $detalle_falla = $falla_detalle; 
    
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];

    try {
        /* ========================================================
           VALIDACIÓN DE DISPONIBILIDAD HORARIA (BACKEND)
           ======================================================== */
        // Se consulta al modelo si la fecha y hora seleccionadas aún están libres.
        if ($modeloCita->verificarDisponibilidad($fecha, $hora)) {
            $horario_ocupado = true;
        } else {
            
            /* ========================================================
               SINCRONIZACIÓN CON GOOGLE CALENDAR API
               ======================================================== */
            // Se traducen los IDs a texto plano para que el calendario sea legible.
            $nombre_marca_cal = ($id_marca == "12") ? $marca_otro : $modeloCita->obtenerNombreMarca($id_marca);
            $nombre_tipo_cal = ($id_tipo_equipo == "7") ? $tipo_equipo_otro : $modeloCita->obtenerNombreTipo($id_tipo_equipo);

            // Se inicializa el cliente de Google y se cargan las credenciales JSON.
            $client = new Client();
            $client->setAuthConfig(dirname(__DIR__, 2) . '/credenciales.json');
            $client->addScope(Calendar::CALENDAR);
            $service = new Calendar($client);
            $calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

            // Se calcula el tiempo de inicio y fin (duración estándar de 1 hora).
            $start_time = $fecha . 'T' . $hora . ':00-06:00';
            $end_time = date('Y-m-d\TH:i:sP', strtotime($start_time . ' + 1 hour'));

            // Se estructura el evento, integrando ahora el campo $detalle_falla en la descripción.
            $event = new Event([
                'summary' => "SERVICIO: $nombreCompleto - $nombre_tipo_cal",
                'description' => "Marca: $nombre_marca_cal\nModelo: $modelo\nFalla: $problema\nDetalle: $detalle_falla\nWhatsApp: $whatsapp",
                'start' => ['dateTime' => $start_time, 'timeZone' => 'America/Mexico_City'],
                'end' => ['dateTime' => $end_time, 'timeZone' => 'America/Mexico_City'],
                'colorId' => '6', 
            ]);
            
            // Se ejecuta la inserción en la API y se recupera el ID único generado por Google.
            $evento_creado = $service->events->insert($calendarId, $event);
            $id_google_calendar = $evento_creado->getId();

            /* ========================================================
               REGISTRO EN LA BASE DE DATOS LOCAL
               ======================================================== */
            // Se empaquetan todas las variables, incluyendo el nuevo campo $detalle_falla, para enviarlas al modelo.
            $datosDB = compact('id_google_calendar', 'nombre', 'apellido', 'whatsapp', 'id_tipo_equipo', 'tipo_equipo_otro', 'id_marca', 'marca_otro', 'modelo', 'numero_serie', 'problema', 'detalle_falla', 'fecha', 'hora');
            
            $modeloCita->registrarCita($datosDB);

            /* ========================================================
               NOTIFICACIÓN AUTOMÁTICA VÍA META WHATSAPP API
               ======================================================== */
            try {
                // Se leen las credenciales secretas del archivo .env.
                $token = $_ENV['META_WA_TOKEN'];
                $phone_id = $_ENV['META_PHONE_ID'];
                
                // Se formatea el número añadiendo la lada de México (52) y retirando símbolos '+'.
                $telefono_destino = "52" . ltrim($whatsapp, '+'); 

                $url = "https://graph.facebook.com/v25.0/" . $phone_id . "/messages";

                // Se construye el cuerpo JSON para invocar la plantilla preaprobada de confirmación.
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

                // Se configuran las cabeceras cURL y se dispara la petición HTTP POST hacia los servidores de Meta.
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

            } catch (Exception $e) { 
                // Los errores de WhatsApp se silencian para no interrumpir el flujo si la API falla.
            }

            // Se levanta la bandera de éxito para que la vista renderice el mensaje de confirmación (SweetAlert).
            $exito = true;
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

/* ========================================================
   EXTRACCIÓN DE DATOS COMPLEMENTARIOS PARA EL FORMULARIO
   ======================================================== */
// Independientemente de si se envió el POST o no, el sistema debe cargar los catálogos 
// de la base de datos para dibujar los menús desplegables (<select>) en el HTML.
$query_tipos = $modeloCita->obtenerTiposFormulario();
$query_marcas = $modeloCita->obtenerMarcasFormulario();
$query_servicios = $modeloCita->obtenerServiciosActivos(); 
$json_relaciones = json_encode($modeloCita->obtenerRelaciones());
$json_ocupadas = json_encode($modeloCita->obtenerCitasOcupadas());

/* ========================================================
   RENDERIZACIÓN DE LA VISTA (UI)
   ======================================================== */
// Se llama al archivo visual para presentar el formulario final al usuario.
require_once dirname(__DIR__) . '/views/citas_cliente_view.php';
?>