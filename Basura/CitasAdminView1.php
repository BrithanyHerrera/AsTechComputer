<div class="contenedor-crud">
    <div class="tabla-responsiva">
        <table class="tabla-admin">
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
                    ?>
                    <tr>
                        <td><strong><?= htmlspecialchars(isset($datos_db) ? $datos_db['nombre_cliente'] . " " . $datos_db['apellido_cliente'] : $summary_clean) ?></strong></td>
                        <td><?= htmlspecialchars($datos_db['problema_reportado'] ?? 'N/A') ?></td>
                        <td><?= date('d/m/Y', strtotime($start_dt)) ?></td>
                        <td><?= date('H:i', strtotime($start_dt)) ?></td>
                        <td><?= htmlspecialchars($datos_db['tipo'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['marca'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['modelo'] ?? 'N/A') ?></td>
                        <td><small><?= htmlspecialchars($datos_db['numero_serie'] ?? 'N/V') ?></small></td>
                        <td><strong><?= htmlspecialchars($datos_db['estado'] ?? 'Pendiente') ?></strong></td>
                        <td class="acciones">
                            <button class="btn-editar" type="button" onclick='abrirModalEditar(
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
                                "<?= date('Y-m-d', strtotime($start_dt)) ?>",
                                "<?= date('H:i', strtotime($start_dt)) ?>"
                            )'>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <a href="?seccion=citas&delete_id=<?= $event->getId() ?>&db_id=<?= $datos_db['id_cita'] ?? '' ?>"
                                class="btn-eliminar" onclick="return confirm('¿Eliminar cita?')"><i
                                    class="fa-solid fa-trash"></i></a>
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
                <div class="grupo-form"><label>Hora:</label><input type="time" id="m_hora" name="hora" required></div>
            </div>

            <button type="submit" class="btn-guardar-cambios">Guardar Cambios</button>
        </form>
    </div>
</div>

<script>
    function abrirModalEditar(gid, dbid, nom, ape, marca, tipo, mod, serie, falla, wa, fecha, hora) {
        document.getElementById('m_google_id').value = gid;
        document.getElementById('m_db_id').value = dbid;
        document.getElementById('m_nombre').value = nom;
        document.getElementById('m_apellido').value = ape;
        document.getElementById('m_marca').value = marca;
        document.getElementById('m_tipo').value = tipo;
        document.getElementById('m_modelo').value = mod;
        document.getElementById('m_serie').value = serie;
        document.getElementById('m_falla').value = falla;
        document.getElementById('m_wa').value = wa;
        document.getElementById('m_fecha').value = fecha;
        document.getElementById('m_hora').value = hora;
        document.getElementById('modalEditar').style.display = 'flex';
    }
    function cerrarModal() { document.getElementById('modalEditar').style.display = 'none'; }
    window.onclick = function (e) { if (e.target == document.getElementById('modalEditar')) cerrarModal(); }
</script>

<style>
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

    .fila-form {
        display: flex;
        gap: 15px;
    }

    .grupo-form {
        flex: 1;
        margin-bottom: 12px;
    }

    .grupo-form label {
        display: block;
        font-weight: bold;
        margin-bottom: 4px;
        color: #555;
        font-size: 0.85em;
        text-transform: uppercase;
    }

    .grupo-form input,
    .grupo-form select {
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
    }

    .tabla-admin th {
        background: #f8f9fa;
        color: #333;
        font-size: 0.9em;
        text-transform: uppercase;
    }

    .tabla-admin td {
        font-size: 0.9em;
    }
</style>