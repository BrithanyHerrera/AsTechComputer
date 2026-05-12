<?php
/* CITAS_CLIENTE_CONTROLLER.PHP */
/*
 * PÁGINA: Controlador de Citas del Cliente - As Tech Computer
 * PROPÓSITO: Operar como el cerebro (Controller) principal para el flujo de agendamiento desde la perspectiva del usuario.
 * FUNCIONALIDADES: 
 * - Recepción y limpieza de datos provenientes del formulario de citas (POST).
 * - Validación de disponibilidad horaria consultando el modelo de la base de datos para evitar sobreescrituras.
 * - Inserción y sincronización del registro en la API de Google Calendar, integrando detalles técnicos y fallas en la descripción del evento.
 * - Registro persistente de la información del cliente, equipo y cita en la base de datos local (MySQL).
 * - Disparo de notificaciones automáticas de confirmación vía WhatsApp utilizando la API oficial de Meta (Graph API).
 * - Inyección de catálogos (tipos de equipo, marcas, servicios y horarios ocupados) hacia la Vista para la correcta renderización del formulario interactivo.
 */

/* ========================================================
   1. CARGA DE DEPENDENCIAS Y VARIABLES DE ENTORNO (APIs)
   ======================================================== */
/**
 * Se utiliza dirname() para establecer una ruta absoluta y segura 
 * hacia las configuraciones globales y las librerías de Composer.
 * Esto habilita el uso de las APIs de Google y la lectura de 
 * variables de entorno (.env) para proteger credenciales sensibles.
 */
require_once __DIR__ . "/../config/config.php"; 
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

require_once dirname(__DIR__) . '/config/conexion.db.php';
require_once dirname(__DIR__) . '/models/citas_model.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

/* ========================================================
   2. INSTANCIACIÓN DEL MODELO DE BASE DE DATOS
   ======================================================== */
/**
 * Se crea una instancia del modelo CitaModel, inyectándole la conexión.
 * Este objeto manejará de forma exclusiva todas las consultas SQL 
 * relacionadas con la gestión de citas.
 */
$modeloCita = new CitaModel($conexion);

/* ========================================================
   3. RECEPCIÓN Y LIMPIEZA DE DATOS (MÉTODO POST)
   ======================================================== */
