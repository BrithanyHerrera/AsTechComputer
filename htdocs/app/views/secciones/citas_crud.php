<?php
// ===============================
// 1. CARGAR AUTOLOAD DE COMPOSER
// ===============================

$autoload_path = $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

if (!file_exists($autoload_path)) {
    die("Error Crítico: No se encontró vendor/autoload.php en: " . $autoload_path);
}

require_once $autoload_path;

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


// ===============================
// 3. ID DEL CALENDARIO
// ===============================

$calendarId = '073f18605ef849562a5cefd2c7e615d7a31c89ec5a89903939db694542a6f419@group.calendar.google.com';


// ===============================
// 4. ELIMINAR EVENTO
// ===============================

if (isset($_GET['delete_id'])) {

    try {

        $service->events->delete($calendarId, $_GET['delete_id']);

        echo "<script>
        alert('Cita eliminada de Google Calendar');
        window.location.href='?seccion=citas';
        </script>";

    } catch (Exception $e) {

        echo "<script>
        alert('Error al eliminar: " . $e->getMessage() . "');
        </script>";
    }
}


// ===============================
// 5. OBTENER EVENTOS
// ===============================

try {

    $eventos = $service->events->listEvents($calendarId, [
        'maxResults' => 20,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c')
    ])->getItems();

} catch (Exception $e) {

    die("Error al conectar con Google Calendar: " . $e->getMessage());
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

                <?php if (empty($eventos)): ?>

                    <tr>
                        <td colspan="5">No hay citas próximas en el calendario.</td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($eventos as $event):

                        $start = $event->start->dateTime ?: $event->start->date;
                        $end = $event->end->dateTime ?: $event->end->date;

                        ?>

                        <tr>

                            <td>
                                <strong><?= htmlspecialchars($event->getSummary()) ?></strong>
                            </td>

                            <td>
                                <?= date('d/m/Y H:i', strtotime($start)) ?>
                            </td>

                            <td>
                                <?= date('H:i', strtotime($end)) ?>
                            </td>

                            <td>
                                <?= nl2br(htmlspecialchars($event->getDescription() ?? 'Sin descripción')) ?>
                            </td>

                            <td class="acciones">

                                <button class="btn-editar" title="Ver en Google Calendar"
                                    onclick="window.open('<?= $event->getHtmlLink() ?>','_blank')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <a href="?seccion=citas&delete_id=<?= $event->getId() ?>" class="btn-eliminar"
                                    onclick="return confirm('¿Seguro que quieres borrar esta cita de Google Calendar?')">
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