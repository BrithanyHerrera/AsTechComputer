<?php
require_once dirname(__DIR__, 2) . '/config/conexion.db.php';
require_once dirname(__DIR__, 2) . '/models/panel_info_model.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$modeloDashboard = new DashboardModel($conexion);
$id_empleado_actual = $_SESSION['id_empleado'] ?? 1; 
$usuario = $modeloDashboard->obtenerInfoUsuario($id_empleado_actual);

if (!$usuario) { $usuario = ['nombre' => 'Usuario', 'apellido' => 'Desconocido', 'nombre_puesto' => 'Sin Rol', 'id_puesto' => 0]; }

$es_admin = ($usuario['id_puesto'] == 3 || $usuario['id_puesto'] == 4);

// Capturar los valores actuales de la URL para que los inputs no se borren visualmente
$val_nombre = $_GET['filtro_nombre'] ?? '';
$val_puesto = $_GET['filtro_puesto'] ?? 'todos';
$val_fecha  = $_GET['filtro_fecha'] ?? '';

// La actividad la carga el controlador, pero si accedemos directo a la vista, usamos el modelo
if (!isset($actividad_reciente)) {
    $actividad_reciente = $es_admin ? $modeloDashboard->obtenerConexiones(['nombre' => $val_nombre, 'puesto' => $val_puesto, 'fecha' => $val_fecha]) : [];
}
?>

<link rel="stylesheet" href="../../public/css/panel_info.css?v=2.0">

<div class="contenedor-dashboard">
    <div class="pildora-usuario">
        <div class="icono-usuario"><i class="fa-solid fa-user"></i></div>
        <span class="texto-usuario">
            <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?> - <?= htmlspecialchars($usuario['nombre_puesto']) ?>
        </span>
    </div>

    <?php if ($es_admin): ?>
        <div class="bitacora-panel">
            <h2 class="titulo-panel"><i class="fa-solid fa-clock-rotate-left"></i> Auditoría de Movimientos</h2>
            
            <form method="GET" action="">
                <?php if(isset($_GET['seccion'])): ?>
                    <input type="hidden" name="seccion" value="<?= htmlspecialchars($_GET['seccion']) ?>">
                <?php endif; ?>

                <div class="barra-filtros">
                    <div class="filtro-grupo buscador">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="filtro_nombre" placeholder="Buscar empleado..." value="<?= htmlspecialchars($val_nombre) ?>">
                    </div>
                    
                    <div class="filtro-grupo">
                        <label>Puesto:</label>
                        <select name="filtro_puesto" onchange="this.form.submit()">
                            <option value="todos" <?= $val_puesto == 'todos' ? 'selected' : '' ?>>Todos los puestos</option>
                            <?php
                            $sql_p = "SELECT nombre_puesto FROM puestos ORDER BY nombre_puesto ASC";
                            $res_p = $conexion->query($sql_p);
                            if ($res_p) {
                                while ($p = $res_p->fetch_assoc()) {
                                    $nombre_p = htmlspecialchars($p['nombre_puesto']);
                                    $seleccionado = ($val_puesto === $nombre_p) ? 'selected' : '';
                                    echo "<option value='{$nombre_p}' {$seleccionado}>{$nombre_p}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="filtro-grupo">
                        <label>Día:</label>
                        <input type="date" name="filtro_fecha" value="<?= htmlspecialchars($val_fecha) ?>" onchange="this.form.submit()">
                        
                        <button type="submit" class="btn-buscar" style="background: #e17203; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; margin-left: 5px;">
                            Buscar
                        </button>

                        <?php $url_limpia = isset($_GET['seccion']) ? "?seccion=" . htmlspecialchars($_GET['seccion']) : $_SERVER['PHP_SELF']; ?>
                        <a href="<?= $url_limpia ?>" class="btn-limpiar" title="Limpiar filtros" style="margin-left: 5px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-sizing: border-box; height: 38px; width: 38px;">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </form>
            
            <?php if (!empty($actividad_reciente)): ?>
            <div class="tabla-responsiva">
                <table class="tabla-admin">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Puesto</th>
                            <th>Acción</th>
                            <th>Detalle</th>
                            <th>Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($actividad_reciente as $act): 
                            $nombre_puesto_clase = strtolower(str_replace(' ', '-', $act['nombre_puesto']));
                        ?>
                        <tr class="fila-panel-info">
                            <td><strong><?= htmlspecialchars($act['nombre'] . ' ' . $act['apellido']) ?></strong></td>
                            <td><span class="status-pill rol-<?= $nombre_puesto_clase ?>"><?= htmlspecialchars($act['nombre_puesto']) ?></span></td>
                            <td><span class="badge-accion"><?= htmlspecialchars($act['accion']) ?></span></td>
                            <td class="td-detalle"><?= htmlspecialchars($act['detalle']) ?></td>
                            <td style="color: #666;"><i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> <?= date('d/m/Y H:i', strtotime($act['fecha_hora'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <i class="fa-solid fa-search"></i>
                    No se encontraron movimientos con esos filtros.
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>