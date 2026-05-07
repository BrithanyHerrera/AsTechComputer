<?php
// ========================================================
// VISTA: dispositivos_ingresados_crud_view.php
// UBICACIÓN: app/views/secciones/dispositivos_ingresados_crud_view.php
//
// Responsabilidad: SOLO dibuja el HTML.
// Todas las variables vienen preparadas desde el controlador:
//   $lista_registros  → array con todos los registros del JOIN
//   $puesto_usuario   → id_puesto del empleado logueado
//                       (controla qué columnas y botones se muestran)
// ========================================================
require_once __DIR__ . "/../../controllers/dispositivos_ingresados_crud_controller.php";
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../../public/css/registros_crud.css?v=4.0">

<div class="contenedor-ingresos">

    <!-- ====================================================
         ENCABEZADO: Título + barra de filtros
    ==================================================== -->
    <div class="encabezado-crud">
        <h1><i class="fa-solid fa-microchip"></i> Dispositivos Ingresados</h1>
        <div class="barra-filtros">

            <div class="filtro-grupo">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorGlobal"
                       placeholder="Buscar por Nombre o Folio..."
                       onkeyup="filtrarTabla()">
            </div>

            <div class="filtro-grupo">
                <label>Mostrar:</label>
                <select id="filtroPaginacion" onchange="cambiarFilasPorPagina()">
                    <option value="10">10 registros</option>
                    <option value="25">25 registros</option>
                    <option value="50">50 registros</option>
                    <option value="todos">Todos</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Estado:</label>
                <select id="filtroEstado" onchange="filtrarTabla()">
                    <option value="todos">Todos los estados</option>
                    <option value="recibido">Recibido</option>
                    <option value="entregado">Entregado</option>
                </select>
            </div>

            <div class="filtro-grupo">
                <label>Fecha:</label>
                <input type="date" id="filtroFecha" onchange="filtrarTabla()">
                <button class="btn-limpiar" onclick="limpiarFiltros()" title="Limpiar filtros">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- ====================================================
         TABLA PRINCIPAL
    ==================================================== -->
    <div class="tabla-responsiva">
        <table class="tabla-admin" id="tablaRegistros">
            <thead>
                <tr>
                    <th>Con.</th>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Dispositivo</th>
                    <th>Falla</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <?php if ($puesto_usuario != 1): ?>
                        <th>Entregado</th>
                    <?php endif; ?>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_registros as $row):
                    $solo_fecha = date('Y-m-d', strtotime($row['fecha_ingreso']));
                    $esTecnico  = ($puesto_usuario == 1);
                    $nombre_mostrar = $esTecnico
                        ? '<span style="color:red; font-weight:bold;">Confidencial</span>'
                        : "<strong>{$row['nombre']} {$row['apellido']}</strong>";

                    $datos_js = $row;
                    if ($esTecnico) {
                        $datos_js['nombre']   = 'Confidencial';
                        $datos_js['apellido'] = '';
                        $datos_js['whatsapp'] = '***';
                    }
                ?>
                <tr class="fila-registro"
                    data-nombre="<?= strtolower($row['nombre'] . ' ' . $row['apellido']) ?>"
                    data-folio="<?= strtolower($row['folio']) ?>"
                    data-estado="<?= $row['estado'] ?>"
                    data-fecha="<?= $solo_fecha ?>">

                    <td><strong><?= $row['id_gabinete'] ?></strong></td>
                    <td><span class="badge-folio"><?= $row['folio'] ?></span></td>
                    <td><?= $nombre_mostrar ?></td>
                    <td><?= $row['marca'] ?> <?= $row['modelo'] ?></td>
                    <td><span class="falla-txt"><?= $row['descripcion_problema'] ?></span></td>
                    <td style="white-space:nowrap;"><?= date('d/m/Y', strtotime($row['fecha_ingreso'])) ?></td>
                    <td>
                        <span class="status-pill <?= str_replace(' ', '-', $row['estado']) ?>">
                            <?= ucfirst($row['estado']) ?>
                        </span>
                    </td>

                    <?php if (!$esTecnico): ?>
                    <td style="text-align:center;">
                        <?php if ($row['estado'] != 'entregado'): ?>
                            <input type="checkbox" class="check-finalizar"
                                   onchange="abrirModalEntregar('<?= $row['folio'] ?>', '<?= $row['id_gabinete'] ?>', this)">
                        <?php else: ?>
                            <i class="fa-solid fa-check" style="color:green;"></i>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>

                    <td class="acciones">
                        <button class="btn-ver"
                                onclick='verDetalles(<?= json_encode($datos_js) ?>)'
                                title="Ver detalles">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <?php if (!$esTecnico): ?>
                            <a href="administracion_controller.php?seccion=ingreso&editar=<?= $row['folio'] ?>"
                               class="btn-editar" title="Editar">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="controlesPaginacion" class="paginacion-crud"></div>
