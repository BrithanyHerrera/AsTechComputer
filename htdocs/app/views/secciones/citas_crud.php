<?php
// ===============================
// 1. CARGAR AUTOLOAD Y CONEXIÓN
// ===============================
// Respetando tu ruta: htdocs/../vendor/autoload.php
$autoload_path = $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

if (!file_exists($autoload_path)) {
    die("Error Crítico: No se encontró vendor/autoload.php en: " . $autoload_path);
}

require_once $autoload_path;
// Incluimos tu conexión dinámica (Local/Producción)
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/conexion.db.php'; 

use Google\Client;
use Google\Service\Calendar;

// ===============================
// 2. CONFIGURAR CLIENTE GOOGLE
// ===============================
$client = new Client();
$ruta_credenciales = $_SERVER['DOCUMENT_ROOT'] . '/credenciales.json';

if (!file_exists($ruta_credenciales)) {
    die("Error Crítico: No se encuentra credenciales.json en: " . $ruta_credenciales);
}

$client->setAuthConfig($ruta_credenciales);
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);

$calendarId = '073f18605ef849562a5cefd2c7e615d7a31c89ec5a89903939db694542a6f419@group.calendar.google.com';

// ===============================
// 3. LÓGICA ELIMINAR (DB + GOOGLE)
// ===============================
if (isset($_GET['delete_id'])) {
    $id_para_google = $_GET['delete_id']; // El ID que viene de Google
    $id_para_db = isset($_GET['db_id']) ? $_GET['db_id'] : null;

    try {
        // Eliminar de Google Calendar
        $service->events->delete($calendarId, $id_para_google);

        // Si tenemos el ID de la base de datos, lo borramos también
        if ($id_para_db) {
            $stmt = $conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
            $stmt->bind_param("i", $id_para_db);
            $stmt->execute();
            $stmt->close();
        }

        echo "<script>
        alert('Cita eliminada de Google Calendar y Base de Datos');
        window.location.href='?seccion=citas';
        </script>";

    } catch (Exception $e) {
        echo "<script>alert('Error al eliminar: " . $e->getMessage() . "');</script>";
    }
}

// ===============================
// 4. OBTENER EVENTOS Y DATOS DB
// ===============================
try {
    // Obtenemos eventos de Google
    $eventos_google = $service->events->listEvents($calendarId, [
        'maxResults' => 20,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c')
    ])->getItems();

    // Consultamos la DB con JOIN para traer nombres de marcas y equipos
    $sql_db = "SELECT c.id_cita, c.nombre_cliente, c.apellido_cliente, m.marca, t.tipo 
               FROM citas_web c
               LEFT JOIN marcas m ON c.id_marca = m.id_marca
               LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
    $res_db = $conexion->query($sql_db);
    
    // Creamos un mapa para vincular Google con la DB por el nombre del cliente
    $mapa_db = [];
    while($fila = $res_db->fetch_assoc()){
        $key = strtoupper($fila['nombre_cliente'] . " " . $fila['apellido_cliente']);
        $mapa_db[$key] = $fila['id_cita'];
    }

} catch (Exception $e) {
    die("Error al conectar con los servicios: " . $e->getMessage());
}
?>

<div class="contenedor-crud">
    <div class="tabla-responsiva">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Cliente / Servicio</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($eventos_google)): ?>
                    <tr><td colspan="5">No hay citas próximas en el calendario.</td></tr>
                <?php else: ?>
                    <?php foreach ($eventos_google as $event):
                        $start = $event->start->dateTime ?: $event->start->date;
                        $end = $event->end->dateTime ?: $event->end->date;
                        
                        // Buscamos si este evento existe en nuestra DB para poder borrarlo de ambos lados
                        $summary = strtoupper($event->getSummary());
                        $db_id = null;
                        foreach($mapa_db as $nombre => $id){
                            if(strpos($summary, $nombre) !== false) {
                                $db_id = $id;
                                break;
                            }
                        }
                    ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($event->getSummary()) ?></strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($start)) ?></td>
                            <td><?= date('H:i', strtotime($end)) ?></td>
                            <td><?= nl2br(htmlspecialchars($event->getDescription() ?? 'Sin descripción')) ?></td>
                            <td class="acciones">
                                <button class="btn-editar" title="Ver en Google Calendar"
                                    onclick="window.open('<?= $event->getHtmlLink() ?>','_blank')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <a href="?seccion=citas&delete_id=<?= $event->getId() ?>&db_id=<?= $db_id ?>" 
                                   class="btn-eliminar"
                                   onclick="return confirm('¿Seguro que quieres borrar esta cita de TODO el sistema?')">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>