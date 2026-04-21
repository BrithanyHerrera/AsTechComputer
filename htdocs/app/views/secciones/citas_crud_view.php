<?php
/* CITAS_CRUD_VIEW.PHP */
/*
Este archivo actúa como la Vista (View) encargada de renderizar la interfaz de administración (CRUD) de citas para ASTECH COMPUTER. Su objetivo es tomar los datos provenientes del controlador (eventos de Google Calendar cruzados con la base de datos local) y mostrarlos en una tabla dinámica e interactiva. Incluye una barra de filtros superiores, botones de acción por cada registro, y un modal emergente que permite al administrador editar toda la información de una cita específica de manera cómoda. Se vincula externamente a hojas de estilo CSS y scripts de JavaScript para mantener una arquitectura limpia y responsiva.
*/
?>

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
                    <option value="atendida">Atendida</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Desde:</label>
                <input type="date" id="filtroFechaInicio" onchange="filtrarTabla()">
                <label>Hasta:</label>
                <input type="date" id="filtroFechaFin" onchange="filtrarTabla()">
                <button type="button" class="btn-limpiar" onclick="limpiarFiltros()" title="Limpiar filtros">
                    <i class="fa-solid fa-rotate-left"></i> Limpiar
                </button>
            </div>
        </div>
    </div>

    <div class="tabla-responsiva">
        <table class="tabla-admin" id="tablaCitas">
            <thead>
                <tr>
                    <th>Nombre Cliente</th>
                    <th>Motivo</th>
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
                    $id_evento = $event->getId();
                    $datos_db = $mapa_db[$id_evento] ?? null;

                    $summary_clean = str_replace("SERVICIO: ", "", $event->getSummary());
                    $nombre_google = explode(' - ', $summary_clean)[0];

                    $nombre_mostrar = isset($datos_db) ? $datos_db['nombre_cliente'] . " " . $datos_db['apellido_cliente'] : $nombre_google;
                    $estado_actual = strtolower($datos_db['estado'] ?? 'pendiente');
                    $clase_estado = str_replace(' ', '-', $estado_actual);
                    $fecha_formato_filtro = date('Y-m-d', strtotime($start_dt));

                    $partes_nombre = explode(' ', $nombre_mostrar);
                    $nombre_f = $datos_db['nombre_cliente'] ?? array_shift($partes_nombre);
                    $apellido_f = $datos_db['apellido_cliente'] ?? implode(' ', $partes_nombre);
                ?>

                    <tr class="fila-registro" data-nombre="<?= strtolower(htmlspecialchars($nombre_mostrar)) ?>"
                        data-estado="<?= $clase_estado ?>" data-fecha="<?= $fecha_formato_filtro ?>">

                        <td><strong><?= htmlspecialchars($nombre_mostrar) ?></strong></td>
                        <td>
                            <span class="falla-txt">
                                <strong><?= htmlspecialchars($datos_db['problema_reportado'] ?? 'N/A') ?></strong>
                            </span><br>
                            <small style="color: #666;">
                                <?= htmlspecialchars($datos_db['detalle_falla'] ?? '') ?>
                            </small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($start_dt)) ?></td>
                        <td><?= date('H:i', strtotime($start_dt)) ?></td>
                        <td><?= htmlspecialchars($datos_db['tipo'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['marca'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['modelo'] ?? 'N/A') ?></td>
                        <td><small><?= htmlspecialchars($datos_db['numero_serie'] ?? 'N/V') ?></small></td>

                        <td>
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="accion" value="actualizar_estado_rapido">
                                <input type="hidden" name="db_id" value="<?= $datos_db['id_cita'] ?? '' ?>">
                                <input type="hidden" name="google_id" value="<?= $id_evento ?>">

                                <select name="estado" class="status-pill <?= $clase_estado ?>"
                                    data-estado-anterior="<?= $estado_actual ?>"
                                    onchange="confirmarCambioEstado(this)"
                                    style="border: none; outline: none; cursor: pointer; font-weight: bold;">
                                    <option value="pendiente" <?= $estado_actual == 'pendiente' ? 'selected' : '' ?>
                                        style="background: #fff3cd; color: #856404;">Pendiente</option>
                                    <option value="atendida" <?= $estado_actual == 'atendida' ? 'selected' : '' ?>
                                        style="background: #d4edda; color: #155724;">Atendida</option>
                                    <option value="cancelada" <?= $estado_actual == 'cancelada' ? 'selected' : '' ?>
                                        style="background: #f8d7da; color: #721c24;">Cancelada</option>
                                </select>
                            </form>
                        </td>

                        <td class="acciones">
                            <button class="btn-ver" type="button" title="Ver Detalles" data-cita='<?= htmlspecialchars(json_encode([
                                "nombre" => $nombre_f,
                                "apellido" => $apellido_f,
                                "tipoTxt" => $datos_db['tipo'] ?? "N/A",
                                "marcaTxt" => $datos_db['marca'] ?? "N/A",
                                "modelo" => $datos_db['modelo'] ?? "N/A",
                                "serie" => $datos_db['numero_serie'] ?? "N/V",
                                "falla" => $datos_db['problema_reportado'] ?? "N/A",
                                "detalle" => $datos_db['detalle_falla'] ?? "Ninguno",
                                "whatsapp" => $datos_db['whatsapp'] ?? "No registrado",
                                "estado" => ucfirst($estado_actual),
                                "fecha" => date("d/m/Y", strtotime($start_dt)),
                                "hora" => date("H:i", strtotime($start_dt))
                            ]), ENT_QUOTES, "UTF-8") ?>' onclick="abrirModalVer(this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-editar" type="button" title="Editar" data-cita='<?= htmlspecialchars(json_encode([
                                "googleId" => $id_evento,
                                "dbId" => $datos_db['id_cita'] ?? "",
                                "nombre" => $nombre_f,
                                "apellido" => $apellido_f,
                                "idMarca" => $datos_db['id_marca'] ?? "",
                                "idTipo" => $datos_db['id_tipo_equipo'] ?? "",
                                "modelo" => $datos_db['modelo'] ?? "",
                                "serie" => $datos_db['numero_serie'] ?? "",
                                "falla" => $datos_db['problema_reportado'] ?? "",
                                "detalle" => $datos_db['detalle_falla'] ?? "",
                                "whatsapp" => $datos_db['whatsapp'] ?? "",
                                "fecha" => $fecha_formato_filtro,
                                "hora" => date("H:i", strtotime($start_dt)),
                                "estado" => $estado_actual
                            ]), ENT_QUOTES, "UTF-8") ?>' onclick="abrirModalEditar(this)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <a href="?seccion=citas&delete_id=<?= $id_evento ?>&db_id=<?= $datos_db['id_cita'] ?? '' ?>"
                                class="btn-eliminar" title="Eliminar"
                                onclick="return confirm('¿Estás seguro de eliminar esta cita?')">
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
        <h2><i class="fa-solid fa-address-card"></i> Detalles del Servicio</h2>
        <div class="grid-detalles">
            <div class="detalle-item"><span>Cliente</span>
                <p id="v_cliente"></p>
            </div>
            <div class="detalle-item"><span>WhatsApp</span>
                <p id="v_wa"></p>
            </div>
            <div class="detalle-item"><span>Dispositivo</span>
                <p id="v_dispositivo"></p>
            </div>
            <div class="detalle-item"><span>Marca y Modelo</span>
                <p id="v_marca_modelo"></p>
            </div>
            <div class="detalle-item"><span>No. Serie</span>
                <p id="v_serie"></p>
            </div>
            <div class="detalle-item"><span>Falla Reportada</span>
                <p id="v_falla"></p>
            </div>
            <div class="detalle-item"><span>Detalles Adicionales</span>
                <p id="v_detalle"></p>
            </div>
            <div class="detalle-item"><span>Estado</span>
                <p id="v_estado"></p>
            </div>
            <div class="detalle-item"><span>Fecha</span>
                <p id="v_fecha"></p>
            </div>
            <div class="detalle-item"><span>Hora</span>
                <p id="v_hora"></p>
            </div>
        </div>
    </div>