</div>


<!-- ========================================================
     MODAL: VER DETALLES (COMPLETO)
======================================================== -->
<div id="modalDetalles" class="modal-personalizado">
    <div class="contenido-modal modal-amplio"> 
        <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
        <h2 id="det_folio" style="text-align: center; color: #4f46e5;">Detalles del Ingreso</h2>

        <div class="grid-detalles" style="grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- DATOS DEL CLIENTE Y MERCADO -->
            <div class="seccion-det" style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                <h3 style="color: #334155; border-bottom: 2px solid #cbd5e1; padding-bottom: 5px;"><i class="fa-solid fa-address-card"></i> Cliente y Mercado</h3>
                <p><strong>Cliente:</strong> <span id="det_nombre"></span></p>
                <p><strong>WhatsApp:</strong> <span id="det_wa"></span></p>
                <p><strong>Correo:</strong> <span id="det_correo"></span></p>
                <p><strong>Como se entero de nosotros:</strong> <span id="det_origen"></span></p>
                <p><strong>¿Primera vez?:</strong> <span id="det_primera_vez"></span></p>
                <p><strong>Uso del equipo:</strong> <span id="det_uso_equipo"></span></p>
                <p><strong>Acepta Promociones:</strong> <span id="det_promociones"></span></p>
            </div>

            <!-- DATOS DEL INGRESO Y LEGALES -->
            <div class="seccion-det" style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                <h3 style="color: #334155; border-bottom: 2px solid #cbd5e1; padding-bottom: 5px;"><i class="fa-solid fa-file-contract"></i> Ingreso y Condiciones</h3>
                <p><strong>Estado:</strong> <span id="det_estado" style="text-transform: uppercase; font-weight: bold; color: #4f46e5;"></span></p>
                <p><strong>Fecha y Hora:</strong> <span id="det_fecha"></span> a las <span id="det_hora"></span></p>
                <p><strong>Técnico Asignado (ID):</strong> <span id="det_tecnico"></span></p>
                <p><strong>Autoriza Revisión:</strong> <span id="det_autoriza" style="font-weight: bold; color: #d97706;"></span></p>
                <p><strong>Tiempo Estimado:</strong> <span id="det_tiempo"></span> días</p>
                <p><strong>Dudas del cliente:</strong> <span id="det_dudas"></span></p>
            </div>

            <!-- DATOS DEL EQUIPO -->
            <div class="seccion-det" style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                <h3 style="color: #334155; border-bottom: 2px solid #cbd5e1; padding-bottom: 5px;"><i class="fa-solid fa-laptop"></i> Equipo</h3>
                <p><strong>Tipo:</strong> <span id="det_tipo"></span></p>
                <p><strong>Marca / Modelo:</strong> <span id="det_equipo"></span></p>
                <p><strong>No. Serie (SN):</strong> <span id="det_serie"></span></p>
                <p><strong>Ubicación (Bodega):</strong> <span id="det_gabinete" style="font-weight:bold; color: #e74c3c;"></span></p>
                <p><strong>Frecuencia de servicio:</strong> <span id="det_frecuencia"></span></p>
            </div>

            <!-- REVISIÓN FÍSICA -->
            <div class="seccion-det" style="background: #f8fafc; padding: 15px; border-radius: 8px;">
                <h3 style="color: #334155; border-bottom: 2px solid #cbd5e1; padding-bottom: 5px;"><i class="fa-solid fa-magnifying-glass"></i> Revisión Técnica</h3>
                <p><strong>Motivo de ingreso:</strong> <span id="det_falla"></span></p>
                <p><strong>Condición Física:</strong> <span id="det_condicion"></span></p>
                <p><strong>Accesorios Extra:</strong> <span id="det_accesorios"></span></p>
                <p><strong>Obs. Recepción:</strong> <span id="det_observaciones"></span></p>
                <p><strong>Obs. del Equipo:</strong> <span id="det_obs_equipo"></span></p>
            </div>
        </div>
    </div>
