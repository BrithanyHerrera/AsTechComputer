<?php
// Carga de librerías y dependencias (Google y Twilio)
require_once __DIR__ . '/../../../vendor/autoload.php';

// Cargar las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

// 1. INCLUIR TU CONEXIÓN A LA BASE DE DATOS
require_once '../config/conexion.db.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Twilio\Rest\Client as TwilioClient; // Librería de Twilio

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

    // Iniciamos el bloque de intentos principal
    try {
        // ====================================================================
        // FASE 0: VALIDAR QUE EL HORARIO SIGA DISPONIBLE (Antichoque)
        // ====================================================================
        $hora_bd = $hora . ":00"; // Agregamos los segundos para buscar exacto en MySQL
        $check_sql = "SELECT id_cita FROM citas_web WHERE fecha_cita = ? AND hora_cita = ?";
        $check_stmt = $conexion->prepare($check_sql);
        $check_stmt->bind_param("ss", $fecha, $hora_bd);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            $check_stmt->close();
            // Si el horario ya existe, expulsamos al cliente de vuelta con un mensaje de error
            die("<script>alert('Lo sentimos, alguien acaba de reservar las $hora. Por favor, elige otro horario.'); window.history.back();</script>");
        }
        $check_stmt->close();

        // ====================================================================
        // FASE 1: GUARDAR EN LA BASE DE DATOS LOCAL (MySQL) Segurizado
        // ====================================================================
        $sql = "INSERT INTO citas_web (nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, tipo_equipo_otro, id_marca, marca_otro, modelo, numero_serie, problema_reportado, fecha_cita, hora_cita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssisissssss", $nombre, $apellido, $whatsapp, $id_tipo_equipo, $tipo_equipo_otro, $id_marca, $marca_otro, $modelo, $numero_serie, $problema, $fecha, $hora);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar en la Base de Datos: " . $stmt->error);
        }
        $stmt->close();

        // ====================================================================
        // FASE 2: TRADUCIR LOS IDs A TEXTO PARA EL CALENDARIO Y WHATSAPP
        // ====================================================================
        $query_marca = $conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        $nombre_marca_cal = ($query_marca->num_rows > 0) ? $query_marca->fetch_assoc()['marca'] : $marca_otro;

        $query_tipo = $conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo_equipo'");
        $nombre_tipo_cal = ($query_tipo->num_rows > 0) ? $query_tipo->fetch_assoc()['tipo'] : $tipo_equipo_otro;

        // ====================================================================
        // FASE 3: ENVIAR A GOOGLE CALENDAR
        // ====================================================================
        $client = new Client();
        // Cuidado aquí: revisa si esta ruta a tus credenciales.json es la correcta (2 saltos hacia atrás)
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

        // ====================================================================
        // FASE 4: ENVIAR MENSAJE DE WHATSAPP (Twilio)
        // ====================================================================
        try {
            // Ahora usamos $_ENV para obtener las llaves de forma segura
            $twilio_sid    = $_ENV['TWILIO_SID'];
            $twilio_token  = $_ENV['TWILIO_TOKEN'];
            $twilio_number = $_ENV['TWILIO_NUMBER'];

            $twilio = new TwilioClient($twilio_sid, $twilio_token);

            $numero_destino = 'whatsapp:+521' . $whatsapp; 

            $mensaje_texto = "¡Hola $nombre!\n\n"
                           . "Tu solicitud de servicio en As Tech Computer ha sido recibida y agendada.\n"
                           . "📅 Fecha: $fecha\n"
                           . "⏰ Hora: $hora\n"
                           . "💻 Equipo: $nombre_marca_cal $modelo\n\n"
                           . "¡Te esperamos!";

            $twilio->messages->create(
                $numero_destino,
                [
                    "from" => $twilio_number,
                    "body" => $mensaje_texto
                ]
            );
        } catch (Exception $e) {
            die("<h3 style='color:red;'>Error de Twilio: " . $e->getMessage() . "</h3>");
        }

        // ====================================================================
        // REDIRECCIÓN FINAL
        // ====================================================================
        echo "<script>alert('Cita agendada correctamente.'); window.location.href='cita_cliente.php';</script>";

    } catch (Exception $e) {
        // Este catch atrapa los errores de la BD (Fase 1) o de Google Calendar (Fase 3)
        echo "Error del sistema: " . $e->getMessage();
    }
}
?>