</div>

<div id="modalEditar" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
        <h2><i class="fa-solid fa-edit"></i> Editar Información</h2>

        <form method="POST" id="formEditarCita">
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" id="m_google_id" name="modal_google_id">
            <input type="hidden" id="m_db_id" name="modal_db_id">
            <input type="hidden" id="m_estado" name="estado">

            <div class="fila-form">
                <div class="grupo-form">
                    <label>Nombre(s):</label>
                    <input type="text" id="m_nombre" name="nombre" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                           title="Solo se permiten letras y espacios." 
                           oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required>
                </div>
                <div class="grupo-form">
                    <label>Apellido(s):</label>
                    <input type="text" id="m_apellido" name="apellido" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" 
                           title="Solo se permiten letras y espacios." 
                           oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required>
                </div>
            </div>

            <div class="fila-form">
                <div class="grupo-form">
                    <label>WhatsApp:</label>
                    <input type="tel" id="m_wa" name="whatsapp" required>
                </div>
                <div class="grupo-form">
                    <label>No. Serie (Opcional):</label>
                    <input type="text" id="m_serie" name="n_serie">
                </div>
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

            <div class="grupo-form">
                <label>Modelo:</label>
                <input type="text" id="m_modelo" name="modelo" required>
            </div>

            <div class="grupo-form">
                <label>Falla / Motivo del Servicio:</label>
                <select id="m_falla" name="falla" required>
                    <option value="">Seleccione un servicio...</option>
                    <?php
                    if ($servicios_res):
                        $servicios_res->data_seek(0);
                        while ($s = $servicios_res->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($s['tipo_servicio']) ?>">
                                <?= htmlspecialchars($s['tipo_servicio']) ?>
                            </option>
                        <?php endwhile;
                    endif; ?>
                    <option value="Otro">Otro / No listado</option>
                </select>
            </div>

            <div class="grupo-form">
                <label>Descripción detallada (Opcional):</label>
                <textarea id="m_detalle" name="detalle_falla" rows="3"
                    style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
            </div>

            <div class="fila-form">
                <div class="grupo-form">
                    <label>Fecha:</label>
                    <input type="date" id="m_fecha" name="fecha" required>
                </div>
                <div class="grupo-form">
                    <label>Hora:</label>
                    <select id="m_hora" name="hora" required></select>
                </div>
            </div>

            <button type="submit" class="btn-guardar-cambios">Guardar Cambios</button>
        </form>
    </div>
</div>

<div id="modalConfirmacion" class="modal-personalizado">
    <div class="contenido-modal" style="max-width: 400px; text-align: center;">
        <h2 style="color: #e17203;"><i class="fa-solid fa-triangle-exclamation"></i> Confirmación</h2>
        <p id="textoConfirmacion" style="margin: 20px 0; font-size: 1.1rem; color: #444;"></p>
        <div style="display: flex; gap: 15px; justify-content: center; margin-top: 25px;">
            <button id="btnCancelarConfirmacion" class="btn-cancelar-conf" type="button">Cancelar</button>
            <button id="btnAceptarConfirmacion" class="btn-aceptar-conf" type="button">Confirmar</button>
        </div>
    </div>
</div>

<script>
    const horasOcupadas = <?= $json_ocupadas ?? '{}' ?>;
</script>

<?php if (!empty($alerta_script)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php echo $alerta_script; ?>
        });
    </script>
<?php endif; ?>

<script src="../../public/js/citas_crud.js"></script>