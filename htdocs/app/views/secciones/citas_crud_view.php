<link rel="stylesheet" href="../../public/css/citas_crud.css">

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
    const horasOcupadas = <?= $json_ocupadas ?? '{}' ?>;
</script>
<script src="../../public/js/citas_crud.js"></script>