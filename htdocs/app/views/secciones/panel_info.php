<?php
require_once __DIR__ . "/../../controllers/panel_info_controller.php";
?>

<link rel="stylesheet" href="../../public/css/panel_info.css?v=3.1">

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
                        <label>Buscar Empleado:</label>
                        <div class="input-con-icono">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="filtro_nombre" placeholder="Nombre o apellido..." value="<?= htmlspecialchars($val_nombre) ?>">
                        </div>
                    </div>
                    
                    <div class="filtro-grupo">
                        <label>Puesto:</label>
                        <select name="filtro_puesto" onchange="this.form.submit()">
                            <option value="todos" <?= $val_puesto == 'todos' ? 'selected' : '' ?>>Todos</option>
                            <?php foreach ($puestos as $p):
                                $nombre_p    = htmlspecialchars($p['nombre_puesto']);
                                $seleccionado = ($val_puesto === $nombre_p) ? 'selected' : '';
                            ?>
                                <option value="<?= $nombre_p ?>" <?= $seleccionado ?>><?= $nombre_p ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filtro-grupo">
                        <label>Desde:</label>
                        <input type="date" name="filtro_fecha_inicio" value="<?= htmlspecialchars($val_fecha_inicio) ?>" onchange="this.form.submit()">
                    </div>

                    <div class="filtro-grupo">
                        <label>Hasta:</label>
                        <input type="date" name="filtro_fecha_fin" value="<?= htmlspecialchars($val_fecha_fin) ?>" onchange="this.form.submit()">
                    </div>

                    <div class="filtro-grupo">
                        <label>Mostrar:</label>
                        <select name="limite" onchange="this.form.submit()">
                            <option value="10"  <?= $val_limite == 10  ? 'selected' : '' ?>>10</option>
                            <option value="25"  <?= $val_limite == 25  ? 'selected' : '' ?>>25</option>
                            <option value="50"  <?= $val_limite == 50  ? 'selected' : '' ?>>50</option>
                            <option value="100" <?= $val_limite == 100 ? 'selected' : '' ?>>100</option>
                        </select>
                    </div>

                    <div class="filtro-acciones">
                        <button type="submit" class="btn-buscar">
                            <i class="fa-solid fa-filter"></i> Filtrar
                        </button>
                        
                        <?php $url_limpia = isset($_GET['seccion']) ? "?seccion=" . htmlspecialchars($_GET['seccion']) : $_SERVER['PHP_SELF']; ?>
                        <a href="<?= $url_limpia ?>" class="btn-limpiar" title="Limpiar filtros">
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

            <?php if ($total_paginas > 1): ?>
            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 20px; padding: 15px;">
                <?php if ($pagina_actual > 1): ?>
                    <a href="<?= $url_base_paginacion . ($pagina_actual - 1) ?>" style="padding: 8px 15px; background: #eef2ff; color: #4f46e5; border-radius: 6px; text-decoration: none; font-weight: bold;"><i class="fa-solid fa-angle-left"></i> Anterior</a>
                <?php else: ?>
                    <span style="padding: 8px 15px; background: #f3f4f6; color: #9ca3af; border-radius: 6px; font-weight: bold;"><i class="fa-solid fa-angle-left"></i> Anterior</span>
                <?php endif; ?>

                <span style="font-size: 14px; color: #4b5563;">Página <strong><?= $pagina_actual ?></strong> de <strong><?= $total_paginas ?></strong></span>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="<?= $url_base_paginacion . ($pagina_actual + 1) ?>" style="padding: 8px 15px; background: #eef2ff; color: #4f46e5; border-radius: 6px; text-decoration: none; font-weight: bold;">Siguiente <i class="fa-solid fa-angle-right"></i></a>
                <?php else: ?>
                    <span style="padding: 8px 15px; background: #f3f4f6; color: #9ca3af; border-radius: 6px; font-weight: bold;">Siguiente <i class="fa-solid fa-angle-right"></i></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php else: ?>
                <div class="mensaje-vacio" style="text-align: center; padding: 40px; color: #6b7280;">
                    <i class="fa-solid fa-search" style="font-size: 30px; margin-bottom: 10px;"></i><br>
                    No se encontraron movimientos con esos filtros.
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script src="../../public/js/panel_info.js"></script>