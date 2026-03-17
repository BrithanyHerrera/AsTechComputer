<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

//--------------------------------------------
// CONEXIÓN A LA BASE DE DATOS
//--------------------------------------------

require_once '../config/conexion.db.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Twilio\Rest\Client as TwilioClient;

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
        //--------------------------------------------
        // FASE 0: VALIDAR DISPONIBILIDAD
        //--------------------------------------------
        $hora_bd = $hora . ":00"; 
        $check_sql = "SELECT id_cita FROM citas_web WHERE fecha_cita = ? AND hora_cita = ?";
        $check_stmt = $conexion->prepare($check_sql);
        $check_stmt->bind_param("ss", $fecha, $hora_bd);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            $check_stmt->close();
            die("<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                 <script>
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Horario Ocupado',
                            text: 'Este horario acaba de ser reservado. Elige otro, por favor.',
                            confirmButtonColor: '#e17203'
                        }).then(() => { window.history.back(); });
                    }, 100);
                 </script>");
        }
        $check_stmt->close();

        //--------------------------------------------
        // FASE 1: GUARDAR EN MYSQL
        //--------------------------------------------
        $sql = "INSERT INTO citas_web (nombre_cliente, apellido_cliente, whatsapp, id_tipo_equipo, tipo_equipo_otro, id_marca, marca_otro, modelo, numero_serie, problema_reportado, fecha_cita, hora_cita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssisissssss", $nombre, $apellido, $whatsapp, $id_tipo_equipo, $tipo_equipo_otro, $id_marca, $marca_otro, $modelo, $numero_serie, $problema, $fecha, $hora);
        
        if (!$stmt->execute()) { throw new Exception("Error DB: " . $stmt->error); }
        $stmt->close();

        //--------------------------------------------
        // FASE 2: TRADUCCIÓN PARA CALENDARIO
        //--------------------------------------------
        $query_marca = $conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'");
        $nombre_marca_cal = ($query_marca->num_rows > 0) ? $query_marca->fetch_assoc()['marca'] : $marca_otro;
        $query_tipo = $conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo_equipo'");
        $nombre_tipo_cal = ($query_tipo->num_rows > 0) ? $query_tipo->fetch_assoc()['tipo'] : $tipo_equipo_otro;

        //--------------------------------------------
        // FASE 3: GOOGLE CALENDAR
        //--------------------------------------------
        $client = new Client();
        $client->setAuthConfig(__DIR__ . '/../../credenciales.json');
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

        //--------------------------------------------
        // FASE 4: WHATSAPP (TWILIO)
        //--------------------------------------------
        try {
            $twilio = new TwilioClient($_ENV['TWILIO_SID'], $_ENV['TWILIO_TOKEN']);
            $twilio->messages->create('whatsapp:+521' . $whatsapp, [
                "from" => $_ENV['TWILIO_NUMBER'],
                "body" => "¡Hola $nombre! Tu cita en As Tech Computer para el $fecha a las $hora ha sido agendada con éxito."
            ]);
        } catch (Exception $e) { /* Silencioso */ }

        $exito = true;

    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Lato', sans-serif; background-color: #f4f4f4; }
    </style>
</head>
<body>

<?php if(isset($exito)): ?>
<script>
    let timerInterval;
    Swal.fire({
        icon: 'success',
        title: '¡Cita Agendada!',
        html: 'Tu solicitud se registró correctamente.<br>Serás redirigido en <b></b> milisegundos.',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        }
    }).then((result) => {
        window.location.href = 'cita_cliente.php';
    });
</script>
<?php endif; ?>

<?php if(isset($error_msg)): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error de Registro',
        text: '<?php echo $error_msg; ?>',
        confirmButtonText: 'Reintentar',
        confirmButtonColor: '#e17203'
    }).then(() => {
        window.history.back();
    });
</script>
<?php endif; ?>

</body>
</html>