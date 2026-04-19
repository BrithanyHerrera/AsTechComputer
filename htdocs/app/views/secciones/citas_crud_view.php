<script>
/* CITAS_CRUD_VIEW.PHP */
/*
Este archivo actúa como la Vista (View) encargada de renderizar la interfaz de administración (CRUD) de citas para ASTECH COMPUTER. Su objetivo es tomar los datos provenientes del controlador (eventos de Google Calendar cruzados con la base de datos local) y mostrarlos en una tabla dinámica e interactiva. Incluye una barra de filtros superiores, botones de acción por cada registro, y un modal emergente que permite al administrador editar toda la información de una cita específica de manera cómoda. Se vincula externamente a hojas de estilo CSS y scripts de JavaScript para mantener una arquitectura limpia y responsiva.
*/
</script>

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
                    <option value="entregado">Entregado</option>
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

                    $partes_nombre = explode(' ', $nombre_mostrar);
                    $nombre_fallback = array_shift($partes_nombre);
                    $apellido_fallback = implode(' ', $partes_nombre);
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
                            <?php if(!empty($datos_db['id_cita'])): ?>
                                <select class="status-pill <?= $clase_estado ?>" 
                                        onchange="cambiarEstadoCita(<?= $datos_db['id_cita'] ?>, this)">
                                    <option class="pendiente" value="Pendiente" <?= $estado_actual == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option class="en-proceso" value="En proceso" <?= $estado_actual == 'en proceso' ? 'selected' : '' ?>>En proceso</option>
                                    <option class="listo" value="Listo" <?= $estado_actual == 'listo' ? 'selected' : '' ?>>Listo</option>
                                    <option class="entregado" value="Entregado" <?= $estado_actual == 'entregado' ? 'selected' : '' ?>>Entregado</option>
                                </select>
                            <?php else: ?>
                                <span class="status-pill pendiente">Pendiente (No BD)</span>
                            <?php endif; ?>
                        </td>

                        <td class="acciones">
                            <button class="btn-ver" type="button" title="Ver Detalles"
                                    data-cita='<?= htmlspecialchars(json_encode([
                                        "nombre"   => $datos_db['nombre_cliente'] ?? $nombre_fallback,
                                        "apellido" => $datos_db['apellido_cliente'] ?? $apellido_fallback,
                                        "tipoTxt"  => $datos_db['tipo'] ?? "N/A",
                                        "marcaTxt" => $datos_db['marca'] ?? "N/A",
                                        "modelo"   => $datos_db['modelo'] ?? "N/A",
                                        "serie"    => $datos_db['numero_serie'] ?? "N/V",
                                        "falla"    => $datos_db['problema_reportado'] ?? "N/A",
                                        "whatsapp" => $datos_db['whatsapp'] ?? "No registrado",
                                        "fecha"    => date("d/m/Y", strtotime($start_dt)),
                                        "hora"     => date("H:i", strtotime($start_dt))
                                    ]), ENT_QUOTES, "UTF-8") ?>'
                                    onclick="abrirModalVer(this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <button class="btn-editar" type="button" title="Editar" 
                                    data-cita='<?= htmlspecialchars(json_encode([
                                        "googleId" => $event->getId(),
                                        "dbId"     => $datos_db['id_cita'] ?? "",
                                        "nombre"   => $datos_db['nombre_cliente'] ?? $nombre_fallback,
                                        "apellido" => $datos_db['apellido_cliente'] ?? $apellido_fallback,
                                        "idMarca"  => $datos_db['id_marca'] ?? "",
                                        "idTipo"   => $datos_db['id_tipo_equipo'] ?? "",
                                        "modelo"   => $datos_db['modelo'] ?? "",
                                        "serie"    => $datos_db['numero_serie'] ?? "",
                                        "falla"    => $datos_db['problema_reportado'] ?? "",
                                        "whatsapp" => $datos_db['whatsapp'] ?? "",
                                        "fecha"    => $fecha_formato_filtro,
                                        "hora"     => date("H:i", strtotime($start_dt))
                                    ]), ENT_QUOTES, "UTF-8") ?>'
                                    onclick="abrirModalEditar(this)">
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

<div id="modalVer" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModalVer()">&times;</span>
        <h2><i class="fa-solid fa-address-card"></i> Detalles Completos del Servicio</h2>
        <div class="grid-detalles">
            <div class="detalle-item"><span>Cliente</span><p id="v_cliente"></p></div>
            <div class="detalle-item"><span>WhatsApp</span><p id="v_wa"></p></div>
            <div class="detalle-item"><span>Dispositivo</span><p id="v_dispositivo"></p></div>
            <div class="detalle-item"><span>Marca y Modelo</span><p id="v_marca_modelo"></p></div>
            <div class="detalle-item"><span>No. Serie</span><p id="v_serie"></p></div>
            <div class="detalle-item"><span>Falla Reportada</span><p id="v_falla"></p></div>
            <div class="detalle-item"><span>Fecha</span><p id="v_fecha"></p></div>
            <div class="detalle-item"><span>Hora</span><p id="v_hora"></p></div>
        </div>
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

<?php if (!empty($alerta_script)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php echo $alerta_script; ?>
        });
    </script>
<?php endif; ?>

<script src="../../public/js/citas_crud.js"></script>