</div>


<!-- ========================================================
     MODAL: EDITAR REGISTRO
======================================================== -->
<div id="modalEditar" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModalEditar()">&times;</span>
        <h2 class="modal-titulo-editar">
            <i class="fa-solid fa-pen-to-square"></i> Editar Registro
        </h2>
        <form action="../controllers/dispositivos_ingresados_crud_controller.php?accion=editar" method="POST">
            <input type="hidden" name="folio"      id="edit_folio">
            <input type="hidden" name="id_cliente" id="edit_id_cliente">

            <h3 class="modal-subtitulo">
                <i class="fa-solid fa-user-pen"></i> Datos del Cliente
            </h3>
            <div class="grid-detalles" style="margin-top: 10px;">
                <div class="grupo-input">
                    <label>Nombre(s):</label>
                    <input type="text" name="nombre_cliente" id="edit_nombre" required>
                </div>
                <div class="grupo-input">
                    <label>Apellido(s):</label>
                    <input type="text" name="apellido_cliente" id="edit_apellido" required>
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>WhatsApp / Teléfono:</label>
                    <input type="text" name="telefono_cliente" id="edit_telefono" required>
                </div>
            </div>

            <h3 class="modal-subtitulo" style="margin-top: 10px;">
                <i class="fa-solid fa-laptop-medical"></i> Datos del Ingreso
            </h3>
            <div class="grid-detalles" style="margin-top: 10px;">
                <div class="grupo-input seccion-det-full">
                    <label>Estado de la Orden:</label>
                    <select name="estado" id="edit_estado" required>
                        <option value="recibido">Recibido</option>
                        <option value="entregado">Entregado</option>
                    </select>
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>Condición Física:</label>
                    <input type="text" name="condicion_fisica" id="edit_condicion">
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>Accesorios Entregados:</label>
                    <input type="text" name="accesorios_entregados" id="edit_accesorios">
                </div>
                <div class="grupo-input seccion-det-full">
                    <label>Observaciones de Recepción:</label>
                    <textarea name="observaciones_recepcion" id="edit_observaciones" rows="2"></textarea>
                </div>
            </div>

            <button type="submit" class="btn-modal-submit btn-submit-guardar">
                Guardar Cambios
            </button>
        </form>
    </div>
</div>


<!-- ========================================================
     MODAL: CONFIRMAR ENTREGA
======================================================== -->
<div id="modalEntregar" class="modal-personalizado">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModalEntregar()">&times;</span>
        <h2 class="modal-titulo-entrega">
            <i class="fa-solid fa-check-double"></i> Confirmar Entrega
        </h2>
        <p class="texto-confirmar-entrega">
            ¿Estás seguro de marcar el folio
            <strong id="txt_folio_entregar" class="badge-folio"></strong>
            como ENTREGADO al cliente?
        </p>

        <form action="../controllers/dispositivos_ingresados_crud_controller.php?accion=entregar" method="POST">
            <input type="hidden" id="input_folio_entregar"    name="folio">
            <input type="hidden" id="input_gabinete_entregar" name="id_gabinete">
            <button type="submit" class="btn-modal-submit btn-submit-entregar">
                <i class="fa-solid fa-check"></i> Sí, Registrar Entrega
            </button>
        </form>
    </div>
</div>

<script src="../../public/js/registros_crud.js"></script>