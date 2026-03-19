<?php
// ===============================
// 1. CARGAR AUTOLOAD Y CONEXIÓN
// ===============================
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/config/conexion.db.php';

$sql_limpieza = "DELETE FROM citas_web WHERE TIMESTAMP(fecha_cita, hora_cita) < DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
$conexion->query($sql_limpieza);

use Google\Client;
use Google\Service\Calendar;

date_default_timezone_set('America/Mexico_City');

// ===============================
// 2. CONFIGURAR CLIENTE GOOGLE
// ===============================
$client = new Client();
$ruta_credenciales = dirname(__DIR__, 3) . '/credenciales.json';
$client->setAuthConfig($ruta_credenciales);
$client->addScope(Calendar::CALENDAR);
$service = new Calendar($client);
$calendarId = '4a33353b0ebaa41888fc4ea59bc85921899469a7c9e231d72d8a2887ea62eab5@group.calendar.google.com';

// ===================================
// 3. LÓGICA ELIMINAR (DB + GOOGLE)
// ===================================
if (isset($_GET['delete_id'])) {
    try {
        $service->events->delete($calendarId, $_GET['delete_id']);
        if (!empty($_GET['db_id'])) {
            $stmt = $conexion->prepare("DELETE FROM citas_web WHERE id_cita = ?");
            $stmt->bind_param("i", $_GET['db_id']);
            $stmt->execute();
        }
        echo "<script>alert('Cita eliminada correctamente'); window.location.href='?seccion=citas';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// ===================================
// 4. LÓGICA ACTUALIZAR (DB + GOOGLE)
// ===================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    $id_google = $_POST['modal_google_id'];
    $id_db = $_POST['modal_db_id'];

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $id_marca = $_POST['id_marca'];
    $id_tipo = $_POST['id_tipo'];
    $falla = $_POST['falla'];
    $whatsapp = $_POST['whatsapp'];
    $modelo = $_POST['modelo'];
    $n_serie = $_POST['n_serie'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    try {
        $m_nom = $conexion->query("SELECT marca FROM marcas WHERE id_marca = '$id_marca'")->fetch_assoc()['marca'];
        $t_nom = $conexion->query("SELECT tipo FROM tipos_equipo WHERE id_tipo_equipo = '$id_tipo'")->fetch_assoc()['tipo'];

        $nuevo_resumen = "SERVICIO: $nombre $apellido - $t_nom";
        $nueva_desc = "Marca: $m_nom\nModelo: $modelo\nNo. Serie: $n_serie\nFalla: $falla\nWhatsApp: $whatsapp";

        $evento = $service->events->get($calendarId, $id_google);
        $inicio_dt = $fecha . 'T' . $hora . ':00-06:00';
        $fin_dt = date('Y-m-d\TH:i:sP', strtotime($inicio_dt . ' + 1 hour'));

        $evento->setSummary($nuevo_resumen);
        $evento->setDescription($nueva_desc);
        $evento->setStart(new Google\Service\Calendar\EventDateTime(['dateTime' => $inicio_dt, 'timeZone' => 'America/Mexico_City']));
        $evento->setEnd(new Google\Service\Calendar\EventDateTime(['dateTime' => $fin_dt, 'timeZone' => 'America/Mexico_City']));

        $service->events->update($calendarId, $id_google, $evento);

        if (!empty($id_db)) {
            $stmt = $conexion->prepare("UPDATE citas_web SET nombre_cliente=?, apellido_cliente=?, id_tipo_equipo=?, id_marca=?, modelo=?, numero_serie=?, problema_reportado=?, fecha_cita=?, hora_cita=?, whatsapp=? WHERE id_cita=?");
            $stmt->bind_param("ssiissssssi", $nombre, $apellido, $id_tipo, $id_marca, $modelo, $n_serie, $falla, $fecha, $hora, $whatsapp, $id_db);
            $stmt->execute();
        }
        echo "<script>alert('Información actualizada en todo el sistema'); window.location.href='?seccion=citas';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// ===================================
// 5. CONSULTA DE CATÁLOGOS Y CITAS
// ===================================
$marcas_res = $conexion->query("SELECT * FROM marcas ORDER BY marca ASC");
$tipos_res = $conexion->query("SELECT * FROM tipos_equipo ORDER BY tipo ASC");

$eventos_google = $service->events->listEvents($calendarId, ['singleEvents' => true, 'orderBy' => 'startTime', 'timeMin' => date('c')])->getItems();

$citas_ocupadas = [];
foreach ($eventos_google as $ev) {
    $dt_start = $ev->start->dateTime ?: $ev->start->date;
    $fecha_ev = date('Y-m-d', strtotime($dt_start));
    $hora_ev = date('H:i', strtotime($dt_start));
    $citas_ocupadas[$fecha_ev][] = $hora_ev;
}
$json_ocupadas = json_encode($citas_ocupadas);

$sql_db = "SELECT c.*, m.marca, t.tipo 
           FROM citas_web c
           LEFT JOIN marcas m ON c.id_marca = m.id_marca
           LEFT JOIN tipos_equipo t ON c.id_tipo_equipo = t.id_tipo_equipo";
$res_db = $conexion->query($sql_db);

$mapa_db = [];
while ($f = $res_db->fetch_assoc()) {
    $mapa_db[strtoupper($f['nombre_cliente'] . " " . $f['apellido_cliente'])] = $f;
}
?>

<div class="contenedor-ingresos">
    <div class="encabezado-crud">
        <h1><i class="fa-solid fa-calendar-check"></i> Gestión de Citas</h1>
        
        <div class="barra-filtros">
            <div class="filtro-grupo">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorGlobal" placeholder="Buscar por Nombre..." onkeyup="filtrarTabla()">
            </div>
            
            <div class="filtro-grupo">
                <label>Estado:</label>
                <select id="filtroEstado" onchange="filtrarTabla()">
                    <option value="todos">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en-proceso">En proceso</option>
                    <option value="listo">Listo</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Fecha:</label>
                <input type="date" id="filtroFecha" onchange="filtrarTabla()">
                <button class="btn-limpiar" onclick="limpiarFiltros()" title="Limpiar filtros"><i class="fa-solid fa-rotate-left"></i></button>
            </div>
        </div>
    </div>

    <div class="tabla-responsiva">
        <table class="tabla-admin" id="tablaCitas">
            <thead>
                <tr>
                    <th>Nombre Cliente</th>
                    <th>Falla</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Dispositivo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>No. Serie</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos_google as $event):
                    $start_dt = $event->start->dateTime ?: $event->start->date;
                    $summary_clean = str_replace("SERVICIO: ", "", $event->getSummary());
                    $nombre_buscar = strtoupper(explode(' - ', $summary_clean)[0]);
                    $datos_db = $mapa_db[$nombre_buscar] ?? null;
                    
                    // Normalizar nombres y estados para los data-attributes y buscador
                    $nombre_mostrar = isset($datos_db) ? $datos_db['nombre_cliente'] . " " . $datos_db['apellido_cliente'] : $summary_clean;
                    $estado_actual = strtolower($datos_db['estado'] ?? 'pendiente');
                    $clase_estado = str_replace(' ', '-', $estado_actual);
                    $fecha_formato_filtro = date('Y-m-d', strtotime($start_dt));
                ?>
                    <tr class="fila-registro" 
                        data-nombre="<?= strtolower(htmlspecialchars($nombre_mostrar)) ?>" 
                        data-estado="<?= $clase_estado ?>" 
                        data-fecha="<?= $fecha_formato_filtro ?>">
                        
                        <td><strong><?= htmlspecialchars($nombre_mostrar) ?></strong></td>
                        <td><span class="falla-txt"><?= htmlspecialchars($datos_db['problema_reportado'] ?? 'N/A') ?></span></td>
                        <td><?= date('d/m/Y', strtotime($start_dt)) ?></td>
                        <td><?= date('H:i', strtotime($start_dt)) ?></td>
                        <td><?= htmlspecialchars($datos_db['tipo'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['marca'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['modelo'] ?? 'N/A') ?></td>
                        <td><small><?= htmlspecialchars($datos_db['numero_serie'] ?? 'N/V') ?></small></td>
                        
                        <td>
                            <span class="status-pill <?= $clase_estado ?>">
                                <?= ucfirst($datos_db['estado'] ?? 'Pendiente') ?>
                            </span>
                        </td>

                        <td class="acciones">
                            <button class="btn-editar" type="button" title="Editar" onclick='abrirModalEditar(
                                "<?= $event->getId() ?>", 
                                "<?= $datos_db['id_cita'] ?? '' ?>", 
                                "<?= $datos_db['nombre_cliente'] ?? '' ?>", 
                                "<?= $datos_db['apellido_cliente'] ?? '' ?>",
                                "<?= $datos_db['id_marca'] ?? '' ?>",
                                "<?= $datos_db['id_tipo_equipo'] ?? '' ?>",
                                "<?= addslashes($datos_db['modelo'] ?? '') ?>",
                                "<?= addslashes($datos_db['numero_serie'] ?? '') ?>",
                                "<?= addslashes(str_replace(["\r", "\n"], ' ', $datos_db['problema_reportado'] ?? '')) ?>",
                                "<?= $datos_db['whatsapp'] ?? '' ?>",
                                "<?= $fecha_formato_filtro ?>",
                                "<?= date('H:i', strtotime($start_dt)) ?>"
                            )'>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <a href="?seccion=citas&delete_id=<?= $event->getId() ?>&db_id=<?= $datos_db['id_cita'] ?? '' ?>"
                               class="btn-eliminar" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta cita?')">
                               <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modalEditar" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
        <h2><i class="fa-solid fa-edit"></i> Editar Información</h2>
        <form method="POST">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" id="m_google_id" name="modal_google_id">
            <input type="hidden" id="m_db_id" name="modal_db_id">

            <div class="fila-form">
                <div class="grupo-form"><label>Nombre(s):</label><input type="text" id="m_nombre" name="nombre" required></div>
                <div class="grupo-form"><label>Apellido(s):</label><input type="text" id="m_apellido" name="apellido" required></div>
            </div>

            <div class="fila-form">
                <div class="grupo-form"><label>WhatsApp:</label><input type="text" id="m_wa" name="whatsapp" required></div>
                <div class="grupo-form"><label>No. Serie:</label><input type="text" id="m_serie" name="n_serie"></div>
            </div>

            <div class="fila-form">
                <div class="grupo-form">
                    <label>Tipo:</label>
                    <select id="m_tipo" name="id_tipo" required>
                        <?php $tipos_res->data_seek(0);
                        while ($t = $tipos_res->fetch_assoc()): ?>
                            <option value="<?= $t['id_tipo_equipo'] ?>"><?= $t['tipo'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="grupo-form">
                    <label>Marca:</label>
                    <select id="m_marca" name="id_marca" required>
                        <?php $marcas_res->data_seek(0);
                        while ($m = $marcas_res->fetch_assoc()): ?>
                            <option value="<?= $m['id_marca'] ?>"><?= $m['marca'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="grupo-form"><label>Modelo:</label><input type="text" id="m_modelo" name="modelo" required></div>
            
            <div class="grupo-form">
                <label>Falla:</label>
                <select id="m_falla" name="falla" required>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Pantalla no funciona">Pantalla no funciona</option>
                    <option value="No enciende">No enciende</option>
                    <option value="Lento / Virus">Lento / Virus</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="fila-form">
                <div class="grupo-form"><label>Fecha:</label><input type="date" id="m_fecha" name="fecha" required></div>
                <div class="grupo-form">
                    <label>Hora:</label>
                    <select id="m_hora" name="hora" required></select>
                </div>
            </div>

            <button type="submit" class="btn-guardar-cambios">Guardar Cambios</button>
        </form>
    </div>
</div>

<script>
    // ==========================================
    // SCRIPTS DE FILTROS DINÁMICOS
    // ==========================================
    function filtrarTabla() {
        const busqueda = document.getElementById('buscadorGlobal').value.toLowerCase();
        const estado = document.getElementById('filtroEstado').value;
        const fecha = document.getElementById('filtroFecha').value;
        const filas = document.querySelectorAll('#tablaCitas .fila-registro');

        filas.forEach(fila => {
            const txtNombre = fila.getAttribute('data-nombre');
            const txtEstado = fila.getAttribute('data-estado');
            const txtFecha = fila.getAttribute('data-fecha');

            const coincideBusqueda = txtNombre.includes(busqueda);
            const coincideEstado = estado === 'todos' || txtEstado === estado;
            const coincideFecha = !fecha || txtFecha === fecha;

            if (coincideBusqueda && coincideEstado && coincideFecha) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }

    function limpiarFiltros() {
        document.getElementById('buscadorGlobal').value = '';
        document.getElementById('filtroEstado').value = 'todos';
        document.getElementById('filtroFecha').value = '';
        filtrarTabla();
    }

    // ==========================================
    // SCRIPTS DEL MODAL DE EDICIÓN Y HORARIOS
    // ==========================================
    const horasOcupadas = <?= $json_ocupadas ?>;

    function generarHorarios(fechaElegida, horaPreseleccionada) {
        const selectorHora = document.getElementById('m_hora');
        selectorHora.innerHTML = '<option value="">Seleccione una hora...</option>';
        if (!fechaElegida) return;

        const todasLasHoras = [
            "10:00", "10:20", "10:40", "11:00", "11:20", "11:40",
            "12:00", "12:20", "12:40", "13:00", "13:20", "13:40",
            "14:00", "14:20", "14:40", "15:00", "15:20", "15:40", "16:00"
        ];

        const ocupadasHoy = horasOcupadas[fechaElegida] || [];

        todasLasHoras.forEach(hora => {
            if (!ocupadasHoy.includes(hora) || hora === horaPreseleccionada) {
                let opt = document.createElement('option');
                opt.value = hora;
                opt.textContent = hora;
                if (hora === horaPreseleccionada) {
                    opt.selected = true;
                }
                selectorHora.appendChild(opt);
            }
        });
    }

    document.getElementById('m_fecha').addEventListener('change', function() {
        const fechaOriginal = this.getAttribute('data-fecha-orig');
        const horaOriginal = document.getElementById('m_hora').getAttribute('data-hora-orig');
        
        if (this.value === fechaOriginal) {
            generarHorarios(this.value, horaOriginal);
        } else {
            generarHorarios(this.value, null);
        }
    });

    function abrirModalEditar(gid, dbid, nom, ape, marca, tipo, mod, serie, falla, wa, fecha, hora) {
        document.getElementById('m_google_id').value = gid;
        document.getElementById('m_db_id').value = dbid;
        document.getElementById('m_nombre').value = nom;
        document.getElementById('m_apellido').value = ape;
        document.getElementById('m_marca').value = marca;
        document.getElementById('m_tipo').value = tipo;
        document.getElementById('m_modelo').value = mod;
        document.getElementById('m_serie').value = serie;
        
        // Asignar Falla (selecciona el correspondiente si existe, si no "Otro")
        let selectFalla = document.getElementById('m_falla');
        let optionFallaExists = Array.from(selectFalla.options).some(opt => opt.value === falla);
        selectFalla.value = optionFallaExists ? falla : "Otro";

        document.getElementById('m_wa').value = wa;
        
        const inFecha = document.getElementById('m_fecha');
        const selHora = document.getElementById('m_hora');

        inFecha.value = fecha;
        inFecha.setAttribute('data-fecha-orig', fecha);
        selHora.setAttribute('data-hora-orig', hora);

        generarHorarios(fecha, hora);
        
        document.getElementById('modalEditar').style.display = 'flex';
    }

    function cerrarModal() { document.getElementById('modalEditar').style.display = 'none'; }
    window.onclick = function (e) { if (e.target == document.getElementById('modalEditar')) cerrarModal(); }
</script>

<style>
/* =========================================
   ESTILOS GENERALES, CONTENEDOR Y FILTROS
   ========================================= */
.contenedor-ingresos { padding: 25px; background: #fff; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
.encabezado-crud h1 { color: #52073a; margin-bottom: 20px; font-size: 1.6rem; border-left: 5px solid #e17203; padding-left: 15px; }

.barra-filtros { 
    display: flex; 
    gap: 20px; 
    background: #f9f9f9; 
    padding: 15px; 
    border-radius: 10px; 
    margin-bottom: 20px;
    align-items: center;
    flex-wrap: wrap;
}

.filtro-grupo { display: flex; align-items: center; gap: 10px; }
.filtro-grupo label { font-weight: bold; color: #555; font-size: 0.9rem; }
.filtro-grupo input, .filtro-grupo select { 
    padding: 8px 12px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    outline: none;
    font-size: 0.85rem;
}

.btn-limpiar { background: #666; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; transition: 0.3s; }
.btn-limpiar:hover { background: #333; }

/* =========================================
   TABLA, BADGES Y BOTONES DE ACCIÓN
   ========================================= */
.tabla-responsiva { overflow-x: auto; }
.tabla-admin { width: 100%; border-collapse: collapse; min-width: 900px; }
.tabla-admin th { background: #f8f9fa; padding: 15px 12px; text-align: left; font-size: 0.85rem; color: #444; text-transform: uppercase; border-bottom: 2px solid #ddd;}
.tabla-admin td { padding: 15px 12px; border-bottom: 1px solid #eee; font-size: 0.9rem; vertical-align: middle; }

.falla-txt { color: #555; font-style: italic; }

/* Pills de Estado */
.status-pill { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; display: inline-block; text-align: center; }
.pendiente { background: #fff3cd; color: #856404; }
.en-proceso { background: #cce5ff; color: #004085; }
.listo { background: #d4edda; color: #155724; }

/* Botones Tabla */
.acciones { display: flex; gap: 8px; }
.btn-editar { background: #e17203; color: white; border: none; padding: 8px 10px; border-radius: 6px; cursor: pointer; transition: 0.2s;}
.btn-editar:hover { background: #c66302; }
.btn-eliminar { background: #dc3545; color: white; border: none; padding: 8px 10px; border-radius: 6px; cursor: pointer; text-decoration: none; transition: 0.2s;}
.btn-eliminar:hover { background: #c82333; }

/* =========================================
   ESTILOS DEL MODAL (MANTENIDOS)
   ========================================= */
.modal-personalizado {
    position: fixed;
    z-index: 99999;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.8);
    display: none;
    align-items: center;
    justify-content: center;
}

.contenido-modal {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    width: 95%;
    max-width: 550px;
    position: relative;
    border-top: 5px solid #52073a;
}

.cerrar-modal {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 28px;
    cursor: pointer;
    color: #999;
    font-weight: bold;
}

.contenido-modal h2 { color: #52073a; font-size: 1.3rem; margin-bottom: 20px;}

.fila-form { display: flex; gap: 15px; }
.grupo-form { flex: 1; margin-bottom: 12px; }
.grupo-form label {
    display: block;
    font-weight: bold;
    margin-bottom: 4px;
    color: #555;
    font-size: 0.85em;
    text-transform: uppercase;
}
.grupo-form input, .grupo-form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-sizing: border-box;
}

.btn-guardar-cambios {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    font-weight: bold;
    margin-top: 10px;
    font-size: 1rem;
}
.btn-guardar-cambios:hover { background: #218838; }
</style>