/**
 * El sistema detecta si se ha enviado el formulario mediante POST 
 * e inicia la captura y asignación de variables.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aplicamos trim() a los campos obligatorios
    $nombre = trim($_POST['nombre_cliente'] ?? '');
    $apellido = trim($_POST['apellido_cliente'] ?? '');
    $nombreCompleto = $nombre . " " . $apellido;
    $whatsapp = trim($_POST['whatsapp'] ?? '');

    $id_tipo_equipo = $_POST['tipo_dispositivo'];
    $tipo_equipo_otro = ($_POST['tipo_dispositivo'] == "7") ? trim($_POST['otro_tipo_texto'] ?? '') : null;

    $id_marca = $_POST['marca'];
    $marca_otro = ($_POST['marca'] == "12") ? trim($_POST['otra_marca_texto'] ?? '') : null;

    // Aplicamos trim() a los campos opcionales y asignamos "N/V" si quedan vacíos
    $modelo = !empty(trim($_POST['modelo'] ?? '')) ? trim($_POST['modelo']) : 'N/V';
    $numero_serie = !empty(trim($_POST['numero_serie'] ?? '')) ? trim($_POST['numero_serie']) : 'N/V';
    
    // Se extraen y separan correctamente los datos de la falla técnica
    $falla_lista = $_POST['problema_lista']; // Este proviene de un <select>
    $falla_detalle = !empty(trim($_POST['problema_detalle'] ?? '')) ? trim($_POST['problema_detalle']) : 'N/V';
    
    $problema = $falla_lista; 
    $detalle_falla = $falla_detalle; 
    
    $fecha = $_POST['fecha_cita'];
    $hora = $_POST['hora_cita'];

    try {
        /* ========================================================
           4. VALIDACIÓN DE DISPONIBILIDAD HORARIA (BACKEND)
           ======================================================== */
        /**
         * Se consulta al modelo si la fecha y hora seleccionadas aún están libres.
         * Si el horario está tomado, se levanta una bandera; de lo contrario, 
         * continúa el proceso de agendamiento.
         */
        if ($modeloCita->verificarDisponibilidad($fecha, $hora)) {
            $horario_ocupado = true;
        } else {
            
            /* ========================================================
               5. SINCRONIZACIÓN CON GOOGLE CALENDAR API
               ======================================================== */
            /**
             * Se traducen los IDs numéricos a texto plano utilizando el modelo,
             * para asegurar que el evento en el calendario sea legible por humanos.
             */
            $nombre_marca_cal = ($id_marca == "12") ? $marca_otro : $modeloCita->obtenerNombreMarca($id_marca);
            $nombre_tipo_cal = ($id_tipo_equipo == "7") ? $tipo_equipo_otro : $modeloCita->obtenerNombreTipo($id_tipo_equipo);

            // Se inicializa el cliente de Google y se asocian las credenciales JSON de la cuenta de servicio
            $client = new Client();
            $client->setAuthConfig(dirname(__DIR__, 2) . '/credenciales.json');
            $client->addScope(Calendar::CALENDAR);
            $service = new Calendar($client);
            $calendarId = $_ENV['CALENDAR_ID'];

            // Se calcula el tiempo de inicio y fin (asumiendo una duración estándar de 1 hora por cita).
            $start_time = $fecha . 'T' . $hora . ':00-06:00';
            $end_time = date('Y-m-d\TH:i:sP', strtotime($start_time . ' + 1 hour'));

            // Se estructura el evento, integrando el campo $detalle_falla en la descripción para mayor contexto.
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
               6. REGISTRO EN LA BASE DE DATOS LOCAL
               ======================================================== */
            /**
             * Se empaquetan todas las variables procesadas (incluyendo el ID de Google) 
             * utilizando compact(), y se envían al modelo para su persistencia en MySQL.
             */
            $datosDB = compact('id_google_calendar', 'nombre', 'apellido', 'whatsapp', 'id_tipo_equipo', 'tipo_equipo_otro', 'id_marca', 'marca_otro', 'modelo', 'numero_serie', 'problema', 'detalle_falla', 'fecha', 'hora');
            
            $modeloCita->registrarCita($datosDB);

            /* ========================================================
               7. NOTIFICACIÓN AUTOMÁTICA VÍA META WHATSAPP API
               ======================================================== */
            /**
             * Se intenta enviar un mensaje de confirmación al cliente utilizando la API 
             * oficial de Meta. Este bloque está envuelto en un try-catch silencioso 
             * para que un fallo en WhatsApp no interrumpa el éxito del agendamiento.
             */
            try {
                // Se extraen las credenciales desde las variables de entorno.
                $token = $_ENV['META_WA_TOKEN'];
                $phone_id = $_ENV['META_PHONE_ID'];
                
                // Se limpia cualquier espacio o guion extra
                $numero_limpio = preg_replace('/[^0-9]/', '', $whatsapp);

                // Si el usuario ingresó sus 10 dígitos locales, le agregamos 521 (Formato Meta para México)
                if (strlen($numero_limpio) == 10) {
                    $telefono_destino = "521" . $numero_limpio;
                } else {
                    // Si metió más números (por si ya traía el 52 o es extranjero), lo dejamos pasar tal cual
                    $telefono_destino = $numero_limpio; 
                }

                $url = "https://graph.facebook.com/v25.0/" . $phone_id . "/messages";

                // Se construye el payload JSON invocando la plantilla preaprobada de confirmación.
                $data = [
                    "messaging_product" => "whatsapp",
                    "to" => $telefono_destino,
                    "type" => "template",
                    "template" => [
                        "name" => "confirmacion_cita_v2", 
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

                // Configuración de cabeceras cURL y ejecución de la petición HTTP POST.
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
                // Excepciones de red o API silenciadas por diseño.
            }

            // Se levanta la bandera de éxito para que la vista despliegue el mensaje final (SweetAlert).
            $exito = true;
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

/* ========================================================
   8. EXTRACCIÓN DE CATÁLOGOS PARA EL FORMULARIO (GET/POST)
   ======================================================== */
/**
 * Independientemente de si se envió el formulario (POST) o si es 
 * la carga inicial (GET), el sistema extrae de la base de datos 
 * los catálogos y relaciones necesarios para dibujar los selects en el HTML.
 */
$query_tipos = $modeloCita->obtenerTiposFormulario();
$query_marcas = $modeloCita->obtenerMarcasFormulario();
$query_servicios = $modeloCita->obtenerServiciosActivos(); 
$json_relaciones = json_encode($modeloCita->obtenerRelaciones());
$json_ocupadas = json_encode($modeloCita->obtenerCitasOcupadas());

/* ========================================================
   9. RENDERIZACIÓN DE LA VISTA (UI)
   ======================================================== */
// Se integra el archivo visual, pasando todas las variables procesadas al Frontend.
require_once dirname(__DIR__) . '/views/citas_cliente_view.php';
?>