<?php
/* CITAS_CRUD_VIEW.PHP */
/*
 * PÁGINA: Vista de Gestión de Citas (Citas CRUD View) - As Tech Computer
 * PROPÓSITO: Renderizar la interfaz de administración (CRUD) de citas, mostrando los datos sincronizados entre Google Calendar y la base de datos local en una tabla dinámica e interactiva.
 * FUNCIONALIDADES:
 * - Barra de filtros superiores multifuncional que permite búsquedas en tiempo real (por nombre, estado y rango de fechas).
 * - Representación tabular de los registros, integrando selectores para la actualización rápida y asíncrona (AJAX) del estado de cada cita sin recargar la página completa.
 * - Despliegue de ventanas emergentes (Modales) modulares para la visualización de detalles completos y la edición profunda de la información.
 * - Preparación y serialización de datos de la cita mediante atributos `data-cita` en formato JSON, facilitando su consumo seguro por JavaScript al abrir los modales.
 * - Inyección de variables dinámicas (como los horarios ocupados y scripts de alerta) para gobernar el comportamiento del lado del cliente.
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
                <?php 
                /* * El sistema itera sobre los eventos extraídos de Google Calendar y 
                 * los cruza con el mapa de la base de datos local ($mapa_db) usando el ID del evento. 
                 */
                foreach ($eventos_google as $event):
                    $start_dt = $event->start->dateTime ?: $event->start->date;
                    $id_evento = $event->getId();
                    $datos_db = $mapa_db[$id_evento] ?? null;

                    $nombre_mostrar = isset($datos_db) ? $datos_db['nombre_cliente'] . " " . $datos_db['apellido_cliente'] : $event->getSummary();
                    $estado_actual = strtolower($datos_db['estado'] ?? 'pendiente');
                    $clase_estado = str_replace(' ', '-', $estado_actual);
                    $fecha_formato_filtro = date('Y-m-d', strtotime($start_dt));

                    $partes_nombre = explode(' ', $nombre_mostrar);
                    $nombre_f = $datos_db['nombre_cliente'] ?? array_shift($partes_nombre);
                    $apellido_f = $datos_db['apellido_cliente'] ?? implode(' ', $partes_nombre);

                    $id_t = $datos_db['id_tipo_equipo'] ?? null;
                    $id_m = $datos_db['id_marca'] ?? null;

                    $tipo_mostrar = ($id_t == "7") ? ($datos_db['tipo_equipo_otro'] ?? 'Otro (No especificado)') : ($datos_db['tipo'] ?? 'N/A');
                    $marca_mostrar = ($id_m == "12") ? ($datos_db['marca_otro'] ?? 'Otra (No especificada)') : ($datos_db['marca'] ?? 'N/A');
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
                        <td><?= htmlspecialchars($tipo_mostrar ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($marca_mostrar ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($datos_db['modelo'] ?? 'N/A') ?></td>
                        <td><small><?= htmlspecialchars($datos_db['numero_serie'] ?? 'N/V') ?></small></td>

                        <td>
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="accion" value="actualizar_estado_rapido">
                                <input type="hidden" name="db_id" value="<?= $datos_db['id_cita'] ?? '' ?>">
                                <input type="hidden" name="google_id" value="<?= $id_evento ?>">

                                <select name="estado" class="status-pill <?= $clase_estado ?>"
                                    data-estado-anterior="<?= $estado_actual ?>" onchange="confirmarCambioEstado(this)"
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
                                "tipoTxt" => $tipo_mostrar ?? "N/A",
                                "marcaTxt" => $marca_mostrar ?? "N/A",
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
                                "tipoOtro"  => $datos_db['tipo_equipo_otro'] ?? "",
                                "marcaOtro" => $datos_db['marca_otro'] ?? "",
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
                                class="btn-eliminar" title="Eliminar" onclick="confirmarEliminacion(event, this.href)">
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
    <div class="contenido-modal modal-ficha">
        <span class="cerrar-modal" onclick="cerrarModalVer()">&times;</span>
        
        <div class="ficha-header">
            <h2><i class="fa-solid fa-clipboard-list"></i> Ficha de Servicio</h2>
            <span id="v_estado_pill" class="ficha-estado"></span>
        </div>

        <div class="ficha-grid">
            <div class="ficha-tarjeta">
                <h3><i class="fa-solid fa-user"></i> Cliente</h3>
                <div class="ficha-linea">
                    <i class="fa-solid fa-id-badge icono-dato"></i>
                    <div class="dato-texto">
                        <small>Nombre Completo</small>
                        <p id="v_cliente"></p>
                    </div>
                </div>
                <div class="ficha-linea">
                    <i class="fa-brands fa-whatsapp icono-dato wa-color"></i>
                    <div class="dato-texto">
                        <small>WhatsApp</small>
                        <p id="v_wa"></p>
                    </div>
                </div>
            </div>

            <div class="ficha-tarjeta">
                <h3><i class="fa-solid fa-laptop-medical"></i> Equipo</h3>
                <div class="ficha-linea">
                    <i class="fa-solid fa-desktop icono-dato"></i>
                    <div class="dato-texto">
                        <small>Dispositivo</small>
                        <p id="v_dispositivo"></p>
                    </div>
                </div>
                <div class="ficha-linea">
                    <i class="fa-solid fa-tag icono-dato"></i>
                    <div class="dato-texto">
                        <small>Marca y Modelo</small>
                        <p id="v_marca_modelo"></p>
                    </div>
                </div>
                <div class="ficha-linea">
                    <i class="fa-solid fa-barcode icono-dato"></i>
                    <div class="dato-texto">
                        <small>No. Serie</small>
                        <p id="v_serie"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="ficha-tarjeta tarjeta-full">
            <h3><i class="fa-solid fa-triangle-exclamation"></i> Reporte Técnico</h3>
            <div class="ficha-linea">
                <i class="fa-solid fa-comment-dots icono-dato"></i>
                <div class="dato-texto">
                    <small>Falla Reportada</small>
                    <p id="v_falla" class="falla-destacada"></p>
                </div>
            </div>
            <div class="ficha-linea">
                <i class="fa-solid fa-align-left icono-dato"></i>
                <div class="dato-texto">
                    <small>Detalles Adicionales</small>
                    <p id="v_detalle"></p>
                </div>
            </div>
        </div>

        <div class="ficha-tarjeta tarjeta-full">
            <h3><i class="fa-regular fa-calendar-days"></i> Agendamiento</h3>
            <div class="agendamiento-flex">
                <div class="ficha-linea">
                    <i class="fa-solid fa-calendar-day icono-dato"></i>
                    <div class="dato-texto">
                        <small>Fecha</small>
                        <p id="v_fecha"></p>
                    </div>
                </div>
                <div class="ficha-linea">
                    <i class="fa-solid fa-clock icono-dato"></i>
                    <div class="dato-texto">
                        <small>Hora</small>
                        <p id="v_hora"></p>
                    </div>
                </div>
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
                    <input type="text" id="m_nombre" name="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                        title="Solo se permiten letras y espacios."
                        oninput="this.value = this.value.trimStart().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required>
                </div>
                <div class="grupo-form">
                    <label>Apellido(s):</label>
                    <input type="text" id="m_apellido" name="apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                        title="Solo se permiten letras y espacios."
                        oninput="this.value = this.value.trimStart().replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" required>
                </div>
            </div>

            <div class="fila-form">
                <div class="grupo-form">
                    <label>WhatsApp:</label>
                    <input type="tel" id="m_wa" name="whatsapp" maxlength="10" minlength="10" pattern="[0-9]{10}" title="Por favor, ingresa exactamente 10 números." oninput="this.value = this.value.trimStart().replace(/[^0-9]/g, '' required>
                </div>
                <div class="grupo-form">
                    <label>No. Serie (Opcional):</label>
                    <input type="text" id="m_serie" name="n_serie" oninput="this.value = this.value.trimStart();">
                </div>
            </div>

            <div class="fila-form">
                <div class="grupo-form">
                    <label>Tipo de dispositivo:</label>
                    <select id="m_tipo" name="id_tipo" onchange="verificarTipoOtro(this)" required>
                        <?php $tipos_res->data_seek(0);
                        while ($t = $tipos_res->fetch_assoc()): ?>
                            <option value="<?= $t['id_tipo_equipo'] ?>"><?= $t['tipo'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="text" id="m_tipo_otro" name="tipo_otro" placeholder="Especifique dispositivo..." 
                        style="display:none; margin-top: 10px; width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;" 
                        oninput="this.value = this.value.trimStart();">
                </div>
                
                <div class="grupo-form">
                    <label>Marca:</label>
                    <select id="m_marca" name="id_marca" onchange="verificarMarcaOtra(this)" required>
                        <?php $marcas_res->data_seek(0);
                        while ($m = $marcas_res->fetch_assoc()): ?>
                            <option value="<?= $m['id_marca'] ?>"><?= $m['marca'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="text" id="m_marca_otro" name="marca_otra" placeholder="Especifique marca..." 
                        style="display:none; margin-top: 10px; width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;" 
                        oninput="this.value = this.value.trimStart();">
                </div>
            </div>

            <div class="grupo-form">
                <label>Modelo:</label>
                <input type="text" id="m_modelo" name="modelo" oninput="this.value = this.value.trimStart();" required>
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
                    style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;" oninput="this.value = this.value.trimStart();"></textarea>
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
    // El sistema serializa e inyecta los horarios ocupados a JavaScript para gestionar disponibilidades
    const horasOcupadas = <?= $json_ocupadas ?? '{}' ?>;
</script>

<?php if (!empty($alerta_script)): ?>
    <script>
        // El sistema evalúa si el controlador emitió alguna alerta de éxito/error y la dispara
        document.addEventListener('DOMContentLoaded', function () {
            <?php echo $alerta_script; ?>
        });
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../public/js/citas_crud.js"></script>